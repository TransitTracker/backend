import Vue from 'vue'
import VueRouter from 'vue-router'

Vue.use(VueRouter)

const router = new VueRouter({
  routes: [
    {
      path: '/',
      name: 'Home / Accueil',
      component: () => import(/* webpackChunkName: 'js/home' */ './components/TabHome.vue'),
    },
    {
      path: '/map',
      name: 'Map / Carte',
      component: () => import(/* webpackChunkName: 'js/map' */ './components/TabMap.vue'),
    },
    {
      path: '/table',
      name: 'Table / Liste',
      component: () => import(/* webpackChunkName: 'js/table' */ './components/TabTable.vue'),
    },
    {
      path: '/settings',
      name: 'Settings / Réglages',
      component: () => import(/* webpackChunkName: 'js/settings' */ './components/TabSettings.vue'),
    },
  ],
})

export default router
