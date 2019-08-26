<template>
  <v-container>
    <v-row>
      <v-col cols="12">
        <v-alert
          type="info"
          outlined>The change you made will be in effect the next time you open this app.</v-alert>
      </v-col>
      <v-col cols="12" md="6">
        <v-card>
          <v-card-title>Agencies</v-card-title>
          <v-card-text>
            You can select as many agencies as you want.
            <b>Please remember that the number of agencies you choose will impact the download size and the performance
            of this application, especially on mobile devices.</b>
            <br>
            <v-list-item
              v-for="agency in agencies"
              :key="agency.id">
              <v-list-item-action>
                <v-checkbox
                        v-model="activeAgencies"
                        :value="agency.slug"></v-checkbox>
              </v-list-item-action>
              <v-list-item-content>
                <v-list-item-title>{{ agency.name }}</v-list-item-title>
              </v-list-item-content>
              <v-list-item-avatar v-bind:style="{ backgroundColor: agency.color, borderColor: agency.text_color }">
                <v-icon v-bind:style="{ color: agency.text_color }">mdi-{{ agency.vehicles_type }}</v-icon>
              </v-list-item-avatar>
            </v-list-item>
          </v-card-text>
        </v-card>
      </v-col>
      <v-col cols="12" md="6" lg="3">
        <v-card>
          <v-card-title>Other settings</v-card-title>
          <v-card-text>
            <v-switch v-model="autoRefresh" label="Auto refresh every minute"></v-switch>
            <v-divider></v-divider>
            <p class="subtitle-1">Default tab on opening</p>
            <v-radio-group v-model="defaultPath">
              <v-radio
                v-for="route in routes"
                :key="route.path"
                :value="route.path"
                :label="route.name">
              </v-radio>
            </v-radio-group>
          </v-card-text>
        </v-card>
      </v-col>
      <v-col cols="12" md="6" lg="3">
        <v-card
          color="secondary"
          dark>
          <v-card-title>About this application</v-card-title>
          <v-card-text>
            This application is made by FelixINX. Data is from the <a href="https://stm.info">Société de transport de Montréal</a>,
            the <a href="https://stl.laval.qc.ca">Société de transport de Laval</a> trough <a href="https://nextbus.com">Nextbus</a> and
            <a href="https://exo.quebec">exo</a>.
            <br>
            <v-btn
                color="accent"
                class="mt-2"
                href="https://github.com/felixinx/montreal-transit-tracker">
              <v-icon left>mdi-github-circle</v-icon> Source code
            </v-btn>
          </v-card-text>
        </v-card>
      </v-col>
    </v-row>
  </v-container>
</template>

<script>
import { VContainer, VRow, VCol, VCard, VCardTitle, VCardText, VListItem, VListItemContent, VListItemAction, VCheckbox, VListItemAvatar, VIcon, VListItemTitle, VAlert, VSwitch, VDivider, VRadioGroup, VRadio, VBtn } from 'vuetify/lib'

export default {
  name: 'TabSettings',
  components: {
    VContainer,
    VRow,
    VCol,
    VCard,
    VCardTitle,
    VCardText,
    VListItem,
    VListItemContent,
    VListItemAction,
    VCheckbox,
    VListItemAvatar,
    VIcon,
    VListItemTitle,
    VAlert,
    VSwitch,
    VDivider,
    VRadioGroup,
    VRadio,
    VBtn
  },
  data: () => {
    return {
      agenciesAreUpdated: false
    }
  },
  mounted () {
  },
  computed: {
    routes () {
      return this.$router.options.routes
    },
    agencies: {
      get () {
        return this.$store.state.agencies.data
      },
      set (newAgencies) {
        this.$store.commit('agencies/setData', newAgencies)
      }
    },
    activeAgencies: {
      get () {
        this.agenciesAreUpdated = true
        return this.$store.state.settings.activeAgencies
      },
      set (value) {
        this.$store.commit('settings/setActiveAgencies', value)
      }
    },
    autoRefresh: {
      get () {
        return this.$store.state.settings.autoRefresh
      },
      set (value) {
        this.$store.commit('settings/setAutoRefresh', value)
      }
    },
    defaultPath: {
      get () {
        return this.$store.state.settings.defaultPath
      },
      set (value) {
        this.$store.commit('settings/setDefaultPath', value)
      }
    }
  }
}
</script>

<style lang="scss" scoped>
  .v-input--checkbox {
    margin-right: 15px;
  }
  .v-list-item__avatar {
    margin-right: 15px !important;
    border-width: 1px;
    border-style: solid;
    max-width: 40px;
  }
  .v-list-item__title {
    white-space: normal;
  }
  .subtitle-1 {
    margin-top: 16px;
  }
  .v-card a {
    color: #fafafa;
  }
</style>
