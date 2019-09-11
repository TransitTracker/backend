<template>
  <v-container>
    <v-row>
      <v-col cols="12">
        <v-alert
          type="info"
          outlined>{{ $vuetify.lang.t('$vuetify.settings.changeEffect') }}</v-alert>
      </v-col>
      <v-col cols="12" md="6">
        <v-card>
          <v-card-title>{{ $vuetify.lang.t('$vuetify.settings.agenciesTitle') }}</v-card-title>
          <v-card-text>
            <span v-html="$vuetify.lang.t('$vuetify.settings.agenciesBody')"></span>
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
          <v-card-title>{{ $vuetify.lang.t('$vuetify.settings.otherTitle') }}</v-card-title>
          <v-card-text>
            <v-switch v-model="autoRefresh" :label="$vuetify.lang.t('$vuetify.settings.otherAutoRefresh')"></v-switch>
            <v-divider></v-divider>
            <p class="subtitle-1">{{ $vuetify.lang.t('$vuetify.settings.otherDefaultTab') }}</p>
            <v-radio-group v-model="defaultPath">
              <v-radio
                v-for="route in routes"
                :key="route.path"
                :value="route.path"
                :label="route.name">
              </v-radio>
            </v-radio-group>
            <v-divider></v-divider>
            <p class="subtitle-1">{{ $vuetify.lang.t('$vuetify.settings.otherLanguage') }}</p>
            <v-radio-group v-model="language">
              <v-radio
                key="en"
                value="en"
                label="English"></v-radio>
              <v-radio
                key="fr"
                value="fr"
                label="Français"></v-radio>
            </v-radio-group>
          </v-card-text>
        </v-card>
      </v-col>
      <v-col cols="12" md="6" lg="3">
        <v-card
          color="secondary"
          dark>
          <v-card-title>{{ $vuetify.lang.t('$vuetify.settings.aboutTitle') }}</v-card-title>
          <v-card-text>
            <span v-html="$vuetify.lang.t('$vuetify.settings.aboutBody')"></span>
            <br>
            <v-btn
                color="accent"
                class="mt-2"
                href="https://github.com/felixinx/montreal-transit-tracker">
              <v-icon left>mdi-github-circle</v-icon> {{ $vuetify.lang.t('$vuetify.settings.aboutSource') }}
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
    },
    language: {
      get () {
        return this.$store.state.settings.language
      },
      set (value) {
        this.$store.commit('settings/setLanguage', value)
        this.$vuetify.lang.current = value
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
