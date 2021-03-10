<template>
  <div id="app">
    <v-app id="mtltt">
      <v-app-bar
        id="header"
        app
        absolute
        :color="appBarComponentColor"
        dark
      >
        <v-toolbar-title><b>{{ activeRegion.name }}</b> Transit Tracker</v-toolbar-title>
        <v-spacer />

        <v-menu>
          <template v-slot:activator="{ on }">
            <v-btn
              icon
              :aria-label="$vuetify.lang.t('$vuetify.app.regionAriaLabel')"
              v-on="on"
            >
              <v-icon>{{ mdiSvg.map }}</v-icon>
            </v-btn>
          </template>
          <v-list>
            <v-list-item
              v-for="region in regions"
              :key="region.slug"
              @click="changeActiveRegion(region)"
            >
              <v-list-item-title>{{ region.name }}</v-list-item-title>
              <v-list-item-action v-if="region === activeRegion">
                <v-icon>{{ mdiSvg.check }}</v-icon>
              </v-list-item-action>
            </v-list-item>
          </v-list>
        </v-menu>

        <template v-slot:extension>
          <v-tabs
            fixed-tabs
            background-color="transparent"
            color="white"
          >
            <v-tab to="/">
              {{ $vuetify.lang.t('$vuetify.app.tabHome') }}
            </v-tab>
            <v-tab to="/map">
              {{ $vuetify.lang.t('$vuetify.app.tabMap') }}
            </v-tab>
            <v-tab to="/table">
              {{ $vuetify.lang.t('$vuetify.app.tabTable') }}
            </v-tab>
            <v-tab to="/settings">
              {{ $vuetify.lang.t('$vuetify.app.tabSettings') }}
            </v-tab>
          </v-tabs>
        </template>
      </v-app-bar>

      <alert-dialog
        v-if="alertIsVisible"
        :dialog-visible="alertDialogVisible"
        @alert-has-been-read="alertBannerVisible = false"
        @hide-dialog="changeAlertDialogVisibility(false)"
      />

      <v-main>
        <alert-banner
          v-if="alertIsVisible"
          @show-dialog="changeAlertDialogVisibility(true)"
        />
        <dialog-configuration
          v-if="!settings.configurationDone"
          @configurationDone="setConfigurationAsDone"
        />
        <router-view
          v-if="settings.configurationDone"
          :vehicles-pending-request="vehiclesRequestPending"
          :refresh-event="refreshEvent"
          @refresh-vehicles="refreshVehicles()"
          @change-region="changeActiveRegion"
        />
        <v-snackbar
          v-model="oldAgenciesSnackbarVisible"
          :timeout="oldAgenciesSnackbarTimeout"
        >
          <b>{{ $vuetify.lang.t('$vuetify.app.snackbarBold') }}</b>
          <span>{{ $vuetify.lang.t('$vuetify.app.snackbarText') }}</span>
          <template v-slot:action="{attrs}">
            <v-btn
              color="primary lighten-3"
              text
              v-bind="attrs"
              @click="oldAgenciesSnackbarVisible = false"
            >
              {{ $vuetify.lang.t('$vuetify.app.snackbarBtn') }}
            </v-btn>
          </template>
        </v-snackbar>
      </v-main>
    </v-app>
  </div>
</template>

