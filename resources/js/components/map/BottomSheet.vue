<template>
    <v-bottom-sheet hide-overlay v-model="sheetModel" :persistent="persistent">
        <v-list>
            <v-btn icon v-on:click="togglePersistent" class="float-right" :color="componentColor">
                <v-icon v-if="persistent">{{ mdiSvg.pinOff }}</v-icon>
                <v-icon v-else>{{ mdiSvg.pin }}</v-icon>
            </v-btn>
            <v-btn outlined :color="componentColor" @click="$emit('close-sheet')" class="float-right">
                <span class="d-none d-md-block">{{ $vuetify.lang.t('$vuetify.mapBottomSheet.close') }}</span>
                <v-icon>{{ mdiSvg.close }}</v-icon>
            </v-btn>
            <v-spacer></v-spacer>
            <v-subheader>{{ $vuetify.lang.t('$vuetify.mapBottomSheet.moreInfo') }} {{ vehicle.ref }}</v-subheader>
            <v-list-item v-if="vehicle.route">
                <v-list-item-icon>
                    <v-icon>{{ mdiSvg.mapMarkerPath }}</v-icon>
                </v-list-item-icon>
                <v-list-item-title><b>{{ $vuetify.lang.t('$vuetify.mapBottomSheet.route') }}</b>
                    <span v-if="vehicle.trip.long_name">{{ vehicle.trip.route_short_name}} {{ vehicle.trip.long_name}} (<code>{{ vehicle.route }}</code>)</span>
                    <span v-else>{{ vehicle.route }}</span>
                </v-list-item-title>
            </v-list-item>
            <v-list-item v-if="vehicle.trip.headsign">
                <v-list-item-icon>
                    <v-icon>{{ mdiSvg.signDirection }}</v-icon>
                </v-list-item-icon>
                <v-list-item-title><b>{{ $vuetify.lang.t('$vuetify.mapBottomSheet.headsign') }}</b> {{ vehicle.trip.headsign }}</v-list-item-title>
            </v-list-item>
            <v-list-item v-if="vehicle.gtfs_trip">
                <v-list-item-icon>
                    <v-icon>{{ mdiSvg.identifier }}</v-icon>
                </v-list-item-icon>
                <v-list-item-title><b>{{ $vuetify.lang.t('$vuetify.mapBottomSheet.tripId') }}</b> {{ vehicle.gtfs_trip }}</v-list-item-title>
                <v-list-item-action v-if="agency.slug === 'stm'">
                    <v-tooltip left>
                        <template v-slot:activator="{ on }">
                            <v-btn icon v-on="on" @click="searchTrip"><v-icon>{{ mdiSvg.tableSearch }}</v-icon></v-btn>
                        </template>
                        <span>{{ $vuetify.lang.t('$vuetify.mapBottomSheet.searchTrip') }}</span>
                    </v-tooltip>
                </v-list-item-action>
            </v-list-item>
            <v-list-item v-if="vehicle.start">
                <v-list-item-icon>
                    <v-icon>{{ mdiSvg.busClock }}</v-icon>
                </v-list-item-icon>
                <v-list-item-title><b>{{ $vuetify.lang.t('$vuetify.mapBottomSheet.startTime') }}</b> {{ vehicle.start }}</v-list-item-title>
            </v-list-item>
            <v-list-item v-if="vehicle.status">
                <v-list-item-icon>
                    <v-icon>{{ mdiSvg.busStop }}</v-icon>
                </v-list-item-icon>
                <v-list-item-title><b>{{ $vuetify.lang.t('$vuetify.mapBottomSheet.status') }}</b> {{ vehicle.status === 1 ? 'STOPPED_AT' : 'IN_TRANSIT_TO' }}</v-list-item-title>
            </v-list-item>
            <v-list-item v-if="vehicle.stop_sequence">
                <v-list-item-icon>
                    <v-icon>{{ mdiSvg.timetable }}</v-icon>
                </v-list-item-icon>
                <v-list-item-title><b>{{ $vuetify.lang.t('$vuetify.mapBottomSheet.stopSequence') }}</b> {{ vehicle.stop_sequence }}</v-list-item-title>
            </v-list-item>
            <v-list-item v-if="vehicle.bearing">
                <v-list-item-icon>
                    <v-icon>{{ mdiSvg.compass }}</v-icon>
                </v-list-item-icon>
                <v-list-item-title>
                    <b>{{ $vuetify.lang.t('$vuetify.mapBottomSheet.bearing') }}</b>
                    {{ vehicle.bearing }}&deg;
                    <v-icon :style="{ transform: 'rotate(' + vehicle.bearing + 'deg)' }">{{ mdiSvg.navigation }}</v-icon>
                </v-list-item-title>
            </v-list-item>
            <v-list-item v-if="vehicle.speed">
                <v-list-item-icon>
                    <v-icon>{{ mdiSvg.speedometer }}</v-icon>
                </v-list-item-icon>
                <v-list-item-title><b>{{ $vuetify.lang.t('$vuetify.mapBottomSheet.speed') }}</b> {{ vehicle.speed }} km/h</v-list-item-title>
            </v-list-item>
            <v-list-item v-if="vehicle.trip.trip_short_name">
                <v-list-item-icon>
                    <v-icon>{{ mdiSvg.ticketConfirmation }}</v-icon>
                </v-list-item-icon>
                <v-list-item-title><b>{{ $vuetify.lang.t('$vuetify.mapBottomSheet.departureNumber') }}</b> {{ vehicle.trip.trip_short_name }}</v-list-item-title>
            </v-list-item>
        </v-list>
    </v-bottom-sheet>
</template>

<script>
import {
  VBtn, VIcon, VBottomSheet, VList, VSubheader, VListItem, VListItemIcon, VListItemTitle, VListItemAction, VTooltip,
  VSpacer
} from 'vuetify/lib'
import {
  mdiPinOff, mdiPin, mdiClose, mdiMapMarkerPath, mdiSignDirection, mdiIdentifier, mdiTableSearch, mdiBusClock,
  mdiBusStop, mdiTimetable, mdiCompass, mdiNavigation, mdiSpeedometer, mdiTicketConfirmation
} from '@mdi/js'

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
  data: () => ({
    persistent: false,
    mdiSvg: {
      pinOff: mdiPinOff,
      pin: mdiPin,
      close: mdiClose,
      mapMarkerPath: mdiMapMarkerPath,
      signDirection: mdiSignDirection,
      identifier: mdiIdentifier,
      tableSearch: mdiTableSearch,
      busClock: mdiBusClock,
      busStop: mdiBusStop,
      timetable: mdiTimetable,
      compass: mdiCompass,
      navigation: mdiNavigation,
      speedometer: mdiSpeedometer,
      ticketConfirmation: mdiTicketConfirmation
    }
  }),
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
    },
    componentColor () {
      return this.$vuetify.theme.dark
        ? 'white'
        : 'primary'
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
