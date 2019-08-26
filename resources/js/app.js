// Vuetify
import vuetify from './vuetify'

// Vue Plugins
import router from './router'
import store from './store'
import VueI18n from 'vue-i18n'

// Laravel Echo
import Echo from 'laravel-echo'
window.Pusher = require('pusher-js')

// App
import App from './App.vue'

// Vue
import Vue from 'vue'

// Plugin setup
// Todo: use vuetify i18n
Vue.use(VueI18n)
window.Echo = new Echo({
  broadcaster: 'pusher',
  key: '6e6f7e34817efcde182a',
  cluster: 'us2',
  forceTLS: true
})

// Vue comes to life!
window.vm = new Vue({
  el: '#app',
  vuetify,
  router,
  store,
  render: h => h(App)
})
