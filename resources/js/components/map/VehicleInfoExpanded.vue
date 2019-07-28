<template>
    <div class="container md-layout md-gutter container-expanded-attributes">
        <div class="md-layout-item md-large-size-100" v-if="vehicle.trip.headsign">
            <md-icon>transit_enterexit</md-icon><b>Headsign:</b> {{ vehicle.trip.headsign }}
        </div>
        <div class="md-layout-item md-large-size-100">
            <div v-if="vehicle.trip.id">
                <md-icon>featured_play_list</md-icon><b>Trip ID:</b> {{ vehicle.trip.id }}
            </div>
            <div v-else-if="vehicle.gtfs_trip">
                <md-icon>featured_play_list</md-icon><b>Trip ID:</b> {{ vehicle.gtfs_trip }}
            </div>
        </div>
        <div class="md-layout-item md-large-size-100" v-if="vehicle.start">
            <md-icon>departure_board</md-icon><b>Start time:</b> {{ vehicle.start }}
        </div>
        <div class="md-layout-item md-large-size-100" v-if="vehicle.status">
            <md-icon>stop</md-icon><b>Status:</b> {{ vehicle.status }}
        </div>
        <div class="md-layout-item md-large-size-100" v-if="vehicle.stop_sequence">
            <md-icon>pin_drop</md-icon><b>Stop sequence:</b> {{ vehicle.stop_sequence }}
        </div>
        <div class="md-layout-item md-large-size-100 hide-big" v-if="vehicle.bearing">
            <span class="no-icon"></span><b>Bearing:</b> {{ vehicle.bearing}}&deg; <md-icon :style="{ transform:'rotate('+vehicle.bearing+'deg)'}">navigation</md-icon>
        </div>
        <div class="md-layout-item md-large-size-100 hide-big" v-if="vehicle.speed">
            <span class="no-icon"></span><b>Speed:</b> {{ vehicle.speed }} km/h
        </div>
        <div class="md-layout-item md-large-size-100" v-if="vehicle.trip.trip_short_name">
            <md-icon>confirmation_number</md-icon><b>Departure number:</b> {{ vehicle.trip.trip_short_name }}
        </div>
    </div>
</template>

<script>
    const collect = require('collect.js')

    export default {
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
        }
    }
</script>

<style lang="scss" scoped>
    .map-vehicle-info {
        min-height: 148px !important;
        height: fit-content;
        position: absolute;
        bottom: 74px;
    }
    .container-expanded-attributes .md-layout-item {
        margin: auto;
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

    @media screen and (max-width: 1919px) {
        .md-layout-item {
            padding-bottom: 8px;
        }
        .no-icon {
            padding-right: 32px;
        }
    }

    @media screen and (min-width: 1920px) {
        .md-layout-item {
            text-align: center;
        }
    }

    .md-icon {
        margin-right: 8px;
    }
</style>
