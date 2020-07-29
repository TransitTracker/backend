const state = {
  data: {},
  geojson: {},
  selection: {
    id: null,
    coordinates: [],
    agency: {},
  },
}

const mutations = {
  setData (state, payload) {
    state.data[payload.agencySlug] = payload.data
  },
  setGeojson (state, payload) {
    state.geojson[payload.agencySlug] = payload.data
  },
  setSelection (state, selection) {
    state.selection = selection
  },
  emptyData (state, agencySlug) {
    if (agencySlug === 'all') {
      state.data = {}
      state.geojson = {}
    } else {
      state.data[agencySlug] = []
      state.geojson[agencySlug] = {}
    }
    state.selection = { agency: {}, coordinates: [], id: null }
  },
}

export default {
  namespaced: true,
  state,
  mutations,
}
