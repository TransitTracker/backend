const state = {
  data: [],
  active: {
    agencies: [],
    contributions: {
      en: '',
      fr: '',
    },
    credits: {
      en: '',
      fr: '',
    },
    info_body: {
      en: '',
      fr: '',
    },
    info_title: {
      en: '',
      fr: '',
    },
    map: '',
    map_box: [],
    map_zoom: 10,
    name: '',
    slug: '',
  },
}

const mutations = {
  setData (state, regions) {
    state.data = regions
  },
  setActive (state, newRegion) {
    state.active = newRegion
  },
}

export default {
  namespaced: true,
  state,
  mutations,
}
