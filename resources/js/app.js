// Vue
window.Vue = require('vue');

// Vue Material
import { MdApp, MdDrawer, MdToolbar, MdList, MdIcon, MdButton, MdTabs, MdContent, MdEmptyState, MdAvatar, MdCheckbox, MdProgress, MdTable, MdRipple, MdCard, MdSwitch, MdRadio, MdSteppers, MdDialog, MdSnackbar } from 'vue-material/dist/components';
Vue.use(MdApp)
Vue.use(MdDrawer)
Vue.use(MdToolbar)
Vue.use(MdList)
Vue.use(MdIcon)
Vue.use(MdButton)
Vue.use(MdTabs)
Vue.use(MdContent)
Vue.use(MdEmptyState)
Vue.use(MdAvatar)
Vue.use(MdCheckbox)
Vue.use(MdProgress)
Vue.use(MdTable)
Vue.use(MdRipple)
Vue.use(MdCard)
Vue.use(MdSwitch)
Vue.use(MdRadio)
Vue.use(MdSteppers)
Vue.use(MdDialog)
Vue.use(MdSnackbar)


// App
import App from './App.vue'

// Components
import TabHome from './components/TabHome.vue';
import TabMap from './components/TabMap.vue';
import TabSettings from './components/TabSettings.vue';
import TabTable from './components/TabTable.vue';

// Vue Router
import Router from 'vue-router'
Vue.use(Router)
const router = new Router({
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
});

// Vue Store
import store from './store'

// Vue i18n
import VueI18n from 'vue-i18n'
Vue.use(VueI18n)

// Vue comes to life!
const app = new Vue(
    Vue.util.extend({router, store}, App)
).$mount('#app');
