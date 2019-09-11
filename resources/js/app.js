// Vuetify
import vuetify from './vuetify'

// Vue Plugins
import router from './router'
import store from './store'

// App
import App from './App.vue'

// Vue itself
import Vue from 'vue'

// Bugsnap
// Todo: remove when beta ends
// import bugsnap from '@bugsnag/js'
// import bugsnapVue from '@bugsnag/plugin-vue'
// const bugsnapClient = bugsnap('8b0403f91803771a07af0f9d944e2638')
// bugsnapClient.use(bugsnapVue, Vue)

// Vue comes to life!
window.vm = new Vue({
  el: '#app',
  vuetify,
  router,
  store,
  render: h => h(App)
})
