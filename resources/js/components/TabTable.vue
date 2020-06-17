<template>
    <div id="table">
        <vue-good-table :columns="tableColumns" :rows="groupedVehicles" :fixed-header="true"
                        :sort-options="{ enabled: true, initialSortBy: {field: 'data.ref', type: 'asc'} }"
                        :pagination-options="{ enabled: true, perPage: 100 }" :group-options="{ enabled: true }"
                        :theme="tableComponentTheme" @on-cell-click="viewOnMap" max-height="calc(100vh - 170px)">
            <div slot="emptystate">
                {{ $vuetify.lang.t('$vuetify.table.empty') }}
            </div>
        </vue-good-table>
    </div>
</template>

<script>
import 'vue-good-table/dist/vue-good-table.css'
import { VueGoodTable } from 'vue-good-table'
import collect from 'collect.js'
import { mdiMapMarker } from '@mdi/js'

export default {
  name: 'TabTable',
  components: {
    VueGoodTable
  },
  computed: {
    stateVehicles () {
      return this.$store.state.vehicles.data
    },
    stateAgencies () {
      return this.$store.state.agencies.data
    },
    stateActiveAgencies () {
      return this.$store.state.settings.activeAgencies
    },
    stateCounts () {
      return this.$store.state.agencies.counts
    },
    vehicles () {
      const stateVehicles = collect(this.stateVehicles)
      return stateVehicles.map(item => {
        const vehicle = {}
        vehicle.data = item
        vehicle.action = `<button type="button" class="v-btn v-btn--flat v-btn--icon v-btn--round v-btn--text theme--dark v-size--default ${this.buttonComponentColor}--text"><span class="v-btn__content"><span aria-hidden="true" class="v-icon notranslate v-icon--svg theme--dark"><svg xmlns="http://www.w3.org/2000/svg" viewBox="0 0 24 24" height="24" width="24" role="img" aria-hidden="true"><path d="${mdiMapMarker}"></path></svg></span></span></button>`
        return vehicle
      })
    },
    groupedVehicles () {
      const stateCounts = collect(this.stateCounts)
      const stateAgencies = collect(this.stateAgencies)
      return stateCounts.map(count => {
        const agency = stateAgencies.firstWhere('slug', count.agency)

        const group = {
          mode: 'span',
          label: agency.name,
          html: false,
          children: []
        }

        group.children = this.vehicles.where('data.agency_id', agency.id).items

        return group
      }).toArray()
    },
    selectedVehicle: {
      get () {
        return this.$store.state.vehicles.selection
      },
      set (vehicle) {
        this.$store.commit('vehicles/setSelection', vehicle)
      }
    },
    tableComponentTheme () {
      return this.$vuetify.theme.dark
        ? 'nocturnal'
        : ''
    },
    buttonComponentColor () {
      return this.$vuetify.theme.dark
        ? 'white'
        : 'primary'
    }
  },
  data: function () {
    return {
      tableColumns: [
        {
          label: this.$vuetify.lang.t('$vuetify.table.dataRef'),
          field: 'data.ref',
          type: 'text',
          filterOptions: {
            enabled: true
          }
        },
        {
          label: this.$vuetify.lang.t('$vuetify.table.dataRoute'),
          field: 'data.route',
          type: 'number',
          filterOptions: {
            enabled: true
          }
        },
        {
          label: this.$vuetify.lang.t('$vuetify.table.dataHeadsign'),
          field: 'data.trip.headsign',
          type: 'text'
        },
        {
          label: this.$vuetify.lang.t('$vuetify.table.dataTripId'),
          field: 'data.gtfs_trip',
          type: 'text',
          filterOptions: {
            enabled: true
          }
        },
        {
          label: this.$vuetify.lang.t('$vuetify.table.dataStartTime'),
          field: 'data.start',
          type: 'date',
          dateInputFormat: 'HH:mm:ss',
          dateOutputFormat: 'HH:mm'
        },
        {
          label: this.$vuetify.lang.t('$vuetify.table.action'),
          field: 'action',
          html: true
        }
      ]
    }
  },
  watch: {
    rawVehicles: {
      deep: true,
      handler () {
        this.$forceUpdate()
      }
    }
  },
  methods: {
    viewOnMap (params) {
      if (params.column.field === 'action') {
        const vehicle = {
          coordinates: [params.row.data.lon, params.row.data.lat],
          id: params.row.data.id,
          agency: collect(this.stateAgencies).firstWhere('id', params.row.data.agency_id)
        }
        this.selectedVehicle = vehicle
        this.$router.push('/map')
      }
    }
  }
}
</script>

<style scoped>
    .v-btn {
        width: 100%;
        height: 100%;
    }
</style>

<style>
    .vgt-table.nocturnal th.vgt-row-header {
        background-color: #435169 !important;
    }
</style>
