<template>
    <v-banner
            v-if="stateAlert.isVisible"
            :color="stateAlert.data.color"
            :icon="mdiSvg[stateAlert.data.icon]"
            :dark="isDark"
            single-line>
        <span v-if="isEnglish">{{ stateAlert.data.title_en}}</span>
        <span v-else>{{ stateAlert.data.title_fr}}</span>
        <template v-slot:actions>
            <v-btn
                    text
                    @click="$emit('show-dialog')">
                {{ $vuetify.lang.t('$vuetify.alert.readMore') }}
            </v-btn>
            <v-btn
                    text
                    icon
                    v-if="stateAlert.data.can_be_closed"
                    class="d-none d-md-block"
                    @click="markAlertAsRead">
                <v-icon>{{ mdiSvg.close }}</v-icon>
            </v-btn>
        </template>
    </v-banner>
</template>

<script>
import { VBanner, VBtn, VIcon } from 'vuetify/lib'
import { mdiAlert, mdiStarCircle, mdiServerNetworkOff, mdiCheck, mdiUpdate, mdiInformation, mdiClose } from '@mdi/js'

export default {
  name: 'AlertBanner',
  components: {
    VBanner,
    VIcon,
    VBtn
  },
  data: () => ({
    mdiSvg: {
      alert: mdiAlert,
      starCircle: mdiStarCircle,
      serverNetworkOff: mdiServerNetworkOff,
      check: mdiCheck,
      update: mdiUpdate,
      information: mdiInformation,
      close: mdiClose
    }
  }),
  computed: {
    stateAlert () {
      return this.$store.state.alert
    },
    isEnglish () {
      return this.$vuetify.lang.current === 'en'
    },
    isDark () {
      return this.stateAlert.data.color === 'dark'
    }
  },
  methods: {
    markAlertAsRead () {
      this.$store.commit('settings/setAlertRead', this.stateAlert.data.id)
      this.$store.commit('alert/setVisibility', false)
    }
  }
}
</script>

<style>
    .v-banner__actions {
        margin-left: 0 !important;
    }
</style>
