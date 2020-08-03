<template>
  <v-bottom-sheet
    v-model="sheetModel"
    hide-overlay
    :persistent="persistent"
    class="map-bottom-sheet"
  >
    <v-sheet>
      <div
        class="d-flex align-center pa-4 grey"
        :class="{'lighten-4': !settingsDarkMode, 'darken-4': settingsDarkMode}"
      >
        <div class="flex-grow-1">
          <b>{{ $vuetify.lang.t('$vuetify.mapBottomSheet.vehicle') }} {{ vehicle.label ? vehicle.label : vehicle.ref }}</b><br>
          <span v-if="vehicle.timestamp">
            {{ $vuetify.lang.t('$vuetify.mapBottomSheet.seenAt') }} {{ vehicle.timestamp | timestampToTime }}
          </span>
        </div>
        <v-btn
          icon
          :color="componentColor"
          class="mx-4"
          @click="togglePersistent"
        >
          <v-icon v-if="persistent">
            {{ mdiSvg.pinOff }}
          </v-icon>
          <v-icon v-else>
            {{ mdiSvg.pin }}
          </v-icon>
        </v-btn>
        <v-btn
          outlined
          :color="componentColor"
          @click="$emit('close-sheet')"
        >
          <span class="d-none d-md-block">{{ $vuetify.lang.t('$vuetify.mapBottomSheet.close') }}</span>
          <v-icon>{{ mdiSvg.close }}</v-icon>
        </v-btn>
      </div>
      <div class="bottom-sheet-overflow">
        <v-slide-group
          v-if="vehicle.links.length"
          class="px-4 py-2 grey"
          :class="{'lighten-3': !settingsDarkMode, 'darken-3': settingsDarkMode}"
          show-arrows
        >
          <v-slide-item
            v-for="link in stateLinks"
            :key="link.id"
          >
            <v-sheet
              rounded
              elevation="2"
              :class="{'white': !settingsDarkMode, 'dark': settingsDarkMode}"
              class="pa-2 d-flex align-center mr-4 my-2 cursor-pointer"
              :light="!settingsDarkMode"
              :dark="settingsDarkMode"
              @click="openLink(link.url)"
            >
              <div>
                <p class="subtitle-2 mb-1">
                  {{ settingsLanguageEnglish ? link.title.en : link.title.fr }}
                </p>
                <p class="body-2 mb-0">
                  {{ settingsLanguageEnglish ? link.description.en : link.description.fr }}
                </p>
              </div>
              <v-icon
                class="ml-4"
                size="20px"
              >
                {{ mdiSvg.openInNew }}
              </v-icon>
            </v-sheet>
          </v-slide-item>
        </v-slide-group>

        <v-list :dense="$vuetify.breakpoint.lgAndDown">
          <div
            v-for="property in properties"
            :key="property.name"
          >
            <v-list-item
              v-if="property.parent ? vehicle[property.parent][property.name] : vehicle[property.name]"
            >
              <v-list-item-icon>
                <v-icon v-text="property.icon" />
              </v-list-item-icon>
              <v-list-item-content>
                <v-list-item-title class="d-flex align-center justify-space-between">
                  <p class="mb-0 white-space--normal">
                    <b>{{ $vuetify.lang.t(`$vuetify.mapBottomSheet.properties.${property.name}`) }}</b>
                    <span :class="property.css">
                      {{ property.content ? vehicle[property.content] : property.parent ? vehicle[property.parent][property.name] : vehicle[property.name] }}
                    </span>
                    <span v-if="property.name === 'route' && vehicle.trip.long_name">
                      {{ vehicle.trip.route_short_name === vehicle.route ? '' : vehicle.trip.route_short_name }} {{ vehicle.trip.long_name }}
                    </span>
                    <span v-if="property.name === 'odometer'">km</span>
                    <span v-if="property.name === 'bearing'">
                      &deg;
                      <v-icon :style="{ transform: 'rotate(' + vehicle.bearing + 'deg)' }">
                        {{ mdiSvg.navigation }}
                      </v-icon>
                    </span>
                    <span v-if="property.name === 'speed'">km/h</span>
                  </p>
                  <v-btn
                    v-if="property.help"
                    icon
                    small
                    class="float-right"
                    @click="helpToggle[property.name] = !helpToggle[property.name]"
                  >
                    <v-icon color="secondary">
                      {{ helpToggle[property.name] ? mdiSvg.close : mdiSvg.helpCircle }}
                    </v-icon>
                  </v-btn>
                </v-list-item-title>
                <v-list-item-subtitle
                  v-if="helpToggle[property.name]"
                  class="pa-2 secondary darken-3 white--text rounded white-space--normal"
                >
                  {{ $vuetify.lang.t(`$vuetify.mapBottomSheet.help.${property.name}`) }}
                </v-list-item-subtitle>
              </v-list-item-content>
            </v-list-item>
          </div>
        </v-list>
      </div>
    </v-sheet>
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
    VListItemContent,
    VListItemTitle,
    VListItemSubtitle,
    VSlideGroup,
    VSlideItem,
    VSheet,
  } from 'vuetify/lib'
  import {
    mdiBusClock,
    mdiBusStop,
    mdiClose,
    mdiCompass,
    mdiIdentifier,
    mdiMapMarkerPath,
    mdiNavigation,
    mdiOpenInNew,
    mdiPin,
    mdiPinOff,
    mdiSignDirection,
    mdiSpeedometer,
    mdiTicketConfirmation,
    mdiTimetable,
    mdiFormatLetterStartsWith,
    mdiCounter,
    mdiTrafficLight,
    mdiSeatPassenger,
    mdiTimelinePlus,
    mdiHelpCircle,
  } from '@mdi/js'
  import collect from 'collect.js'

  export default {
    components: {
      VBottomSheet,
      VBtn,
      VIcon,
      VList,
      VSheet,
      VListItem,
      VListItemIcon,
      VListItemContent,
      VListItemTitle,
      VListItemSubtitle,
      VSlideGroup,
      VSlideItem,
    },
    filters: {
      timestampToTime (timestamp) {
        const date = new Date(timestamp * 1000)
        const minutes = date.getMinutes() < 10 ? `0${date.getMinutes()}` : date.getMinutes()
        const seconds = date.getSeconds() < 10 ? `0${date.getSeconds()}` : date.getSeconds()
        return `${date.getHours()}:${minutes}:${seconds}`
      },
    },
    props: {
      agency: Object,
      vehicle: Object,
      sheetOpen: Boolean,
    },
    data: () => ({
      persistent: false,
      mdiSvg: {
        pinOff: mdiPinOff,
        pin: mdiPin,
        close: mdiClose,
        openInNew: mdiOpenInNew,
        navigation: mdiNavigation,
        helpCircle: mdiHelpCircle,
      },
      properties: [
        {
          name: 'label',
          content: 'ref',
          icon: mdiIdentifier,
          help: true,
        },
        {
          name: 'plate',
          icon: mdiFormatLetterStartsWith,
        },
        {
          name: 'gtfs_trip',
          icon: mdiIdentifier,
          help: true,
        },
        {
          name: 'route',
          icon: mdiMapMarkerPath,
        },
        {
          name: 'headsign',
          parent: 'trip',
          icon: mdiSignDirection,
        },
        {
          name: 'trip_short_name',
          parent: 'trip',
          icon: mdiTicketConfirmation,
        },
        {
          name: 'start',
          icon: mdiBusClock,
        },
        {
          name: 'relationship',
          icon: mdiTimelinePlus,
          help: true,
        },
        {
          name: 'odometer',
          icon: mdiCounter,
        },
        {
          name: 'bearing',
          icon: mdiCompass,
        },
        {
          name: 'speed',
          icon: mdiSpeedometer,
        },
        {
          name: 'status',
          icon: mdiBusStop,
          help: true,
        },
        {
          name: 'stop_sequence',
          icon: mdiTimetable,
          help: true,
        },
        {
          name: 'congestion',
          icon: mdiTrafficLight,
        },
        {
          name: 'occupancy',
          icon: mdiSeatPassenger,
        },
      ],
      helpToggle: {
        label: false,
        gtfs_trip: false,
        relationship: false,
        status: false,
        stop_sequence: false,
      },
    }),
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
        },
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
      },
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
      },
    },
  }
</script>

<style scoped>
    .bottom-sheet-overflow {
      max-height: calc(50vh - 80px);
      overflow: auto;
    }
    .cursor-pointer {
        cursor: pointer;
    }
    #links-list {
        overflow-x: auto;
    }
    #links-list > div {
        white-space: nowrap;
    }
    .dark {
      background-color: #1e1e1e;
    }
    .white-space--normal {
      white-space: normal;
    }
</style>
