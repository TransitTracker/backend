<template>
  <v-dialog v-model="dialog">
    <v-card>
      <v-card-title primary-title>
        {{ $vuetify.lang.t('$vuetify.download.cardTitle') }}
      </v-card-title>

      <v-card-text>
        <v-row>
          <v-col
            cols="12"
            md="6"
            class="d-flex flex-column justify-space-between"
          >
            <div>
              <b>{{ $vuetify.lang.t('$vuetify.download.loadedTitle') }}</b>
              <p>{{ $vuetify.lang.t('$vuetify.download.loadedDescription') }}</p>
            </div>

            <json-excel
              :data="stateVehicles"
              :fields="downloadFields"
              type="csv"
              :name="downloadName"
            >
              <v-btn color="primary">
                <v-icon left>
                  {{ mdiSvg.download }}
                </v-icon>
                {{ $vuetify.lang.t('$vuetify.download.downloadButton') }}
              </v-btn>
            </json-excel>
          </v-col>
          <v-col
            cols="12"
            md="6"
            class="d-flex flex-column justify-space-between"
          >
            <div>
              <b>{{ $vuetify.lang.t('$vuetify.download.allTitle') }}</b>
              <p>{{ $vuetify.lang.t('$vuetify.download.allDescription') }}</p>
            </div>

            <v-select
              v-model="selectedAgency"
              :items="agencies"
              :label="$vuetify.lang.t('$vuetify.download.agencySelect')"
            />

            <v-btn
              color="primary"
              class="mt-4"
              :href="downloadUrl"
              :disabled="selectedAgency === ''"
              download
            >
              <v-icon left>
                {{ mdiSvg.download }}
              </v-icon>
              {{ $vuetify.lang.t('$vuetify.download.downloadButton') }}
            </v-btn>
          </v-col>
        </v-row>
      </v-card-text>
    </v-card>
  </v-dialog>
</template>

<script>
  import collect from 'collect.js'
  import JsonExcel from 'vue-json-excel'
  import { VDialog, VCard, VCardTitle, VCardText, VRow, VCol, VBtn, VIcon, VSelect } from 'vuetify/lib'
  import { mdiDownload } from '@mdi/js'

  export default {
    components: {
      VDialog,
      VCard,
      VCardTitle,
      VCardText,
      VRow,
      VCol,
      VBtn,
      VIcon,
      VSelect,
      JsonExcel,
    },
    props: {
      dialogOpen: Boolean,
    },
    data: () => ({
      downloadFields: {
        'Agency ID': 'agency_id',
        'Vehicle fleet number': 'ref',
        Latitude: 'lat',
        Longitude: 'lon',
        'Trip ID': 'gtfs_trip',
        'Trip headsign': 'trip.headsign',
        'Trip short name': 'trip.trip_short_name',
        'Route short name': 'trip.route_short_name',
        'Route long name': 'trip.long_name',
        'Start time': 'start',
        'Stop sequence': 'stop_sequence',
        Status: 'status',
        Speed: 'speed',
        Bearing: 'bearing',
      },
      downloadType: 'xls',
      selectedAgency: '',
      mdiSvg: {
        download: mdiDownload,
      },
    }),
    computed: {
      agencies () {
        const agencies = collect(this.$store.state.agencies.data)
        const selectAgencies = []

        agencies.each((agency) => {
          const agencyObject = {}

          agencyObject.value = agency.slug
          agencyObject.text = agency.region.toUpperCase() + ' - ' + agency.name

          selectAgencies.push(agencyObject)
        })

        return selectAgencies
      },
      dialog: {
        get () {
          return this.dialogOpen
        },
        set (value) {
          this.$emit('close-dialog')
        },
      },
      downloadName () {
        function pad (s) { return (s < 10) ? '0' + s : s }
        const date = new Date()
        const dateTime = date.getFullYear() + pad(date.getMonth() + 1) + pad(date.getDate()) + '_' + pad(date.getHours()) + pad(date.getMinutes())
        return `tt-${this.$store.state.settings.activeRegion}-export-${dateTime}.${this.downloadType}`
      },
      stateVehicles () {
        return this.$store.state.vehicles.data
      },
      downloadUrl () {
        return process.env.MIX_API_ENDPOINT + '/dump/' + this.selectedAgency
      },
    },
  }
</script>
