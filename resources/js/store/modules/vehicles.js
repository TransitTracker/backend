import collect from 'collect.js/src/index.js'

const state = {
  data: [],
  geojson: [],
  selection: {
    id: null,
    coordinates: {},
    agency: {},
  },
}

const mutations = {
  setData (state, vehicles) {
    state.data = state.data.concat(vehicles)
  },
  setGeojson (state, data) {
    state.geojson[data.agency] = data.data
  },
  setSelection (state, selection) {
    state.selection = selection
  },
  emptyData (state, agencyId) {
    if (agencyId === 'all') {
      state.data = []
    } else {
      const vehicles = collect(state.data)
      state.data = vehicles.filter((vehicle, key) => vehicle.agency_id !== agencyId).items
      state.selection = { id: null }
    }
  },
}

export default {
  namespaced: true,
  state,
  mutations,
}
