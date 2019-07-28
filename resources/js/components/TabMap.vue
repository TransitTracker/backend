<template>
    <div class="tab-map">
        <div id="map"></div>
        <vehicle-info></vehicle-info>
    </div>
</template>

<script>
    import VehicleInfo from './map/VehicleInfo.vue'

    let mapboxgl = require('mapbox-gl/dist/mapbox-gl')
    import 'mapbox-gl/dist/mapbox-gl.css'
    const collect = require('collect.js')
    const color = require('color')

    const markerIcon = `M 12,2 C 8.13,2 5,5.13 5,9 c 0,5.25 7,13 7,13 0,0 7,-7.75 7,-13 0,-3.87 -3.13,-7 -7,-7 z`
    const busIcon = `M4 16c0 .88.39 1.67 1 2.22V20c0 .55.45 1 1 1h1c.55 0 1-.45 1-1v-1h8v1c0 .55.45 1 1 1h1c.55 0 1-.45 1-1v-1.78c.61-.55 1-1.34 1-2.22V6c0-3.5-3.58-4-8-4s-8 .5-8 4v10zm3.5 1c-.83 0-1.5-.67-1.5-1.5S6.67 14 7.5 14s1.5.67 1.5 1.5S8.33 17 7.5 17zm9 0c-.83 0-1.5-.67-1.5-1.5s.67-1.5 1.5-1.5 1.5.67 1.5 1.5-.67 1.5-1.5 1.5zm1.5-6H6V6h12v5z`
    const trainIcon = `M12 2c-4.42 0-8 .5-8 4v9.5C4 17.43 5.57 19 7.5 19L6 20.5v.5h12v-.5L16.5 19c1.93 0 3.5-1.57 3.5-3.5V6c0-3.5-3.58-4-8-4zM7.5 17c-.83 0-1.5-.67-1.5-1.5S6.67 14 7.5 14s1.5.67 1.5 1.5S8.33 17 7.5 17zm3.5-6H6V6h5v5zm5.5 6c-.83 0-1.5-.67-1.5-1.5s.67-1.5 1.5-1.5 1.5.67 1.5 1.5-.67 1.5-1.5 1.5zm1.5-6h-5V6h5v5z`

    export default {
        name: "TabMapbox",
        components: {
            VehicleInfo
        },
        data() {
            return {
                map: null
            }
        },
        mounted() {
            mapboxgl.accessToken = 'pk.eyJ1IjoiZmVsaXhpbngiLCJhIjoiY2lqYzJoMW9vMDA1dnZsa3F3cmZzcWVsciJ9.ZWBQm52vI7RFRwGuoAzwMg'

            this.map = new mapboxgl.Map({
                container: 'map',
                style: 'mapbox://styles/mapbox/streets-v11',
                center: [-73.5682, 45.4997],
                zoom: 11,
                attributionControl: false
            })

            this.map.addControl(new mapboxgl.AttributionControl(), 'top-right')
            this.map.addControl(new mapboxgl.GeolocateControl({
                positionOptions: {
                    enableHighAccuracy: true
                },
                trackUserLocation: true
            }), 'top-left')
            this.map.addControl(new mapboxgl.NavigationControl({ showCompass: false }), 'top-left')

            this.putMarkersOnMap(this.markers)
        },
        computed: {
            vehicles() {
                return this.$store.state.vehicles.data;
            },
            agencies() {
                return this.$store.state.agencies.data;
            },
            selectedVehicle() {
                return this.$store.state.vehicles.selection
            },
            markers() {
                // The following code was inspired by remyvhw from SurLesRails. Thank you!
                return collect(this.vehicles).map(vehicle => {
                    // Find agency
                    const agency = collect(this.agencies).firstWhere('id', vehicle.agency_id)

                    // Check if selected vehicle is this one
                    let isSelected = false
                    this.selectedVehicle.id === vehicle.id ? isSelected = true : isSelected = false

                    // Enclosing div
                    let enclosingDiv = document.createElement('div')
                    enclosingDiv.className = isSelected ? 'marker-selected' : 'marker'

                    // SVG element
                    let svgElement = document.createElement('svg');
                    svgElement.setAttribute('xmlns', 'http://www.w3.org/2000/svg')
                    svgElement.setAttribute('viewBox', '0 0 24 24')

                    // Create path
                    let pathElement = document.createElement('path')
                    pathElement.setAttribute('d', markerIcon)
                    pathElement.setAttribute('fill', isSelected ? color(agency.color).darken(0.3).hsl() : agency.color)
                    pathElement.setAttribute('stroke', agency.text_color)
                    pathElement.setAttribute('stroke-width', '0.5')
                    svgElement.appendChild(pathElement)

                    // Create icon
                    let iconElement = document.createElement('path')
                    iconElement.setAttribute('d', agency.vehicles_type === 'bus' ? busIcon : trainIcon)
                    iconElement.setAttribute('fill', agency.text_color)
                    iconElement.setAttribute('transform', 'translate(7.25 4) scale(0.4 0.4)')
                    svgElement.appendChild(iconElement)

                    // Put together and add a click event
                    enclosingDiv.innerHTML = svgElement.outerHTML
                    enclosingDiv.addEventListener('click', () => {
                        this.$store.commit('vehicles/setSelection', vehicle)
                    })

                    // Create the marker and return it
                    let marker = new mapboxgl.Marker(enclosingDiv).setLngLat([vehicle.lon, vehicle.lat])
                    marker.setOffset([0, isSelected ? -25 : -16])
                    marker._data = vehicle;
                    return marker
                }).toArray()
            }
        },
        watch: {
            markers: {
                deep: true,
                handler: function(val, oldVal) {
                    this.putMarkersOnMap(val, oldVal);
                }
            },
        },
        methods: {
            putMarkersOnMap(newMarkers, oldMarkers) {
                // Remove old markers
                if (oldMarkers) {
                    collect(oldMarkers).each(marker => {
                        marker.remove();
                    });
                }
                collect(newMarkers).each(marker => {
                    marker.addTo(this.map);
                });
            }
        }
    }
</script>

<style scoped>
#map {
    height: calc(100vh - 176px);
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
.marker {
    cursor: pointer;
}
</style>