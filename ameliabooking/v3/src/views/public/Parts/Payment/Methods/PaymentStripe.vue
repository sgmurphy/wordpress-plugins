<template>
  <div class="am-fs__payment-stripe" :style="cssVars">
    <div class="am-fs__payment-stripe__card">
      <div>
        <p>
          {{ amLabels.card_number_colon }}:
        </p>
        <div :id="'am-stripe-cn-' + shortcodeData.counter" class="am-stripe-cn"></div>
      </div>
      <div>
        <div>
          <p>
            {{ amLabels.expires_date_colon }}:
          </p>
          <div :id="'am-stripe-ed-' + shortcodeData.counter" class="am-stripe-ed"></div>
        </div>
        <div>
          <p>
            CVC:
          </p>
          <div :id="'am-stripe-cvc-' + shortcodeData.counter" class="am-stripe-cvc"></div>
        </div>
      </div>
    </div>
    <div class="am-fs__payment-stripe__policy">
      <p>
        {{ amLabels.payment_protected_policy }}
      </p>
      <img :src="baseUrls.wpAmeliaPluginURL+'/v3/src/assets/img/icons/stripeLogo.svg'" alt="Stripe policy">
      <span>
        {{ amLabels.stripe }}
      </span>
    </div>
  </div>
</template>

<script setup>
import { computed, onMounted, inject, watchEffect } from 'vue'
import {
  usePaymentError,
  useBookingData,
  useCreateBooking,
  useCreateBookingSuccess,
  useCreateBookingError,
  getErrorMessage
} from '../../../../../assets/js/public/booking.js'
import { useColorTransparency } from '../../../../../assets/js/common/colorManipulation.js'

// * Import from Vuex
import { useStore } from 'vuex'
import {useScrollTo} from "../../../../../assets/js/common/scrollElements";

const store = useStore()

// * Global settings
const amSettings = inject('settings')

// * local language short code
const localLanguage = inject('localLanguage')

// * Labels
const amLabels = inject('amLabels')

// * Base Urls
const baseUrls = inject('baseUrls')

const shortcodeData = inject('shortcodeData')

// * Step Functions
const {
  nextStep,
  footerButtonReset,
  footerButtonClicked
} = inject('changingStepsFunctions', {
  nextStep: () => {},
  footerButtonReset: () => {},
  footerButtonClicked: {
    value: false
  }
})

// * Components Emits
const emits = defineEmits(['payment-error'])

// * Payment Part
let stripeObject = null
// let stripeCard = null
let cardNum = null
let cardEd = null
let cardCvc = null

// * Colors
let amColors = inject('amColors')
let amFonts = inject('amFonts')

function stripePaymentInit () {
  const options = {
    locale: localLanguage.value.replace('_', '-')
  }

  stripeObject = Stripe(
    amSettings.payments.stripe.testMode === false
      ? amSettings.payments.stripe.livePublishableKey
      : amSettings.payments.stripe.testPublishableKey, options
  )

  let elements = stripeObject.elements()

  // stripeCard = elements.create('card')
  // TODO - set unique ID with counter
  // stripeCard.mount('#am-stripe-element')

  let style = {
    base: {
      color: amColors.value.colorInpText,
      fontSize: '15px',
      fontFamily: amFonts.value.fontFamily
    }
  }

  cardNum = elements.create('cardNumber', {style})
  cardNum.mount('#am-stripe-cn-' + shortcodeData.value.counter)
  cardEd = elements.create('cardExpiry', {style})
  cardEd.mount('#am-stripe-ed-' + shortcodeData.value.counter)
  cardCvc = elements.create('cardCvc', {style})
  cardCvc.mount('#am-stripe-cvc-' + shortcodeData.value.counter)
}

