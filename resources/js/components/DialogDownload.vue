<template>
    <v-dialog v-model="dialog">
        <v-card>
            <v-card-title primary-title>{{ $vuetify.lang.t('$vuetify.download.cardTitle') }}</v-card-title>

            <v-card-text>
                <v-row>
                    <v-col
                        cols="12"
                        md="6">
                        <b>Download active vehicles from selected agencies</b>

                        <v-radio-group v-model="downloadType" label="File format">
                            <v-radio label="CSV" value="csv"></v-radio>
                            <v-radio label="Excel" value="xls"></v-radio>
                        </v-radio-group>

                        <json-excel :data="stateVehicles" :fields="downloadFields" :type="downloadType" :name="downloadName">
                            <v-btn color="primary">
                                <v-icon left>mdi-download</v-icon>
                                Download
                            </v-btn>
                        </json-excel>
                    </v-col>
                    <v-col cols="12" md="6">
                        <b>Download all vehicles in the database from selected agency</b>
                        <p>This file is generated each hour and is available only in CSV format.</p>

                        <v-select :items="agencies" label="Agency" v-model="selectedAgency"></v-select>

                        <v-btn color="primary" class="mt-4" @click="downloadDump">
                            <v-icon left>mdi-download</v-icon>
                            Download
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
import { VDialog, VCard, VCardTitle, VCardText, VRow, VCol, VRadioGroup, VRadio, VBtn, VIcon, VSelect } from 'vuetify/lib'

export default {
  components: { VDialog, VCard, VCardTitle, VCardText, VRow, VCol, VRadioGroup, VRadio, VBtn, VIcon, VSelect, JsonExcel },
  computed: {
    agencies () {
      const agencies = collect(this.$store.state.agencies.data)
      const selectAgencies = []

      agencies.each((agency) => {
        const agencyObject = {}

        agencyObject.value = agency.slug
        agencyObject.text = agency.name

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
      }
    },
    downloadName () {
      function pad (s) { return (s < 10) ? '0' + s : s }
      const date = new Date()
      const dateTime = date.getFullYear() + pad(date.getMonth() + 1) + pad(date.getDate()) + '_' + pad(date.getHours()) + pad(date.getMinutes())
      // Todo : add region name
      return 'mtltt-export-' + dateTime + '.' + this.downloadType
    },
    stateVehicles () {
      return this.$store.state.vehicles.data
    }
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
      Bearing: 'bearing'
    },
    downloadType: 'xls',
    selectedAgency: ''
  }),
  methods: {
    downloadDump () {
      window.location.href = process.env.MIX_APIENDPOINT + '/dump/' + this.selectedAgency
    }
  },
  props: {
    dialogOpen: Boolean
  }
}
</script>
