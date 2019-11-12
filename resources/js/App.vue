<template>
    <div id="app">
        <v-app id="mtltt">
            <v-app-bar
                app
                absolute
                color="primary"
                dark
            >
                <v-toolbar-title>{{ $vuetify.lang.t('$vuetify.app.name') }}</v-toolbar-title>
                <v-spacer></v-spacer>
                <template v-slot:extension>
                    <v-tabs
                            fixed-tabs
                            background-color="transparent">
                        <v-tab to="/">{{ $vuetify.lang.t('$vuetify.app.tabHome') }}</v-tab>
                        <v-tab to="/map">{{ $vuetify.lang.t('$vuetify.app.tabMap') }}</v-tab>
                        <v-tab to="/table">{{ $vuetify.lang.t('$vuetify.app.tabTable') }}</v-tab>
                        <v-tab to="/settings">{{ $vuetify.lang.t('$vuetify.app.tabSettings') }}</v-tab>
                    </v-tabs>
                </template>

            </v-app-bar>

            <alert-banner
                v-if="alertIsVisible"
                v-on:show-dialog="changeAlertDialogVisibility(true)"></alert-banner>
            <alert-dialog
                v-if="alertIsVisible"
                :dialog-visible="alertDialogVisible"
                v-on:alert-has-been-read="alertBannerVisible = false"
                v-on:hide-dialog="changeAlertDialogVisibility(false)"></alert-dialog>

            <v-content>
                <dialog-configuration
                    v-if="!settings.configurationDone"
                    v-on:configurationDone="setConfigurationAsDone"></dialog-configuration>
                <router-view
                    :vehicles-pending-request="vehiclesRequestPending"
                    v-if="settings.configurationDone"></router-view>
                <v-snackbar
                    v-model="oldAgenciesSnackbarVisible"
                    :timeout="oldAgenciesSnackbarTimeout">
                    <b>{{ $vuetify.lang.t('$vuetify.app.snackbarBold') }}</b>
                    <span>{{ $vuetify.lang.t('$vuetify.app.snackbarText') }}</span>
                    <v-btn
                        color="accent"
                        text
                        @click="oldAgenciesSnackbarVisible = false">
                        {{ $vuetify.lang.t('$vuetify.app.snackbarBtn') }}
                    </v-btn>
                </v-snackbar>
            </v-content>
        </v-app>
    </div>
</template>

<script>
import { VApp, VAppBar, VToolbarTitle, VSpacer, VTabs, VTab, VContent, VSnackbar, VBtn } from 'vuetify/lib'
import axios from 'axios/index'
import AlertBanner from './components/AlertBanner'
import AlertDialog from './components/AlertDialog'
import DialogConfiguration from './components/DialogConfiguration'
import collect from 'collect.js/src/index.js'
import Echo from 'laravel-echo'
// eslint-disable-next-line no-unused-vars
import Pusher from 'pusher-js'

// Define default axios base URL
axios.defaults.baseURL = process.env.MIX_APIENDPOINT

