<template>
    <v-dialog
            v-model="dialog"
            persistent>
        <v-stepper v-model="stepper">
            <v-stepper-header>
                <v-stepper-step
                        :complete="stepper > 1"
                        step="1">Language
                </v-stepper-step>
                <v-divider></v-divider>
                <v-stepper-step
                        :complete="stepper > 2"
                        step="2">Conditions
                </v-stepper-step>
                <v-divider></v-divider>
                <v-stepper-step
                        :complete="stepper > 3"
                        step="3">Agencies
                </v-stepper-step>
                <v-divider></v-divider>
                <v-stepper-step
                        :complete="stepper > 4"
                        step="4">Settings
                </v-stepper-step>
            </v-stepper-header>

            <v-stepper-items>
                <v-stepper-content step="1">
                    <v-row>
                        <v-col
                            cols="12"
                            md="4">
                            <img src="/svg/road-and-rail.svg" alt="Road rail and bus">
                        </v-col>
                        <v-col
                            cols="12"
                            md="8">
                            <div class="display-1 mb-2">Welcome to Montreal Transit Tracker</div>
                            <div class="title mb-3">Version 2.0 - This is a beta version, please report any bug on
                                <a href="https://cptdb.ca/topic/19090-montreal-realtime-transit-viewer/">CPTDB</a> or
                                <a href="https://github.com/felixinx/montreal-transit-tracker/issues">GitHub</a></div>
                            <v-btn
                                    class="float-right"
                                    color="accent"
                                    @click="stepper = 2">
                                Continue
                            </v-btn>
                        </v-col>
                    </v-row>
                </v-stepper-content>
                <v-stepper-content step="2">
                    <p class="title">Please read the following conditions before using the application:</p>
                    <!-- Todo: fix css typo codes -->
                    <div>
                        <p class='md-body-1'>The data on this website is given as is and should not be used as a public transport timetable. The accuracy and reliability of the data is not guaranteed.</p>
                        <p class='md-body-2'>Montreal Transit Tracker, Société de transport de Montréal, Société de transport de Laval and exo are not responsible for the use of the data presented on this site.</p>
                        <p class='md-body-1'>The data comes from the following agencies:</p>
                            <ul>
                                <li><a href='http://stm.info'>Société de transport de Montréal (STM)</a></li>
                                <li><a href='https://stl.laval.qc.ca'>Société de transport de Laval (STL)</a></li>
                                <li><a href='https://exo.quebec'>exo</a> (including exo buses, exo trains and Réseau de transport de Longueuil buses)</li>
                            </ul>
                        <p>The above data are all available under the <a href='https://creativecommons.org/licenses/by/4.0/deed.en'>Creative Common 4.0 CC BY</a> license.</p>
                        <p class='md-body-2'>Google Analytics is used for statistical purposes. During beta versions, when an error occurs, some data will be sent to Bugsnap to help resolve errors and bugs.</p>
                    </div>

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
                        I agree, continue
                    </v-btn>
                </v-stepper-content>
                <v-stepper-content step="3">
                    <p class="title">Choose the agencies you want to see:</p>
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
                        Continue
                    </v-btn>
                </v-stepper-content>
                <v-stepper-content
                    class="pa-3"
                    step="4">
                    <div class="pa-3">
                        <p class="title">Settings</p>
                        <v-switch v-model="settingsAutoRefresh" label="Auto refresh every minute"></v-switch>
                        <v-alert
                                dense
                                border="left"
                                type="warning">
                            Auto refresh is coming soon!
                        </v-alert>
                        <v-divider></v-divider>
                        <p class="subtitle-1">Default tab on opening</p>
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
                            Done
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
  VRow,
  VCol,
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
  VAlert,
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
    VRow,
    VCol,
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
    VAlert,
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
