import {
  createApp,
  defineAsyncComponent
} from 'vue/dist/vue.esm-bundler'
import { createStore } from "vuex";
import entities from "./../../../store/modules/entities";
import booking from "./../../../store/modules/booking";
import eventEntities from "../../../store/modules/eventEntities";
import eventBooking from "../../../store/modules/eventBooking";
import shortcodeParams from "../../../store/modules/shortcodeParams";
import params from "../../../store/modules/params";
import pagination from "../../../store/modules/pagination";
import customerInfo from "../../../store/modules/customerInfo";
import customFields from "../../../store/modules/customFields";
import persons from "../../../store/modules/persons.js";
import tickets from "../../../store/modules/tickets.js";
import payment from "../../../store/modules/payment.js";
import bookableType from "../../../store/modules/bookableType.js";
import coupon from "../../../store/modules/coupon.js";
import auth from "../../../store/modules/auth.js";
import cabinet from "../../../store/modules/cabinet.js";
import cabinetFilters from "../../../store/modules/cabinetFilters.js"

import {
  provide,
  ref,
  reactive,
  readonly
} from "vue";
import VueGtag from "vue-gtag";
import {
  install,
  init
} from "./facebookPixel.js";

import {useLicence} from "../common/licence";

// It is necessary to investigate what is the best practice
// import axios from './plugins/axios'

const StepFormWrapper = defineAsyncComponent({
  loader: () => import('../../../views/public/StepForm/BookingStepForm.vue'),
})

const CatalogFormWrapper = defineAsyncComponent({
  loader: () => import('../../../views/public/CatalogForm/CatalogForm.vue'),
})

const EventsListFormWrapper = defineAsyncComponent({
  loader: () => import('../../../views/public/EventForm/EventListForm/EventsListForm.vue'),
})

const DialogForms = defineAsyncComponent({
  loader: () => import('../../../views/public/Dialog/DialogForms.vue'),
})

const CustomerPanelWrapper = defineAsyncComponent({
  loader: () => import('../../../views/public/Cabinet/CustomerPanel/CustomerPanel.vue'),
})

if (typeof window.ameliaShortcodeData === 'undefined') {
  window.ameliaShortcodeData = [{counter: null}]
}

const dynamicCdn = window.wpAmeliaUrls.wpAmeliaPluginURL + 'v3/public/';

window.__dynamic_handler__ = function(importer) {
  return dynamicCdn + 'assets/' + importer;
}
// @ts-ignore
window.__dynamic_preload__ = function(preloads) {
  return preloads.map(preload => dynamicCdn + preload);
}

let isMounted = ref(false)

if (window.ameliaShortcodeDataTriggered !== undefined) {
  window.ameliaShortcodeDataTriggered.forEach((shortCodeData) => {

    // * Shortcodes that are rendered in Amelia Popup
    if (shortCodeData.in_dialog) {
      // * vue creation
      createAmelia(shortCodeData)

      // * Collection of all external buttons that are connected to "Amelia popup"
      let externalButtonsLoading = setInterval(() => {
        let externalButtons = shortCodeData.trigger_type && shortCodeData.trigger_type === 'class' ? [...document.getElementsByClassName(shortCodeData.trigger)]
          : [document.getElementById(shortCodeData.trigger)]

        if (externalButtons.length > 0 && externalButtons[0] !== null && typeof externalButtons[0] !== 'undefined') {
          clearInterval(externalButtonsLoading)
          // * Made the buttons invisible because amelia components are not fully loaded
          externalButtons.forEach(btn => {
            btn.style.display = 'none'
          })

          let componentsLoaded = setInterval(() => {
            if (isMounted.value) {
              clearInterval(componentsLoaded)
              // * Made the buttons visible because amelia components are fully loaded
              externalButtons.forEach(btn => {
                btn.style.removeProperty('display')
              })
            }
          }, 250)
        }
      }, 250)
    } else {
      let ameliaPopUpLoaded = false

      let ameliaBookingButtonLoadInterval = setInterval(
        function () {
          let ameliaPopUpButtons = shortCodeData.trigger_type && shortCodeData.trigger_type === 'class' ? [...document.getElementsByClassName(shortCodeData.trigger)]
            : [document.getElementById(shortCodeData.trigger)]

          if (!ameliaPopUpLoaded && ameliaPopUpButtons.length > 0 && ameliaPopUpButtons[0] !== null && typeof ameliaPopUpButtons[0] !== 'undefined') {
            ameliaPopUpLoaded = true

            clearInterval(ameliaBookingButtonLoadInterval)
            ameliaPopUpButtons.forEach(ameliaPopUpButton => {
              ameliaPopUpButton.onclick = function () {
                let ameliaBookingFormLoadInterval = setInterval(
                  function () {
                    let ameliaPopUpForms = document.getElementsByClassName('amelia-skip-load-' + shortCodeData.counter)

                    if (ameliaPopUpForms.length) {
                      clearInterval(ameliaBookingFormLoadInterval)
                      for (let i = 0; i < ameliaPopUpForms.length; i++) {
                        if (!ameliaPopUpForms[i].classList.contains('amelia-v2-booking-' + shortCodeData.counter + '-loaded')) {
                          createAmelia(shortCodeData)
                        }
                      }
                    }
                  }, 1000
                )
              }

              if ('ameliaCache' in window && window.ameliaCache.length && window.ameliaCache[0]) {
                let cacheData = JSON.parse(window.ameliaCache[0])

                if (cacheData &&
                  'request' in cacheData &&
                  'form' in cacheData.request &&
                  'shortcode' in cacheData.request.form &&
                  'trigger' in cacheData.request.form.shortcode &&
                  cacheData.request.form.shortcode.trigger
                ) {
                  if (!('trigger_type' in cacheData.request.form.shortcode) ||
                    !cacheData.request.form.shortcode.trigger_type ||
                    cacheData.request.form.shortcode.trigger_type === 'id'
                  ) {
                    let el = document.getElementById(cacheData.request.form.shortcode.trigger)

                    if (typeof el !== 'undefined') {
                      el.click()
                    }
                  } else if ('trigger_type' in cacheData.request.form.shortcode &&
                    cacheData.request.form.shortcode.trigger_type === 'class'
                  ) {
                    let el = document.getElementsByClassName(cacheData.request.form.shortcode.trigger)

                    if (typeof el !== 'undefined' && el.length) {
                      el[0].click()
                    }
                  }
                }
              }
            })

          }
        }, 1000
      )
    }
  })
}

