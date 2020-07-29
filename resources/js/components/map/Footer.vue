<template>
  <div>
    <v-footer
      fixed
      :color="componentColor"
      height="80px"
    >
      <v-row
        v-if="vehicle.id"
        justify="center"
      >
        <v-col class="agency">
          <span class="d-none d-md-block">{{ agency.name }}</span>
          <span class="d-md-none">{{ agency.slug | uppercase }}</span>
        </v-col>
        <v-col class="ref">
          {{ vehicle.label ? vehicle.label : vehicle.ref }}
        </v-col>
        <v-col
          v-if="vehicle.bearing"
          class="bearing d-none d-md-block"
        >
          <v-icon :style="{ transform: 'rotate(' + vehicle.bearing + 'deg)'}">
            {{ mdiSvg.navigation }}
          </v-icon>
        </v-col>
        <v-col
          v-if="vehicle.speed"
          class="speed d-none d-md-block"
        >
          {{ vehicle.speed }} km/h
        </v-col>
        <v-col class="trip">
          <div
            class="route"
            :style="{
              backgroundColor: vehicle.trip.color,
              color: vehicle.trip.text_color,
              borderColor: vehicle.trip.id ? vehicle.trip.color : agency.color }"
          >
            {{ vehicle.trip.route_short_name === null ? vehicle.route : vehicle.trip.route_short_name }}
            <span class="d-none d-md-block">{{ vehicle.trip.long_name }}</span>
          </div>
        </v-col>
        <v-col class="expand">
          <v-btn
            text
            icon
            @click="$emit('open-sheet')"
          >
            <v-icon>{{ mdiSvg.chevronUp }}</v-icon>
          </v-btn>
        </v-col>
      </v-row>
      <v-row
        v-else
        align="center"
        justify="center"
      >
        <v-col class="select">
          {{ $vuetify.lang.t('$vuetify.mapFooter.select') }}
        </v-col>
      </v-row>
    </v-footer>
  </div>
</template>

<script>
  import { VFooter, VRow, VCol, VBtn, VIcon } from 'vuetify/lib'
  import { mdiNavigation, mdiChevronUp } from '@mdi/js'

  export default {
    components: {
      VFooter,
      VRow,
      VCol,
      VBtn,
      VIcon,
    },
    filters: {
      uppercase: (value) => {
        return value.toUpperCase()
      },
    },
    props: {
      agency: Object,
      vehicle: Object,
    },
    data: () => ({
      mdiSvg: {
        navigation: mdiNavigation,
        chevronUp: mdiChevronUp,
      },
    }),
    computed: {
      componentColor () {
        return this.$vuetify.theme.dark ? '' : 'white'
      },
    },
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

    .trip {
      white-space: nowrap;
      overflow: hidden;
    }

    .trip .route {
        padding: 5px;
        border-radius: 3px;
        font-size: 14px;
        text-align: center;
        border-width: 3px;
        border-style: solid;
    }

    .trip .route span, .trip .route {
      overflow: hidden;
      text-overflow: ellipsis;
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
