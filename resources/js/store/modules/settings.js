const state = {
  activeAgencies: ['stm'],
  autoRefresh: false,
  defaultPath: '/',
  configurationDone: false,
  language: 'en'
}

const mutations = {
  setActiveAgencies (state, agencies) {
    state.activeAgencies = agencies
  },
  setAutoRefresh (state, newSetting) {
    state.autoRefresh = newSetting
  },
  setDefaultPath (state, newSetting) {
    state.defaultPath = newSetting
  },
  setConfigurationDone (state, newSetting) {
    state.configurationDone = newSetting
  },
  setLanguage (state, newSetting) {
    state.language = newSetting
  }
}

export default {
  namespaced: true,
  state,
  mutations
}
