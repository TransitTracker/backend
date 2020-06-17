<template>
  <v-container>
    <v-row>
      <v-col cols="12" md="6">
        <v-card>
          <v-card-title>{{ $vuetify.lang.t('$vuetify.settings.agenciesTitle') }}</v-card-title>
          <v-card-text>
            <span v-html="$vuetify.lang.t('$vuetify.settings.agenciesBody')"></span>
            <v-expansion-panels accordion hover v-model="expansionPanelIndex" class="my-4">
              <v-expansion-panel v-for="region in stateRegions" :key="region.slug">
                <v-expansion-panel-header>
                  <div class="d-flex align-center mr-2">
                    <span class="flex-grow-1">{{ region.name }}</span>
                    <v-btn v-if="region.slug !== stateActiveRegion.slug" color="secondary" small
                           @click="$emit('change-region', region)">
                      {{ $vuetify.lang.t('$vuetify.settings.changeRegion') }}
                    </v-btn>
                    <v-btn v-else text disabled small>
                      {{ $vuetify.lang.t('$vuetify.settings.activeRegion') }}
                    </v-btn>
                  </div>
                </v-expansion-panel-header>
                <v-expansion-panel-content>
                  <v-list-item v-for="agency in region.agencies" :key="agency.id" class="px-0">
                    <v-list-item-action>
                      <v-checkbox v-model="settingsActiveAgencies" :value="agency.slug" color="secondary"></v-checkbox>
                    </v-list-item-action>
                    <v-list-item-content>
                      <v-list-item-title>
                        {{ agency.name }}
                      </v-list-item-title>
                    </v-list-item-content>
                    <v-list-item-avatar v-bind:style="{ backgroundColor: agency.color, borderColor: agency.text_color }">
                      <v-icon v-bind:style="{ color: agency.text_color }" size="25px">{{ mdiSvg[agency.vehicles_type] }}</v-icon>
                    </v-list-item-avatar>
                  </v-list-item>
                </v-expansion-panel-content>
              </v-expansion-panel>
            </v-expansion-panels>
            <v-btn color="primary" @click="applySettings" :loading="applyButtonLoading">
              <v-icon left>{{ mdiSvg.check }}</v-icon> {{ $vuetify.lang.t('$vuetify.settings.agenciesApply') }}
            </v-btn>
          </v-card-text>
        </v-card>
      </v-col>
      <v-col cols="12" md="6" lg="3">
        <v-card>
          <v-card-title>{{ $vuetify.lang.t('$vuetify.settings.otherTitle') }}</v-card-title>
          <v-card-text>
            <p class="mb-2">{{ $vuetify.lang.t('$vuetify.settings.otherChanges') }}</p>
            <div class="settings-row d-flex">
              <div class="settings-label flex-grow-1">
                <span class="text-body-1">{{ $vuetify.lang.t('$vuetify.onboarding.setRefreshLabel') }}</span><br>
                <span class="text-caption">{{ $vuetify.lang.t('$vuetify.onboarding.setRefreshCaption') }}</span>
              </div>
              <v-switch v-model="settingsAutoRefresh" color="secondary"></v-switch>
            </div>
            <div class="settings-row d-flex">
              <div class="settings-label flex-grow-1">
                <span class="text-body-1">{{ $vuetify.lang.t('$vuetify.onboarding.setDarkLabel') }}</span><br>
                <span class="text-caption">{{ $vuetify.lang.t('$vuetify.onboarding.setDarkCaption') }}</span>
              </div>
              <v-switch v-model="settingsDarkMode" color="secondary"></v-switch>
            </div>
            <div class="settings-row d-flex">
              <div class="settings-label flex-grow-1">
                <span class="text-body-1">{{ $vuetify.lang.t('$vuetify.onboarding.setPathLabel') }}</span><br>
                <span class="text-caption">{{ $vuetify.lang.t('$vuetify.onboarding.setPathCaption') }}</span>
              </div>
              <v-select :items="defaultPath" v-model="settingsDefaultPath" class="settings-select" color="secondary"
                        item-color="secondary darken-3">
              </v-select>
            </div>
            <div class="settings-row d-flex">
              <div class="settings-label flex-grow-1">
                <span class="text-body-1">{{ $vuetify.lang.t('$vuetify.settings.otherLanguageLabel') }}</span><br>
                <span class="text-caption">{{ $vuetify.lang.t('$vuetify.settings.otherLanguageCaption') }}</span>
              </div>
              <v-select :items="language" v-model="settingsLanguage" class="settings-select" color="secondary"
                        item-color="secondary darken-3">
              </v-select>
            </div>
            <a :href="'/opt-out/' + settingsLanguage" class="text-subtitle-1 mt-4">
              {{ $vuetify.lang.t('$vuetify.settings.otherOptOut') }}
            </a>
          </v-card-text>
        </v-card>
      </v-col>
      <v-col cols="12" lg="3">
        <v-card dark class="about">
          <v-card-title class="wb-bw">{{ $vuetify.lang.t('$vuetify.settings.aboutTitle') }}</v-card-title>
          <v-card-text>
            <span v-html="$vuetify.lang.t('$vuetify.settings.aboutBody')"></span><br>
            <v-btn color="secondary" class="mt-3 mb-3" href="https://github.com/felixinx/transit-tracker">
              <v-icon left>{{ mdiSvg.github }}</v-icon> {{ $vuetify.lang.t('$vuetify.settings.aboutSource') }}
            </v-btn><br>
            <span v-html="$vuetify.lang.t('$vuetify.settings.aboutContributions')"></span>
          </v-card-text>
        </v-card>
      </v-col>
    </v-row>
  </v-container>
