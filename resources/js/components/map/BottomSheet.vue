<template>
    <v-bottom-sheet hide-overlay v-model="sheetModel" :persistent="persistent">
        <v-list>
            <div class="d-flex align-center">
                <v-subheader>{{ $vuetify.lang.t('$vuetify.mapBottomSheet.moreInfo') }} {{ vehicle.ref }}</v-subheader>
                <v-spacer></v-spacer>
                <v-btn icon v-on:click="togglePersistent" :color="componentColor" class="mx-4">
                    <v-icon v-if="persistent">{{ mdiSvg.pinOff }}</v-icon>
                    <v-icon v-else>{{ mdiSvg.pin }}</v-icon>
                </v-btn>
                <v-btn outlined :color="componentColor" @click="$emit('close-sheet')" class="mr-4">
                    <span class="d-none d-md-block">{{ $vuetify.lang.t('$vuetify.mapBottomSheet.close') }}</span>
                    <v-icon>{{ mdiSvg.close }}</v-icon>
                </v-btn>
            </div>
            <div class="ml-2 mr-4 d-flex align-center" v-if="vehicle.links.length">
                <div class="flex-grow-1 d-flex" id="links-list">
                    <v-sheet v-for="link in stateLinks" :key="link.id" @click="openLink(link.url)" rounded elevation="2"
                             :class="{'lighten-4': !settingsDarkMode, 'darken-3': settingsDarkMode}"
                             class="pa-2 d-flex align-center ma-2 cursor-pointer grey" :light="!settingsDarkMode"
                             :dark="settingsDarkMode">
                        <div>
                            <p class="subtitle-2 mb-1">{{ settingsLanguageEnglish ? link.title.en : link.title.fr }}</p>
                            <p class="body-2 mb-0">
                                {{ settingsLanguageEnglish ? link.description.en : link.description.fr }}
                            </p>
                        </div>
                        <v-icon class="ml-4" size="20px">{{ mdiSvg.openInNew }}</v-icon>
                    </v-sheet>
                </div>
                <v-icon id="links-chevron" v-if="showChevron" class="ml-2">{{ mdiSvg.chevronRight }}</v-icon>
            </div>
            <v-list-item v-if="vehicle.route">
                <v-list-item-icon>
                    <v-icon>{{ mdiSvg.mapMarkerPath }}</v-icon>
                </v-list-item-icon>
                <v-list-item-title><b>{{ $vuetify.lang.t('$vuetify.mapBottomSheet.route') }}</b>
                    <span v-if="vehicle.trip.long_name">
                        {{ vehicle.trip.route_short_name}} {{ vehicle.trip.long_name}}
                        (<code>{{ vehicle.route }}</code>)
                    </span>
                    <span v-else>{{ vehicle.route }}</span>
                </v-list-item-title>
            </v-list-item>
            <v-list-item v-if="vehicle.trip.headsign">
                <v-list-item-icon>
                    <v-icon>{{ mdiSvg.signDirection }}</v-icon>
                </v-list-item-icon>
                <v-list-item-title><b>{{ $vuetify.lang.t('$vuetify.mapBottomSheet.headsign') }}</b> {{
                    vehicle.trip.headsign }}
                </v-list-item-title>
            </v-list-item>
            <v-list-item v-if="vehicle.gtfs_trip">
                <v-list-item-icon>
                    <v-icon>{{ mdiSvg.identifier }}</v-icon>
                </v-list-item-icon>
                <v-list-item-title><b>{{ $vuetify.lang.t('$vuetify.mapBottomSheet.tripId') }}</b> {{ vehicle.gtfs_trip
                    }}
                </v-list-item-title>
            </v-list-item>
            <v-list-item v-if="vehicle.start">
                <v-list-item-icon>
                    <v-icon>{{ mdiSvg.busClock }}</v-icon>
                </v-list-item-icon>
                <v-list-item-title><b>{{ $vuetify.lang.t('$vuetify.mapBottomSheet.startTime') }}</b> {{ vehicle.start }}
                </v-list-item-title>
            </v-list-item>
            <v-list-item v-if="vehicle.status">
                <v-list-item-icon>
                    <v-icon>{{ mdiSvg.busStop }}</v-icon>
                </v-list-item-icon>
                <v-list-item-title><b>{{ $vuetify.lang.t('$vuetify.mapBottomSheet.status') }}</b> {{ vehicle.status ===
                    1 ? 'STOPPED_AT' : 'IN_TRANSIT_TO' }}
                </v-list-item-title>
            </v-list-item>
            <v-list-item v-if="vehicle.stop_sequence">
                <v-list-item-icon>
                    <v-icon>{{ mdiSvg.timetable }}</v-icon>
                </v-list-item-icon>
                <v-list-item-title><b>{{ $vuetify.lang.t('$vuetify.mapBottomSheet.stopSequence') }}</b> {{
                    vehicle.stop_sequence }}
                </v-list-item-title>
            </v-list-item>
            <v-list-item v-if="vehicle.bearing">
                <v-list-item-icon>
                    <v-icon>{{ mdiSvg.compass }}</v-icon>
                </v-list-item-icon>
                <v-list-item-title>
                    <b>{{ $vuetify.lang.t('$vuetify.mapBottomSheet.bearing') }}</b>
                    {{ vehicle.bearing }}&deg;
                    <v-icon :style="{ transform: 'rotate(' + vehicle.bearing + 'deg)' }">{{ mdiSvg.navigation }}
                    </v-icon>
                </v-list-item-title>
            </v-list-item>
            <v-list-item v-if="vehicle.speed">
                <v-list-item-icon>
                    <v-icon>{{ mdiSvg.speedometer }}</v-icon>
                </v-list-item-icon>
                <v-list-item-title><b>{{ $vuetify.lang.t('$vuetify.mapBottomSheet.speed') }}</b> {{ vehicle.speed }}
                    km/h
                </v-list-item-title>
            </v-list-item>
            <v-list-item v-if="vehicle.trip.trip_short_name">
                <v-list-item-icon>
                    <v-icon>{{ mdiSvg.ticketConfirmation }}</v-icon>
                </v-list-item-icon>
                <v-list-item-title><b>{{ $vuetify.lang.t('$vuetify.mapBottomSheet.departureNumber') }}</b> {{
                    vehicle.trip.trip_short_name }}
                </v-list-item-title>
            </v-list-item>
        </v-list>
    </v-bottom-sheet>
