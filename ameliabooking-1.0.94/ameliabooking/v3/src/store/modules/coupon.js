export default {
  namespaced: true,

  state: () => ({
    code: '',
    discount: '',
    deduction: '',
    limit: '',
    error: '',
    loading: false,
    required: false,
    payPalActions: null,
    servicesIds: [],
  }),

  getters: {
    getCoupon (state) {
      return {
        code: state.code,
        discount: state.discount,
        deduction: state.deduction,
        limit: state.limit,
        required: state.required,
        servicesIds: state.servicesIds,
      }
    },

    getCouponValidated (state) {
      return !state.required || (state.code !== '')
    },

    getCode (state) {
      return state.code
    },

    getError (state) {
      return state.error
    },

    getLoading (state) {
      return state.loading
    },

    getPayPalActions (state) {
      return state.payPalActions
    },
  },

  mutations: {
    setCoupon (state, payload) {
      state.code = payload.code
      state.discount = payload.discount
      state.deduction = payload.deduction
      state.limit = payload.limit
      state.servicesIds = payload.servicesIds
    },

    setCode (state, payload) {
      state.code = payload
    },

    setError (state, payload) {
      state.error = payload
    },

    setLoading (state, payload) {
      state.loading = payload
    },

    setCouponRequired (state, payload) {
      state.required = payload
    },

    setPayPalActions (state, payload) {
      state.payPalActions = payload
    },

    enablePayPalActions (state) {
      if (state.payPalActions) {
        state.payPalActions.enable()
      }
    },

    disablePayPalActions (state) {
      if (state.payPalActions) {
        state.payPalActions.disable()
      }
    },
  },

  actions: {
    resetCoupon ({commit}) {
      commit('setCoupon', {
        code: '',
        discount: '',
        deduction: '',
        limit: '',
        servicesIds: [],
      })
    }
  }
}
