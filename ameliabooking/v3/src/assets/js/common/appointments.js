import {useTimeInSeconds} from "./date";
import {useCart, useCartItem} from "../public/cart";
import {useSortedDateStrings} from "./helper";
import {settings} from "../../../plugins/settings";
import {checkLimitPerEmployee, sortForEmployeeSelection} from "./employee";
import {useEntityTax, usePercentageAmount, useRoundAmount, useTaxAmount, useTaxedAmount} from "./pricing";

function useEmployeeService (store, serviceId, employeeId) {
  let service = store.getters['entities/getService'](serviceId)

  let employeeService = employeeId ? store.getters['entities/getEmployeeService'](employeeId, serviceId) : service

  return Object.assign(
    {},
    service,
    {
      price: employeeService.price,
      minCapacity: employeeService.minCapacity,
      maxCapacity: employeeService.maxCapacity,
      customPricing: employeeService.customPricing,
    }
  )
}

function useAppointmentServicePrice (employeeService, duration) {
  return employeeService.customPricing.enabled && (duration in employeeService.customPricing.durations)
    ? employeeService.customPricing.durations[duration].price : employeeService.price
}

function useAppointmentServiceAmount (employeeService, persons, duration) {
  return useAppointmentServicePrice(employeeService, duration) * (employeeService.aggregatedPrice ? persons : 1)
}

function useAppointmentAmountData (store, item, coupon, couponLimit) {
  let instantTotalAmount = 0

  let instantTotalServiceAmount = 0

  let instantTotalExtrasAmount = 0

  let instantDiscountAmount = 0

  let instantTaxAmount = 0

  let instantDepositAmount = 0

  let totalAmount = 0

  let totalServiceAmount = 0

  let totalExtrasAmount = 0

  let discountAmount = 0

  let taxAmount = 0

  let depositAmount = 0

  let useFullAmount = store.getters['booking/getPaymentDeposit']

  let service = store.getters['entities/getService'](
    item.serviceId
  )

  let applyCoupon = couponLimit > 0 && coupon.servicesIds.indexOf(service.id) !== -1

  let instantPaymentCount = 1

  if (service.recurringPayment) {
    instantPaymentCount = service.recurringPayment > item.services[item.serviceId].list.length
      ? item.services[item.serviceId].list.length : service.recurringPayment
  }

  let appliedCoupon = false

  let servicesPrices = {}

  let prepaidCount = 0

  let totalCount = 0

  item.services[item.serviceId].list.forEach((appointment, index) => {
    let employeeService = useEmployeeService(store, item.serviceId, appointment.providerId)

    let amountData = useAppointmentBookingAmountData(
      store,
      {
        price: useAppointmentServicePrice(employeeService, appointment.duration),
        persons: appointment.persons,
        aggregatedPrice: service.aggregatedPrice,
        extras: appointment.extras,
        serviceId: item.serviceId,
        coupon: applyCoupon && couponLimit > 0 ? coupon : null
      },
      true
    )

    if (applyCoupon && couponLimit > 0) {
      appliedCoupon = true

      couponLimit--
    }

    let appointmentTotalAmount = amountData.total

    let appointmentDiscountAmount = amountData.discount

    let appointmentTaxAmount = amountData.tax

    totalExtrasAmount += amountData.total - amountData.bookable

    totalServiceAmount += amountData.bookable

    let appointmentDepositAmount = 0

    let servicePrice = useAppointmentServicePrice(employeeService, appointment.duration)

    servicesPrices[servicePrice] = !(servicePrice in servicesPrices) ? 1 : servicesPrices[servicePrice] + 1

    if (service.depositPayment !== 'disabled' && (useFullAmount ? !service.fullPayment : true)) {
      switch (service.depositPayment) {
        case ('fixed'):
          appointmentDepositAmount = (service.depositPerPerson && service.aggregatedPrice ? appointment.persons : 1) * service.deposit

          break

        case 'percentage':
          appointmentDepositAmount = useRoundAmount(
            usePercentageAmount(
              appointmentTotalAmount - appointmentDiscountAmount + appointmentTaxAmount,
              service.deposit
            )
          )

          break
      }
    }

    totalAmount += appointmentTotalAmount

    discountAmount += appointmentDiscountAmount

    taxAmount += appointmentTaxAmount

    depositAmount += appointmentDepositAmount

    totalCount++

    if (index < instantPaymentCount) {
      instantTotalAmount = totalAmount

      instantTotalServiceAmount = totalServiceAmount

      instantTotalExtrasAmount = totalExtrasAmount

      instantDiscountAmount = discountAmount

      instantTaxAmount = taxAmount

      instantDepositAmount = depositAmount

      prepaidCount++
    }
  })

  return {
    serviceId: service.id,
    postpaid: {
      totalAmount: totalAmount - instantTotalAmount,
      totalServiceAmount: totalServiceAmount - instantTotalServiceAmount,
      totalExtrasAmount: totalExtrasAmount - instantTotalExtrasAmount,
      discountAmount: discountAmount - instantDiscountAmount,
      taxAmount: taxAmount - instantTaxAmount,
      depositAmount: 0,
      count: totalCount - prepaidCount,
    },
    prepaid: {
      totalAmount: instantTotalAmount,
      totalServiceAmount: instantTotalServiceAmount,
      totalExtrasAmount: instantTotalExtrasAmount,
      discountAmount: instantDiscountAmount,
      taxAmount: instantTaxAmount,
      depositAmount: instantDepositAmount,
      count: prepaidCount,
    },
    appliedCoupon: appliedCoupon,
    couponLimit: couponLimit,
    servicesPrices: servicesPrices,
  }
}