export default {
  name: 'app',
  components: {
    VApp,
    VAppBar,
    VToolbarTitle,
    VSpacer,
    VTabs,
    VTab,
    VContent,
    VSnackbar,
    VBtn,
    DialogConfiguration,
    AlertBanner,
    AlertDialog
  },
  data: () => ({
    menuVisible: false,
    appReady: false,
    oldAgenciesSnackbarVisible: false,
    oldAgenciesSnackbarTimeout: 10000,
    echo: null,
    alertDialogVisible: false,
    vehiclesRequestPending: 0
  }),
  mounted () {
    // Add axios interceptors
    axios.interceptors.request.use(config => {
      this.vehiclesRequestPending++
      return config
    }, error => {
      return Promise.reject(error)
    })
    axios.interceptors.response.use(config => {
      this.vehiclesRequestPending--
      return config
    }, error => {
      return Promise.reject(error)
    })

    // Load data if configuration is done
    if (this.settings.configurationDone) {
      this.loadData()
    }

    // Change language
    this.$vuetify.lang.current = this.settings.language

    // According to settings, listen to auto refresh
    if (this.settings.autoRefresh) {
      // Connect to Pusher with Laravel Echo
      if (!this.echo) {
        this.echo = new Echo({
          broadcaster: 'pusher',
          key: process.env.MIX_PUSHER_APP_KEY,
          cluster: 'us2',
          forceTLS: true
        })
      }
      this.listenToAutoRefresh()
    }
  },
  computed: {
    settings () {
      return this.$store.state.settings
    },
    agencies: {
      get () {
        return this.$store.state.agencies.data
      },
      set (newAgencies) {
        this.$store.commit('agencies/setData', newAgencies)
      }
    },
    alertIsVisible () {
      return this.$store.state.alert.isVisible
    }
  },
  methods: {
    setConfigurationAsDone () {
      this.$store.commit('settings/setConfigurationDone', true)
      this.loadData()
    },
    loadData () {
      // Starting app
      const timestamp = Math.floor(Date.now() / 1000)
      console.log('Loading at ' + timestamp)

      // Redirect user to default path
      this.$router.push(this.$store.state.settings.defaultPath)

      // Load agencies
      axios
        .get('/agencies')
        .then(response => (this.agencies = response.data.data))

      // Load vehicle from each active agencies
      collect(this.settings.activeAgencies).each((agency) => {
        // Continue loading vehicles
        console.log('Loading vehicles from ' + agency)
        axios.get('/vehicles/' + agency)
          .then(response => (this.loadVehicles(timestamp, response, agency)))
          .catch((error) => {
            if (error.response.status === 403 || error.response.status === 404) {
              // Agency is either invalid or dosen't exist
              this.removeAgency(agency)
            }
          })
      })
      this.appReady = true

      // Load alert
      axios
        .get('/alert')
        .then(response => {
          if (response.data.message === 'OK') {
            this.$store.commit('alert/setData', response.data.data)
            if (!response.data.data.can_be_closed) {
              this.$store.commit('alert/setVisibility', true)
            } else {
              if (response.data.data.id !== this.settings.alertRead) {
                this.$store.commit('alert/setVisibility', true)
              }
            }
          }
        })
    },
    loadVehicles (timestamp, response, agency) {
      // Calculate time difference and set data
      const timeDiff = timestamp - response.data.timestamp
      this.$store.commit('vehicles/setData', response.data.data)
      this.$store.commit('agencies/setCount', { agency: agency, count: response.data.count, diff: timeDiff })

      // If time difference is too high, show the snackbar
      timeDiff > 300 && this.showSnackbar()
    },
    showSnackbar () {
      this.oldAgenciesSnackbarTimeout += 1000
      this.oldAgenciesSnackbarVisible = true
    },
    removeAgency (agency) {
      const agenciesArray = this.settings.activeAgencies
      agenciesArray.splice(agenciesArray.indexOf(agency), 1)
      this.$store.commit('settings/setActiveAgencies', agenciesArray)
    },
    listenToAutoRefresh () {
      this.echo.channel('updates')
        .listen('VehiclesUpdated', (event) => {
          // Check if agency is selected by user
          if (collect(this.settings.activeAgencies).contains(event.slug)) {
            // Enpty vehicles and count
            this.$store.commit('vehicles/emptyData', event.id)
            this.$store.commit('agencies/emptyCount', event.slug)

            // Start refresh
            const timestamp = Math.floor(Date.now() / 1000)
            console.log('Reloading vehicles from ' + event.slug + ' at ' + timestamp)

            // Reload vehicles
            axios.get('/vehicles/' + event.slug)
              .then(response => (this.loadVehicles(timestamp, response, event.slug)))
              .catch((error) => {
                if (error.response.status === 403) {
                  this.removeAgency(event.slug)
                }
              })
          }
        })
    },
    changeAlertDialogVisibility (newState) {
      this.alertDialogVisible = false
      newState ? this.alertDialogVisible = true : this.alertDialogVisible = false
    }
  }
}
</script>

<style lang="scss">
    .v-application--is-ltr .v-tabs-bar.v-tabs-bar--is-mobile:not(.v-tabs-bar--show-arrows) > .v-slide-group__wrapper > .v-tabs-bar__content > .v-tabs-slider-wrapper + .v-tab {
        margin-left: 0;
    }
    .v-snack__content b {
        padding-right: 10px;
    }
</style>
