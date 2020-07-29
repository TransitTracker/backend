<template>
  <div id="table">
    <vue-good-table
      :columns="tableColumns"
      :rows="tableVehicles"
      :fixed-header="true"
      :sort-options="{ enabled: true, initialSortBy: {field: 'ref', type: 'asc'} }"
      :pagination-options="{ enabled: true, perPage: 100 }"
      :group-options="{ enabled: true }"
      :theme="tableComponentTheme"
      @on-cell-click="viewOnMap"
    >
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
      VueGoodTable,
    },
    data: function () {
      return {

      }
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
      selectedVehicle: {
        get () {
          return this.$store.state.vehicles.selection
        },
        set (vehicle) {
          this.$store.commit('vehicles/setSelection', vehicle)
        },
      },
      tableComponentTheme () {
        return this.$vuetify.theme.dark
          ? 'nocturnal'
          : ''
      },
      tableColumns () {
        return [
          {
            label: this.$vuetify.lang.t('$vuetify.table.dataRef'),
            field: 'ref',
            type: 'text',
            filterOptions: {
              enabled: true,
            },
          },
          {
            label: this.$vuetify.lang.t('$vuetify.table.dataRoute'),
            field: 'route',
            type: 'number',
            filterOptions: {
              enabled: true,
              filterFn: this.filterRouteField,
            },
          },
          {
            label: this.$vuetify.lang.t('$vuetify.table.dataHeadsign'),
            field: 'headsign',
            type: 'text',
            filterOptions: {
              enabled: true,
            },
          },
          {
            label: this.$vuetify.lang.t('$vuetify.table.dataTripId'),
            field: 'tripId',
            type: 'text',
            filterOptions: {
              enabled: true,
            },
          },
          {
            label: this.$vuetify.lang.t('$vuetify.table.dataStartTime'),
            field: 'start',
            type: 'date',
            dateInputFormat: 'HH:mm:ss',
            dateOutputFormat: 'HH:mm',
          },
          {
            label: this.$vuetify.lang.t('$vuetify.table.action'),
            field: 'action',
            html: true,
          },
        ]
      },
      tableVehicles () {
        const stateCounts = collect(this.stateCounts)
        const stateAgencies = collect(this.stateAgencies)
        return stateCounts.map(count => {
          const agency = stateAgencies.firstWhere('slug', count.agency)

          const group = {
            mode: 'span',
            label: agency.name,
            html: false,
            children: [],
          }

          group.children = this.stateVehicles[agency.slug].map(item => {
            return {
              agencyId: item.agency_id,
              ref: item.label ? item.label : item.ref,
              route: item.trip.route_short_name ? item.trip.route_short_name : item.route,
              headsign: item.trip.headsign,
              tripId: item.gtfs_trip,
              start: item.start_time,
              id: item.id,
              lat: item.lat,
              lon: item.lon,
              action: `<button type="button" class="v-btn v-btn--flat v-btn--icon v-btn--round v-btn--text theme--dark v-size--default ${this.buttonComponentColor}--text"><span class="v-btn__content"><span aria-hidden="true" class="v-icon notranslate v-icon--svg theme--dark"><svg xmlns="http://www.w3.org/2000/svg" viewBox="0 0 24 24" height="24" width="24" role="img" aria-hidden="true"><path d="${mdiMapMarker}"></path></svg></span></span></button>`,
            }
          })

          return group
        }).toArray()
      },
      buttonComponentColor () {
        return this.$vuetify.theme.dark
          ? 'white'
          : 'primary'
      },
    },
    watch: {
      stateVehicles: {
        deep: true,
        handler () {
          this.$forceUpdate()
        },
      },
    },
    methods: {
      filterRouteField (itemRoute, filter) {
        return itemRoute.includes(filter)
      },
      viewOnMap (params) {
        if (params.column.field === 'action') {
          this.selectedVehicle = {
            coordinates: [params.row.lon, params.row.lat],
            id: params.row.id,
            agency: collect(this.stateAgencies).firstWhere('id', params.row.agencyId),
          }
          this.$router.push('/map')
        }
      },
    },
  }
</script>

<style>
    .vgt-wrap {
      height: calc(100vh - 112px);
    }
    @media only screen and (max-width: 960px) {
      .vgt-wrap {
        height: calc(100vh - 104px);
      }
    }
    .vgt-fixed-header {
      z-index: 1 !important;
    }
    .vgt-table td, .vgt-table th {
      vertical-align: middle !important;
    }
    .vgt-table thead th.sorting-asc:after {
      border-bottom: 5px solid var(--v-secondary-base);
    }
    .vgt-table thead th.sorting-desc:before {
      border-top: 5px solid var(--v-secondary-base);
    }
    .vgt-wrap__footer .footer__navigation__page-btn .chevron.left::after {
      border-right: 6px solid var(--v-primary-base);
    }
    .vgt-wrap__footer .footer__navigation__page-btn .chevron.right::after {
      border-left: 6px solid var(--v-primary-base);
    }
    .vgt-table.nocturnal th.vgt-row-header {
        background-color: #435169 !important;
    }
</style>