function useAppointmentBookingAmountData (store, appointment, includedTaxInTotal) {
  let serviceTax = null

  let excludedServiceTax = settings.payments.taxes.excluded

  let enabledServiceTax = settings.payments.taxes.enabled

  if ('tax' in appointment) {
    serviceTax = appointment.tax && appointment.tax.length ? appointment.tax[0] : null

    excludedServiceTax = serviceTax ? serviceTax.excluded : excludedServiceTax

    enabledServiceTax = serviceTax !== null
  } else if (enabledServiceTax) {
    serviceTax = useEntityTax(store, appointment.serviceId, 'service')
  }

  let serviceAmount = (appointment.aggregatedPrice ? appointment.persons : 1) * appointment.price

  let appointmentServiceAmount = 0

  let appointmentTotalAmount = 0

  let appointmentDiscountAmount = 0

  let appointmentTaxAmount = 0

  if (appointment.coupon) {
    appointmentTotalAmount = serviceAmount

    appointmentServiceAmount = serviceAmount

    if (enabledServiceTax && serviceTax && !excludedServiceTax) {
      serviceAmount = useTaxedAmount(serviceAmount, serviceTax)
    }

    let serviceDiscountAmount = appointment.coupon.discount
      ? usePercentageAmount(serviceAmount, appointment.coupon.discount)
      : 0

    let serviceDiscountedAmount = serviceAmount - serviceDiscountAmount

    serviceAmount = serviceDiscountedAmount

    let deduction = appointment.coupon.deduction

    let serviceDeductionAmount = 0

    if (serviceDiscountedAmount > 0 && deduction > 0) {
      serviceDeductionAmount = serviceDiscountedAmount >= deduction ? deduction : serviceDiscountedAmount

      serviceAmount = serviceDiscountedAmount - serviceDeductionAmount

      deduction = serviceDiscountedAmount >= deduction ? 0 : deduction - serviceDiscountedAmount
    }

    if (enabledServiceTax && serviceTax && excludedServiceTax) {
      appointmentTaxAmount = useTaxAmount(serviceTax, serviceAmount)
    } else if (enabledServiceTax && serviceTax && !excludedServiceTax) {
      serviceAmount = useTaxedAmount(
        (appointment.aggregatedPrice ? appointment.persons : 1) * appointment.price,
        serviceTax
      )

      let serviceTaxAmount = useTaxAmount(serviceTax, serviceAmount - serviceDiscountAmount - serviceDeductionAmount)

      if (includedTaxInTotal) {
        appointmentTotalAmount = serviceAmount + serviceTaxAmount

        appointmentServiceAmount = serviceAmount + serviceTaxAmount
      } else {
        appointmentTotalAmount = serviceAmount

        appointmentServiceAmount = serviceAmount

        appointmentTaxAmount = serviceTaxAmount
      }
    }

    appointmentDiscountAmount = serviceDiscountAmount + serviceDeductionAmount

    appointment.extras.forEach((selectedExtra) => {
      let extraTax = null

      let excludedExtraTax = settings.payments.taxes.excluded

      let enabledExtraTax = settings.payments.taxes.enabled

      if ('tax' in selectedExtra) {
        extraTax = selectedExtra.tax && selectedExtra.tax.length ? selectedExtra.tax[0] : null

        excludedExtraTax = extraTax ? extraTax.excluded : excludedExtraTax

        enabledExtraTax = extraTax !== null
      } else if (enabledExtraTax) {
        extraTax = useEntityTax(store, selectedExtra.extraId, 'extra')
      }

      let extraAggregatedPrice = selectedExtra.aggregatedPrice === null ? appointment.aggregatedPrice : selectedExtra.aggregatedPrice

      let extraAmount = useExtraAmount(selectedExtra, extraAggregatedPrice, appointment.persons)

      let extraTotalAmount = extraAmount

      if (enabledExtraTax && extraTax && !excludedExtraTax) {
        extraAmount = useTaxedAmount(extraAmount, extraTax)
      }

      let extraDiscountAmount = appointment.coupon.discount
        ? usePercentageAmount(extraAmount, appointment.coupon.discount)
        : 0

      let extraDiscountedAmount = extraAmount - extraDiscountAmount

      extraAmount = extraDiscountedAmount

      let extraDeductionAmount = 0

      if (extraDiscountedAmount > 0 && deduction > 0) {
        extraDeductionAmount = extraDiscountedAmount >= deduction ? deduction : extraDiscountedAmount

        extraAmount = extraDiscountedAmount - extraDeductionAmount

        deduction = extraDiscountedAmount >= deduction ? 0 : deduction - extraDiscountedAmount
      }

      if (enabledExtraTax && extraTax && excludedExtraTax) {
        appointmentTaxAmount += useTaxAmount(extraTax, extraAmount)
      } else if (enabledExtraTax && extraTax && !excludedExtraTax) {
        extraAmount = useTaxedAmount(
          useExtraAmount(selectedExtra, extraAggregatedPrice, appointment.persons),
          extraTax
        )

        let extraTaxAmount = useTaxAmount(extraTax, extraAmount - extraDiscountAmount - extraDeductionAmount)

        if (includedTaxInTotal) {
          extraTotalAmount = extraAmount + extraTaxAmount
        } else {
          extraTotalAmount = extraAmount

          appointmentTaxAmount += extraTaxAmount
        }
      } else if (enabledExtraTax && !extraTax && !excludedExtraTax) {
        extraTotalAmount = useExtraAmount(selectedExtra, extraAggregatedPrice, appointment.persons)
      }

      appointmentTotalAmount += extraTotalAmount

      appointmentDiscountAmount += extraDiscountAmount + extraDeductionAmount
    })
  } else {
    if (enabledServiceTax && serviceTax && excludedServiceTax) {
      appointmentTaxAmount = useTaxAmount(serviceTax, serviceAmount)
    } else if (enabledServiceTax && serviceTax && !excludedServiceTax && !includedTaxInTotal) {
      serviceAmount = useTaxedAmount(
        (appointment.aggregatedPrice ? appointment.persons : 1) * appointment.price,
        serviceTax
      )

      appointmentTaxAmount = useTaxAmount(serviceTax, serviceAmount)
    }

    appointmentTotalAmount = serviceAmount

    appointmentServiceAmount = serviceAmount

    appointment.extras.forEach((selectedExtra) => {
      let extraAggregatedPrice = selectedExtra.aggregatedPrice === null ? appointment.aggregatedPrice : selectedExtra.aggregatedPrice

      let extraAmount = useExtraAmount(selectedExtra, extraAggregatedPrice, appointment.persons)

      let extraTax = null

      let excludedExtraTax = settings.payments.taxes.excluded

      let enabledExtraTax = settings.payments.taxes.enabled

      if ('tax' in selectedExtra) {
        extraTax = selectedExtra.tax && selectedExtra.tax.length ? selectedExtra.tax[0] : null

        excludedExtraTax = extraTax ? extraTax.excluded : excludedExtraTax

        enabledExtraTax = extraTax !== null
      } else if (enabledExtraTax) {
        extraTax = useEntityTax(store, selectedExtra.extraId, 'extra')
      }

      if (enabledExtraTax && extraTax && excludedExtraTax) {
        appointmentTaxAmount += useTaxAmount(extraTax, extraAmount)
      } else if (enabledExtraTax && extraTax && !excludedExtraTax && !includedTaxInTotal) {
        extraAmount = useTaxedAmount(
          useExtraAmount(selectedExtra, extraAggregatedPrice, appointment.persons),
          extraTax
        )

        appointmentTaxAmount += useTaxAmount(extraTax, extraAmount)
      }

      appointmentTotalAmount += extraAmount
    })
  }

  return {
    total: appointmentTotalAmount,
    bookable: appointmentServiceAmount,
    discount: appointmentDiscountAmount,
    tax: appointmentTaxAmount
  }
}

