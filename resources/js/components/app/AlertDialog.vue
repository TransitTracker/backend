<template>
  <v-dialog v-model="dialogToggle">
    <v-card>
      <v-card-title primary-title>
        <span v-if="isEnglish">{{ stateAlert.data.title_en }}</span>
        <span v-else>{{ stateAlert.data.title_fr }}</span>
      </v-card-title>
      <v-card-text>
        <span
          v-if="isEnglish"
          v-html="stateAlert.data.body_en"
        />
        <span
          v-else
          v-html="stateAlert.data.body_fr"
        />
      </v-card-text>
      <v-divider />
      <v-card-actions>
        <v-btn
          v-if="stateAlert.data.can_be_closed"
          color="primary"
          text
          @click="markAlertAsRead"
        >
          <v-icon left>
            {{ mdiSvg.check }}
          </v-icon>
          {{ $vuetify.lang.t('$vuetify.alert.markAsRead') }}
        </v-btn>
        <v-spacer />
        <v-btn
          color="primary"
          @click="$emit('hide-dialog')"
        >
          {{ $vuetify.lang.t('$vuetify.alert.close') }}
        </v-btn>
      </v-card-actions>
    </v-card>
  </v-dialog>
</template>

<script>
  import { VDialog, VCard, VCardTitle, VCardText, VDivider, VCardActions, VBtn, VIcon, VSpacer } from 'vuetify/lib'
  import { mdiCheck } from '@mdi/js'

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
      VSpacer,
    },
    props: {
      dialogVisible: Boolean,
    },
    data: () => ({
      mdiSvg: {
        check: mdiCheck,
      },
    }),
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
        },
      },
      isDark () {
        return this.stateAlert.data.color === 'accent'
      },
    },
    methods: {
      markAlertAsRead () {
        this.$store.commit('settings/setAlertRead', this.stateAlert.data.id)
        this.$store.commit('alert/setVisibility', false)
        this.$emit('hide-dialog')
      },
    },
  }
</script>

<style scoped>
    .v-card__text {
        padding-top: 20px !important;
    }
</style>
