const state = {
  loading: false,
}
const mutations = {
  loadingStateMutation(state, loading) {
    state.loading = loading
  },
}

const actions = {}

const getters = {
  getLoadingState: state => state.loading
}

export default {
  namespaced: true,
  state,
  mutations,
  actions,
  getters,
}