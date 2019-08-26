<template>
    <div id="app">
        <v-app id="mtltt">
            <v-app-bar
                app
                absolute
                color="primary"
                dark
            >
                <v-toolbar-title>Montréal Transit Tracker</v-toolbar-title>
                <v-spacer></v-spacer>
                <template v-slot:extension>
                    <v-tabs
                            fixed-tabs
                            background-color="transparent">
                        <v-tab to="/">Home</v-tab>
                        <v-tab to="/map">Map</v-tab>
                        <v-tab to="/table">Table</v-tab>
                        <v-tab to="/settings">Settings</v-tab>
                    </v-tabs>
                </template>

            </v-app-bar>

            <v-content>
                <dialog-configuration
                    v-if="!settings.configurationDone"
                    v-on:configurationDone="setConfigurationAsDone"></dialog-configuration>
                <v-progress-linear value="0" color="accent" v-if="!appReady" indeterminate></v-progress-linear>
                <router-view v-if="appReady && settings.configurationDone"></router-view>
                <v-snackbar
                    v-model="oldAgenciesSnackbarVisible"
                    :timeout="oldAgenciesSnackbarTimeout">
                    <b>Warning!</b>
                    <span>Data from some agencies are outdated and should be used with caution.</span>
                    <v-btn
                        color="accent"
                        text
                        @click="oldAgenciesSnackbarVisible = false">
                        Close
                    </v-btn>
                </v-snackbar>
                <v-snackbar
                    v-model="updateSnackbarVisible"
                    :timeout="5000">
                    <b>Warning!</b>
                    <span>Data from some agencies are outdated and should be used with caution.</span>
                    <v-btn
                        color="accent"
                        text
                        @click="updateSnackbarVisible = false">
                        Close
                    </v-btn>
                </v-snackbar>
            </v-content>
        </v-app>
    </div>
</template>

<script>
import { VApp, VAppBar, VToolbarTitle, VSpacer, VTabs, VTab, VContent, VProgressLinear, VSnackbar, VBtn } from 'vuetify/lib'
import axios from 'axios/index'
import DialogConfiguration from './components/DialogConfiguration'
import collect from 'collect.js/src/index.js'

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
    VProgressLinear,
    VSnackbar,
    VBtn,
    DialogConfiguration
  },
  data: () => ({
    menuVisible: false,
    appReady: false,
    oldAgenciesSnackbarVisible: false,
    oldAgenciesSnackbarTimeout: 10000,
    updateSnackbarVisible: false
  }),
  mounted () {
    if (this.settings.configurationDone) {
      this.loadData()
    }
    if (this.settings.autoRefresh) {
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
              if (error.response.status === 403) {
                this.removeAgency(agency)
              }
            })
      })
      this.appReady = true
    },
    loadVehicles (timestamp, response, agency) {
      const timeDiff = timestamp - response.data.timestamp
      this.$store.commit('vehicles/setData', response.data.data)
      this.$store.commit('agencies/setCount', { agency: agency, count: response.data.count, diff: timeDiff })
      timeDiff > 300 && this.showSnackbar()
    },
    showSnackbar () {
      this.oldAgenciesSnackbarTimeout += 1000
      this.oldAgenciesSnackbarVisible = true
    },
    removeAgency (agency) {
      let agenciesArray = this.settings.activeAgencies
      agenciesArray.splice(agenciesArray.indexOf(agency), 1)
      this.$store.commit('settings/setActiveAgencies', agenciesArray)
    },
    listenToAutoRefresh () {
      Echo.channel('updates')
        .listen('VehiclesUpdated', (event) => {
          if (event.success) {
            // Starting app
            const timestamp = Math.floor(Date.now() / 1000)
            console.log('Reloading at ' + timestamp)

            // Empty vehicles
            this.$store.commit('vehicles/emptyData')
            this.$store.commit('agencies/emptyCounts')

            // Load vehicle from each active agencies
            collect(this.settings.activeAgencies).each((agency) => {
              // Continue loading vehicles
              console.log('Reloading vehicles from ' + agency)
              axios.get('/vehicles/' + agency)
                .then(response => (this.loadVehicles(timestamp, response, agency)))
                .catch((error) => {
                  if (error.response.status === 403) {
                    this.removeAgency(agency)
                  }
                })
            })
            this.updateSnackbarVisible = true
          }
        })
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
