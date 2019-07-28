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
        @on-row-click="onRowClick"
        max-height="calc(100vh - 166.31px)">
      <div slot="emptystate">
        Please select agencies!
      </div>
      <template slot="table-row" slot-scope="props">
        <span v-if="props.column.field == 'after'">
          <a href="#">
            <md-icon>pin_drop</md-icon>
          </a>
        </span>
      </template>
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
      selectedAgencies() {
        return this.$store.state.settings.activeAgencies
      },
      rawAgencies() {
        return this.$store.state.agencies.data
      },
      rawVehicles() {
        return this.$store.state.vehicles.data
      },
      groupedVehicles() {
        return collect(this.selectedAgencies).map(agencyId => {
          // Find agency
          const agency = collect(this.rawAgencies).firstWhere('slug', agencyId)

          // Create the group
          let group = {
            mode: 'span',
            label: agency.name,
            html: false,
            children: []
          }

          // Find vehicles from this agency
          group.children = collect(this.rawVehicles).where('agency_id', agency.id).items

          return group
        }).toArray()
      },
      selectedVehicle: {
        get() {
          return this.$store.state.vehicles.selection
        },
        set(vehicle) {
          this.$store.commit('vehicles/setSelection', vehicle)
        }
      },
      dropdownAgencies() {
        let collection = collect([]);
        collect(this.rawAgencies).map(agency => {
          collection.push({
            value: agency.id,
            text: agency.name
          })
        })
        return collection.items
      },
    },
    data() {
      return {
        tableColumns: [
          {
            label: 'Vehicle number',
            field: 'ref',
            filterOptions: {
              enabled: true
            }
          },
          {
            label: 'Route',
            field: 'route',
            filterOptions: {
              enabled: true
            }
          },
          {
            label: 'Headsign',
            field: 'trip.headsign'
          },
          {
            label: 'Trip ID',
            field: 'gtfs_trip',
            filterOptions: {
              enabled: true
            }
          },
          {
            label: 'Start time',
            field: 'start'
          }
        ]
      }
    },
    methods: {
      onRowClick(params) {
        this.selectedVehicle = params.row
      }
    },
    watch: {
      rawVehicles: {
        deep: true,
        handler: function(val, oldVal) {
          this.$forceUpdate()
        }
      },
    },
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