</template>

<script>
import {
  VBottomSheet,
  VBtn,
  VIcon,
  VList,
  VListItem,
  VListItemIcon,
  VListItemTitle,
  VSheet,
  VSpacer,
  VSubheader
} from 'vuetify/lib'
import {
  mdiBusClock,
  mdiBusStop,
  mdiClose,
  mdiChevronRight,
  mdiCompass,
  mdiIdentifier,
  mdiMapMarkerPath,
  mdiNavigation,
  mdiOpenInNew,
  mdiPin,
  mdiPinOff,
  mdiSignDirection,
  mdiSpeedometer,
  mdiTableSearch,
  mdiTicketConfirmation,
  mdiTimetable
} from '@mdi/js'
import collect from 'collect.js'

export default {
  components: {
    VBottomSheet,
    VBtn,
    VIcon,
    VList,
    VSheet,
    VSubheader,
    VListItem,
    VListItemIcon,
    VListItemTitle,
    VSpacer
  },
  data: () => ({
    persistent: false,
    mdiSvg: {
      pinOff: mdiPinOff,
      pin: mdiPin,
      close: mdiClose,
      chevronRight: mdiChevronRight,
      openInNew: mdiOpenInNew,
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
    componentColor () {
      return this.$vuetify.theme.dark
        ? 'white'
        : 'primary'
    },
    settingsDarkMode () {
      return this.$store.state.settings.darkMode
    },
    settingsLanguageEnglish () {
      return this.$store.state.settings.language === 'en'
    },
    sheetModel: {
      get () {
        return this.sheetOpen
      },
      set () {
        !this.persistent && this.$emit('close-sheet')
      }
    },
    showChevron () {
      const div = document.getElementById('links-list')
      if (!div || !this.vehicle.links.length) {
        return false
      }
      return div.scrollWidth > div.clientWidth
    },
    stateLinks () {
      return collect(this.$store.state.links.data).whereIn('id', this.vehicle.links).all()
    }
  },
  methods: {
    clickOutsideSheet () {
      if (!this.persistent) {
        this.$emit('close-sheet')
      }
    },
    openLink (url) {
      const tab = window.open(
        url.replace(':id', this.vehicle.id).replace(':ref', this.vehicle.ref).replace(':trip', this.vehicle.gtfs_trip)
        , '_blank')
      tab.focus()
    },
    togglePersistent () {
      this.persistent ? this.persistent = false : this.persistent = true
    }
  }
}
</script>

<style scoped>
    .cursor-pointer {
        cursor: pointer;
    }
    #links-list {
        overflow-x: auto;
    }
    #links-list > div {
        white-space: nowrap;
    }
</style>
