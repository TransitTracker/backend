import Vue from 'vue'
import VueRouter from 'vue-router'

Vue.use(VueRouter)

const router = new VueRouter({
  routes: [
    {
      path: '/',
      name: 'Home',
      component: () => import(/* webpackChunkName: 'home' */ './components/TabHome.vue')
    },
    {
      path: '/map',
      name: 'Map',
      component: () => import(/* webpackChunkName: 'map' */ './components/TabMap.vue')
    },
    {
      path: '/table',
      name: 'Table',
      component: () => import(/* webpackChunkName: 'table' */ './components/TabTable.vue')
    },
    {
      path: '/settings',
      name: 'Settings',
      component: () => import(/* webpackChunkName: 'settings' */ './components/TabSettings.vue')
    }
  ]
})

export default router
