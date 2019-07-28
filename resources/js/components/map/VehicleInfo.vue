<template>
    <div
        class="map-vehicle-info"
        :style="panelIsExpanded ? {
            'min-height': '148px'
        } : {
            'min-height': '74px'
        }">
        <div class="container md-layout md-gutter" v-if="!noVehicle">
            <div class="md-layout-item agency">
                <span class="hide-small">{{ agency.name }}</span>
                <span class="hide-big">{{ agency.slug | uppercase }}</span>
            </div>
            <div class="md-layout-item ref">
                {{ vehicle.ref }}
            </div>
            <div class="md-layout-item bearing hide-small" v-if="vehicle.bearing">
                <md-icon :style="{ transform:'rotate('+vehicle.bearing+'deg)'}">navigation</md-icon>
            </div>
            <div class="md-layout-item speed hide-small" v-if="vehicle.speed">
                {{ vehicle.speed }} km/h
            </div>
            <div class="md-layout-item trip">
                <div class="route" :style="{ backgroundColor: vehicle.trip.color, color: vehicle.trip.text_color }">{{ vehicle.trip.route_short_name === null ? vehicle.route : vehicle.trip.route_short_name  }} <span class="hide-small">{{ vehicle.trip.long_name }}</span></div>
            </div>
            <a class="md-layout-item pull-up" v-if="!panelIsExpanded" v-on:click="openOrClosePanel"><md-icon>keyboard_arrow_up</md-icon></a>
            <a class="md-layout-item pull-up" v-if="panelIsExpanded" v-on:click="openOrClosePanel"><md-icon>keyboard_arrow_down</md-icon></a>
        </div>
        <vehicle-info-expanded v-if="panelIsExpanded" v-bind:vehicle="vehicle" v-on:retract-panel="panelIsExpanded = false"></vehicle-info-expanded>
        <div class="container md-layout md-gutter select-container" v-if="noVehicle">
            <div class="md-layout-item select">
                Please select a vehicle to see more information
            </div>
        </div>
    </div>
</template>

<script>
    import VehicleInfoExpanded from './VehicleInfoExpanded.vue'
    const collect = require('collect.js')

    export default {
        components: {
            VehicleInfoExpanded
        },
        data() {
            return {
                panelIsExpanded: false
            }
        },
        computed: {
            vehicle() {
                return this.$store.state.vehicles.selection
            },
            noVehicle() {
                if (this.vehicle.id === null) {
                    return true
                } else {
                    return false
                }
            },
            agency() {
                const agencies = collect(this.$store.state.agencies.data)
                return agencies.firstWhere('id', this.vehicle.agency_id)
            }
        },
        methods: {
            openOrClosePanel() {
                if (this.panelIsExpanded) {
                    this.panelIsExpanded = false
                } else {
                    this.panelIsExpanded = true
                }
            }
        },
        filters: {
            uppercase: function (value) {
                return value.toUpperCase()
            }
        }
    }
</script>

<style lang="scss" scoped>
    .map-vehicle-info {
        height: fit-content;
        position: absolute;
        bottom: 0;
        width: 100%;
        background-color: white;
        border-radius: 10px 10px 0 0;
        z-index: 2;
        left: 0;
        transition: all .1s linear;
    }
    .md-layout {
        height: 50px;
    }
    .md-layout-item {
        margin: auto;
    }
    .container {
        margin: 12px;
    }
    .agency img {
        height: 24px;
    }
    .ref {
        font-size: 24px;
        text-align: right;
    }
    .trip {
        text-align: left;
    }
    .trip .route {
        padding: 5px;
        -webkit-border-radius: 3px;
        -moz-border-radius: 3px;
        border-radius: 3px;
        font-size: 14px;
        text-align: center;
    }
    .trip .second-line {
        text-align: center;
    }
    .pull-up {
        text-align: right;
    }
    .select {
        text-align: center;
        margin: auto;
    }
    .select-container {
        height: 50px;
    }
    .bearing {
        max-width: 105px;
        text-align: center;
    }
    .speed {
        max-width: 105px;
        text-align: center;
    }
    @media screen and (max-width: 959px) {
        .hide-small {
            display: none;
        }
    }

    @media screen and (min-width: 960px) {
        .hide-big {
            display: none;
        }
    }

    .a:hover {
        text-decoration: none;
    }
</style>