<script>
  import {
    VApp,
    VAppBar,
    VBtn,
    VIcon,
    VList,
    VListItem,
    VListItemAction,
    VListItemTitle,
    VMain,
    VMenu,
    VSnackbar,
    VSpacer,
    VTab,
    VTabs,
    VToolbarTitle,
  } from 'vuetify/lib'
  import { mdiMap, mdiCheck } from '@mdi/js'
  import axios from 'axios/index'
  import collect from 'collect.js/src/index.js'
  import Echo from 'laravel-echo'
  // eslint-disable-next-line no-unused-vars
  import Pusher from 'pusher-js'
  const AlertBanner = () => import(/* webpackChunkName: 'js/alert' */ './components/app/AlertBanner')
  const AlertDialog = () => import(/* webpackChunkName: 'js/alert' */'./components/app/AlertDialog')
  const DialogConfiguration = () => import(/* webpackChunkName: 'js/configuration' */'./components/app/DialogConfiguration')

  // Define default axios base URL
  axios.defaults.baseURL = process.env.MIX_API_ENDPOINT

  export default {
    name: 'App',
    components: {
      VApp,
      VAppBar,
      VBtn,
      VSnackbar,
      VSpacer,
      VTab,
      VTabs,
      VToolbarTitle,
      VMain,
      VMenu,
      VIcon,
      VList,
      VListItem,
      VListItemTitle,
      VListItemAction,
      AlertBanner,
      AlertDialog,
      DialogConfiguration,
    },
    data: () => ({
      menuVisible: false,
      oldAgenciesSnackbarVisible: false,
      oldAgenciesSnackbarTimeout: 10000,
      echo: null,
      alertDialogVisible: false,
      vehiclesRequestPending: 0,
      refreshEvent: {},
      mdiSvg: {
        map: mdiMap,
        check: mdiCheck,
      },
    }),
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
        },
      },
      alertIsVisible () {
        return this.$store.state.alert.isVisible
      },
      appBarComponentColor () {
        return this.$vuetify.theme.dark
          ? 'dark'
          : 'primary'
      },
      regions: {
        get () {
          return this.$store.state.regions.data
        },
        set (newRegions) {
          this.$store.commit('regions/setData', newRegions)
        },
      },
      settings () {
        return this.$store.state.settings
      },
    },
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

      // Redirect user to default path
      // DO NOT redirect if default path is home
      // TODO: fix the map issue
      const defaultPath = this.$store.state.settings.defaultPath
      if (defaultPath !== '/map') {
        this.$router.push(defaultPath)
      } else {
        this.$router.push('/')
      }

    // Service worker will be disabled for this version (check app.blade.php)
    // TODO: bring back service worker
    },
    methods: {
      setConfigurationAsDone () {
        this.$store.commit('settings/setConfigurationDone', true)
        location.reload()
      },
      loadApplication () {
        // Starting app
        const timestamp = Math.floor(Date.now() / 1000)
        console.log('Loading at ' + timestamp)

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
          .catch(error => {
            console.log(error)
            this.vehiclesRequestPending--
          })

        // Load links
        axios
          .get('/links')
          .then(response => {
            if (response.status !== 200) {
              return
            }
            this.$store.commit('links/setData', response.data.data)
          })
          .catch(error => {
            console.log(error)
            this.vehiclesRequestPending--
          })

        // Always listen to pusher
        console.log('Listening')
        // Connect to Pusher with Laravel Echo
        if (!this.echo) {
          this.echo = new Echo({
            broadcaster: 'pusher',
            key: process.env.MIX_PUSHER_APP_KEY,
            wsHost: process.env.MIX_LARAVEL_WEBSOCKETS_HOST,
            wsPort: 6001,
            disableStats: true,
            forceTLS: true,
            enabledTransports: ['ws', 'wss'],
          })
        }

        // Listen to events
        this.echo.channel('updates')
          .listen('VehiclesUpdated', (event) => {
            // Check if user has auto refresh enabled
            if (this.settings.autoRefresh) {
              const newTimestamp = Math.floor(Date.now() / 1000)
              // Check if agency is selected by user
              if (collect(this.settings.activeAgencies).contains(event.slug) && event.region === this.settings.activeRegion) {
                this.loadVehiclesFromAgency(event.slug, newTimestamp)
              }
            }
          })

        // Send statistics
        window._paq.push(
          ['setCustomDimension', 1, this.settings.activeRegion],
          ['setCustomDimension', 2, this.settings.autoRefresh],
          ['setCustomDimension', 3, this.settings.defaultPath],
          ['setCustomDimension', 4, this.settings.darkMode],
          ['setCustomDimension', 5, this.settings.activeAgencies],
          ['setCustomDimension', 6, this.settings.language],
        )
      },
      loadVehiclesFromAgency (agencySlug, timestamp) {
        const agency = collect(this.agencies).firstWhere('slug', agencySlug)
        if (agency) {
          if (agency.region === this.settings.activeRegion) {
            // Load vehicles from specified agency
            console.log('Loading vehicles from ' + agencySlug)
            axios.get('/vehicles/' + agencySlug)
              .then((response) => {
                // Empty count only if request is successful
                this.$store.commit('agencies/emptyCount', agencySlug)

                // Calculate time difference and set data
                const timeDiff = timestamp - response.data.timestamp
                this.$store.commit('vehicles/setData', {
                  data: response.data.data,
                  agencySlug: agency.slug,
                })
                this.$store.commit('vehicles/setGeojson', {
                  data: response.data.geojson,
                  agencySlug: agency.slug,
                })
                this.$store.commit('agencies/setCount', {
                  agency: agencySlug,
                  count: response.data.count,
                  diff: timeDiff,
                })

                // If time difference is too high, show the snackbar
                timeDiff > 300 && this.showSnackbar()

                // Send refresh event
                this.refreshEvent = {
                  slug: agencySlug,
                  timestamp: timestamp,
                }
              })
              .catch((error) => {
                if (error.response?.status === 404) {
                  // Agency dosen't exist
                  this.removeAgency(agencySlug)
                }
                this.vehiclesRequestPending--
              })
          }
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
        this.$store.commit('vehicles/emptyData', 'all')
        this.$store.commit('agencies/emptyCount', 'all')
        this.$store.commit('regions/setActive', newRegion)
        this.$store.commit('settings/setActiveRegion', newRegion.slug)

        const timestamp = Math.floor(Date.now() / 1000)

        // Load vehicle from each active agencies
        collect(this.settings.activeAgencies).each((agency) => {
          this.loadVehiclesFromAgency(agency, timestamp)
        })
      },
      refreshVehicles () {
        const timestamp = Math.floor(Date.now() / 1000)

        // Load vehicle from each active agencies
        collect(this.settings.activeAgencies).each((agency) => {
          this.loadVehiclesFromAgency(agency, timestamp)
        })
      },
    },
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
