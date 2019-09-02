// Vuetify
import vuetify from './vuetify'

// Vue Plugins
import router from './router'
import store from './store'
import VueI18n from 'vue-i18n'

// App
import App from './App.vue'

// Vue
import Vue from 'vue'

// Bugsnap
// Todo: remove when beta ends
import bugsnap from '@bugsnag/js'
import bugsnapVue from '@bugsnag/plugin-vue'
const bugsnapClient = bugsnap('8b0403f91803771a07af0f9d944e2638')
bugsnapClient.use(bugsnapVue, Vue)

// Plugin setup
// Todo: use vuetify i18n
Vue.use(VueI18n)

// Vue comes to life!
window.vm = new Vue({
  el: '#app',
  vuetify,
  router,
  store,
  render: h => h(App)
})

// Google Analytics
ga('set', 'page', router.currentRoute.path);
ga('send', 'pageview');

router.afterEach(( to, from ) => {
  ga('set', 'page', to.path);
  ga('send', 'pageview');
});