window.ameliaShortcodeData.forEach((item) => {
  createAmelia(item)
})

function createAmelia(shortcodeData) {
  const settings = reactive(window.wpAmeliaSettings)

  let app = createApp({
    setup() {
      const baseURLs = reactive(window.wpAmeliaUrls)
      const labels = reactive(window.wpAmeliaLabels)
      const timeZones = reactive(window.wpAmeliaTimeZones)
      const timeZone = ref('wpAmeliaTimeZone' in window ? window.wpAmeliaTimeZone[0] : '')
      const localLanguage = ref(window.localeLanguage[0])
      const licence = reactive(useLicence())
      provide('settings', readonly(settings))
      provide('baseUrls', readonly(baseURLs))
      provide('labels', readonly(labels))
      provide('timeZones', readonly(timeZones))
      provide('timeZone', readonly(timeZone))
      provide('localLanguage', readonly(localLanguage))
      provide('shortcodeData', readonly(ref(shortcodeData)))
      provide('licence', licence)
      provide('isMounted', isMounted)
    }
  })

  if (settings.googleTag.id) {
    app.use(VueGtag, {
      config: {id: window.wpAmeliaSettings.googleTag.id}
    })
  }

  if (settings.googleAnalytics.id) {
    app.use(VueGtag, {
      config: {id: window.wpAmeliaSettings.googleAnalytics.id}
    })
  }

  if (settings.facebookPixel.id) {
    install()

    init(window.wpAmeliaSettings.facebookPixel.id)
  }

  app
    .component('StepFormWrapper', StepFormWrapper)
    .component('CatalogFormWrapper', CatalogFormWrapper)
    .component('EventsListFormWrapper', EventsListFormWrapper)
    .component('DialogForms', DialogForms)
    .component('CustomerPanelWrapper', CustomerPanelWrapper)
    .use(
      createStore({
        namespaced: true,

        state: () => ({
          settings: reactive(window.wpAmeliaSettings),
          labels: reactive(window.wpAmeliaLabels),
          localLanguage: ref(window.localeLanguage[0]),
          baseUrls: reactive(window.wpAmeliaUrls),
          timeZones: reactive(window.wpAmeliaTimeZones),
          timeZone: ref('wpAmeliaTimeZone' in window ? window.wpAmeliaTimeZone[0] : ''),
          ready: false,
          loading: true,
          formKey: '',
        }),

        getters: {
          getSettings (state) {
            return state.settings
          },

          getLabels (state) {
            return state.labels
          },

          getLocalLanguage (state) {
            return state.localLanguage
          },

          getBaseUrls (state) {
            return state.baseUrls
          },

          getReady (state) {
            return state.ready
          },

          getLoading (state) {
            return state.loading
          },

          getFormKey (state) {
            return state.formKey
          }
        },

        mutations: {
          setReady (state, payload) {
            state.ready = payload
          },

          setLoading (state, payload) {
            state.loading = payload
          },

          setFormKey (state, payload) {
            state.formKey = payload
          }
        },

        modules: {
          entities,
          booking,
          eventEntities,
          eventBooking,
          shortcodeParams,
          params,
          pagination,
          customerInfo,
          customFields,
          persons,
          tickets,
          payment,
          bookableType,
          coupon,
          auth,
          cabinet,
          cabinetFilters
        },
      })
    )
    .mount(`#amelia-v2-booking${shortcodeData.counter !== null ? '-' + shortcodeData.counter : ''}`)
}

window.amelia = {load: createAmelia}