function useTaxLabel (store, label) {
  let taxes = {}

  useCart(store).forEach((item) => {
    item.services[item.serviceId].list.forEach((appointment) => {
      let serviceTax = useEntityTax(store, item.serviceId, 'service')

      if (serviceTax) {
        taxes[serviceTax.id] = serviceTax.name
      }

      appointment.extras.forEach((selectedExtra) => {
        let extraTax = useEntityTax(store, selectedExtra.extraId, 'extra')

        if (extraTax) {
          taxes[extraTax.id] = extraTax.name
        }
      })
    })
  })

  return Object.keys(taxes).length === 1 ? Object.values(taxes)[0] : label
}

function useAppointmentsAmountInfo (store) {
  let amountsInfo = []

  let coupon = store.getters['booking/getCoupon']

  let couponLimit = coupon && coupon.limit ? coupon.limit : 0

  useCart(store).forEach((item) => {
    let amountData = useAppointmentAmountData(store, item, coupon, couponLimit)

    couponLimit = amountData.couponLimit

    delete (amountData.couponLimit)

    amountsInfo.push(amountData)
  })

  return amountsInfo
}

function useCapacity (employeeServices) {
  let options = {
    availability: false,
    min: 0,
    max: 0
  }

  let serviceMinCapacity = 0

  if (employeeServices.length && employeeServices.length > 1) {
    employeeServices.forEach(service => {
      serviceMinCapacity = service.minCapacity

      options.availability = service.bringingAnyone && service.maxCapacity > 1 && (service.maxExtraPeople === null || service.maxExtraPeople > 0)

      if (service.maxCapacity > options.max || options.max === 0) {
        options.max = service.maxExtraPeople !== null ? (service.maxExtraPeople + 1) : service.maxCapacity
      }

      if (options.min < service.minCapacity) {
        options.min = settings.appointments.allowBookingIfNotMin ? 1 : service.minCapacity
      }
    })

  } else if (employeeServices.length && employeeServices.length === 1) {
    let service = employeeServices[0]

    serviceMinCapacity = service.minCapacity

    options.availability = service.bringingAnyone && service.maxCapacity > 1 && (service.maxExtraPeople === null || service.maxExtraPeople > 0)
    options.min = settings.appointments.allowBookingIfNotMin ? 1 : service.minCapacity
    options.max = service.maxExtraPeople !== null && service.maxExtraPeople < service.maxCapacity ? (service.maxExtraPeople + 1) : service.maxCapacity
  }

  if (settings.appointments.openedBookingAfterMin) {
    options.min = serviceMinCapacity
  }

  options.max = options.max > 1 ? (options.max - 1) : options.max
  options.min = options.min > 0 ? (options.min - 1) : options.min

  return options
}

