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
        ? 'mapbox://styles/felixinx/ckbi97znr1b5m1in3k4u8kf7a/draft'
        : 'mapbox://styles/felixinx/ckad3l5j203do1jno01b7oq0w/draft'
    },
    stateActiveRegion () {
      return this.$store.state.regions.active
    },
    stateActiveAgencies () {
      const collection = collect(this.$store.state.regions.active.agencies)
      const agencies = collection.whereIn('slug', this.$store.state.settings.activeAgencies)
      return agencies.all()
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
      this.stateActiveAgencies.forEach(agency => {
        this.map.addSource(`source-${agency.slug}`, {
          type: 'geojson',
          data: `${process.env.MIX_APIENDPOINT}/geojson/${agency.slug}`
        })
        this.map.addLayer({
          id: `layer-${agency.slug}`,
          type: 'symbol',
          source: `source-${agency.slug}`,
          layout: {
            'icon-allow-overlap': true,
            'icon-anchor': 'bottom',
            'icon-image': `tt-${agency.slug}-{marker-symbol}`
          }
        })
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
    selectMarker (markerData, agency, zoom) {
      this.popup.remove()
      this.map.flyTo({ center: markerData.geometry.coordinates, zoom: zoom })
      this.selectedAgency = agency
      this.selectedVehicle = collect(this.stateVehicles).firstWhere('id', markerData.properties.id)
      this.popup
        .setLngLat(markerData.geometry.coordinates)
        .setHTML(`<p class="text-caption mb-0">${this.selectedVehicle.ref}</p>`)
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
      attributionControl: false
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
    })

    this.popup = new this.mapbox.Popup({
      offset: [0, -35],
      closeButton: false
    })

    if (this.stateSelectedVehicle.id) {
      this.selectMarker({
        geometry: { coordinates: this.stateSelectedVehicle.coordinates },
        properties: { id: this.stateSelectedVehicle.id }
      }, this.stateSelectedVehicle.agency, 13)
    }
  },
  watch: {
    stateActiveRegion: {
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
