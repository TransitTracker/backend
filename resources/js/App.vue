<template>
    <div id="app">
        <v-app id="mtltt">
            <v-app-bar
                    app
                    absolute
                    :color="appBarColor"
                    dark
                    id="header"
            >
                <v-toolbar-title><b>{{ activeRegion.name }}</b> Transit Tracker</v-toolbar-title>
                <v-spacer></v-spacer>

                <v-menu>
                    <template v-slot:activator="{ on }">
                        <v-btn icon v-on="on" :aria-label="$vuetify.lang.t('$vuetify.app.regionAriaLabel')">
                            <v-icon>mdi-map</v-icon>
                        </v-btn>
                    </template>
                    <v-list>
                        <v-list-item v-for="region in regions" :key="region.slug" @click="changeActiveRegion(region)">
                            <v-list-item-title>{{ region.name }}</v-list-item-title>
                            <v-list-item-action v-if="region === activeRegion"><v-icon>mdi-check</v-icon></v-list-item-action>
                        </v-list-item>
                    </v-list>
                </v-menu>

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

            <alert-dialog
                    v-if="alertIsVisible"
                    :dialog-visible="alertDialogVisible"
                    v-on:alert-has-been-read="alertBannerVisible = false"
                    v-on:hide-dialog="changeAlertDialogVisibility(false)"></alert-dialog>

            <v-content>
                <alert-banner
                        v-if="alertIsVisible"
                        v-on:show-dialog="changeAlertDialogVisibility(true)"></alert-banner>
                <dialog-configuration
                        v-if="!settings.configurationDone"
                        v-on:configurationDone="setConfigurationAsDone"></dialog-configuration>
                <router-view
                        :vehicles-pending-request="vehiclesRequestPending"
                        v-on:refresh-vehicles="refreshVehicles()"
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
import { VApp, VAppBar, VBtn, VContent, VSnackbar, VSpacer, VTab, VTabs, VToolbarTitle, VMenu, VIcon, VList, VListItem, VListItemTitle, VListItemAction } from 'vuetify/lib'
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
  components: { VApp, VAppBar, VBtn, VContent, VSnackbar, VSpacer, VTab, VTabs, VToolbarTitle, VMenu, VIcon, VList, VListItem, VListItemTitle, VListItemAction, AlertBanner, AlertDialog, DialogConfiguration },
  data: () => ({
    menuVisible: false,
    oldAgenciesSnackbarVisible: false,
    oldAgenciesSnackbarTimeout: 10000,
    echo: null,
    alertDialogVisible: false,
    vehiclesRequestPending: 0
  }),
  mounted () {
    // Change theme
    this.$vuetify.theme.dark = this.settings.darkMode

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

    // Start application if configuration is done
    if (this.settings.configurationDone) {
      this.loadApplication()
    }

    // Change language
    this.$vuetify.lang.current = this.settings.language

    // Check that service workers are supported
    if ('serviceWorker' in navigator) {
      // Use the window load event to keep the page load performant
      window.addEventListener('load', () => {
        navigator.serviceWorker.register('/service-worker.js')
      })
    }
  },
  computed: {
    activeRegion () {
      return this.$store.state.regions.active
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
    },
    appBarColor () {
      if (this.settings.darkMode) {
        return 'dark'
      } else {
        return 'primary'
      }
    },
    regions: {
      get () {
        return this.$store.state.regions.data
      },
      set (newRegions) {
        this.$store.commit('regions/setData', newRegions)
      }
    },
    settings () {
      return this.$store.state.settings
    }
  },
  methods: {
    setConfigurationAsDone () {
      this.$store.commit('settings/setConfigurationDone', true)
      this.loadApplication()
    },
    loadApplication () {
      // Starting app
      const timestamp = Math.floor(Date.now() / 1000)
      console.log('Loading at ' + timestamp)

      // Redirect user to default path
      this.$router.push(this.$store.state.settings.defaultPath)

      // Load regions and agencies
      axios
        .get('/regions')
        .then(response => {
          // Save regions and agencies
          this.regions = response.data.data
          response.data.data.forEach(region => {
            this.agencies = this.agencies.concat(region.agencies)

            if (region.slug === this.settings.activeRegion) {
              this.$store.commit('regions/setActive', region)
            }
          })

          // Load vehicle from each active agencies
          collect(this.settings.activeAgencies).each((agency) => {
            this.loadVehiclesFromAgency(agency, timestamp)
          })
        })
        .catch(error => {
          console.log(error)
          this.vehiclesRequestPending--
        })

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

      // If enabled, listen to auto refresh
      if (this.settings.autoRefresh) {
        console.log('Listening')
        // Connect to Pusher with Laravel Echo
        if (!this.echo) {
          this.echo = new Echo({
            broadcaster: 'pusher',
            key: process.env.MIX_PUSHER_APP_KEY,
            cluster: 'us2',
            forceTLS: true
          })
        }

        // Listen to events
        this.echo.channel('updates')
          .listen('VehiclesUpdated', (event) => {
            const newTimestamp = Math.floor(Date.now() / 1000)
            // Check if agency is selected by user
            if (collect(this.settings.activeAgencies).contains(event.slug)) {
              this.loadVehiclesFromAgency(event.slug, newTimestamp)
            }
          })
      }

      // Send statistics
      window._paq.push(
        ['setCustomDimension', 1, this.settings.activeRegion],
        ['setCustomDimension', 2, this.settings.autoRefresh],
        ['setCustomDimension', 3, this.settings.defaultPath],
        ['setCustomDimension', 4, this.settings.darkMode],
        ['setCustomDimension', 5, this.settings.activeAgencies],
        ['setCustomDimension', 6, this.settings.language]
      )
    },
    loadVehiclesFromAgency (agencySlug, timestamp) {
      // Empty vehicles and count
      const agency = collect(this.agencies).firstWhere('slug', agencySlug)
      if (agency) {
        this.$store.commit('vehicles/emptyData', agency.id)
        this.$store.commit('agencies/emptyCount', agencySlug)

        if (agency.region === this.settings.activeRegion) {
          // Load vehicles from specified agency
          console.log('Loading vehicles from ' + agencySlug)
          axios.get('/vehicles/' + agencySlug)
            .then((response) => {
              // Calculate time difference and set data
              const timeDiff = timestamp - response.data.timestamp
              this.$store.commit('vehicles/setData', response.data.data)
              this.$store.commit('agencies/setCount', { agency: agencySlug, count: response.data.count, diff: timeDiff })

              // If time difference is too high, show the snackbar
              timeDiff > 300 && this.showSnackbar()
            })
            .catch((error) => {
              if (error.response.status === 403 || error.response.status === 404) {
                // Agency is either invalid or dosen't exist
                this.removeAgency(agencySlug)
              }
            })
        }
      } else {
        this.removeAgency(agencySlug)
      }
    },
    showSnackbar () {
      // Add time and show snackbar
      this.oldAgenciesSnackbarTimeout += 1000
      this.oldAgenciesSnackbarVisible = true
    },
    removeAgency (agencySlug) {
      // Remove specified agency
      const agenciesArray = this.settings.activeAgencies
      agenciesArray.splice(agenciesArray.indexOf(agencySlug), 1)
      this.$store.commit('settings/setActiveAgencies', agenciesArray)
    },
    changeAlertDialogVisibility (newState) {
      this.alertDialogVisible = false
      this.alertDialogVisible = newState
    },
    changeActiveRegion (newRegion) {
      this.$store.commit('regions/setActive', newRegion)
      this.$store.commit('settings/setActiveRegion', newRegion.slug)

      const timestamp = Math.floor(Date.now() / 1000)

      // Load vehicle from each active agencies
      collect(this.settings.activeAgencies).each((agency) => {
        this.loadVehiclesFromAgency(agency, timestamp)
      })
    },
    refreshVehicles () {
      this.changeActiveRegion(this.activeRegion)
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

    .v-slide-group__prev {
        display: none !important;
    }
</style>