function usePaymentError (store, message) {
  store.commit('booking/setError', message)
}

function usePrepaidPrice (store) {
  let type = store.getters['bookableType/getType'] ? store.getters['bookableType/getType'] : store.getters['booking/getBookableType']

  let entity = null

  switch (type) {
    case 'appointment':
      let appointmentPrice = 0

      useCart(store).forEach((item) => {
        if ((item.serviceId && (item.serviceId in item.services)) || item.packageId) {
          entity = store.getters['entities/getService'](
            item.serviceId
          )

          appointmentPrice += useAppointmentsTotalAmount(
            store,
            entity,
            useAppointmentsPayments(
              store,
              item.serviceId,
              item.services[item.serviceId].list
            ).prepaid
          )
        }
      })

      return appointmentPrice
    case 'package':
      let price = 0

      if (useCart(store)[0].packageId) {
        entity = store.getters['entities/getPackage'](
          useCart(store)[0].packageId
        )

        price = entity.price
      }

      return price
    case 'event':
      entity = store.getters['eventEntities/getEvent'](store.getters['eventBooking/getSelectedEventId'])

      let eventPrice = 0

      if (entity.customPricing) {
        let tickets = store.getters['tickets/getTicketsData']

        tickets.forEach(t => {
          eventPrice += t.price * t.persons
        })

        return eventPrice
      }

      let persons = store.getters['persons/getPersons']

      return entity.price * persons
  }
}

function useDuration (serviceDuration, extras) {
  let duration = serviceDuration

  extras.forEach((extra) => {
    duration += (extra.duration * extra.quantity)
  })

  return duration
}

function useCalendarEvents (slots) {
  let calendarSlotsValues = []

  useSortedDateStrings(Object.keys(slots)).forEach((date) => {
    calendarSlotsValues.push({
      title  : 'e',
      start  : date,
      display: 'background',
      extendedProps: {
        slotsTotal: 100,
        slotsAvailable: 1,
        slots: slots[date]
      }
    })
  })

  return calendarSlotsValues
}

