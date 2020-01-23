<template>
    <v-bottom-sheet
        hide-overlay
        v-model="sheetModel"
        :persistent="persistent">
        <v-list>
            <v-btn
                    icon
                    color="secondary"
                    v-on:click="togglePersistent"
                    class="float-right">
                <v-icon v-if="persistent">mdi-pin-off</v-icon>
                <v-icon v-else>mdi-pin</v-icon>
            </v-btn>
            <v-spacer></v-spacer>
            <v-btn
                outlined
                color="accent"
                @click="$emit('close-sheet')"
                class="float-right">
                <span class="d-none d-md-block">{{ $vuetify.lang.t('$vuetify.mapBottomSheet.close') }}</span>
                <v-icon>mdi-close</v-icon>
            </v-btn>
            <v-spacer></v-spacer>
            <v-subheader>{{ $vuetify.lang.t('$vuetify.mapBottomSheet.moreInfo') }} {{ vehicle.ref }}</v-subheader>
            <v-list-item v-if="vehicle.route">
                <v-list-item-icon>
                    <v-icon>mdi-map-marker-path</v-icon>
                </v-list-item-icon>
                <v-list-item-title><b>{{ $vuetify.lang.t('$vuetify.mapBottomSheet.route') }}</b> {{ vehicle.route }}
                    <span v-if="vehicle.trip.long_name">{{ vehicle.trip.long_name}}</span>
                </v-list-item-title>
            </v-list-item>
            <v-list-item v-if="vehicle.trip.headsign">
                <v-list-item-icon>
                    <v-icon>mdi-sign-direction</v-icon>
                </v-list-item-icon>
                <v-list-item-title><b>{{ $vuetify.lang.t('$vuetify.mapBottomSheet.headsign') }}</b> {{ vehicle.trip.headsign }}</v-list-item-title>
            </v-list-item>
            <v-list-item v-if="vehicle.gtfs_trip">
                <v-list-item-icon>
                    <v-icon>mdi-identifier</v-icon>
                </v-list-item-icon>
                <v-list-item-title><b>{{ $vuetify.lang.t('$vuetify.mapBottomSheet.tripId') }}</b> {{ vehicle.gtfs_trip }}</v-list-item-title>
                <v-list-item-action v-if="agency.slug === 'stm'">
                    <v-tooltip left>
                        <template v-slot:activator="{ on }">
                            <v-btn icon color="secondary" v-on="on" @click="searchTrip"><v-icon>mdi-table-search</v-icon></v-btn>
                        </template>
                        <span>{{ $vuetify.lang.t('$vuetify.mapBottomSheet.searchTrip') }}</span>
                    </v-tooltip>
                </v-list-item-action>
            </v-list-item>
            <v-list-item v-if="vehicle.start">
                <v-list-item-icon>
                    <v-icon>mdi-bus-clock</v-icon>
                </v-list-item-icon>
                <v-list-item-title><b>{{ $vuetify.lang.t('$vuetify.mapBottomSheet.startTime') }}</b> {{ vehicle.start }}</v-list-item-title>
            </v-list-item>
            <v-list-item v-if="vehicle.status">
                <v-list-item-icon>
                    <v-icon>mdi-bus-stop</v-icon>
                </v-list-item-icon>
                <v-list-item-title><b>{{ $vuetify.lang.t('$vuetify.mapBottomSheet.status') }}</b> {{ vehicle.status === 1 ? 'STOPPED_AT' : 'IN_TRANSIT_TO' }}</v-list-item-title>
            </v-list-item>
            <v-list-item v-if="vehicle.stop_sequence">
                <v-list-item-icon>
                    <v-icon>mdi-timetable</v-icon>
                </v-list-item-icon>
                <v-list-item-title><b>{{ $vuetify.lang.t('$vuetify.mapBottomSheet.stopSequence') }}</b> {{ vehicle.stop_sequence }}</v-list-item-title>
            </v-list-item>
            <v-list-item v-if="vehicle.bearing">
                <v-list-item-icon>
                    <v-icon>mdi-compass</v-icon>
                </v-list-item-icon>
                <v-list-item-title>
                    <b>{{ $vuetify.lang.t('$vuetify.mapBottomSheet.bearing') }}</b>
                    {{ vehicle.bearing }}&deg;
                    <v-icon :style="{ transform: 'rotate(' + vehicle.bearing + 'deg)' }">mdi-navigation</v-icon>
                </v-list-item-title>
            </v-list-item>
            <v-list-item v-if="vehicle.speed">
                <v-list-item-icon>
                    <v-icon>mdi-speedometer</v-icon>
                </v-list-item-icon>
                <v-list-item-title><b>{{ $vuetify.lang.t('$vuetify.mapBottomSheet.speed') }}</b> {{ vehicle.speed }} km/h</v-list-item-title>
            </v-list-item>
            <v-list-item v-if="vehicle.trip.trip_short_name">
                <v-list-item-icon>
                    <v-icon>mdi-ticket-confirmation</v-icon>
                </v-list-item-icon>
                <v-list-item-title><b>{{ $vuetify.lang.t('$vuetify.mapBottomSheet.departureNumber') }}</b> {{ vehicle.trip.trip_short_name }}</v-list-item-title>
            </v-list-item>
        </v-list>
    </v-bottom-sheet>
</template>

<script>
import { VBtn, VIcon, VBottomSheet, VList, VSubheader, VListItem, VListItemIcon, VListItemTitle, VListItemAction, VTooltip, VSpacer } from 'vuetify/lib'

export default {
  components: {
    VBottomSheet,
    VBtn,
    VIcon,
    VList,
    VSubheader,
    VListItem,
    VListItemIcon,
    VListItemTitle,
    VListItemAction,
    VTooltip,
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
      set () {
        !this.persistent && this.$emit('close-sheet')
      }
    }
  },
  methods: {
    togglePersistent () {
      this.persistent ? this.persistent = false : this.persistent = true
    },
    clickOutsideSheet () {
      if (!this.persistent) {
        this.$emit('close-sheet')
      }
    },
    searchTrip () {
      const tab = window.open('https://www.cs.mcgill.ca/~jread3/cgi-bin/runsearch.cgi?tripid=' + this.vehicle.gtfs_trip, '_blank')
      tab.focus()
    }
  }
}
</script>

<style lang="scss" scoped>
    .v-btn {
        margin-left: 16px;
    }
    .v-btn--icon {
        margin-right: 16px;
    }
</style>
