<template>
  <div>
    <div id="map" />
    <map-footer
      :agency="selectedAgency"
      :vehicle="selectedVehicle"
      @open-sheet="sheetOpen = true"
    />
    <map-bottom-sheet
      v-if="sheetOpen"
      :agency="selectedAgency"
      :vehicle="selectedVehicle"
      :sheet-open="sheetOpen"
      @close-sheet="sheetOpen = false"
    />
  </div>
</template>

<script>
  import collect from 'collect.js'
  import Mapbox from 'mapbox-gl'
  import MapFooter from './map/Footer'
  import MapBottomSheet from './map/BottomSheet'

  const defaultGeojsonShapeData = {
    type: 'Feature',
    properties: {},
    geometry: { type: 'LineString', coordinates: [] },
  }

  export default {
    name: 'TabMap',
    components: {
      MapFooter,
      MapBottomSheet,
    },
    props: {
      refreshEvent: Object,
    },
    data: () => ({
      sheetOpen: false,
      selectedAgency: {},
      selectedVehicle: {},
    }),
    computed: {
      mapStyle () {
        return this.$store.state.settings.darkMode
          ? 'mapbox://styles/felixinx/ckbmbgwoa19851inl6ifakq1s'
          : 'mapbox://styles/felixinx/ckbmbifk40jwn1ipdubgvsfy3'
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
      },
    },
    watch: {
      refreshEvent: {
        deep: true,
        handler (val, oldVal) {
          // Updating map source when auto refresh sends event
          console.log(`Updating map source for ${val.slug}`)
          this.map.getSource(`source-${val.slug}`).setData(this.stateGeojsonData[val.slug])
        },
      },
      stateActiveRegionSlug: {
        deep: true,
        handler (val, oldVal) {
          // Refresh router when region changes
          // TODO: find a better way to handle this use case
          this.$router.go(0)
        },
      },
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
        maxPitch: 0,
        pitchWithRotate: false,
        dragRotate: false,
        touchZoomRotate: false,
      })

      this.map.addControl(new this.mapbox.AttributionControl(), 'top-right')
      this.map.addControl(new this.mapbox.GeolocateControl({
        positionOptions: {
          enableHighAccuracy: true,
        },
        trackUserLocation: true,
      }), 'top-left')
      this.map.addControl(new this.mapbox.NavigationControl({ showCompass: false }), 'top-left')

      this.map.on('load', () => {
        // Add route shape source and layer
        this.map.addSource('shape-source', {
          type: 'geojson',
          data: defaultGeojsonShapeData,
        })
        this.map.addLayer({
          id: 'shape-layer',
          type: 'line',
          source: 'shape-source',
          layout: {
            'line-join': 'round',
            'line-cap': 'round',
          },
          paint: {
            'line-color': '#000000',
            'line-width': 3,
          },
        })
        this.loadMapLayers()
        if (this.stateSelectedVehicle.id) {
          this.selectMarker({
            geometry: { coordinates: this.stateSelectedVehicle.coordinates },
            properties: { id: this.stateSelectedVehicle.id },
          }, this.stateSelectedVehicle.agency, 13)
        }
      })
    },
    methods: {
      loadMapLayers () {
        // Add layers for all active agencies
        this.stateActiveAgencies.forEach(agency => {
          // Add map source
          this.map.addSource(`source-${agency.slug}`, {
            type: 'geojson',
            data: this.stateGeojsonData[agency.slug],
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
              'icon-image': `tt-${agency.slug}-{marker-symbol}`,
            },
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
              'circle-color': agency.color,
            },
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
        this.selectedVehicle = collect(this.stateVehicles[agency.slug]).firstWhere('id', markerData.properties.id)
        if (this.selectedVehicle.trip.shape) {
          this.map.getSource('shape-source').setData(`${process.env.MIX_SHAPES_ENDPOINT}/${agency.slug}/${this.selectedVehicle.trip.shape}.json`)
          this.map.setPaintProperty('shape-layer', 'line-color', this.selectedVehicle.trip.color ? this.selectedVehicle.trip.color : agency.color)
        } else {
          this.map.getSource('shape-source').setData(defaultGeojsonShapeData)
        }
        new this.mapbox.Popup({ offset: [0, -35], closeButton: false })
          .setLngLat(markerData.geometry.coordinates)
          .setHTML(`<p class="text-caption black--text mb-0">${this.selectedVehicle.label ? this.selectedVehicle.label : this.selectedVehicle.ref}</p>`)
          .addTo(this.map)
      },
    },
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
