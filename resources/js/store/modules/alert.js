const state = {
  data: {
    body_en: null,
    body_fr: null,
    can_be_closed: null,
    color: null,
    icon: null,
    id: null,
    title_en: null,
    title_fr: null
  },
  isVisible: false
}

const mutations = {
  setData (state, newAlert) {
    state.data = newAlert
  },
  setVisibility (state, newSetting) {
    state.isVisible = newSetting
  }
}

export default {
  namespaced: true,
  state,
  mutations
}
