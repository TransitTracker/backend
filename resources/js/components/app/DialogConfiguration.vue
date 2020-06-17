<template>
    <v-dialog v-model="dialog" persistent max-width="1000px">
        <v-card>
            <v-window v-model="onboarding">
                <v-window-item key="card-0">
                    <v-card color="transparent" height="500">
                        <div class="card-0-image"></div>
                        <v-btn color="secondary" class="card-0-btn-mobile d-lg-none" @click="changeLanguage">
                            <v-icon left>{{ mdiSvg.translate }}</v-icon>
                            {{ $vuetify.lang.t('$vuetify.onboarding.changeLang') }}
                        </v-btn>
                        <v-btn color="secondary" class="card-0-btn d-none d-lg-block" @click="changeLanguage" outlined>
                            <v-icon left>{{ mdiSvg.translate }}</v-icon>
                            {{ $vuetify.lang.t('$vuetify.onboarding.changeLang') }}
                        </v-btn>
                        <div class="d-flex card-0-text align-center justify-center">
                            <div class="text-center d-lg-none">
                                <h1 class="text-h5">{{ $vuetify.lang.t('$vuetify.onboarding.welcome') }}</h1>
                                <h2 class="text-subtitle-1">{{ $vuetify.lang.t('$vuetify.onboarding.Headline') }}</h2>
                            </div>
                            <div class="text-center d-none d-lg-block">
                                <h1 class="text-h2">{{ $vuetify.lang.t('$vuetify.onboarding.welcome') }}</h1>
                                <h2 class="text-h5">{{ $vuetify.lang.t('$vuetify.onboarding.Headline') }}</h2>
                            </div>
                        </div>
                    </v-card>
                </v-window-item>
                <v-window-item key="card-1">
                    <v-card color="transparent" height="500" class="pa-6 overflow-y-auto d-flex flex-column">
                        <div class="text-center mb-4">
                            <h1 class="text-h5 mb-2">{{ $vuetify.lang.t('$vuetify.onboarding.conditionsTitle') }}</h1>
                            <h2 class="title">{{ $vuetify.lang.t('$vuetify.onboarding.conditionsHeadline') }}</h2>
                        </div>
                        <p class="text-body-1" v-html="$vuetify.lang.t('$vuetify.onboarding.conditionsBody')"></p>
                        <div class="flex-grow-1"></div>
                        <p class="text-body-1" v-html="$vuetify.lang.t('$vuetify.onboarding.contributions')"></p>
                    </v-card>
                </v-window-item>
                <v-window-item key="card-2">
                    <v-card color="transparent" height="500" class="pa-6 overflow-y-auto">
                        <div class="text-center mb-4">
                            <h1 class="text-h5 mb-2">{{ $vuetify.lang.t('$vuetify.onboarding.regionTitle') }}</h1>
                            <h2 class="title">{{ $vuetify.lang.t('$vuetify.onboarding.regionHeadline') }}</h2>
                        </div>
                        <v-row>
                            <v-col cols="12" md="6" v-for="region in loadedRegions" :key="region.id"
                                   class="d-flex justify-center">
                                <div class="region-choice-box" @click="settingsActiveRegion = region.slug"
                                     :class="{ 'region-choice-box-active': settingsActiveRegion === region.slug }">
                                    <div class="region-choice-map pb-2" v-html="region.map"></div>
                                    <div class="d-flex justify-space-between mx-1">
                                        <span class="region-choice-dummy">
                                        </span>
                                        <span class="title">{{ region.name }}</span>
                                        <v-icon class="region-choice-check" v-if="settingsActiveRegion === region.slug"
                                                color="secondary">
                                            {{ mdiSvg.checkCircle }}
                                        </v-icon>
                                        <v-icon class="region-choice-check" v-else dark>
                                            {{ mdiSvg.checkboxBlankCircleOutline }}
                                        </v-icon>
                                    </div>
                                </div>
                            </v-col>
                        </v-row>
                        <v-alert :icon="mdiSvg.lightbulbOn" dark class="mt-1">
                            {{ $vuetify.lang.t('$vuetify.onboarding.regionTip') }}
                        </v-alert>
                    </v-card>
                </v-window-item>
                <v-window-item key="card-3">
                    <v-card color="transparent" height="500" class="pa-6 overflow-y-auto">
                        <div class="text-center mb-4">
                            <h1 class="text-h5 mb-2">{{ $vuetify.lang.t('$vuetify.onboarding.agenciesTitle') }}</h1>
                            <h2 class="title">{{ $vuetify.lang.t('$vuetify.onboarding.agenciesHeadline') }}</h2>
                        </div>
                        <v-alert :icon="mdiSvg.alert" color="warning">
                            {{ $vuetify.lang.t('$vuetify.onboarding.agenciesWarning') }}
                        </v-alert>
                        <v-expansion-panels accordion hover v-model="expansionPanelIndex">
                            <v-expansion-panel v-for="region in loadedRegions" :key="region.slug">
                                <v-expansion-panel-header>{{ region.name }}</v-expansion-panel-header>
                                <v-expansion-panel-content>
                                    <v-row>
                                        <v-col v-for="agency in region.agencies" :key="agency.id" cols="6" md="4" lg="3"
                                               class="text-center">
                                            <v-avatar :color="agency.color" size="100" class="mb-2 agency-avatar"
                                                      @click="toggleAgency(agency.slug)">
                                                <div class="agency-overlay"
                                                     v-if="settingsActiveAgencies.includes(agency.slug)">
                                                    <v-icon class="agency-overlay-check" size="50" color="white">
                                                        {{ mdiSvg.check }}
                                                    </v-icon>
                                                </div>
                                                <v-icon :style="{ color: agency.text_color }" size="50"
                                                        :class="{ 'agency-hide': settingsActiveAgencies.includes(agency.slug)}">
                                                    {{ mdiSvg[agency.vehicles_type] }}
                                                </v-icon>
                                            </v-avatar>
                                            <br><span>{{ agency.name }}</span>
                                        </v-col>
                                    </v-row>
                                </v-expansion-panel-content>
                            </v-expansion-panel>
                        </v-expansion-panels>
                    </v-card>
                </v-window-item>
                <v-window-item key="card-4">
                    <v-card color="transparent" height="500" class="pa-6 overflow-y-auto">
                        <div class="text-center mb-4">
                            <h1 class="text-h5 mb-2">{{ $vuetify.lang.t('$vuetify.onboarding.settingsTitle') }}</h1>
                            <h2 class="title">{{ $vuetify.lang.t('$vuetify.onboarding.settingsHeadline') }}</h2>
                        </div>
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
                            <v-select :items="defaultPath" v-model="settingsDefaultPath" class="settings-select"
                                      color="secondary" item-color="secondary darken-3">
                            </v-select>
                        </div>
                        <div class="settings-row d-flex pa-2 secondary darken-1" v-if="pwa.showPromotion">
                            <div class="settings-label flex-grow-1">
                                <span class="text-body-1">{{ $vuetify.lang.t('$vuetify.onboarding.addHomeLabel') }}</span><br>
                                <span class="text-caption">{{ $vuetify.lang.t('$vuetify.onboarding.addHomeCaption') }}</span>
                            </div>
                            <v-btn color="primary" @click="pwaInstall" :loading="pwa.buttonLoading" dark
                                   :disabled="pwa.buttonDisabled">
                                <v-icon left>{{ pwa.buttonIcon }}</v-icon>
                                {{ $vuetify.lang.t(pwa.buttonText) }}
                            </v-btn>
                        </div>
                    </v-card>
                </v-window-item>
            </v-window>

            <v-card-actions class="justify-center" v-if="onboarding === 0">
                <v-btn color="primary" @click="onboardingNext">
                    {{ $vuetify.lang.t('$vuetify.onboarding.getStarted') }}
                    <v-icon right>{{ mdiSvg.chevronRight }}</v-icon>
                </v-btn>
            </v-card-actions>
            <v-card-actions class="justify-space-between card-actions" v-else>
                <v-btn text @click="onboardingPrev" color="primary">
                    <v-icon left>{{ mdiSvg.chevronLeft }}</v-icon>
                    {{ $vuetify.lang.t('$vuetify.onboarding.btnBack') }}
                </v-btn>
                <v-item-group v-model="onboarding" class="text-center hidden-md-and-down" mandatory>
                    <v-item v-for="n in onboardingLength" :key="`btn-${n}`" v-slot:default="{active, toggle}">
                        <v-btn :input-value="active" icon @click="toggle" color="primary" v-show="n > 1">
                            <v-icon>{{ mdiSvg.record }}</v-icon>
                        </v-btn>
                    </v-item>
                </v-item-group>
                <v-btn text @click="$emit('configurationDone')" color="primary" v-if="onboarding === 4">
                    {{ $vuetify.lang.t('$vuetify.onboarding.btnDone') }}
                </v-btn>
                <v-btn text @click="onboardingNext" color="primary" v-else>
                    {{ $vuetify.lang.t('$vuetify.onboarding.btnNext') }}
                    <v-icon right>{{ mdiSvg.chevronRight }}</v-icon>
                </v-btn>
            </v-card-actions>
        </v-card>
    </v-dialog>
