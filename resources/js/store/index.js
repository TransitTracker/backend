import Vue from 'vue'
import Vuex from 'vuex'
import agencies from './modules/agencies'
import alert from './modules/alert'
import vehicles from './modules/vehicles'
import settings from './modules/settings'
import regions from './modules/regions'
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
    vehicles,
    regions,
    settings
  },
  plugins: [vuexlocal.plugin]
})
