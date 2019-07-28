<template>
  <div class="container md-layout">
    <div class="md-layout-item">
      <md-card>
        <md-card-header>
          <div class="md-title">Agencies</div>
          <div class="mb-subhead">You can select as many agencies as you want. <b>Please remember that if you choose multiples agencies, the download size will increase. On some devices, especially phones and tablets, more agencies can cause performance issue.</b></div>
        </md-card-header>
        <md-card-content>
          <md-list>
            <md-list-item v-for="agency in agencies" :key="agency.id">
              <md-checkbox v-model="activeAgencies" :value="agency.slug"></md-checkbox>
              <md-avatar v-bind:style="{'background-color': agency.color, 'border-color': agency.text_color}">
                <md-icon v-bind:style="{'color': agency.text_color}">{{ agency.vehicles_type === 'bus' ? 'directions_bus' : 'train' }}</md-icon>
              </md-avatar>
              <span class="md-list-item-text">{{ agency.name }}</span>
            </md-list-item>
          </md-list>
        </md-card-content>
      </md-card>
    </div>
    <div class="md-layout-item">
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
    <div class="md-layout-item">
      <md-card class="md-dark">
        <md-card-header>
          <div class="md-title">About this application</div>
        </md-card-header>
        <md-card-content>
          This application is made by FelixINX. Data is from the <a href="https://stm.info">Société de transport de Montréal</a>,
          the <a href="https://stl.laval.qc.ca">Société de transport de Laval</a> trough <a href="https://nextbus.com">Nextbus</a> and
          <a href="https://exo.quebec">exo</a>.
        </md-card-content>
      </md-card>
    </div>
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
      agencies: {
        get() {
          return this.$store.state.agencies.data
        },
        set(newAgencies) {
          this.$store.commit('agencies/setData', newAgencies)
        }
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
    }
  }
</script>

<style lang="scss" scoped>
  .md-checkbox {
    margin-right: 15px;
  }
  .md-avatar {
    margin-right: 15px !important;
    border-width: 1px;
    border-style: solid;
  }
  .container {
    margin-top: 12px;
  }
  .md-list-item-text {
    white-space: normal;
  }
</style>
