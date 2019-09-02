<template>
    <v-container>
        <v-row>
            <v-col cols="12">
                <v-card color="accent">
                    <v-card-title>Welcome to Montréal Transit Tracker</v-card-title>
                    <v-card-text>Version 2.0.0-beta.3+002</v-card-text>
                </v-card>
            </v-col>
            <v-col
                cols="12">
                <v-card>
                    <v-card-title>
                        {{ totalCount }} vehicles are active
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
                                            {{ count.secondsAgo }} seconds ago
                                            <v-chip
                                                v-if="count.secondsAgo > 300"
                                                label
                                                x-small
                                                color="red"
                                                class="white--text">
                                                Outdated
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
                    <v-card-title>What's new?</v-card-title>
                    <v-card-text>
                        <b>Montreal Transit Tracker version 2 introduces several new features and changes that enhance your experience.</b>
                        <ul>
                            <li>New interface</li>
                            <li>More agencies</li>
                            <li>Auto refresh</li>
                            <li>Detailed information on vehicles</li>
                        </ul>
                    </v-card-text>
                </v-card>
            </v-col>
            <v-col
                cols="12"
                md="6">
                <v-card
                    color="red"
                    dark>
                    <v-card-title>Community</v-card-title>
                    <v-card-text>
                        Visit the <a href="https://cptdb.ca" class="white--text">Canadian Public Transit Discussion Board</a>
                        to share your sightings. For more information on agencies and vehicles, visit the
                        <a href="https://cptdb.ca/wiki/index.php/Main_Page" class="white--text">wiki</a>. To discuss
                        about this application, visit the
                        <a href="https://cptdb.ca/topic/19090-montreal-realtime-transit-viewer/" class="white--text">official thread</a>.
                    </v-card-text>
                </v-card>
            </v-col>
        </v-row>
    </v-container>
</template>

<script>
import collect from 'collect.js'
import { VContainer, VRow, VCol, VCard, VCardTitle, VCardText, VChip } from 'vuetify/lib'

// Todo: Add version to store
export default {
  name: 'TabHome',
  components: {
    VContainer,
    VRow,
    VCol,
    VCard,
    VCardTitle,
    VCardText,
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
      return collect(this.$store.state.agencies.counts)
    },
    counts () {
      const count = this.stateCounts.map(item => {
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

      this.stateCounts.each((item) => {
        count += item.count
      })

      return count
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
