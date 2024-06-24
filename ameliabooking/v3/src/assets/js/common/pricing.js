function useAmount (entity, coupon, entityTax, subTotal, includedTaxInTotal) {
  let excludedTax = entityTax ? entityTax.excluded : false

  let discount = 0

  if (coupon && coupon.limit) {
    discount = entityTax && !excludedTax
      ? usePercentageAmount(useTaxedAmount(subTotal, entityTax), coupon.discount) + coupon.deduction
      : usePercentageAmount(subTotal, coupon.discount) + coupon.deduction
  }

  let tax = 0

  if (entityTax && excludedTax) {
    tax = useTaxAmount(entityTax, subTotal - discount)
  } else if (entityTax && !excludedTax) {
    let baseAmount = useTaxedAmount(subTotal, entityTax)

    tax = useTaxAmount(entityTax, baseAmount - discount)

    if (includedTaxInTotal) {
      subTotal = baseAmount + tax

      tax = 0
    } else {
      subTotal = baseAmount
    }
  }

  return {
    price: subTotal,
    discount: discount,
    tax: tax,
    deposit: entity ? useDepositAmount(subTotal - discount + tax, entity) : 0,
  }
}

function useTaxVisibility (store, id, type) {
  let amSettings = store.getters['getSettings']
  let tax = useEntityTax(store, id, type)

  if (!amSettings.payments.taxes.enabled) {
    return false
  }

  return !!tax?.[`${type}List`].length
}

function useEntityTax (store, entityId, entityType) {
  let tax = store.getters[entityType !== 'event' ? 'entities/getTaxes' : 'eventEntities/getTaxes'].find(
    t => t[entityType + 'List'].find(s => s.id === entityId)
  )

  return tax && typeof tax !== 'undefined' && ('status' in tax ? tax.status === 'visible' : true) ? tax : null
}

function useTaxAmount (tax, amount) {
  switch (tax.type) {
    case ('percentage'):
      return usePercentageAmount(amount, tax.amount)
    case ('fixed'):
      return tax.amount
  }
}

function useTaxedAmount (value, tax) {
  switch (tax.type) {
    case ('percentage'):
      return value / (1 + tax.amount / 100)
    case ('fixed'):
      return value - tax.amount
  }
}

function useDepositAmount (totalAmount, entity) {
  let depositAmount = 0

  if (entity.depositPayment !== 'disabled') {
    switch (entity.depositPayment) {
      case ('fixed'):
        depositAmount = entity.deposit

        break

      case 'percentage':
        depositAmount = usePercentageAmount(totalAmount, entity.deposit)

        break
    }
  }

  return useRoundAmount(totalAmount > depositAmount ? depositAmount : 0)
}

function usePercentageAmount (amount, percentage) {
  return amount * percentage / 100
}

function useRoundAmount (amount) {
  return Math.round(amount * 100) / 100
}

export {
  useAmount,
  useDepositAmount,
  useTaxVisibility,
  useEntityTax,
  usePercentageAmount,
  useRoundAmount,
  useTaxAmount,
  useTaxedAmount,
}
