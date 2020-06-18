<template>
    <div>
        <div id="map"></div>
        <map-footer v-on:open-sheet="sheetOpen = true" :agency="selectedAgency" :vehicle="selectedVehicle"></map-footer>
        <map-bottom-sheet v-if="sheetOpen" v-on:close-sheet="sheetOpen = false" :agency="selectedAgency"
                          :vehicle="selectedVehicle" :sheet-open="sheetOpen"></map-bottom-sheet>
    </div>
</template>

<script>
import collect from 'collect.js'
import Mapbox from 'mapbox-gl'
import MapFooter from './map/Footer'
import MapBottomSheet from './map/BottomSheet'

export default {
  name: 'TabMap',
  components: {
    MapFooter,
    MapBottomSheet
  },
  computed: {
    mapStyle () {
      return this.$store.state.settings.darkMode
        ? 'mapbox://styles/felixinx/ckbi97znr1b5m1in3k4u8kf7a'
        : 'mapbox://styles/felixinx/ckad3l5j203do1jno01b7oq0w'
    },
    stateActiveRegion () {
      return this.$store.state.regions.active
    },
    stateActiveRegionSlug () {
      return this.stateActiveRegion.slug
    },
    stateActiveAgencies () {
      // Filter active agencies according to selected region
      const collection = collect(this.$store.state.regions.active.agencies)
      const agencies = collection.whereIn('slug', this.$store.state.settings.activeAgencies)
      return agencies.all()
    },
    stateGeojsonData () {
      return this.$store.state.vehicles.geojson
    },
    stateSelectedVehicle () {
      return this.$store.state.vehicles.selection
    },
    stateVehicles () {
      return this.$store.state.vehicles.data
    }
  },
  data: () => ({
    sheetOpen: false,
    selectedAgency: {},
    selectedVehicle: {}
  }),
  methods: {
    loadMapLayers () {
      // Add layers for all active agencies
      this.stateActiveAgencies.forEach(agency => {
        // Add map source
        this.map.addSource(`source-${agency.slug}`, {
          type: 'geojson',
          data: this.stateGeojsonData[agency.slug]
        })
        // Add map layers
        this.map.addLayer({
          id: `layer-${agency.slug}`,
          type: 'symbol',
          source: `source-${agency.slug}`,
          minzoom: 11,
          layout: {
            'icon-allow-overlap': true,
            'icon-anchor': 'bottom',
            'icon-image': `tt-${agency.slug}-{marker-symbol}`
          }
        })
        this.map.addLayer({
          id: `circles-${agency.slug}`,
          type: 'circle',
          source: `source-${agency.slug}`,
          maxzoom: 11,
          paint: {
            'circle-radius': 5,
            'circle-stroke-color': agency.text_color,
            'circle-stroke-width': 0.5,
            'circle-color': agency.color
          }
        })
        // Add map events
        this.map.on('click', `layer-${agency.slug}`, e => {
          this.selectMarker(e.features[0], agency)
        })
        this.map.on('mouseenter', `layer-${agency.slug}`, e => {
          this.map.getCanvas().style.cursor = 'pointer'
        })
        this.map.on('mouseleave', `layer-${agency.slug}`, e => {
          this.map.getCanvas().style.cursor = ''
        })
      })
    },
    selectMarker (markerData, agency, zoom = this.map.getZoom()) {
      this.map.flyTo({ center: markerData.geometry.coordinates, zoom: zoom })
      this.selectedAgency = agency
      this.selectedVehicle = collect(this.stateVehicles).firstWhere('id', markerData.properties.id)
      new this.mapbox.Popup({ offset: [0, -35], closeButton: false })
        .setLngLat(markerData.geometry.coordinates)
        .setHTML(`<p class="text-caption black--text mb-0">${this.selectedVehicle.ref}</p>`)
        .addTo(this.map)
    }
  },
  mounted () {
    this.mapbox = Mapbox
    this.mapbox.accessToken = 'pk.eyJ1IjoiZmVsaXhpbngiLCJhIjoiY2lqYzJoMW9vMDA1dnZsa3F3cmZzcWVsciJ9.ZWBQm52vI7RFRwGuoAzwMg'

    this.map = new this.mapbox.Map({
      container: 'map',
      style: this.mapStyle,
      center: this.stateActiveRegion.map_box,
      zoom: this.stateActiveRegion.map_zoom,
      attributionControl: false,
      maxPitch: 0
    })

    this.map.addControl(new this.mapbox.AttributionControl(), 'top-right')
    this.map.addControl(new this.mapbox.GeolocateControl({
      positionOptions: {
        enableHighAccuracy: true
      },
      trackUserLocation: true
    }), 'top-left')
    this.map.addControl(new this.mapbox.NavigationControl({ showCompass: false }), 'top-left')

    this.map.on('load', () => {
      this.loadMapLayers()
      if (this.stateSelectedVehicle.id) {
        this.selectMarker({
          geometry: { coordinates: this.stateSelectedVehicle.coordinates },
          properties: { id: this.stateSelectedVehicle.id }
        }, this.stateSelectedVehicle.agency, 13)
      }
    })
  },
  props: ['refreshEvent'],
  watch: {
    refreshEvent: {
      deep: true,
      handler (val, oldVal) {
        // Updating map source when auto refresh sends event
        console.log(`Updating map source for ${val.slug}`)
        this.map.getSource(`source-${val.slug}`).setData(this.stateGeojsonData[val.slug])
      }
    },
    stateActiveRegionSlug: {
      deep: true,
      handler (val, oldVal) {
        // Refresh router when region changes
        // TODO: find a better way to handle this use case
        this.$router.go(0)
      }
    }
  }
}
</script>

<style scoped>
    #map {
        height: calc(100vh - 192px);
        z-index: 1;
    }
    @media only screen and (max-width: 960px) {
        #map {
            height: calc(100vh - 184px);
        }
    }
</style>
