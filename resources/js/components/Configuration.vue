<i18n>
{
    "en": {
        "dialogTitle": "Welcome to Montréal Transit Tracker!",
        "dialogContinue": "Continue",
        "languageTitle": "Language",
        "conditionsTitle": "Conditions",
        "conditionsHeading": "Please read the following conditions before using the application:",
        "conditions": "Long conditions. <b>Very long!</b>",
        "dialogAgree": "I agree, continue",
        "agenciesTitle": "Agencies",
        "agenciesHeading": "Choose the agencies you want to see:",
        "settingsTitle": "Settings",
        "settingsHeading": "Choose your settings:",
        "settingsRefresh": "Automatic refresh every minute",
        "settingsPath": "Default tab on launch",
        "dialogDone": "Done"
    },
    "fr": {
        "dialogTitle": "Bienvenue dans Montréal Transit Tracker!",
        "dialogContinue": "Continuer",
        "languageTitle": "Langue",
        "conditionsTitle": "Conditions",
        "conditionsHeading": "Veuillez lire les conditions suivantes avant d'utiliser l'application :",
        "conditions": "Longues conditions. <b>Très long!</b>",
        "dialogAgree": "J'accepte, continuer",
        "agenciesTitle": "Agences",
        "agenciesHeading": "Choissisez les agences que vous souhaitez voir :",
        "settingsTitle": "Réglages",
        "settingsHeading": "Choissisez les réglages :",
        "settingsRefresh": "Actualisation automatique à chaque minute",
        "settingsPath": "Onglet par défaut lors du lancement",
        "dialogDone": "Terminer"
    }
}
</i18n>
<template>
    <div>
        <md-dialog :md-active="dialogSettings.active" :md-close-on-esc="dialogSettings.closeOnEsc"
                   :md-click-outside-to-close="dialogSettings.clickOutsideToClose">
            <md-dialog-title>{{ $t("dialogTitle") }}</md-dialog-title>

            <md-dialog-content>
                <md-steppers :md-active-step.sync="stepperActive" md-linear>
                    <md-step id="stepperLanguage" :md-label="$t('languageTitle' )" :md-done.sync="stepperLanguage">
                        <p class="subheading">Please choose your language / Veuillez choisir votre langue</p>
                        <md-radio v-model="settingsLang" value="fr">Français</md-radio>
                        <md-radio v-model="settingsLang" value="en" checked>English</md-radio>
                        <br>
                        <md-button class="md-accent md-raised" @click="setDone('stepperLanguage', 'stepperConditions')">
                            {{ $t("dialogContinue")}}
                        </md-button>
                    </md-step>
                    <md-step id="stepperConditions" :md-label="$t('conditionsTitle' )" :md-done.sync="stepperConditions">
                        <p class="subheading">{{ $t("conditionsHeading")}}</p>
                        <p v-html="$t('conditions')"></p>
                        <br>
                        <md-button class="md-accent md-raised" @click="setDone('stepperConditions', 'stepperAgencies'); loadAgencies()">
                            {{ $t("dialogAgree" )}}
                        </md-button>
                    </md-step>
                    <md-step id="stepperAgencies" :md-label="$t('agenciesTitle' )" :md-done.sync="stepperAgencies">
                        <p class="subheading">{{ $t("agenciesHeading" )}}</p>
                        <md-list>
                            <md-list-item v-for="agency in loadedAgencies" :key="agency.id">
                                <md-checkbox v-model="settingsActiveAgencies" :value="agency.slug"></md-checkbox>
                                <md-avatar
                                        v-bind:style="{'background-color': agency.color, 'border-color': agency.text_color}">
                                    <md-icon v-bind:style="{'color': agency.text_color}">{{ agency.vehicles_type ===
                                        'bus' ? 'directions_bus' : 'train' }}
                                    </md-icon>
                                </md-avatar>
                                <span class="md-list-item-text">{{ agency.name }}</span>
                            </md-list-item>
                        </md-list>
                        <br>
                        <md-button class="md-accent md-raised" @click="setDone('stepperAgencies', 'stepperSettings')">{{ $t("dialogContinue") }}
                        </md-button>
                    </md-step>
                    <md-step id="stepperSettings" :md-label="$t('settingsTitle' )" :md-done.sync="stepperSettings">
                        <p class="subheading">{{ $t("settingsHeading" )}}</p>
                        <md-switch v-model="settingsAutoRefresh">{{ $t("settingsRefresh" )}}</md-switch>
                        <hr>
                        <div class="md-subhead">{{ $t("settingsPath" )}}</div>
                        <md-radio v-model="settingsDefaultPath" v-for="route in routes" :key="route.path"
                                  :value="route.path">{{ route.name }}
                        </md-radio>
                        <br>
                        <md-button class="md-accent md-raised" @click="setDone('stepperSettings')">{{ $t("dialogDone" ) }}
                        </md-button>
                    </md-step>
                </md-steppers>
            </md-dialog-content>
        </md-dialog>
    </div>
</template>

<script>
    import axios from 'axios/index'

    export default {
        name: 'ConfigurationStepper',
        data: function() {
            this.$i18n.locale = 'en'
            return {
                dialogSettings: {
                    active: true,
                        closeOnEsc: false,
                        clickOutsideToClose: false
                },
                stepperActive: 'stepperLanguage',
                    stepperLanguage: false,
                stepperConditions: false,
                stepperAgencies: false,
                stepperSettings: false,
                settingsLang: 'en'
            }
        },
        methods: {
            setDone(id, next) {
                this[id] = true

                if (next) {
                    this.stepperActive = next
                } else {
                    this.$emit('configurationDone')
                }
            },
            loadAgencies() {
                axios
                    .get('/agencies')
                    .then(response => (this.loadedAgencies = response.data.data))
            }
        },
        computed: {
            routes() {
                return this.$router.options.routes
            },
            loadedAgencies: {
                get() {
                    return this.$store.state.agencies.data
                },
                set(value) {
                    this.$store.commit('agencies/setData', value)
                }
            },
            settingsActiveAgencies: {
                get() {
                    return this.$store.state.settings.activeAgencies
                },
                set(value) {
                    this.$store.commit('settings/setActiveAgencies', value)
                }
            },
            settingsAutoRefresh: {
                get() {
                    return this.$store.state.settings.autoRefresh
                },
                set(value) {
                    this.$store.commit('settings/setAutoRefresh', value)
                }
            },
            settingsDefaultPath: {
                get() {
                    return this.$store.state.settings.defaultPath
                },
                set(value) {
                    this.$store.commit('settings/setDefaultPath', value)
                }
            }
        },
        watch: {
            settingsLang(val) {
                this.$i18n.locale = val
            }
        }
    }
</script>

<style lang="scss">
    .md-steppers-navigation {
        box-shadow: none;
    }

    .md-checkbox {
        margin-right: 15px;
    }

    .md-avatar {
        margin-right: 15px !important;
        border-width: 1px;
        border-style: solid;
    }
</style>