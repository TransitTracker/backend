<template>
  <div class="card-columns">
    <md-card>
      <md-card-header>
        <div class="md-title">Agencies</div>
        <div class="mb-subhead">You can select as many agencies as you want. <b>Please remember that if you choose multiples agencies, the download size will be bigger. On some devices, especially phones and tablets, more agencies can cause performance issue.</b></div>
      </md-card-header>
      <md-card-content>
        <md-list>
          <md-list-item v-for="agency in agencies" :key="agency.id">
            <md-checkbox v-model="activeAgencies" :value="agency.slug"></md-checkbox>
            <md-avatar v-bind:style="{'background-color': agency.color}">
              <md-icon style="color: white;">{{ agency.vehicles_type === 'bus' ? 'directions_bus' : 'train' }}</md-icon>
            </md-avatar>
            <span class="md-list-item-text">{{ agency.name }}</span>
          </md-list-item>
        </md-list>
      </md-card-content>
    </md-card>
    <md-card>
      <md-card-header>
        <div class="md-title">Other settings</div>
      </md-card-header>
      <md-card-content>
        <md-switch v-model="autoRefresh">Auto refresh every minute?</md-switch>
        <hr>
        <div class="md-subhead">Default tab on opening</div>
        <md-radio v-model="defaultPath" v-for="route in routes" :key="route.path" :value="route.path">{{ route.name }}</md-radio>
      </md-card-content>
    </md-card>
  </div>
</template>

<script>
  export default {
    name: 'TabSettings',
    data: function () {
      return {
        activeAgenciesChanges: []
      }
    },
    mounted() {
    },
    computed: {
      routes() {
        return this.$router.options.routes
      },
      agencies() {
        return this.$store.state.agencies.data
      },
      activeAgencies: {
        get() {
          return this.$store.state.settings.activeAgencies
        },
        set(value) {
          this.$store.commit('settings/setActiveAgencies', value)
        }
      },
      autoRefresh: {
        get() {
          return this.$store.state.settings.autoRefresh
        },
        set(value) {
          this.$store.commit('settings/setAutoRefresh', value)
        }
      },
      defaultPath: {
        get() {
          return this.$store.state.settings.defaultPath
        },
        set(value) {
          this.$store.commit('settings/setDefaultPath', value)
        }
      }
    },
    watch: {
      // activeAgenciesChanges: function (value) {
      //   this.$store.commit('changeActiveAgencies', value)
      // }
    }
  }
</script>

<style lang="scss" scoped>
  .md-checkbox {
    margin-right: 15px;
  }
  .md-avatar {
    margin-right: 15px !important;
  }
  .card-columns {
    -webkit-column-count: 3;
    -moz-column-count: 3;
    column-count: 3;
    -webkit-column-gap: 1.25rem;
    -moz-column-gap: 1.25rem;
    column-gap: 1.25rem;
    orphans: 1;
    widows: 1;
    padding-top: 1rem;
  }
  .md-card {
    display: inline-block;
    width: 100%;
  }
</style>
