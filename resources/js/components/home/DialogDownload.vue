<template>
  <v-dialog v-model="dialog">
    <v-stepper
      v-model="downloadStepper"
      vertical
    >
      <v-stepper-step
        :complete="downloadStepper > 1"
        step="1"
      >
        {{ $vuetify.lang.t('$vuetify.download.agencyStep') }}
      </v-stepper-step>
      <v-stepper-content step="1">
        <v-select
          v-model="selectedAgency"
          :items="agencies"
          :label="$vuetify.lang.t('$vuetify.download.agencySelect')"
          color="secondary"
          item-color="secondary darken-3"
        />

        <v-card
          v-if="selectedAgency && selectedAgency.is_downloadable"
          :color="darkMode ? 'grey darken-3': 'grey lighten-4'"
          class="mb-4"
          outlined
        >
          <v-card-text class="body-2">
            <b>{{ $vuetify.lang.t('$vuetify.download.agencyLicense') }}</b><br>
            {{ selectedAgency.license_title }}
            <a
              v-if="selectedAgency.license_url"
              :href="selectedAgency.license_url"
            >
              {{ $vuetify.lang.t('$vuetify.download.agencyRead') }}
            </a>
          </v-card-text>
        </v-card>
        <v-card
          v-else-if="selectedAgency && !selectedAgency.is_downloadable"
          color="error"
          class="mb-4"
          outlined
        >
          <v-card-text class="white--text body-2">
            <b>{{ $vuetify.lang.t('$vuetify.download.agencyNotDownloadable') }}</b><br>
            {{ selectedAgency.license_title }}
            <a
              v-if="selectedAgency.license_url"
              :href="selectedAgency.license_url"
            >
              {{ $vuetify.lang.t('$vuetify.download.agencyRead') }}
            </a><br>
          </v-card-text>
        </v-card>

        <div class="d-flex justify-space-between">
          <v-btn
            color="primary"
            :disabled="!selectedAgency || !selectedAgency.is_downloadable"
            @click="downloadStepper = 2"
          >
            {{ $vuetify.lang.t('$vuetify.onboarding.btnNext') }}
          </v-btn>
          <div />
          <v-btn
            text
            @click="dialog = false"
          >
            {{ $vuetify.lang.t('$vuetify.download.btnCancel') }}
          </v-btn>
        </div>
      </v-stepper-content>
      <v-stepper-step
        :complete="downloadStepper > 2"
        step="2"
      >
        {{ $vuetify.lang.t('$vuetify.download.formatStep') }}
      </v-stepper-step>
      <v-stepper-content step="2">
        <p class="text-body-1">
          {{ $vuetify.lang.t('$vuetify.download.formatDesc') }}
        </p>
        <b
          v-if="agencyIsNotLoaded"
          class="text-body-1"
        >
          {{ $vuetify.lang.t('$vuetify.download.formatNotLoaded') }}
        </b>
        <v-radio-group
          v-model="downloadFormat"
          class="ml-2"
        >
          <v-radio
            :label="$vuetify.lang.t('$vuetify.download.formatLoaded')"
            :disabled="agencyIsNotLoaded"
            color="secondary"
            value="loaded"
          />
          <v-radio
            :label="$vuetify.lang.t('$vuetify.download.formatDump')"
            color="secondary"
            value="dump"
          />
        </v-radio-group>
        <div>
          <v-btn
            color="primary"
            @click="prepareDownload"
          >
            {{ $vuetify.lang.t('$vuetify.onboarding.btnNext') }}
          </v-btn>
          <v-btn
            text
            class="ml-2"
            @click="downloadStepper = 1"
          >
            {{ $vuetify.lang.t('$vuetify.onboarding.btnBack') }}
          </v-btn>
        </div>
      </v-stepper-content>
      <v-stepper-step
        :complete="downloadStepper > 3"
        step="3"
      >
        {{ $vuetify.lang.t('$vuetify.download.downloadStep') }}
      </v-stepper-step>
      <v-stepper-content step="3">
        <p
          v-if="downloadReady"
          class="body-1"
        >
          {{ $vuetify.lang.t('$vuetify.download.downloadReady') }}
        </p>
        <p
          v-else
          class="body-1"
        >
          {{ $vuetify.lang.t('$vuetify.download.downloadLoading') }}
        </p>
        <v-card
          v-if="downloadError"
          color="error"
          class="mb-4"
          outlined
        >
          <v-card-text class="white--text body-2">
            {{ $vuetify.lang.t(downloadError === '429' ? '$vuetify.download.downloadError429' : '$vuetify.download.downloadError') }}
          </v-card-text>
        </v-card>
        <div class="d-flex align-items-center">
          <v-btn
            v-if="downloadFormat === 'dump'"
            color="primary"
            :loading="!downloadReady"
            :href="downloadDumpData"
            :download="downloadDumpName"
          >
            <v-icon left>
              {{ mdiSvg.download }}
            </v-icon>
            {{ $vuetify.lang.t('$vuetify.download.downloadBtn') }}
          </v-btn>
          <div v-else>
            <json-excel
              :data="stateVehicles"
              :fields="downloadFields"
              type="csv"
              :name="downloadName"
              style="display: inline-flex"
            >
              <v-btn color="primary">
                <v-icon left>
                  {{ mdiSvg.download }}
                </v-icon>
                {{ $vuetify.lang.t('$vuetify.download.downloadButton') }}
              </v-btn>
            </json-excel>
          </div>
          <v-btn
            text
            class="ml-2"
            @click="downloadStepper = 2"
          >
            {{ $vuetify.lang.t('$vuetify.onboarding.btnBack') }}
          </v-btn>
        </div>
      </v-stepper-content>
    </v-stepper>
  </v-dialog>