function useServices (store) {
  let type = store.getters['booking/getBookableType']

  let services = null

  switch (type) {
    case ('appointment'): {
      services = store.getters['entities/getServices']

      break
    }

    case ('package'): {
      let packages = store.getters['entities/getPackages']

      let packagesServices = {}

      packages.forEach((pack) => {
        pack.bookable.forEach((book) => {
          packagesServices[book.service.id] = book.service
        })
      })

      services = Object.values(packagesServices)

      break
    }
  }

  return services
}

function useBusySlots (store) {
  let cartItem = useCartItem(store)

  let activeAppointment = cartItem.services[cartItem.serviceId].list[cartItem.index]

  let busySlots = store.getters['booking/getMultipleAppointmentsOccupied']

  return busySlots[activeAppointment.date] ? Object.keys(busySlots[activeAppointment.date]) : []
}

function useAvailableSlots (store) {
  let cart = store.getters['booking/getAllMultipleAppointments']

  let cartIndex = store.getters['booking/getCartItemIndex']

  let activeAppointment = cart[cartIndex].services[cart[cartIndex].serviceId].list[cart[cartIndex].index]

  let services = useServices(store)

  if (activeAppointment.date) {
    let selectedSlots = []

    cart.forEach((cartItem, selectedCartIndex) => {
      for (let serviceId in cartItem.services) {
        let service = services.find(i => i.id === parseInt(serviceId))

        cartItem.services[serviceId].list.forEach((i, selectedListIndex) => {
          let isCurrentAppointment = selectedCartIndex === parseInt(cartIndex) &&
              selectedListIndex === parseInt(cart[cartIndex].index) &&
              (cartItem.packageId ? parseInt(cartItem.serviceId) === parseInt(serviceId) : true)

          if (i.date && i.date === activeAppointment.date && i.time && !isCurrentAppointment) {
            selectedSlots.push({
              time: i.time,
              duration: service.duration + i.extras.filter(e => e.quantity && e.duration).map(e => e.duration).reduce((fullDuration, duration) => fullDuration + duration, 0),
              timeAfter: service.timeAfter,
              timeBefore: service.timeBefore
            })
          }
        })
      }
    })

    let service = services.find(i => i.id === cart[cartIndex].serviceId)

    let defaultSlots = Object.keys(cart[cartIndex].services[cart[cartIndex].serviceId].slots[activeAppointment.date])

    let availableSlots = {}

    for (let i = 0; i < defaultSlots.length; i++) {
      let defaultSlotSeconds = useTimeInSeconds(defaultSlots[i])

      let isFreeSlot = true

      for (let j = 0; j < selectedSlots.length; j++) {
        let slotInSeconds = useTimeInSeconds(selectedSlots[j].time)

        if (defaultSlotSeconds > (slotInSeconds - service.duration - service.timeAfter) &&
          defaultSlotSeconds < (slotInSeconds + selectedSlots[j].duration + selectedSlots[j].timeBefore + service.timeAfter)
        ) {
          isFreeSlot = false

          break
        }
      }

      if (isFreeSlot) {
        availableSlots[defaultSlots[i]] = useTimeInSeconds(defaultSlots[i])
      }
    }

    return useSortedDateStrings(Object.keys(availableSlots))
  }

  return 'slots' in activeAppointment ? activeAppointment.slots : []
}

