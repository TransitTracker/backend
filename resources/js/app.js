// Vuetify
import vuetify from './vuetify'

// Vue Plugins
import router from './router'
import store from './store'

// App
import App from './App.vue'

// Vue itself
import Vue from 'vue'

// Matomo
import VueMatomo from 'vue-matomo'
Vue.use(VueMatomo, {
  host: process.env.MIX_MATOMO_HOST,
  siteId: process.env.MIX_MATOMO_SITE_ID,
  router: router
})

// Vue comes to life!
window.vm = new Vue({
  el: '#app',
  vuetify,
  router,
  store,
  render: h => h(App)
})
