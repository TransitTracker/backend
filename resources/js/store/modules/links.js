const state = {
  data: []
}

const mutations = {
  setData (state, links) {
    state.data = links
  }
}

export default {
  namespaced: true,
  state,
  mutations
}
