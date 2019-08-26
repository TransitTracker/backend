const state = {
  data: [],
  counts: []
}

const mutations = {
  setData (state, agencies) {
    state.data = agencies
  },
  setCount (state, payload) {
    state.counts = state.counts.concat([payload])
  },
  emptyCounts (state) {
    state.counts = []
  }
}

export default {
  namespaced: true,
  state,
  mutations
}