</template>

<script>
import {
  VAlert, VAvatar, VBtn, VCard, VCardActions, VCardText, VCol, VDialog, VExpansionPanel,
  VExpansionPanelContent, VExpansionPanelHeader, VExpansionPanels, VIcon, VItem, VItemGroup, VRow, VSelect,
  VSwitch, VWindow, VWindowItem
} from 'vuetify/lib'
import {
  mdiTranslate, mdiCheckCircle, mdiCheckboxBlankCircleOutline, mdiLightbulbOn, mdiAlert, mdiCheck, mdiBus, mdiTrain,
  mdiTram, mdiChevronRight, mdiChevronLeft, mdiRecord, mdiPlusCircleOutline, mdiAlertCircleOutline
} from '@mdi/js'
import axios from 'axios'

export default {
  components: {
    VAlert,
    VAvatar,
    VBtn,
    VCard,
    VCardActions,
    // eslint-disable-next-line vue/no-unused-components
    VCardText,
    VCol,
    VDialog,
    VExpansionPanels,
    VExpansionPanel,
    VExpansionPanelHeader,
    VExpansionPanelContent,
    VIcon,
    VItem,
    VItemGroup,
    VRow,
    VSelect,
    VSwitch,
    VWindow,
    VWindowItem
  },
  computed: {
    defaultPath () {
      return [
        { text: this.$vuetify.lang.t('$vuetify.app.tabHome'), value: '/' },
        { text: this.$vuetify.lang.t('$vuetify.app.tabMap'), value: '/map' },
        { text: this.$vuetify.lang.t('$vuetify.app.tabTable'), value: '/table' },
        { text: this.$vuetify.lang.t('$vuetify.app.tabSettings'), value: '/settings' }
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
    settingsActiveRegion: {
      get () {
        return this.$store.state.settings.activeRegion
      },
      set (value) {
        this.$store.commit('settings/setActiveRegion', value)
        this.loadedRegions.findIndex(a => a.slug === value)
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
    }
  },
  data: () => ({
    dialog: true,
    expansionPanelIndex: 0,
    loadedRegions: [],
    loadedAgencies: [],
    mdiSvg: {
      translate: mdiTranslate,
      checkCircle: mdiCheckCircle,
      checkboxBlankCircleOutline: mdiCheckboxBlankCircleOutline,
      lightbulbOn: mdiLightbulbOn,
      alert: mdiAlert,
      check: mdiCheck,
      bus: mdiBus,
      train: mdiTrain,
      tram: mdiTram,
      chevronRight: mdiChevronRight,
      chevronLeft: mdiChevronLeft,
      record: mdiRecord
    },
    onboarding: 0,
    onboardingLength: 5,
    pwa: {
      buttonDisabled: false,
      buttonIcon: mdiPlusCircleOutline,
      buttonText: '$vuetify.onboarding.addHomeButtonInstall',
      buttonLoading: false,
      defferedPrompt: null,
      showPromotion: false
    }
  }),
  methods: {
    changeLanguage () {
      let newLang = 'en'
      this.$vuetify.lang.current === 'en'
        ? newLang = 'fr'
        : newLang = 'en'
      this.$store.commit('settings/setLanguage', newLang)
      this.$vuetify.lang.current = newLang
    },
    onboardingNext () {
      this.onboarding = this.onboarding + 1 === this.length
        ? 0
        : this.onboarding + 1
    },
    onboardingPrev () {
      this.onboarding = this.onboarding - 1 < 0
        ? this.length - 1
        : this.onboarding - 1
    },
    pwaInstall () {
      this.pwa.buttonLoading = true
      this.pwa.deferredPrompt.prompt()
      this.pwa.deferredPrompt.userChoice.then((result) => {
        this.pwa.buttonLoading = false
        this.pwa.buttonDisabled = true
        if (result.outcome === 'accepted') {
          this.pwa.buttonIcon = mdiCheck
          this.pwa.buttonText = '$vuetify.onboarding.addHomeButtonSuccess'
        } else {
          this.pwa.buttonIcon = mdiAlertCircleOutline
          this.pwa.buttonText = '$vuetify.onboarding.addHomeButtonError'
        }
      })
    },
    toggleAgency (agencySlug) {
      const originalArray = this.settingsActiveAgencies
      originalArray.includes(agencySlug)
        ? this.settingsActiveAgencies.splice(originalArray.indexOf(agencySlug), 1)
        : this.settingsActiveAgencies.push(agencySlug)
    }
  },
  mounted () {
    axios
      .get('/regions')
      .then(response => {
        this.loadedRegions = response.data.data
        let agencies = []
        response.data.data.forEach(region => {
          agencies = agencies.concat(region.agencies)
        })
        this.loadedAgencies = agencies
      })

    // PWA installation promotion
    window.addEventListener('beforeinstallprompt', (e) => {
      e.preventDefault()
      this.pwa.deferredPrompt = e
      this.pwa.showPromotion = true
    })
  },
  watch: {
    settingsLang (val) {
      this.$i18n.locale = val
    }
  }
}
</script>

<style>
    .card-0-image {
        background-image: url("/img/onboarding.png");
        width: 100%;
        height: 70%;
        background-position: center center;
        background-size: cover;
    }

    .card-0-btn {
        position: absolute;
        top: 358px;
        right: 8px;
    }

    .card-0-btn-mobile {
        position: absolute;
        top: 308px;
        right: 8px;
    }

    .card-0-text {
        height: 30%;
    }

    .v-card .transparent {
        box-shadow: none;
    }

    .card-actions {
        box-shadow: 0px 0px 20px 0px rgba(0, 0, 0, 0.25);
    }

    .region-choice-box {
        border: rgba(0,0,0,.87) solid 2px;
        border-radius: 5px;
        text-align: center;
        max-width: 375px;
        max-height: 375px;
    }

    .region-choice-map svg {
        width: 75%;
        height: 75%;
    }

    .region-choice-box-active {
        border: #4DCCBD solid 2px;
    }

    .agency-avatar {
        cursor: pointer;
    }

    .agency-overlay-check {
        margin-top: 25px;
        color: white;
        z-index: 3;
    }

    .agency-overlay {
        position: absolute;
        top: 0;
        left: 0;
        background: rgba(48,54,51,.75);
        width: 100px;
        height: 100px;
        transition: opacity 0.5s;
    }
    .agency-hide {
        opacity: 0.25;
    }

    .settings-row {
        align-items: center;
        margin-bottom: 4px;
    }
    .settings-row.pa-2 {
        border-radius: 4px;
    }
</style>
