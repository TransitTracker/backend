import Vue from 'vue'
import VueRouter from 'vue-router'
const TabHome = () => import('./components/TabHome.vue')
const TabMap = () => import('./components/TabMap.vue')
const TabTable = () => import('./components/TabTable.vue')
const TabSettings = () => import('./components/TabSettings.vue')

Vue.use(VueRouter)

const router = new VueRouter({
  routes: [
    {
      path: '/',
      name: 'Home',
      component: TabHome
    },
    {
      path: '/map',
      name: 'Map',
      component: TabMap
    },
    {
      path: '/table',
      name: 'Table',
      component: TabTable
    },
    {
      path: '/settings',
      name: 'Settings',
      component: TabSettings
    }
  ]
})

export default router
