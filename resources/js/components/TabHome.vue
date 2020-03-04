<template>
    <div id="home">
        <v-container>
            <v-row>
                <v-col cols="12">
                    <v-card color="accent">
                        <v-card-title class="app-title">
                            {{ $vuetify.lang.t('$vuetify.home.welcome') }} Transit Tracker
                        </v-card-title>
                        <v-card-text>{{ $vuetify.lang.t('$vuetify.home.version') }} 2.0.0</v-card-text>
                    </v-card>
                </v-col>
                <v-col
                        cols="12">
                    <v-card>
                        <v-card-title>
                            <span class="flex-grow-1">{{ totalCount }} {{ $vuetify.lang.t('$vuetify.home.vehicleTotal') }}</span>
                            <v-btn dark @click="dialogDownloadOpen = true" :loading="vehiclesPendingRequest > 0">
                                <v-icon left>mdi-download</v-icon>
                                {{ $vuetify.lang.t('$vuetify.home.download') }}
                            </v-btn>
                        </v-card-title>
                        <v-card-text>
                            <v-row>
                                <v-col
                                        v-for="vehicle in vehiclesPendingRequest"
                                        :key="vehicle"
                                        cols="12"
                                        md="4">
                                    <v-skeleton-loader
                                            width="100%"
                                            type="list-item-avatar-two-line"></v-skeleton-loader>
                                </v-col>
                                <v-col
                                        v-for="count in counts"
                                        :key="count.name"
                                        cols="12"
                                        md="4">
                                    <v-sheet
                                            :color="count.backgroundColor"
                                            width="100%"
                                            height="100%"
                                            class="d-flex pa-1">
                                        <v-avatar size="36" class="ml-1 mr-2 align-self-center avatar" color="white">
                                            {{ count.count }}
                                        </v-avatar>
                                        <div
                                                class="flex-grow-1 align-self-center"
                                                :style="{ color: count.textColor }">
                                            <b>{{ count.name }}</b><br>
                                            <span v-if="!isEnglish">Il y a </span>
                                            <span v-if="count.secondsAgo < 60">
                                            {{ count.secondsAgo }} {{ $vuetify.lang.t('$vuetify.home.secondsAgo') }}
                                        </span>
                                            <span v-else>
                                            {{ Math.floor(count.secondsAgo / 60) }} {{ $vuetify.lang.t('$vuetify.home.minutesAgo') }}
                                        </span>
                                            <div v-if="count.secondsAgo > 300">
                                                <v-chip label x-small>
                                                    <v-icon left>mdi-close</v-icon>
                                                    {{ $vuetify.lang.t('$vuetify.home.outdated') }}
                                                </v-chip>
                                            </div>
                                        </div>
                                    </v-sheet>
                                </v-col>
                            </v-row>
                        </v-card-text>
                    </v-card>
                </v-col>
                <v-col cols="12" md="6">
                    <v-card v-if="isEnglish">
                        <v-card-title v-html="stateActiveRegion.info_title.en"></v-card-title>
                        <v-card-text v-html="stateActiveRegion.info_body.en"></v-card-text>
                    </v-card>
                    <v-card v-else>
                        <v-card-title v-html="stateActiveRegion.info_title.fr"></v-card-title>
                        <v-card-text v-html="stateActiveRegion.info_body.fr"></v-card-text>
                    </v-card>
                </v-col>
                <v-col cols="12" md="6">
                    <v-card>
                        <v-card-title>{{ $vuetify.lang.t('$vuetify.home.creditsTitle') }}</v-card-title>
                        <v-card-text v-html="stateActiveRegion.credits.en" v-if="isEnglish"></v-card-text>
                        <v-card-text v-html="stateActiveRegion.credits.fr" v-else></v-card-text>
                    </v-card>
                </v-col>
            </v-row>
            <!-- Todo: complete refresh button -->
            <v-btn dark fab class="fab-refresh" @click="refreshVehicles()">
                <v-icon>mdi-refresh</v-icon>
            </v-btn>
        </v-container>

        <dialog-download v-if="dialogDownloadOpen" v-on:close-dialog="dialogDownloadOpen = false"
                         :dialog-open="dialogDownloadOpen"></dialog-download>
    </div>
</template>

<script>
import collect from 'collect.js'
import DialogDownload from './DialogDownload'
import {
  VAvatar,
  VBtn,
  VCard,
  VCardText,
  VCardTitle,
  VChip,
  VCol,
  VContainer,
  VIcon,
  VRow,
  VSheet,
  VSkeletonLoader
} from 'vuetify/lib'

export default {
  name: 'TabHome',
  components: {
    VContainer,
    VRow,
    VCol,
    VCard,
    VCardTitle,
    VCardText,
    VSkeletonLoader,
    VSheet,
    VAvatar,
    VChip,
    VIcon,
    VBtn,
    DialogDownload
  },
  data: () => ({
    dialogDownloadOpen: false
  }),
  props: ['vehiclesPendingRequest'],
  computed: {
    stateActiveRegion () {
      return this.$store.state.regions.active
    },
    stateAgencies () {
      return collect(this.$store.state.agencies.data)
    },
    stateAlert () {
      return this.$store.state.alert
    },
    stateCounts () {
      return this.$store.state.agencies.counts
    },
    stateVehicles () {
      return this.$store.state.vehicles.data
    },
    counts () {
      const stateCounts = collect(this.stateCounts)
      const count = stateCounts.map(item => {
        const agency = this.stateAgencies.firstWhere('slug', item.agency)

        const count = {}
        count.name = agency.name
        count.backgroundColor = agency.color
        count.textColor = agency.text_color
        count.count = item.count
        count.secondsAgo = item.diff

        return count
      })

      return count.all()
    },
    totalCount () {
      let count = 0

      const stateCounts = collect(this.stateCounts)
      stateCounts.each((item) => {
        count += item.count
      })

      return count
    },
    isEnglish () {
      return this.$store.state.settings.language === 'en'
    },
    alertIsDark () {
      return this.stateAlert.data.color === 'secondary'
    },
    alertShow () {
      return this.stateAlert.data.id !== null && this.stateAgencies.isVisble
    }
  },
  methods: {
    refreshVehicles () {
      this.$emit('refresh-vehicles')
    }
  },
  watch: {
    stateCounts: {
      deep: true,
      handler () {
        this.$forceUpdate()
      }
    }
  }
}
</script>

<style lang="scss" scoped>
    .md-card {
        margin: 16px;
    }

    .app-title {
        word-break: break-word;
    }

    .fab-refresh {
        position: fixed;
        right: 16px;
        bottom: 16px;
    }

    .avatar {
        color: #000000;
    }
</style>
