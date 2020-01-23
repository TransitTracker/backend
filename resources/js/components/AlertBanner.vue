<template>
    <v-banner
            v-if="stateAlert.isVisible"
            :class="stateAlert.data.color"
            :icon="stateAlert.data.icon"
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
                <v-icon>mdi-close</v-icon>
            </v-btn>
        </template>
    </v-banner>
</template>

<script>
import { VBanner, VBtn, VIcon } from 'vuetify/lib'

export default {
  name: 'AlertBanner',
  components: {
    VBanner,
    VIcon,
    VBtn
  },
  data () {
    return {
      iconColor: 'accent'
    }
  },
  computed: {
    stateAlert () {
      return this.$store.state.alert
    },
    isEnglish () {
      return this.$vuetify.lang.current === 'en'
    },
    isDark () {
      return this.stateAlert.data.color === 'secondary'
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
