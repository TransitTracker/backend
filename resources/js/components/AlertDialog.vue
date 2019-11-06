<template>
    <v-dialog v-model="dialogToggle">
        <v-card>
            <v-card-title
                class="headline"
                :class="[{ 'white--text': isDark }, stateAlert.data.color]"
                primary-title>
                <span v-if="isEnglish">{{ stateAlert.data.title_en }}</span>
                <span v-else>{{ stateAlert.data.title_fr }}</span>
            </v-card-title>
            <v-card-text>
                <span v-if="isEnglish" v-html="stateAlert.data.body_en"></span>
                <span v-else v-html="stateAlert.data.body_fr"></span>
            </v-card-text>
            <v-divider></v-divider>
            <v-card-actions>
                <v-btn
                    text
                    color="primary"
                    @click="markAlertAsRead"
                    v-if="stateAlert.data.can_be_closed">
                        <v-icon left>mdi-check</v-icon>
                        Mark as read
                </v-btn>
                <v-spacer></v-spacer>
                <v-btn
                    color="secondary"
                    @click="$emit('hide-dialog')">Close</v-btn>
            </v-card-actions>
        </v-card>
    </v-dialog>
</template>

<script>
  import {VDialog, VCard, VCardTitle, VCardText, VDivider, VCardActions, VBtn, VIcon, VSpacer} from 'vuetify/lib'

  export default {
    name: 'AlertDialog',
    components: {
      VDialog,
      VCard,
      VCardTitle,
      VCardText,
      VDivider,
      VCardActions,
      VBtn,
      VIcon,
      VSpacer
    },
    props: ['dialogVisible'],
    computed: {
      stateAlert () {
        return this.$store.state.alert
      },
      isEnglish () {
        return this.$vuetify.lang.current === 'en'
      },
      dialogToggle: {
        get () {
          return this.dialogVisible
        },
        set () {
          this.$emit('hide-dialog')
        }
      },
      isDark () {
        return this.stateAlert.data.color === 'secondary'
      }
    },
    methods: {
      markAlertAsRead () {
        this.$store.commit('settings/setAlertRead', this.stateAlert.data.id)
        this.$store.commit('alert/setVisibility', false)
        this.$emit('hide-dialog')
      }
    }
  }
</script>

<style scoped>
    .v-card__text {
        padding-top: 20px !important;
    }
</style>
