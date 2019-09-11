import collect from 'collect.js/src/index.js'

const state = {
  data: [],
  selection: {
    id: null
  }
}

const mutations = {
  setData (state, vehicles) {
    state.data = state.data.concat(vehicles)
  },
  setSelection (state, selectedVehicle) {
    state.selection = selectedVehicle
  },
  emptyData (state, agencyId) {
    const vehicles = collect(state.data)
    state.data = vehicles.filter((vehicle, key) => vehicle.agency_id !== agencyId).items
  }
}

export default {
  namespaced: true,
  state,
  mutations
}
