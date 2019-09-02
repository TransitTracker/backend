<template>
    <v-bottom-sheet
        hide-overlay
        v-model="sheetModel"
        :persistent="persistent">
        <v-list>
            <v-tooltip left>
                <template v-slot:activator="{ on }">
                    <v-btn
                            icon
                            color="secondary"
                            v-on="on"
                            class="float-right">
                        <v-icon v-if="persistent">mdi-pin-off</v-icon>
                        <v-icon v-else>mdi-pin</v-icon>
                    </v-btn>
                </template>
                <span>This feature is currently broken</span>
            </v-tooltip>
            <v-spacer></v-spacer>
            <v-btn
                outlined
                color="accent"
                @click="$emit('close-sheet')"
                class="float-right">
                Close <v-icon>mdi-close</v-icon>
            </v-btn>
            <v-spacer></v-spacer>
            <v-btn
                outlined
                color="red"
                :href="'https://cptdb.ca/wiki/index.php?title=Special%3ASearch&fulltext=Search&search=' + agency.name + '+' + vehicle.ref"
                target="_blank"
                class="float-right">
                <v-icon left>mdi-open-in-new</v-icon> Search on CPTDB wiki
            </v-btn>
            <v-subheader>More info on {{ vehicle.ref }}</v-subheader>
            <v-list-item v-if="vehicle.trip.headsign">
                <v-list-item-icon>
                    <v-icon>mdi-sign-direction</v-icon>
                </v-list-item-icon>
                <v-list-item-title><b>Headsign:</b> {{ vehicle.trip.headsign }}</v-list-item-title>
            </v-list-item>
            <v-list-item v-if="vehicle.gtfs_trip">
                <v-list-item-icon>
                    <v-icon>mdi-identifier</v-icon>
                </v-list-item-icon>
                <v-list-item-title><b>Trip ID:</b> {{ vehicle.gtfs_trip }}</v-list-item-title>
            </v-list-item>
            <v-list-item v-if="vehicle.start">
                <v-list-item-icon>
                    <v-icon>mdi-bus-clock</v-icon>
                </v-list-item-icon>
                <v-list-item-title><b>Start time:</b> {{ vehicle.start }}</v-list-item-title>
            </v-list-item>
            <v-list-item v-if="vehicle.status">
                <v-list-item-icon>
                    <v-icon>mdi-bus-stop</v-icon>
                </v-list-item-icon>
                <v-list-item-title><b>Status:</b> {{ vehicle.status === 1 ? 'STOPPED_AT' : 'IN_TRANSIT_TO' }}</v-list-item-title>
            </v-list-item>
            <v-list-item v-if="vehicle.stop_sequence">
                <v-list-item-icon>
                    <v-icon>mdi-timetable</v-icon>
                </v-list-item-icon>
                <v-list-item-title><b>Stop sequence:</b> {{ vehicle.stop_sequence }}</v-list-item-title>
            </v-list-item>
            <v-list-item v-if="vehicle.bearing">
                <v-list-item-icon>
                    <v-icon>mdi-compass</v-icon>
                </v-list-item-icon>
                <v-list-item-title>
                    <b>Bearing:</b>
                    {{ vehicle.bearing }}&deg;
                    <v-icon :style="{ transfrom: 'rotate(' + vehicle.bearing + 'deg)' }">mdi-navigation</v-icon>
                </v-list-item-title>
            </v-list-item>
            <v-list-item v-if="vehicle.speed">
                <v-list-item-icon>
                    <v-icon>mdi-speedometer</v-icon>
                </v-list-item-icon>
                <v-list-item-title><b>Speed:</b> {{ vehicle.speed }} km/h</v-list-item-title>
            </v-list-item>
            <v-list-item v-if="vehicle.trip.trip_short_name">
                <v-list-item-icon>
                    <v-icon>mdi-ticket-confirmation</v-icon>
                </v-list-item-icon>
                <v-list-item-title><b>Departure number:</b> {{ vehicle.trip.trip_short_name }}</v-list-item-title>
            </v-list-item>
        </v-list>
    </v-bottom-sheet>
</template>

<script>
import { VBtn, VIcon, VBottomSheet, VList, VTooltip, VSubheader, VListItem, VListItemIcon, VListItemTitle, VSpacer } from 'vuetify/lib'

export default {
  components: {
    VBottomSheet,
    VBtn,
    VIcon,
    VList,
    VTooltip,
    VSubheader,
    VListItem,
    VListItemIcon,
    VListItemTitle,
    VSpacer
  },
  data () {
    return {
      persistent: false
    }
  },
  props: {
    agency: Object,
    vehicle: Object,
    sheetOpen: Boolean
  },
  computed: {
    sheetModel: {
      get () {
        return this.sheetOpen
      },
      set (val) {
        !this.persistent && this.$emit('close-sheet')
      }
    }
  },
  methods: {
    togglePersistent () {
      if (this.persistent) {
        this.persistent = false
      } else {
        this.persistent = true
      }
    },
    clickOutsideSheet () {
      if (!this.persistent) {
        this.$emit('close-sheet')
      }
    }
  }
}

// Todo: replace v-model sheetOpen with something that emits back
</script>

<style lang="scss" scoped>
    .v-btn {
        margin-left: 16px;
    }
    .v-btn--icon {
        margin-right: 16px;
    }
</style>
