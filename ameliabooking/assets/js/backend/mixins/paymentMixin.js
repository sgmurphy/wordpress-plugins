export default {

  data: () => ({}),

  methods: {
    getPaymentType (payment) {
      if (!payment.gateway || payment.gateway === 'onSite') {
        return 'onsite'
      }
      if (payment.status === 'partiallyPaid') {
        return 'deposit'
      }
      return 'online'
    },

    longNamePayments (gateway) {
      return ['mollie', 'razorpay', 'square'].includes(gateway)
    },

    getPaymentData (payment, appointment, event, pack) {
      let selectedPaymentModalData = {}

      selectedPaymentModalData.paymentId = payment.id

      if (appointment) {
        selectedPaymentModalData.bookableType = 'appointment'
        selectedPaymentModalData.bookings = appointment.bookings
        selectedPaymentModalData.bookingStart = appointment.bookingStart
        selectedPaymentModalData.bookableName = this.getServiceById(appointment.serviceId).name
        selectedPaymentModalData.bookable = this.getServiceById(appointment.serviceId)
        selectedPaymentModalData.customerBookingId = payment.customerBookingId

        let provider = this.getProviderById(appointment.providerId)
        provider.fullName = provider.firstName + ' ' + provider.lastName

        selectedPaymentModalData.providers = [provider]

        appointment.bookings.forEach(function (bookItem, index) {
          bookItem.payments.forEach(function (payItem) {
            if (payItem.id === payment.id) {
              selectedPaymentModalData.customer = bookItem.customer
              selectedPaymentModalData.bookingIndex = index
            }
          })
        })
      }

      if (event) {
        selectedPaymentModalData.bookableType = 'event'
        selectedPaymentModalData.bookings = event.bookings
        selectedPaymentModalData.bookingStart = event.periods[0].periodStart
        selectedPaymentModalData.bookableName = event.name
        selectedPaymentModalData.providers = event.providers
        selectedPaymentModalData.bookable = event
        selectedPaymentModalData.customerBookingId = payment.customerBookingId

        event.bookings.forEach(function (bookItem, index) {
          bookItem.payments.forEach(function (payItem) {
            if (payItem.id === payment.id) {
              selectedPaymentModalData.customer = bookItem.customer
              selectedPaymentModalData.bookingIndex = index
            }
          })
        })
      }

      if (pack) {
        selectedPaymentModalData.bookableType = 'package'
        selectedPaymentModalData.bookings = []
        selectedPaymentModalData.bookingStart = null
        selectedPaymentModalData.bookableName = pack.name
        selectedPaymentModalData.providers = []
        selectedPaymentModalData.bookable = pack

        selectedPaymentModalData.bookings = []
        selectedPaymentModalData.bookingIndex = 0
      }

      return selectedPaymentModalData
    },

    getPaymentStatusNiceName (status) {
      switch (status) {
        case ('paid'):
          return this.$root.labels.paid

        case ('pending'):
          return this.$root.labels.pending

        case ('partiallyPaid'):
          return this.$root.labels.partially_paid

        case ('refunded'):
          return this.$root.labels.refunded
      }
    },

    getPaymentClassName (payment) {
      let method = payment.gateway

      if (payment.gatewayTitle === 'oliver') {
        method = 'oliver'
      }

      return 'am-appointment-payment am-appointment-payment-' + method
    },

    getPaymentIconName (payment) {
      return (payment.gateway === 'onSite' || payment.gateway === 'stripe') && payment.gatewayTitle === 'oliver' ? 'oliver.png' : payment.gateway + '.svg'
    },

    getPaymentGatewayNiceName (payment) {
      if (payment.gateway === 'stripe' && payment.gatewayTitle === 'oliver') {
        return this.$root.labels.oliver_on_line
      }

      if (payment.gateway === 'onSite' && payment.gatewayTitle === 'oliver') {
        return this.$root.labels.oliver_on_site
      }

      if (payment.gateway === 'onSite') {
        return this.$root.labels.on_site
      }

      if (payment.gateway === 'wc') {
        return payment.gatewayTitle
      }

      if (payment.gateway) {
        return payment.gateway.charAt(0).toUpperCase() + payment.gateway.slice(1)
      }
    },

    getPaymentIconWidth (paymentGateway) {
      switch (paymentGateway) {
        case 'razorpay':
          return '76px'
        case 'square':
          return '70px'
        case 'mollie':
          return '38px'
        default:
          return '16px'
      }
    }
  }

}
