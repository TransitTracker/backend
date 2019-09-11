<template>
    <v-dialog
            v-model="dialog"
            persistent>
        <v-stepper v-model="stepper">
            <v-stepper-header>
                <v-stepper-step
                        :complete="stepper > 1"
                        step="1">{{ $vuetify.lang.t('$vuetify.configuration.languageStep') }}
                </v-stepper-step>
                <v-divider></v-divider>
                <v-stepper-step
                        :complete="stepper > 2"
                        step="2">{{ $vuetify.lang.t('$vuetify.configuration.conditionsStep') }}
                </v-stepper-step>
                <v-divider></v-divider>
                <v-stepper-step
                        :complete="stepper > 3"
                        step="3">{{ $vuetify.lang.t('$vuetify.configuration.agenciesStep') }}
                </v-stepper-step>
                <v-divider></v-divider>
                <v-stepper-step
                        :complete="stepper > 4"
                        step="4">{{ $vuetify.lang.t('$vuetify.configuration.settingsStep') }}
                </v-stepper-step>
            </v-stepper-header>

            <v-stepper-items>
                <v-stepper-content
                        step="1"
                        style="text-align: center">
                    <img src="/svg/undraw/map-dark.svg" alt="Map" width="250px">
                    <div class="display-1 mb-2">{{ $vuetify.lang.t('$vuetify.configuration.languageTitle') }}</div>
                    <div
                        class="title mb-4"
                        v-html="$vuetify.lang.t('$vuetify.configuration.languageBody')"></div>
                    <v-btn
                            x-large
                            color="primary"
                            @click="setLanguage('en')"
                            class="ma-4">
                        Continue in English
                        <v-icon>mdi-arrow-right</v-icon>
                    </v-btn>
                    <v-btn
                            x-large
                            color="secondary"
                            @click="setLanguage('fr')"
                            class="ma-4">
                        Continuer en français
                        <v-icon>mdi-arrow-right</v-icon>
                    </v-btn>
                </v-stepper-content>
                <v-stepper-content step="2">
                    <p class="title">{{ $vuetify.lang.t('$vuetify.configuration.conditionsTitle') }}</p>
                    <div v-html="$vuetify.lang.t('$vuetify.configuration.conditionsBody')"></div>

                    <v-btn
                        text
                        icon
                        color="secondary"
                        @click="stepper = 1">
                        <v-icon>mdi-arrow-left</v-icon>
                    </v-btn>
                    <v-btn
                        class="float-right"
                        color="accent"
                        @click="stepper = 3; loadAgencies()">
                        {{ $vuetify.lang.t('$vuetify.configuration.conditionsAgree') }}
                    </v-btn>
                </v-stepper-content>
                <v-stepper-content step="3">
                    <p class="title">{{ $vuetify.lang.t('$vuetify.configuration.agenciesTitle') }}</p>
                    <v-list>
                        <v-list-item
                                v-for="agency in loadedAgencies"
                                :key="agency.id">
                            <v-list-item-action>
                                <v-checkbox
                                        v-model="settingsActiveAgencies"
                                        :value="agency.slug"></v-checkbox>
                            </v-list-item-action>
                            <v-list-item-content>
                                <v-list-item-title>{{ agency.name }}</v-list-item-title>
                            </v-list-item-content>
                            <v-list-item-avatar v-bind:style="{ backgroundColor: agency.color, borderColor: agency.text_color }">
                                <v-icon v-bind:style="{ color: agency.text_color }">mdi-{{ agency.vehicles_type }}</v-icon>
                            </v-list-item-avatar>
                        </v-list-item>
                    </v-list>
                    <v-btn
                        text
                        icon
                        color="secondary"
                        @click="stepper = 2">
                        <v-icon>mdi-arrow-left</v-icon>
                    </v-btn>
                    <v-btn
                        class="float-right"
                        color="accent"
                        @click="stepper = 4">
                        {{ $vuetify.lang.t('$vuetify.configuration.agenciesContinue') }}
                    </v-btn>
                </v-stepper-content>
                <v-stepper-content
                    class="pa-3"
                    step="4">
                    <div class="pa-3">
                        <p class="title">{{ $vuetify.lang.t('$vuetify.configuration.settingsTitle') }}</p>
                        <v-switch v-model="settingsAutoRefresh" :label="$vuetify.lang.t('$vuetify.settings.otherAutoRefresh')"></v-switch>
                        <v-divider></v-divider>
                        <p class="subtitle-1">{{ $vuetify.lang.t('$vuetify.settings.otherDefaultTab') }}</p>
                        <v-radio-group v-model="settingsDefaultPath">
                            <v-radio
                                    v-for="route in routes"
                                    :key="route.path"
                                    :value="route.path"
                                    :label="route.name">
                            </v-radio>
                        </v-radio-group>
                        <v-btn
                            icon
                            text
                            color="secondary"
                            @click="stepper = 3">
                            <v-icon>mdi-arrow-left</v-icon>
                        </v-btn>
                        <v-btn
                            class="float-right"
                            color="accent"
                            @click="setConfigurationAsDone">
                            {{ $vuetify.lang.t('$vuetify.configuration.settingsDone') }}
                        </v-btn>
                    </div>
                </v-stepper-content>
            </v-stepper-items>
        </v-stepper>
    </v-dialog>
</template>

<script>
import axios from 'axios/index'
import {
  VDialog,
  VStepper,
  VStepperHeader,
  VStepperStep,
  VDivider,
  VStepperItems,
  VStepperContent,
  VBtn,
  VList,
  VListItem,
  VListItemAction,
  VCheckbox,
  VListItemContent,
  VListItemTitle,
  VListItemAvatar,
  VIcon,
  VSwitch,
  VRadioGroup,
  VRadio
} from 'vuetify/lib'

export default {
  components: {
    VDialog,
    VStepper,
    VStepperHeader,
    VStepperStep,
    VDivider,
    VStepperItems,
    VStepperContent,
    VBtn,
    VList,
    VListItem,
    VListItemAction,
    VCheckbox,
    VListItemContent,
    VListItemTitle,
    VListItemAvatar,
    VIcon,
    VSwitch,
    VRadioGroup,
    VRadio
  },
  data () {
    return {
      stepper: 0,
      dialog: true,
      settingsLang: 'en'
    }
  },
  methods: {
    loadAgencies () {
      axios
        .get('/agencies')
        .then(response => (this.loadedAgencies = response.data.data))
    },
    setConfigurationAsDone () {
      this.$emit('configurationDone')
    },
    setLanguage (newLang) {
      this.$store.commit('settings/setLanguage', newLang)
      this.$vuetify.lang.current = newLang
      this.stepper = 2
    }
  },
  computed: {
    routes () {
      return this.$router.options.routes
    },
    loadedAgencies: {
      get () {
        return this.$store.state.agencies.data
      },
      set (value) {
        this.$store.commit('agencies/setData', value)
      }
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
    settingsDefaultPath: {
      get () {
        return this.$store.state.settings.defaultPath
      },
      set (value) {
        this.$store.commit('settings/setDefaultPath', value)
      }
    }
  },
  watch: {
    settingsLang (val) {
      this.$i18n.locale = val
    }
  }
}
</script>

<style scoped>

</style>
