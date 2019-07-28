import collect from 'collect.js'

const state = {
    data: []
}

const mutations = {
    setData(state, agencies) {
        state.data = agencies
    },
    setCount(state, agency, count) {
        // collect(state.data).firstWhere('slug', agency).push(count)
    }
}

export default {
    namespaced: true,
    state,
    mutations
}