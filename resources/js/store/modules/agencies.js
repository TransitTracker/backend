import collect from 'collect.js/src/index.js'

const state = {
  data: [],
  counts: [],
}

const mutations = {
  setData (state, agencies) {
    state.data = agencies
  },
  setCount (state, payload) {
    state.counts = state.counts.concat([payload])
  },
  emptyCount (state, agencySlug) {
    if (agencySlug === 'all') {
      state.counts = []
    } else {
      const counts = collect(state.counts)
      state.counts = counts.reject(count => count.agency === agencySlug).items
    }
  },
}

export default {
  namespaced: true,
  state,
  mutations,
}
