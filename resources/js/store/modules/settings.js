const state = {
    activeAgencies: ["stm"],
    autoRefresh: false,
    defaultPath: '/',
    onboardingDone: false,
}

const mutations = {
    setActiveAgencies(state, agencies) {
        state.activeAgencies = agencies;
    },
    setAutoRefresh(state, newSetting) {
        state.autoRefresh = newSetting;
    },
    setDefaultPath(state, newSetting) {
        state.defaultPath = newSetting;
    },
    setOnboardingDone(state, newSetting) {
        state.onboardingDone = newSetting;
    }
}

export default {
    namespaced: true,
    state,
    mutations
}