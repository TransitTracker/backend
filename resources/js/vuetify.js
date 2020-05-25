import Vue from 'vue'

import Vuetify from 'vuetify/lib'
import { Ripple } from 'vuetify/lib/directives'

import en from './lang/en'
import fr from './lang/fr'

Vue.use(Vuetify, {
  directives: {
    Ripple
  }
})

export default new Vuetify({
  theme: {
    themes: {
      light: {
        primary: '#2374AB',
        secondary: '#4DCCBD',
        accent: '#303633'
      },
      dark: {
        primary: '#00497B',
        secondary: '#009A8D',
        accent: '#303633',
        anchor: '#FFFFFF'
      }
    }
  },
  icons: {
    iconfont: 'mdiSvg'
  },
  lang: {
    locales: { en, fr },
    current: 'en'
  }
})
