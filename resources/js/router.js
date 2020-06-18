import Vue from 'vue'
import VueRouter from 'vue-router'

Vue.use(VueRouter)

const router = new VueRouter({
  routes: [
    {
      path: '/',
      name: 'Home / Accueil',
      component: () => import(/* webpackChunkName: 'home' */ './components/TabHome.vue')
    },
    {
      path: '/map',
      name: 'Map / Carte',
      component: () => import(/* webpackChunkName: 'map' */ './components/TabMap.vue')
    },
    {
      path: '/table',
      name: 'Table / Liste',
      component: () => import(/* webpackChunkName: 'table' */ './components/TabTable.vue')
    },
    {
      path: '/settings',
      name: 'Settings / Réglages',
      component: () => import(/* webpackChunkName: 'settings' */ './components/TabSettings.vue')
    }
  ]
})

export default router
