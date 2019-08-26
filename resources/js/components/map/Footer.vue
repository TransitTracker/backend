<template>
<div>
    <v-footer fixed>
        <v-row
                justify="center"
                v-if="!noVehicle">
            <v-col class="agency">
                <span class="d-none d-md-block">{{ agency.name }}</span>
                <span class="d-md-none">{{ agency.slug | uppercase }}</span>
            </v-col>
            <v-col class="ref">
                {{ vehicle.ref }}
            </v-col>
            <v-col
                    class="bearing d-none d-md-block"
                    v-if="vehicle.bearing">
                <v-icon :style="{ transform: 'rotate(' + vehicle.bearing + 'deg)'}">mdi-navigation</v-icon>
            </v-col>
            <v-col
                    class="speed d-none d-md-block"
                    v-if="vehicle.speed">
                {{ vehicle.speed }} km/h
            </v-col>
            <v-col class="trip">
                <div
                        class="route"
                        :style="{ backgroundColor: vehicle.trip.color, color: vehicle.trip.text_color }">
                    {{ vehicle.trip.route_short_name === null ? vehicle.route : vehicle.trip.route_short_name }}
                    <span class="d-none d-md-block">{{ vehicle.trip.long_name }}</span>
                </div>
            </v-col>
            <v-col class="expand">
                <v-btn
                        text
                        icon
                        v-on:click="$emit('open-sheet')">
                    <v-icon>mdi-chevron-up</v-icon>
                </v-btn>
            </v-col>
        </v-row>
        <v-row
                align="center"
                justify="center"
                v-else>
            <v-col class="select">
                Please select a vehicle to see more information
            </v-col>
        </v-row>
    </v-footer>
</div>
</template>

<script>
import collect from 'collect.js'
import MapBottomSheet from './BottomSheet'
import { VFooter, VRow, VCol, VBtn, VIcon, VBottomSheet, VList, VSubheader, VListItem, VListItemIcon, VListItemTitle } from 'vuetify/lib'

export default {
    components: {
      VFooter,
      VRow,
      VCol,
      VBtn,
      VIcon,
      VBottomSheet,
      VList,
      VSubheader,
      VListItem,
      VListItemIcon,
      VListItemTitle,
      MapBottomSheet
    },
    props: {
      agency: Object,
      vehicle: Object
    },
    computed: {
      noVehicle () {
        if (this.vehicle.id === null) {
          return true
        } else {
          return false
        }
      }
    },
    filters: {
      uppercase: (value) => {
        return value.toUpperCase()
      }
    }
}
</script>

<style lang="scss" scoped>
    .v-footer {
        padding: 0px 16px;
        min-height: 76px;
    }

    .col {
        margin: auto;
        text-align: center;
    }

    .agency {
        text-align: left;
    }

    .trip .route {
        padding: 5px;
        border-radius: 3px;
        font-size: 14px;
        text-align: center;
    }

    .trip .second-line {
        text-align: center;
    }

    .expand {
        text-align: right;
    }

    .bearing {
        max-width: 105px;
    }

    .speed {
        max-width: 105px;
    }
</style>