import Vue from 'vue'
import Vuex from 'vuex'
import agencies from './modules/agencies'
import alert from './modules/alert'
import links from './modules/links'
import regions from './modules/regions'
import settings from './modules/settings'
import vehicles from './modules/vehicles'
import VuexPersistence from 'vuex-persist'

Vue.use(Vuex)

const vuexlocal = new VuexPersistence({
  storage: window.localStorage,
  reducer: (state) => ({ settings: state.settings })
})

export default new Vuex.Store({
  modules: {
    agencies,
    alert,
    links,
    regions,
    settings,
    vehicles
  },
  plugins: [vuexlocal.plugin]
})
