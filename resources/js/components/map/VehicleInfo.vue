<template>
    <div class="map-vehicle-info">
        <div class="container md-layout md-gutter" v-if="!noVehicle">
            <div class="md-layout-item agency">
                <span class="md-xsmall-hide md-small-hide">{{ agency.name }}</span>
                <span class="md-medium-hide md-large-hide md-xlarge-hide">{{ agency.slug | capitalize }}</span>
            </div>
            <div class="md-layout-item ref">
                {{ vehicle.ref }}
            </div>
            <div class="md-layout-item bearing" v-if="vehicle.bearing">
                <md-icon :style="{ transform:'rotate('+vehicle.bearing+'deg)'}">navigation</md-icon>
            </div>
            <div class="md-layout-item speed md-xsmall-hide" v-if="vehicle.speed">
                {{ vehicle.speed }} km/h
            </div>
            <div class="md-layout-item trip">
                <div class="route" :style="{ backgroundColor: vehicle.trip.color, color: vehicle.trip.text_color }">{{ vehicle.trip.route_short_name === null ? vehicle.route : vehicle.trip.route_short_name  }} <span class="md-xsmall-hide md-small-hide">{{ vehicle.trip.long_name }}</span></div>
                <div class="second-line">
                    <span class="number" v-if="agency.vehicles_type === 'train'">#{{ vehicle.trip.trip_short_name }}</span>
                    <span class="direction md-xsmall-hide md-small-hide">{{ vehicle.trip.headsign }}</span>
                </div>
            </div>
            <span class="md-layout-item pull-up"><md-icon>keyboard_arrow_up</md-icon></span>
        </div>
        <div class="container md-layout md-gutter select-container" v-if="noVehicle">
            <div class="md-layout-item select">
                Please select a vehicle to see more information
            </div>
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
        },
        filters: {
            capitalize: function (value) {
                if (!value) return ''
                value = value.toString()
                return value.charAt(0).toUpperCase() + value.slice(1)
            }
        }
    }
</script>

<style lang="scss" scoped>
    .map-vehicle-info {
        height: 74px;
        position: absolute;
        bottom: 0;
        width: 100%;
        background-color: white;
        border-radius: 10px 10px 0 0;
        z-index: 2;
        left: 0;
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
</style>
