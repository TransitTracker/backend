const state = {
    data: []
}

const mutations = {
    setData(state, agencies) {
        state.data = agencies
    }
}

export default {
    namespaced: true,
    state,
    mutations
}