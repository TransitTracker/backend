<template>
    <div id="app">
        <md-app md-mode="fixed">
            <md-app-toolbar class="md-large md-dense md-primary">
                <div class="md-toolbar-row">
                    <div class="md-toolbar-section-start">
                        <span class="md-title">Montreal Transit Tracker</span>
                    </div>

                    <div class="md-toolbar-section-end">
                        <md-button class="md-icon-button">
                            <md-icon>more_vert</md-icon>
                        </md-button>
                    </div>
                </div>

                <div class="md-toolbar-row">
                    <md-tabs class="md-primary" md-sync-route>
                        <md-tab id="tab-home" md-label="Home" to="/" exact></md-tab>
                        <md-tab id="tab-map" md-label="Map" to="/map"></md-tab>
                        <md-tab id="tab-table" md-label="Table" to="/table"></md-tab>
                        <md-tab id="tab-settings" md-label="Settings" to="/settings"></md-tab>
                    </md-tabs>
                </div>
            </md-app-toolbar>

            <md-app-content>
                <configuration v-if="!settings.configurationDone" v-on:configurationDone="setConfigurationAsDone"></configuration>
                <md-progress-bar md-mode="indeterminate" class="md-accent" v-if="!appReady"></md-progress-bar>
                <router-view v-if="appReady && settings.configurationDone"></router-view>
                <md-snackbar md-position="center" :md-active.sync="snackbarVisible">
                    <span>Data from {{ snackbarAgency }} has been loaded and is {{ snackbarSeconds }} old.</span>
                </md-snackbar>
            </md-app-content>
        </md-app>
    </div>
</template>

<script>
    import axios from 'axios/index'
    const collect = require('collect.js/src/index.js')
    import Configuration from './components/Configuration.vue'

    axios.defaults.baseURL = process.env.MIX_APIENDPOINT;

    export default {
        name: 'app',
        components: {
          Configuration
        },
        data: () => ({
            menuVisible: false,
            appReady: false,
            snackbarVisible: false,
            snackbarAgency: 'STM',
            snackbarSeconds: 0,
        }),
        mounted () {
            if (this.settings.configurationDone) {
                this.loadData()
            }

        },
        computed: {
            settings () {
                return this.$store.state.settings
            },
            agencies: {
                get() {
                    return this.$store.state.agencies.data
                },
                set(newAgencies) {
                    this.$store.commit('agencies/setData', newAgencies)
                }
            }
        },
        methods: {
            showSnackbar(agency, seconds) {
                this.snackbarAgency = agency.toUpperCase()
                this.snackbarSeconds = seconds
                this.snackbarVisible = true
            },
            setConfigurationAsDone() {
                this.$store.commit('settings/setConfigurationDone', true)
                this.loadData()
            },
            loadData() {
                // Starting app
                const timestamp = Date.now()
                console.log('[MTLTT] Loading at ' + timestamp)

                // Redirect user to default path
                this.$router.push(this.$store.state.settings.defaultPath)

                // Load agencies
                axios
                    .get('/agencies')
                    .then(response => (this.agencies = response.data.data))

                // Load vehicle from each active agencies
                collect(this.settings.activeAgencies).each((agency) => {
                    console.log('Loading vehicles from ' + agency)
                    axios.get('/vehicles/' + agency)
                        .then(response => (this.loadVehicles(timestamp, response, agency)))
                        .catch(function (error) {
                            console.log(error)
                        })
                })
                this.appReady = true
            },
            loadVehicles(timestamp, response, agency) {
                if ((timestamp - response.data.timestamp) > 300) {
                    this.$store.commit('vehicles/setData', response.data.data)
                    this.$store.commit('agencies/setCount', agency, response.data.count)
                    this.showSnackbar(agency, (timestamp - response.data.timestamp))
                } else {
                    this.showSnackbar(agency, 'too old!')
                }
            }
        }
    }
</script>

<style lang="scss" scoped>
    .md-app {
        height: 100vh;
    }

    .md-toolbar .md-tabs {
        padding-left: 0;
    }

    .md-app-container .md-app-scroller {
        margin-top: 112px;
    }
</style>
