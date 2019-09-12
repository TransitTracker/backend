<template>
    <v-container>
        <v-row>
            <v-col cols="12">
                <v-card color="accent">
                    <v-card-title>{{ $vuetify.lang.t('$vuetify.home.welcome') }} {{ $vuetify.lang.t('$vuetify.app.name') }}</v-card-title>
                    <v-card-text>{{ $vuetify.lang.t('$vuetify.home.version') }} 2.0.0-beta.3+005 (public beta)</v-card-text>
                    <v-card-actions>
                        <v-btn
                            text
                            href="https://felixinx.github.io/mtl-gtfs-rt/">{{ $vuetify.lang.t('$vuetify.home.exitBeta') }}</v-btn>
                    </v-card-actions>
                </v-card>
            </v-col>
            <v-col
                cols="12">
                <v-card>
                    <v-card-title>
                        {{ totalCount }} {{ $vuetify.lang.t('$vuetify.home.vehicleTotal') }}
                    </v-card-title>
                    <v-card-text>
                        <v-row>
                            <v-col
                                class="count-wrapper"
                                v-for="count in counts"
                                :key="count.name"
                                cols="12"
                                md="4">
                                <div class="count"
                                     v-bind:style="{ borderColor: count.backgroundColor }">
                                    <div class="text">
                                        <span class="md-body-2">{{ count.name }}</span><br>
                                        <span class="md-body-1">
                                            <span v-if="language === 'fr'">Il y a </span>
                                            <span v-if="count.secondsAgo < 60">
                                                {{ count.secondsAgo }} {{ $vuetify.lang.t('$vuetify.home.secondsAgo') }}
                                            </span>
                                            <span v-else>
                                                {{ Math.floor(count.secondsAgo / 60) }} {{ $vuetify.lang.t('$vuetify.home.minutesAgo') }}
                                            </span>
                                            <v-chip
                                                v-if="count.secondsAgo > 300"
                                                label
                                                x-small
                                                color="red"
                                                class="white--text">
                                                {{ $vuetify.lang.t('$vuetify.home.outdated') }}
                                            </v-chip>
                                        </span>
                                    </div>
                                    <span
                                        class="number"
                                        v-bind:style="{ backgroundColor: count.backgroundColor, color: count.textColor }">{{ count.count }}</span>
                                </div>
                            </v-col>
                        </v-row>
                    </v-card-text>
                </v-card>
            </v-col>
            <v-col
                cols="12"
                md="6">
                <v-card
                    color="primary"
                    dark>
                    <v-card-title>{{ $vuetify.lang.t('$vuetify.home.whatsNewTitle') }}</v-card-title>
                    <v-card-text v-html="$vuetify.lang.t('$vuetify.home.whatsNewBody')"></v-card-text>
                </v-card>
            </v-col>
            <v-col
                cols="12"
                md="6">
                <v-card
                    color="red"
                    dark>
                    <v-card-title>{{ $vuetify.lang.t('$vuetify.home.communityTitle') }}</v-card-title>
                    <v-card-text v-html="$vuetify.lang.t('$vuetify.home.communityBody')"></v-card-text>
                </v-card>
            </v-col>
        </v-row>
    </v-container>
</template>

<script>
import collect from 'collect.js'
import { VContainer, VRow, VCol, VCard, VCardTitle, VCardText, VCardActions, VBtn, VChip } from 'vuetify/lib'

export default {
  name: 'TabHome',
  components: {
    VContainer,
    VRow,
    VCol,
    VCard,
    VCardTitle,
    VCardText,
    VCardActions,
    VBtn,
    VChip
  },
  mounted () {
    this.$root.$on('vehiclesUpdated', () => {

    })
  },
  computed: {
    appVersion () {
      return this.$store.state.settings.version
    },
    stateAgencies () {
      return collect(this.$store.state.agencies.data)
    },
    stateCounts () {
      return this.$store.state.agencies.counts
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
    language () {
      return this.$store.state.settings.language
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
    .count {
        width: 100%;
        border-radius: 5px;
        border-style: solid;
        border-width: 2px;
        display: flex;
    }
    .count .text {
        padding: 2px;
        flex: 9;
    }
    .count .number {
        flex: 1;
        padding-left: 2px;
        padding-right: 2px;
        margin-left: 5px;
        text-align: center;
        line-height: 50px;
    }

</style>