function useFillAppointments (store) {
  let cartItem = useCartItem(store)

  if (!cartItem.packageId &&
    Object.keys(cartItem.services).length === 1 &&
    cartItem.services[cartItem.serviceId].list.length === 1
  ) {
    let booking = cartItem.services[cartItem.serviceId].list[0]

    if (!booking.providerId && booking.date && booking.time) {
      let employeesIds = cartItem.services[cartItem.serviceId].slots[booking.date][booking.time].map(
        i => i[0]
      ).filter(
        (v, i, a) => a.indexOf(v) === i
      )

      if (settings.roles.limitPerEmployee.enabled) {
        let chosenEmployees = store.getters['booking/getAllMultipleAppointments'].map(a => Object.values(a.services)[0].list[0])
        let appCount = store.getters['booking/getMultipleAppointmentsAppCount'](cartItem.serviceId);
        let result = checkLimitPerEmployee(employeesIds, 0, [], booking, appCount, chosenEmployees, cartItem.serviceId)
        if (result.bookingFailed !== null) {
          return {booking: result.bookingFailed, serviceId: parseInt(cartItem.serviceId)}
        }
        employeesIds = result.employeeIds
      }

      if (settings.appointments.employeeSelection === 'random') {
        booking.providerId = employeesIds[Math.floor(Math.random() * (employeesIds.length) + 1) - 1]
      } else {
        employeesIds = sortForEmployeeSelection(store, employeesIds, cartItem.serviceId)
        booking.providerId = employeesIds[0]
      }
    }

    if (!booking.locationId && booking.date && booking.time) {
      let locationsIds = cartItem.services[cartItem.serviceId].slots[booking.date][booking.time].filter(
        i => i[0] === booking.providerId
      ).map(i => i[1])

      booking.locationId = locationsIds.length ? getPreferredEntityId(
        cartItem.services[cartItem.serviceId].slots[booking.date],
        booking.date in cartItem.services[cartItem.serviceId].occupied
          ? cartItem.services[cartItem.serviceId].occupied[booking.date] : {},
        booking.time,
        booking.providerId,
        locationsIds,
        1
      ) : null
    }

    let slots = store.getters['booking/getMultipleAppointmentsSlots']

    let existingApp = booking.date in slots && booking.time in slots[booking.date] &&  slots[booking.date][booking.time].length > 0 ?
      slots[booking.date][booking.time].find(s => s[0] === booking.providerId) : null

    store.commit('booking/setMultipleAppointmentsExistingApp', existingApp && existingApp[2] && existingApp[2] > 0)
  } else {
    let chosenEmployees = []
    for (let serviceId of Object.keys(cartItem.services)) {
      if (cartItem.services[serviceId].list.length &&
          cartItem.services[serviceId].list.filter(i => i.date && i.time).length
      ) {
        let bookingFailed = setPreferredEntitiesData(cartItem.services[serviceId], store, serviceId, chosenEmployees)
        if (bookingFailed !== null) {
          return {booking: bookingFailed, serviceId: parseInt(serviceId)}
        }
        chosenEmployees = chosenEmployees.concat(cartItem.services[serviceId].list.map((l) => { return { date: l.date, providerId: l.providerId, serviceId: serviceId, existingApp: l.existingApp} }))
      }
    }
  }

  let activeItemServices = cartItem.services

  Object.keys(activeItemServices).forEach((serviceId) => {
    if (activeItemServices[serviceId].list.filter(i => i.date && i.time).length) {
      activeItemServices[serviceId].list.forEach((booking) => {
        if (booking.date && booking.time) {
          setProviderServicePrice(store, booking.providerId, serviceId)
        }
      })
    }
  })

  return null
}

function setProviderServicePrice (store, employeeId, serviceId) {
  let employee = store.getters['entities/getUnfilteredEmployee'](employeeId)

  let service = employee.serviceList.find(i => i.id === parseInt(serviceId))

  let duration = store.getters['booking/getDuration']

  if (store.getters['booking/getDuration'] in service.customPricing.durations) {
    service.duration = duration

    service.price = service.customPricing.durations[duration].price
  }
}

function useAppointmentsAmount (store, service, appointments) {
  let amount = 0

  appointments.forEach((appointment) => {
    amount += useAppointmentServiceAmount(
      useEmployeeService(store, service.id, appointment.providerId),
      appointment.persons,
      appointment.duration
    )
  })

  return amount
}

function useExtraAmount (extra, serviceAggregatedPrice, persons) {
  let extraAggregatedPrice = extra.aggregatedPrice === null ? serviceAggregatedPrice : extra.aggregatedPrice

  return extra.price * extra.quantity * (extraAggregatedPrice ? persons : 1)
}

function useAppointmentExtraAmount (service, selectedExtra, persons) {
  let extra = service.extras.find(item => item.id === parseInt(selectedExtra.extraId))

  if (extra) {
    let extraAggregatedPrice = extra.aggregatedPrice === null ? service.aggregatedPrice : extra.aggregatedPrice

    return extra.price * selectedExtra.quantity * (extraAggregatedPrice ? persons : 1)
  }

  return 0
}

function useAppointmentExtrasAmount (service, appointments) {
  let amount = 0

  appointments.forEach((appointment) => {
    if (appointment.extras) {
      appointment.extras.forEach((selectedExtra) => {
        amount += useAppointmentExtraAmount(service, selectedExtra, appointment.persons)
      })
    }
  })

  return amount
}

function useAppointmentsTotalAmount (store, service, appointments) {
  return useAppointmentsAmount(store, service, appointments) + useAppointmentExtrasAmount(service, appointments)
}

function useAppointmentsPayments (store, serviceId, appointments) {
  let service = store.getters['entities/getService'](
    serviceId
  )

  let prepaidCount = 1

  if (service.recurringPayment) {
    prepaidCount = service.recurringPayment > appointments.length
      ? appointments.length : service.recurringPayment
  }

  return {
    prepaid: appointments.slice(0, prepaidCount),
    postpaid: appointments.slice(prepaidCount),
  }
}

