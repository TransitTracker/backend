<template>
  <div class="tab-table">
    <md-table v-model="vehicles" md-sort="number" md-sort-order="asc" md-fixed-header>
      <md-table-row slot="md-table-row" slot-scope="{ item }">
        <md-table-cell md-label="Agency" md-sort-by="agency">{{ item.agency_id }}</md-table-cell>
        <md-table-cell md-label="Number" md-sort-by="number">{{ item.ref }}</md-table-cell>
        <md-table-cell md-label="Route" md-sort-by="route">{{ item.route }}</md-table-cell>
        <md-table-cell md-label="Headsign" md-sort-by="headsign">{{ item.trip.headsign }}</md-table-cell>
        <md-table-cell md-label="Trip ID" md-sort-by="trip">{{ item.trip.id }}</md-table-cell>
        <md-table-cell md-label="Start time" md-sort-by="start">{{ item.start }}</md-table-cell>
      </md-table-row>
    </md-table>
  </div>
</template>

<script>
  export default {
    name: 'TabTable',
    computed: {
      vehicles() {
        return this.$store.state.vehicles.data
      }
    }
  }
</script>

<style lang="scss" scoped>

</style>