</template>

<script>
  import axios from 'axios/index'
  import JsonExcel from 'vue-json-excel'
  import { VDialog, VCard, VCardText, VBtn, VSelect, VStepper, VStepperContent, VStepperStep, VRadioGroup, VRadio, VIcon } from 'vuetify/lib'
  import { mdiDownload } from '@mdi/js'

  export default {
    components: {
      VDialog,
      VCard,
      VCardText,
      VBtn,
      VSelect,
      VStepper,
      VStepperContent,
      VStepperStep,
      VRadio,
      VRadioGroup,
      JsonExcel,
      VIcon,
    },
    props: {
      dialogOpen: Boolean,
    },
    data: () => ({
      downloadFields: {
        agency_id: 'agency_id',
        vehicle: 'ref',
        route: 'route',
        gtfs_trip: 'gtfs_trip',
        lat: 'lat',
        lon: 'lon',
        'trip.trip_headsign': 'trip.headsign',
        'trip.trip_short_name': 'trip.trip_short_name',
        'trip.route_short_name': 'trip.route_short_name',
        'trip.route_long_name': 'trip.long_name',
        bearing: 'bearing',
        speed: 'speed',
        start: 'start',
        status: 'status',
        current_stop_sequence: 'stop_sequence',
        relationship: 'relationship',
        label: 'label',
        plate: 'plate',
        odometer: 'odometer',
        timestamp: 'timestamp',
        congestion: 'congestion',
        occupancy: 'occupancy',
      },
      downloadFormat: 'dump',
      downloadStepper: 1,
      downloadReady: false,
      downloadDumpData: null,
      downloadDumpName: 'tt-dump',
      downloadError: false,
      selectedAgency: null,
      mdiSvg: {
        download: mdiDownload,
      },
    }),
    computed: {
      agencies () {
        const agencies = this.$store.state.agencies.data
        const selectAgencies = []

        agencies.forEach(agency => {
          const agencyObject = {}

          agencyObject.value = {
            slug: agency.slug,
            license_title: agency.license.license_title,
            license_url: agency.license.license_url,
            is_downloadable: (agency.license.is_downloadable === '1'),
            region: agency.region,
          }
          agencyObject.text = agency.region.toUpperCase() + ' - ' + agency.name

          selectAgencies.push(agencyObject)
        })

        return selectAgencies
      },
      agencyIsNotLoaded () {
        return this.selectedAgency
          ? !(this.selectedAgency.slug in this.$store.state.vehicles.data)
          : true
      },
      darkMode () {
        return this.$vuetify.theme.dark
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
        return `tt-export-${dateTime}.csv`
      },
      stateActiveRegion () {
        return this.$store.state.regions.active.slug
      },
      stateVehicles () {
        return this.selectedAgency
          ? this.$store.state.vehicles.data[this.selectedAgency.slug]
          : []
      },
    },
    methods: {
      prepareDownload () {
        this.downloadReady = false
        this.downloadStepper = 3
        if (this.downloadFormat === 'dump') {
          axios.get(`/dump/${this.selectedAgency.slug}`)
            .then(response => {
              console.log(response)
              const blob = new Blob([response.data], { type: 'text/csv' })
              this.downloadDumpData = window.URL.createObjectURL(blob)
              this.downloadDumpName = /filename[^;=\n]*=(?:(\\?['"])(.*?)\1|(?:[^\s]+'.*?')?([^;\n]*))/i.exec(response.headers['content-disposition'])[2]
              this.downloadReady = true
            })
            .catch(response => {
              this.downloadError = response.status
            })
        } else if (this.downloadFormat === 'loaded') {
          this.downloadReady = true
        }
      },
    },
  }
</script>