function setPreferredEntitiesData (bookings, store, serviceId, chosenEmployees) {
  let employeesIds = getAllEntitiesIds(bookings, 0)

  let locationsIds = getAllEntitiesIds(bookings, 1)

  let isSingleEmployee = employeesIds.length === 1

  let isSingleLocation = locationsIds.length === 1

  let appCount = store.getters['booking/getMultipleAppointmentsAppCount'](serviceId);

  for (let bookingIndex = 0; bookingIndex < bookings.list.length; bookingIndex++) {
    let booking = bookings.list[bookingIndex]
    if (booking.date && booking.time) {
      employeesIds = sortForEmployeeSelection(store, employeesIds, serviceId)

      if (settings.roles.limitPerEmployee.enabled) {
        let result = checkLimitPerEmployee(employeesIds, bookingIndex, bookings.list, booking, appCount, chosenEmployees, serviceId)
        if (result.bookingFailed !== null) {
          return result.bookingFailed
        }
        employeesIds = result.employeeIds
      }

      if (!locationsIds.length && isSingleEmployee) {
        booking.providerId = employeesIds[0]

        booking.locationId = null
      } else if (!locationsIds.length && !isSingleEmployee) {
        booking.locationId = null

        for (let i = 0; i < employeesIds.length; i++) {
          for (let j = 0; j < bookings.slots[booking.date][booking.time].length; j++) {
            if (bookings.slots[booking.date][booking.time][j][0] === employeesIds[i]) {
              booking.providerId = employeesIds[i]

              break
            }
          }
        }
      } else if (isSingleLocation && isSingleEmployee) {
        booking.providerId = employeesIds[0]

        booking.locationId = locationsIds[0]
      } else if (!isSingleLocation && isSingleEmployee) {
        booking.providerId = employeesIds[0]

        booking.locationId = getPreferredEntityId(
          bookings.slots[booking.date],
          booking.date in bookings.occupied ? bookings.occupied[booking.date] : {},
          booking.time,
          booking.providerId,
          locationsIds,
          1
        )
      } else if (isSingleLocation && !isSingleEmployee) {
        booking.locationId = locationsIds[0]

        booking.providerId = getPreferredEntityId(
          bookings.slots[booking.date],
          booking.date in bookings.occupied ? bookings.occupied[booking.date] : {},
          booking.time,
          booking.locationId,
          employeesIds,
          0
        )
      } else {
        let setEntities = false
        outsideLoop: for (let j = 0; j < employeesIds.length; j++) {
          for (let i = 0; i < locationsIds.length; i++) {
            let isPreferred = isPreferredLocationAndEmployee(
              bookings.slots[booking.date],
              booking.date in bookings.occupied ? bookings.occupied[booking.date] : {},
              booking.time,
              locationsIds[i],
              employeesIds[j]
            )

            if (isPreferred) {
              booking.providerId = employeesIds[j]

              booking.locationId = locationsIds[i]

              setEntities = true

              break outsideLoop
            }
          }
        }

        if (!setEntities) {
          outsideLoop2: for (let j = 0; j < employeesIds.length; j++) {
            for (let i = 0; i < locationsIds.length; i++) {
              for (let k = 0; k < bookings.slots[booking.date][booking.time].length; k++) {
                if (bookings.slots[booking.date][booking.time][k][0] === employeesIds[j] &&
                    bookings.slots[booking.date][booking.time][k][1] === locationsIds[i]
                ) {
                  booking.providerId = employeesIds[j]

                  booking.locationId = locationsIds[i]

                  break outsideLoop2
                }
              }
            }
          }
        }
      }

      let slots = store.getters['booking/getMultipleAppointmentsSlots']
      let existingApp = booking.date in slots && booking.time in slots[booking.date] &&  slots[booking.date][booking.time].length > 0 ?
          slots[booking.date][booking.time].find(s => s[0] === booking.providerId) : null
      bookings.list[bookingIndex].existingApp = existingApp && existingApp[2] && existingApp[2] > 0

      store.commit('booking/setLastBookedProviderId', {providerId: booking.providerId, fromBackend: false})

    }
  }

  return null
}

function getAllEntitiesIds (bookings, index) {
  let ids = {}

  for (let i = 0; i < bookings.list.length; i++) {
    if (bookings.list[i].date && bookings.list[i].time) {
      bookings.slots[bookings.list[i].date][bookings.list[i].time].forEach((slotData) => {
        if (slotData[index]) {
          if (!(slotData[index] in ids)) {
            ids[slotData[index]] = 0
          }

          ids[slotData[index]]++
        }
      })
    }
  }

  let sortedEntitiesIds = []

  Object.keys(ids).forEach((id) => {
    sortedEntitiesIds.push({id: parseInt(id), quantity: ids[id]})
  })

  sortedEntitiesIds.sort((a, b) => b.quantity - a.quantity)

  return sortedEntitiesIds.map(entity => entity.id)
}

