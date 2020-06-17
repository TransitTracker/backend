<template>
    <div class="container">
        <div class="d-flex">
            <ul>
                <li v-for="icon in icons" :key="icon.id">
                    <a :href="icon.url" :download="icon.id">{{ icon.id }}</a>
                </li>
            </ul>
            <ul>
                <li v-for="icon in activeIcons" :key="icon.id">
                    <a :href="icon.url" :download="icon.id">{{ icon.id }}</a>
                </li>
            </ul>
        </div>
    </div>
</template>

<script>
import color from 'color'
export default {
  name: 'GenerateIcons',
  computed: {
    agencies () {
      return this.$store.state.agencies.data
    }
  },
  data: () => ({
    activeIcons: [],
    icons: []
  }),
  mounted () {
    const markerIcon = 'm 33.866667,229.76003 c -12.799225,0 -23.151053,10.35183 -23.151053,23.15105 0,17.36329 23.151053,42.99481 23.151053,42.99481 0,0 23.151052,-25.63152 23.151052,-42.99481 0,-12.79922 -10.351826,-23.15105 -23.151052,-23.15105 z'
    const vehicles = [
      { name: 'bus', icon: 'm 23.944797,259.88944 c 0,1.09144 0.483689,2.07122 1.240233,2.75335 v 2.20762 c 0,0.68213 0.558103,1.24022 1.240233,1.24022 H 27.6655 c 0.682125,0 1.240233,-0.55809 1.240233,-1.24022 v -1.24026 h 9.921877 v 1.24026 c 0,0.68213 0.558104,1.24022 1.240233,1.24022 h 1.240233 c 0.68213,0 1.240238,-0.55809 1.240238,-1.24022 v -2.20762 c 0.756539,-0.68213 1.240233,-1.66191 1.240233,-2.75335 v -12.40233 c 0,-4.34081 -4.440038,-4.96092 -9.921877,-4.96092 -5.481835,0 -9.921873,0.62011 -9.921873,4.96092 z m 4.340817,1.24027 c -1.029393,0 -1.860351,-0.83096 -1.860351,-1.86038 0,-1.02937 0.830958,-1.86033 1.860351,-1.86033 1.029394,0 1.860352,0.83096 1.860352,1.86033 0,1.02942 -0.830958,1.86038 -1.860352,1.86038 z m 11.162111,0 c -1.029394,0 -1.860352,-0.83096 -1.860352,-1.86038 0,-1.02937 0.830958,-1.86033 1.860352,-1.86033 1.029393,0 1.860351,0.83096 1.860351,1.86033 0,1.02942 -0.830958,1.86038 -1.860351,1.86038 z m 1.860351,-7.44141 H 26.425263 v -6.20119 h 14.882813 z' },
      { name: 'train', icon: 'M12 2c-4.42 0-8 .5-8 4v9.5C4 17.43 5.57 19 7.5 19L6 20.5v.5h12v-.5L16.5 19c1.93 0 3.5-1.57 3.5-3.5V6c0-3.5-3.58-4-8-4zM7.5 17c-.83 0-1.5-.67-1.5-1.5S6.67 14 7.5 14s1.5.67 1.5 1.5S8.33 17 7.5 17zm3.5-6H6V6h5v5zm5.5 6c-.83 0-1.5-.67-1.5-1.5s.67-1.5 1.5-1.5 1.5.67 1.5 1.5-.67 1.5-1.5 1.5zm1.5-6h-5V6h5v5z' },
      { name: 'tram', icon: 'M9 1L5 4L7.5 6H5C5 6 2 6 2 9V19H7C7 19 7 17 9 17H22V14H18V8H22V6H10.5L13 4L9 1M4 8H9V14H4V8M11 8H16V14H11V8M4 16H5V18H4V16M9 19V19.5C9 20.88 10.12 22 11.5 22C12.5 22 13.39 21.41 13.79 20.5H15.21C15.61 21.41 16.5 22 17.5 22C18.88 22 20 20.88 20 19.5V19H9Z' }
    ]

    this.$store.state.agencies.data.forEach(agency => {
      vehicles.forEach(vehicle => {
        let i
        for (i = 0; i < 2; i++) {
          // SVG element
          const svg = document.createElement('svg')
          svg.setAttribute('viewBox', '0 0 67.73333 67.733335')
          svg.setAttribute('height', '256')
          svg.setAttribute('width', '256')
          svg.setAttribute('id', i ? `tt-${agency.slug}-${vehicle}` : `tt-${agency.slug}-${vehicle}-active`)

          // Create group
          const groupElement = document.createElement('g')
          groupElement.setAttribute('id', 'icon')
          groupElement.setAttribute('transform', 'translate(0,-229.26665)')
          svg.appendChild(groupElement)

          // Create path
          const pathElement = document.createElement('path')
          pathElement.setAttribute('d', markerIcon)
          const pathColor = i ? agency.color : color(agency.color).darken(0.3).hex()
          pathElement.setAttribute('style', `stroke:${agency.text_color};stroke-width:0.6;stroke-miterlimit:4;stroke-dasharray:none;stroke-opacity:1;paint-order:normal;fill:${pathColor};fill-opacity:1`)
          pathElement.setAttribute('d', markerIcon)
          pathElement.setAttribute('id', 'icon-path')
          groupElement.appendChild(pathElement)

          // Create icon
          const iconElement = document.createElement('path')
          iconElement.setAttribute('d', vehicle.icon)
          iconElement.setAttribute('style', `fill:${agency.text_color};fill-opacity:1;stroke:none;stroke-width:1.25`)
          iconElement.setAttribute('id', 'icon-vehicle')
          groupElement.appendChild(iconElement)

          const svgAsXML = (new XMLSerializer()).serializeToString(svg)
          const svgUrl = 'data:image/svg+xml,' + encodeURIComponent(svgAsXML)

          i
            ? this.icons.push({
              id: `tt-${agency.slug}-${vehicle.name}`,
              url: svgUrl
            })
            : this.activeIcons.push({
              id: `tt-${agency.slug}-${vehicle.name}-active`,
              url: svgUrl
            })
        }
      })
    })
  }
}
</script>
