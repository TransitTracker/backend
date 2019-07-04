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
                        <md-tab id="tab-home" md-label="Home" to="/"></md-tab>
                        <md-tab id="tab-map" md-label="Map" to="/map"></md-tab>
                        <md-tab id="tab-table" md-label="Table" to="/table"></md-tab>
                        <md-tab id="tab-settings" md-label="Settings" to="/settings"></md-tab>
                    </md-tabs>
                </div>
            </md-app-toolbar>

            <md-app-content>
                <md-progress-bar md-mode="indeterminate" class="md-accent" v-if="!appReady"></md-progress-bar>
                <router-view v-if="appReady"></router-view>
            </md-app-content>
        </md-app>
    </div>
</template>

<script>
    import axios from 'axios/index'
    const collect = require('collect.js/src/index.js')

    export default {
        name: 'app',
        data: () => ({
            menuVisible: false,
            appReady: false
        }),
        mounted () {
            // Redirect user to default path
            this.$router.push(this.$store.state.settings.defaultPath)

            // Load agencies
            axios
                .get('http://127.0.0.1:8000/api/agencies')
                .then(response => (this.$store.commit('agencies/setData', response.data.data)))

            // Load vehicle from each active agencies
            collect(this.settings.activeAgencies).each((agency) => {
                console.log('Loading vehicles from ' + agency)
                axios.get('http://127.0.0.1:8000/api/vehicles/' + agency)
                    .then(response => (this.$store.commit('vehicles/setData', response.data.data)))
                    .catch(function (error) {
                        console.log(error)
                    })
                    .then(this.appReady = true)
            })
        },
        computed: {
            settings () {
                return this.$store.state.settings
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