function getPreferredEntityId (availableSlots, occupiedSlots, timeString, selectedId, allIds, targetIndex) {
  let searchIndex = targetIndex ? 0 : 1

  let appointmentsStarts = {}

  Object.keys(occupiedSlots).forEach((time) => {
    occupiedSlots[time].forEach((slotData) => {
      if (slotData[searchIndex] === selectedId) {
        appointmentsStarts[useTimeInSeconds(time)] = slotData[targetIndex]
      }
    })
  })

  Object.keys(availableSlots).forEach((time) => {
    availableSlots[time].forEach((slotData) => {
      if (slotData.length >= 3 && slotData[searchIndex] === selectedId) {
        appointmentsStarts[useTimeInSeconds(time)] = slotData[targetIndex]
      }
    })
  })

  let availableIds = []

  availableSlots[timeString].forEach((slotData) => {
    if (slotData[searchIndex] === selectedId) {
      availableIds.push(slotData[targetIndex])
    }
  })

  if (Object.keys(appointmentsStarts).length) {
    let timeInSeconds = useTimeInSeconds(timeString)

    let closestSlot = Object.keys(appointmentsStarts).reduce((a, b) => {
      return Math.abs(b - timeInSeconds) < Math.abs(a - timeInSeconds) ? b : a
    })

    if (availableIds.indexOf(appointmentsStarts[closestSlot]) !== -1) {
      return appointmentsStarts[closestSlot]
    }
  }

  for (let i = 0; i < allIds.length; i++) {
    for (let j = 0; j < availableSlots[timeString].length; j++) {
      if (availableSlots[timeString][j][searchIndex] === selectedId &&
        allIds[i] === availableSlots[timeString][j][targetIndex]
      ) {
        return availableSlots[timeString][j][targetIndex]
      }
    }
  }

  return null
}

function isPreferredLocationAndEmployee (slotsData, occupiedData, timeString, locationId, employeeId) {
  let isEmployeeLocation = false

  slotsData[timeString].forEach((slotData) => {
    if (slotData[0] === employeeId && slotData[1] === locationId) {
      isEmployeeLocation = true
    }
  })

  // inspect if employee is available on proposed location
  if (!isEmployeeLocation) {
    return false
  }

  let appointmentStarts = {
    onLocation: {},
    offLocation: {}
  }

  Object.keys(occupiedData).forEach((time) => {
    occupiedData[time].forEach((slotData) => {
      if (slotData[0] === employeeId && slotData[1] === locationId) {
        appointmentStarts.onLocation[useTimeInSeconds(time)] = slotData[1]
      } else if (slotData[0] === employeeId) {
        appointmentStarts.offLocation[useTimeInSeconds(time)] = slotData[1]
      }
    })
  })

  Object.keys(slotsData).forEach((time) => {
    slotsData[time].forEach((slotData) => {
      if (slotData.length >= 3 && slotData[0] === employeeId && slotData[1] === locationId) {
        appointmentStarts.onLocation[useTimeInSeconds(time)] = slotData[1]
      } else if (slotData.length >= 3 && slotData[0] === employeeId) {
        appointmentStarts.offLocation[useTimeInSeconds(time)] = slotData[1]
      }
    })
  })

  // inspect if employee has appointments only on proposed location, or has no appointments in that day
  if (
    (!Object.keys(appointmentStarts.onLocation).length && !Object.keys(appointmentStarts.offLocation).length) ||
    (Object.keys(appointmentStarts.onLocation).length && !Object.keys(appointmentStarts.offLocation).length)
  ) {
    return true
  }

  let timeInSeconds = useTimeInSeconds(timeString)

  appointmentStarts = Object.assign(appointmentStarts.onLocation, appointmentStarts.offLocation)

  let closestTime = Object.keys(appointmentStarts).reduce((a, b) => {
    return Math.abs(b - timeInSeconds) < Math.abs(a - timeInSeconds) ? b : a
  })

  return locationId === appointmentStarts[closestTime]
}

export {
  useCapacity,
  useAvailableSlots,
  useBusySlots,
  useFillAppointments,
  useCalendarEvents,
  useAppointmentsPayments,
  useAppointmentsAmountInfo,
  useAppointmentServiceAmount,
  useAppointmentExtrasAmount,
  useAppointmentExtraAmount,
  useAppointmentsAmount,
  useAppointmentsTotalAmount,
  useDuration,
  usePrepaidPrice,
  usePaymentError,
  useServices,
  useEmployeeService,
  useTaxLabel,
  useAppointmentBookingAmountData,
}
