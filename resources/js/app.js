// Polyfill for support of IE11, Edge and Safari 9/10
import 'babel-polyfill'

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

// Bugsnag
import Bugsnag from '@bugsnag/js'
import BugsnagPluginVue from '@bugsnag/plugin-vue'

Vue.use(VueMatomo, {
  host: process.env.MIX_MATOMO_HOST,
  siteId: process.env.MIX_MATOMO_SITE_ID,
  router: router
})

Bugsnag.start({
  apiKey: process.env.MIX_BUGNSAG_API_KEY,
  plugins: [new BugsnagPluginVue()],
})
Bugsnag.getPlugin('vue')
  .installVueErrorHandler(Vue)

// Vue comes to life!
window.vm = new Vue({
  el: '#app',
  vuetify,
  router,
  store,
  render: h => h(App)
})
