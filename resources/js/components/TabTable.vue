<template>
  <div class="tab-table">
    <vue-good-table
        :columns="tableColumns"
        :rows="groupedVehicles"
        :fixed-header="true"
        :sort-options="{
          enabled: true,
          initialSortBy: {field: 'ref', type: 'asc'}
        }"
        :pagination-options="{
          enabled: true,
          perPage: 100
        }"
        :group-options="{
          enabled: true
        }"
        @on-row-click="selectVehicle"
        max-height="calc(100vh - 166.31px)">
      <div slot="emptystate">
        Please select agencies!
      </div>
    </vue-good-table>
  </div>
</template>

<script>
import 'vue-good-table/dist/vue-good-table.css'
import { VueGoodTable } from 'vue-good-table'
const collect = require('collect.js')

export default {
  name: 'TabTable',
  components: {
    VueGoodTable
  },
  computed: {
    stateVehicles () {
      return collect(this.$store.state.vehicles.data)
    },
    stateAgencies () {
      return collect(this.$store.state.agencies.data)
    },
    stateActiveAgencies () {
      return collect(this.$store.state.settings.activeAgencies)
    },
    groupedVehicles () {
      const agencies = this.stateAgencies

      const vehicles = this.stateVehicles.map(item => {
        const vehicle = {}
        vehicle.data = item
        vehicle.action = `<button @click="viewOnMap" type="button" class="v-btn v-btn--flat v-btn--icon v-btn--round v-btn--text theme--light v-size--default accent--text"><span class="v-btn__content"><i aria-hidden="true" class="v-icon notranslate mdi mdi-map-marker theme--light"></i></span></button>`
        return vehicle
      })

      return this.stateActiveAgencies.map(function (agencyId) {
        // Find agency
        const agency = agencies.firstWhere('slug', agencyId)

        // Create the group
        const group = {
          mode: 'span',
          label: agency.name,
          html: false,
          children: []
        }

        // Find vehicles from this agency
        group.children = collect(vehicles.all()).where('data.agency_id', agency.id).items

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
    }
  },
  data () {
    return {
      tableColumns: [
        {
          label: 'Vehicle number',
          field: 'data.ref',
          type: 'text',
          filterOptions: {
            enabled: true
          }
        },
        {
          label: 'Route',
          field: 'data.route',
          type: 'text',
          filterOptions: {
            enabled: true
          }
        },
        {
          label: 'Headsign',
          field: 'data.trip.headsign',
          type: 'text'
        },
        {
          label: 'Trip ID',
          field: 'data.gtfs_trip',
          type: 'text',
          filterOptions: {
            enabled: true
          }
        },
        {
          label: 'Start time',
          field: 'data.start',
          type: 'date',
          dateInputFormat: 'HH:mm:ss',
          dateOutputFormat: 'HH:mm'
        },
        {
          label: 'View on map',
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
    viewOnMap () {
      // Todo: change view
      this.selectVehicle()
    },
    selectVehicle (params) {
      this.selectedVehicle = params.row.data
    }
  }
}
</script>

<style lang="scss">
    .vt-table {
        width: 100%;
        border-collapse: collapse;
    }
    .vt-table th {
        text-align: left;
        padding: 12px 0;
    }
    .vt-table th:first-child {
        padding-left: 16px;
    }
    .vt-table th:last-child {
        padding-right: 16px;
    }
    .vt-table thead {
        border-bottom: 2px solid darkgrey;
        height: 48px;
        font-size: 12px;
        color: #00000099;
    }
    .vt-table tbody {
        font-size: 14px;
        color: #000000de;
    }
    .vt-table tr {
        height: 48px;
        border-bottom: 1px solid gray;
    }
    .vt-table tr td:first-child {
        padding-left: 16px;
    }
    .vt-table tr td:last-child {
        padding-right: 16px;
    }
</style>