</template>

<script>
import {
  VContainer, VRow, VCol, VCard, VCardTitle, VCardText, VExpansionPanels, VExpansionPanel, VExpansionPanelHeader,
  VExpansionPanelContent, VListItem, VListItemContent, VListItemAction, VCheckbox, VListItemAvatar, VIcon,
  VListItemTitle, VSwitch, VBtn, VSelect
} from 'vuetify/lib'
import { mdiCheck, mdiBus, mdiTrain, mdiTram, mdiGithub } from '@mdi/js'

export default {
  name: 'TabSettings',
  components: {
    VContainer,
    VRow,
    VCol,
    VCard,
    VCardTitle,
    VCardText,
    VExpansionPanels,
    VExpansionPanel,
    VExpansionPanelHeader,
    VExpansionPanelContent,
    VListItem,
    VListItemContent,
    VListItemAction,
    VCheckbox,
    VListItemAvatar,
    VIcon,
    VListItemTitle,
    VSwitch,
    VBtn,
    VSelect
  },
  computed: {
    aboutComponentColor () {
      return this.$vuetify.theme.dark ? 'dark' : 'secondary'
    },
    defaultPath () {
      return [
        { text: this.$vuetify.lang.t('$vuetify.app.tabHome'), value: '/' },
        { text: this.$vuetify.lang.t('$vuetify.app.tabMap'), value: '/map' },
        { text: this.$vuetify.lang.t('$vuetify.app.tabTable'), value: '/table' },
        { text: this.$vuetify.lang.t('$vuetify.app.tabSettings'), value: '/settings' }
      ]
    },
    language () {
      return [
        { text: 'English', value: 'en' },
        { text: 'Français', value: 'fr' }
      ]
    },
    settingsActiveAgencies: {
      get () {
        return this.$store.state.settings.activeAgencies
      },
      set (value) {
        this.$store.commit('settings/setActiveAgencies', value)
      }
    },
    settingsAutoRefresh: {
      get () {
        return this.$store.state.settings.autoRefresh
      },
      set (value) {
        this.$store.commit('settings/setAutoRefresh', value)
      }
    },
    settingsDarkMode: {
      get () {
        return this.$store.state.settings.darkMode
      },
      set (value) {
        this.$vuetify.theme.dark = value
        this.$store.commit('settings/setDarkMode', value)
      }
    },
    settingsDefaultPath: {
      get () {
        return this.$store.state.settings.defaultPath
      },
      set (value) {
        this.$store.commit('settings/setDefaultPath', value)
      }
    },
    settingsLanguage: {
      get () {
        return this.$store.state.settings.language
      },
      set (value) {
        this.$store.commit('settings/setLanguage', value)
        this.$vuetify.lang.current = value
      }
    },
    stateActiveRegion () {
      return this.$store.state.regions.active
    },
    stateRegions () {
      return this.$store.state.regions.data
    },
    tipComponentColor () {
      return this.$vuetify.theme.dark ? 'primary' : 'secondary'
    }
  },
  data: () => ({
    applyButtonLoading: false,
    expansionPanelIndex: 0,
    mdiSvg: {
      check: mdiCheck,
      bus: mdiBus,
      train: mdiTrain,
      tram: mdiTram,
      github: mdiGithub
    }
  }),
  methods: {
    applySettings () {
      this.applyButtonLoading = true
      this.$emit('change-region', this.stateActiveRegion)
      setTimeout(() => { this.applyButtonLoading = false }, 1000)
    }
  },
  mounted () {
    this.expansionPanelIndex = this.stateRegions.findIndex(a => a.slug === this.stateActiveRegion.slug)
  }
}
</script>

<style>
  .fab-refresh {
    bottom: 16px;
  }
</style>

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
  .about a {
    color: #fafafa;
  }
  .wb-bw {
    word-break: break-word;
  }
  .reload svg {
    height: 32px;
    width: 32px;
  }
  .settings-row {
    align-items: center;
    margin-bottom: 4px;
  }
  .settings-select {
    max-width: 150px;
  }
</style>
