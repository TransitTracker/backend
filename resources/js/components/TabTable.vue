<template>
    <vue-good-table
        :columns="tableColumns"
        :rows="groupedVehicles"
        :fixed-header="true"
        :sort-options="{
          enabled: true,
          initialSortBy: {field: 'data.ref', type: 'asc'}
        }"
        :pagination-options="{
          enabled: true,
          perPage: 100
        }"
        :group-options="{
          enabled: true
        }"
        @on-cell-click="viewOnMap"
        max-height="calc(100vh - 170px)">
        <div slot="emptystate">
            No vehicles!
        </div>
    </vue-good-table>

</template>

<script>
import 'vue-good-table/dist/vue-good-table.css'
import { VueGoodTable } from 'vue-good-table'
import collect from 'collect.js'

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
    vehicles () {
      const stateVehicles = collect(this.stateVehicles)
      return stateVehicles.map(item => {
        const vehicle = {}
        vehicle.data = item
        vehicle.action = '<button @click="viewOnMap" type="button" class="v-btn v-btn--flat v-btn--icon v-btn--round v-btn--text theme--light v-size--default accent--text"><span class="v-btn__content"><i aria-hidden="true" class="v-icon notranslate mdi mdi-map-marker theme--light"></i></span></button>'
        return vehicle
      })
    },
    groupedVehicles () {
      const stateActiveAgencies = collect(this.stateActiveAgencies)
      return stateActiveAgencies.map(agencySlug => {
        const stateAgencies = collect(this.stateAgencies)
        const agency = stateAgencies.firstWhere('slug', agencySlug)

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
    viewOnMap (params) {
      if (params.column.field === 'action') {
        this.selectedVehicle = params.row.data
        this.$router.push('/map')
      }
    }
  }
}
</script>
