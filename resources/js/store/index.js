import Vue from 'vue'
import Vuex from 'vuex'
import agencies from './modules/agencies'
import vehicles from './modules/vehicles'
import settings from './modules/settings'
import VuexPersistence from 'vuex-persist'

Vue.use(Vuex)

const debug = process.env.NODE_ENV !== 'production'

const vuexlocal = new VuexPersistence({
    storage: window.localStorage,
    reducer: (state) => ({settings: state.settings})
})

export default new Vuex.Store({
    modules: {
        agencies,
        vehicles,
        settings
    },
    plugins: [vuexlocal.plugin]
})