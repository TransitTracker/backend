const state = {
    data: [],
    selection: {
        id: null,
    }
}

const mutations = {
    setData(state, vehicles) {
        state.data = state.data.concat(vehicles);
    },
    setSelection(state, selectedVehicle) {
        state.selection = selectedVehicle;
    }
}

export default {
    namespaced: true,
    state,
    mutations
}