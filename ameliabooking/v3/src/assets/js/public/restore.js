import { useRemoveUrlParameter } from "../common/helper.js";
import {
  useAppointmentCalendarData,
  usePackageCalendarData,
  useEventCalendarData,
  useBookingError,
  useNotify
} from "./booking.js";

function fixType (item, key) {
  item[key] = !item[key] ? null : parseInt(item[key])
}

function fixCacheData (data) {
  let keys = []

  data.request.state.attachments = []

  data.request.state.booked = null

  data.request.state.loading = true

  data.request.state.ready = false

  if (!('extras' in data.request.state.appointment.bookings[0])) {
    data.request.state.appointment.bookings[0].extras = []
  }

  fixType(data.request.state, 'packageId')

  fixType(data.request.state, 'appointmentsIndex')

  data.request.state.appointments.forEach((a) => {
    keys = ['index', 'packageId', 'serviceId']

    keys.forEach((key) => {
      fixType(a, key)
    })

    for (let serviceId in a.services) {
      a.services[serviceId].list.forEach((i) => {
        keys = ['locationId', 'providerId']

        keys.forEach((key) => {
          fixType(i, key)
        })
      })

      keys = ['locationId', 'providerId']

      keys.forEach((key) => {
        fixType(a.services[serviceId], key)
      })
    }
  })

  keys = ['locationId', 'providerId', 'serviceId', 'categoryId', 'packageId']

  keys.forEach((key) => {
    fixType(data.request.state.appointment, key)
  })
}

function useRestore (store, shortcodeData) {
  let data = 'ameliaCache' in window && window.ameliaCache.length && window.ameliaCache[0] ?
    JSON.parse(window.ameliaCache[0]) : null

  if (!data || (parseInt(data.request.form.shortcode.counter) !== parseInt(shortcodeData.counter))) {
    return null
  }

  try {
    window.history.replaceState(
      null,
      null,
      useRemoveUrlParameter(
        useRemoveUrlParameter(
          window.location.href,
          'ameliaWcCache'
        ),
        'ameliaCache'
      )
    )
  } catch (e) {
    console.log(e)
  }

  if (data.request.state.attachments && (data.request.state.attachments.length || Object.keys(data.request.state.attachments).length)) {
    fixCacheData(data)
  }

  if ('bookableType' in data.request.state && data.request.state.bookableType === 'event') {
    store.commit('bookableType/setType', data.request.state.bookableType)
    store.commit('pagination/setAllData', data.request.state.pagination)
    store.commit('params/setAllData', data.request.state.params)
    store.commit('eventBooking/setEventId', data.request.state.eventId)
    store.commit('coupon/setCoupon', data.request.state.coupon)
    store.commit('customFields/setAllData', data.request.state.customFields)
    store.commit('customerInfo/setAllData', data.request.state.customerInfo)
    store.commit('payment/setAllData', data.request.state.payment)
    store.commit('persons/setAllData', data.request.state.persons)
    store.commit('tickets/setAllData', data.request.state.tickets)

    // * Request because event params and pagination
    store.dispatch('eventEntities/requestEvents')
  } else {
    store.state.booking = {...data.request.state }
  }

  switch ((data.status !== null) ? data.status : 'paid') {
    case ('canceled'):
      return {
        result: 'canceled',
        steps: data.request.form.steps,
        sidebar: data.request.form.sidebar,
      }

    case ('failed'):
      store.commit('booking/setError', useBookingError(data, store))

      return {
        result: 'error',
        steps: data.request.form.steps,
        sidebar: data.request.form.sidebar,
      }

    case ('paid'):
      switch (data.response.type) {
        case ('appointment'):
          store.commit('booking/setBooked', useAppointmentCalendarData(store, data.response))

          break

        case ('package'):
          store.commit('booking/setBooked', usePackageCalendarData(store, data.response))

          break

        case ('event'):
          store.commit('eventBooking/setBooked', useEventCalendarData(store, data.response))

          break
      }

      if (data.response.payment.gateway !== 'wc') {
        useNotify(store, data.response, () => {}, () => {})
      }

      return {
        result: 'success',
        steps: data.request.form.steps,
        sidebar: data.request.form.sidebar,
      }
  }
}

export default useRestore