function stripePaymentCreate () {
  store.commit('setLoading', true)

  footerButtonReset()
  stripeObject.createPaymentMethod(
    'card',
    cardNum,
    {}
  ).then(
    function (result) {
      if (stripeError(result)) {
        store.commit('setLoading', false)
        return
      }

      useCreateBooking(
        store,
        useBookingData(
          store,
          null,
          false,
          {
            paymentMethodId: result.paymentMethod.id
          },
          null
        ),
        function (response) {
          if (response.data.data.requiresAction) {
            store.commit('setLoading', false)
            stripePaymentActionRequired(response.data.data)

            return
          }

          store.commit('setLoading', false)
          successBooking(response)
        },
        (response) => {
          store.commit('setLoading', false)
          errorBooking(response)
        }
      )
    }
  )
}

function stripePaymentActionRequired (response) {
  stripeObject.handleCardAction(
    response.paymentIntentClientSecret
  ).then(
    function (result) {
      if (stripeError(result)) {
        return
      }

      useCreateBooking(
        store,
        useBookingData(
          store,
          null,
          false,
          {
            paymentIntentId: result.paymentIntent.id
          },
          null
        ),
        successBooking,
        errorBooking
      )
    }
  )
}

function stripeError (result) {
  if (result.error) {
    usePaymentError(
      store,
      function () {
        emits('payment-error', result.error.message)
      }
    )
    return true
  }

  return false
}

function successBooking (response) {
  useCreateBookingSuccess(
    store,
    response,
    function () {
      nextStep()
    }
  )
}

function errorBooking (error) {
  useCreateBookingError(
    store,
    error.response.data,
    () => {
      emits('payment-error', getErrorMessage())
    }
  )
}

let paymentStepRef = inject('paymentRef')

// * Watching when footer button was clicked
watchEffect(() => {
  if(footerButtonClicked.value) {
    if (!store.getters['coupon/getCouponValidated']) {
      footerButtonReset()
      useScrollTo(paymentStepRef.value, paymentStepRef.value, 20, 300)
      emits('payment-error', amLabels.value.coupon_mandatory)
    } else {
      stripePaymentCreate()
    }
  }
}, {flush: 'post'})

onMounted(() => {
  stripePaymentInit()
})

// * Css variables
let cssVars = computed(() => {
  return {
    '--am-c-pay-text': amColors.value.colorMainText,
    '--am-c-pay-text-op60': useColorTransparency(amColors.value.colorMainText, 0.6)
  }
})
</script>

<script>
export default {
  name: 'PaymentStripe'
}
</script>

<style lang="scss">
.amelia-v2-booking {
  #amelia-container {
    $pay: am-fs__payment-stripe;
    .#{$pay} {
      .#{$pay}__policy {
        display: flex;
        align-items: center;
        justify-content: center;
        color: var(--am-c-pay-text-op60);
        margin: 20px 0 10px;

        p {
          display: inline-flex;
          font-size: 14px;
          font-weight: 500;
          line-height: 1.42857;
          color: var(--am-c-ps-text);
        }

        img {
          margin: 0 8px;
        }

        span {
          display: inline-flex;
          font-size: 14px;
          font-weight: 500;
          line-height: 1.42857;
          color: #6772E5;
        }
      }

      &__card {
        p {
          font-size: 15px;
          font-weight: 500;
          line-height: 1.33333;
          color: var(--am-c-pay-text);
          margin-bottom: 4px;
        }

        & > div:nth-child(2) {
          display: flex;
          gap: 16px;

          & > div:first-child {
            width: 60%
          }

          & > div:nth-child(2) {
            width: 40%
          }
        }

        .am-stripe-cn, .am-stripe-ed, .am-stripe-cvc {
          background-color: var(--am-c-inp-bgr);
          border: 1px solid var(--am-c-inp-border);
          border-radius: 6px;
          box-shadow: 0 2px 2px rgb(14 25 32 / 3%);
          box-sizing: border-box;
          padding: 12px;
        }
        .am-stripe-cn {
          margin-bottom: 16px;
        }
      }
    }
  }
}
</style>
