<template>
    <div class="tab-map">
        <div id="map"></div>
        <map-footer v-on:open-sheet="sheetOpen = true" :agency="selectedAgency" :vehicle="selectedVehicle"></map-footer>
        <map-bottom-sheet v-if="sheetOpen" v-on:close-sheet="sheetOpen = false" :agency="selectedAgency"
                          :vehicle="selectedVehicle" :sheet-open="sheetOpen"></map-bottom-sheet>
    </div>
</template>

<script>
import MapFooter from './map/Footer'
import MapBottomSheet from './map/BottomSheet'
import 'mapbox-gl/dist/mapbox-gl.css'
import mapboxgl from 'mapbox-gl/dist/mapbox-gl'
import collect from 'collect.js'

export default {
  name: 'TabMap',
  components: {
    MapFooter,
    MapBottomSheet
  },
  computed: {
    activeAgencies () {
      return this.$store.state.settings.activeAgencies
    },
    activeRegion () {
      return this.$store.state.regions.active
    },
    vehicles () {
      return this.$store.state.vehicles.data
    },
    agencies () {
      return this.$store.state.agencies.data
    },
    selectedAgency () {
      const agencies = collect(this.agencies)
      return agencies.firstWhere('id', this.selectedVehicle.agency_id)
    },
    mapStyle () {
      if (this.$store.state.settings.darkMode) {
        return 'mapbox://styles/felixinx/ckbi97znr1b5m1in3k4u8kf7a/draft'
      } else {
        return 'mapbox://styles/felixinx/ckad3l5j203do1jno01b7oq0w/draft'
      }
    }
  },
  data: () => ({
    accessToken: process.env.MIX_MAPBOX_TOKEN,
    selectedVehicle: {
      id: null
    },
    sheetOpen: false
  }),
  methods: {
    toggleSheet () {
      if (this.sheetOpen) {
        this.sheetOpen = false
      } else {
        this.sheetOpen = true
      }
    }
  },
  mounted () {
    mapboxgl.accessToken = 'pk.eyJ1IjoiZmVsaXhpbngiLCJhIjoiY2lqYzJoMW9vMDA1dnZsa3F3cmZzcWVsciJ9.ZWBQm52vI7RFRwGuoAzwMg'

    const map = new mapboxgl.Map({
      container: 'map',
      style: this.mapStyle,
      center: this.activeRegion.map_box,
      zoom: this.activeRegion.map_zoom,
      attributionControl: false
    })

    map.addControl(new mapboxgl.AttributionControl(), 'top-right')
    map.addControl(new mapboxgl.GeolocateControl({
      positionOptions: {
        enableHighAccuracy: true
      },
      trackUserLocation: true
    }), 'top-left')
    map.addControl(new mapboxgl.NavigationControl({ showCompass: false }), 'top-left')

    const activeAgencies = this.$store.state.settings.activeAgencies
    map.on('load', function () {
      activeAgencies.forEach(agencySlug => {
        map.addSource(`source-${agencySlug}`, {
          type: 'geojson',
          data: `${process.env.MIX_APIENDPOINT}/geojson/${agencySlug}`
        })
        map.addLayer({
          id: `layer-${agencySlug}`,
          type: 'symbol',
          source: `source-${agencySlug}`,
          layout: {
            'icon-image': `tt-${agencySlug}-{marker-symbol}`,
            'icon-anchor': 'bottom',
            'icon-size': 0.15
          }
        })
        map.on('click', `layer-${agencySlug}`, e => {
          map.flyTo({ center: e.features[0].geometry.coordinates })
          const vehicle = collect(this.$store.state.vehicles.data).where('id', e.features[0].properties.id)
          this.selectedVehicle = vehicle
        })
      })
    })

    if (this.selectedVehicle.lat) {
      map.flyTo({
        center: [this.selectedVehicle.lon, this.selectedVehicle.lat],
        zoom: 13
      })
    }
  },
  props: ['vehiclesPendingRequest'],
  watch: {
    activeRegion: {
      deep: true,
      handler (val, oldVal) {
        this.$forceUpdate()
      }
    }
  }
}
</script>

<style scoped>
#map {
    height: calc(100vh - 180px);
    z-index: 1;
}
</style>

<style>
.md-app-content {
    padding: 0;
}
.mapboxgl-ctrl-bottom-left .mapboxgl-ctrl {
    margin: 0 0 30px 10px;
}
.circle {
    transform: translate(10px, 10px);
}
.circle svg {
    height: 10px;
    width: 10px;
}
.marker {
    display: none;
}
.marker svg {
    height: 40px;
    width: 40px;
}
.marker-selected svg {
    height: 60px;
    width: 60px;
}
.marker-selected {
    z-index: 2;
}
.marker svg {
    cursor: pointer;
}
.fab-refresh {
    bottom: 92px;
    z-index: 2;
}
</style>
