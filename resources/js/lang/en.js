export default {
  app: {
    tabHome: 'Home',
    tabMap: 'Map',
    tabTable: 'Table',
    tabSettings: 'Settings',
    snackbarBold: 'Warning!',
    snackbarText: 'Data from some agencies are outdated and should be used with caution.',
    snackbarBtn: 'Close',
    regionAriaLabel: 'Change region'
  },
  home: {
    welcome: 'Welcome to ',
    version: 'Version',
    exitBeta: 'Exit beta version',
    vehicleTotal: 'vehicles are active',
    download: 'Download',
    secondsAgo: 'seconds ago',
    minutesAgo: 'minutes ago',
    outdated: 'Outdated',
    emptyTitle: 'No agencies selected',
    emptyBody: 'You didn\'t select any agencies for this region. Head over to the settings tab to add some agencies or change region using the top-right button.',
    emptyButton: 'Add agencies',
    creditsTitle: 'Credits',
    refreshAriaLabel: 'Refresh'
  },
  mapFooter: {
    select: 'Please select a vehicle to see more information'
  },
  mapBottomSheet: {
    close: 'Close',
    search: 'Search on CPTDB wiki',
    moreInfo: 'More info on',
    route: 'Route:',
    headsign: 'Headsign:',
    tripId: 'Trip ID:',
    searchTrip: 'View related departures (by Gerbil)',
    startTime: 'Start time:',
    status: 'Status:',
    stopSequence: 'Stop sequence:',
    bearing: 'Bearing:',
    speed: 'Speed:',
    departureNumber: 'Departure number:'
  },
  table: {
    empty: 'No vehicles!',
    dataRef: 'Vehicle number',
    dataRoute: 'Route',
    dataHeadsign: 'Headsign',
    dataTripId: 'Trip ID',
    dataStartTime: 'Start time',
    action: 'View on map'
  },
  settings: {
    agenciesTitle: 'Agencies',
    agenciesBody: 'On a mobile device, start with one or two agencies, otherwise your device will have trouble keeping up!',
    agenciesApply: 'Apply changes',
    changeRegion: 'Change',
    activeRegion: 'Active',
    otherTitle: 'Other settings',
    otherAutoRefresh: 'Auto refresh',
    otherLanguageLabel: 'Language',
    otherLanguageCaption: 'Langue',
    otherOptOut: 'Opt out from statistics',
    otherChanges: 'Changes in this section are applied instantly.',
    aboutTitle: 'About this application',
    aboutBody: 'This application is made by FelixINX. Data is available through open data programs.' +
      'A problem, a comment or a suggestion? <a href="https://forms.gle/3qGEuNKs7pGKMijs9" class="white--text">Contact me</a>',
    aboutSource: 'Source code',
    aboutContributions: 'Transit Tracker would not be possible without many open source projects and free products, including: <a class="white--text" href="https://vuetifyjs.com">Vuetify</a>, <a class="white--text" href="https://laravel.com">Laravel</a>, <a class="white--text" href="https://ploi.io">Ploi</a> and <a class="white--text" href="https://backpackforlaravel.com/">Backpack</a>.'
  },
  alert: {
    readMore: 'Read more',
    markAsRead: 'Mark as read',
    close: 'Close'
  },
  download: {
    cardTitle: 'Download data',
    loadedTitle: 'Download loaded vehicles',
    loadedDescription: 'This file includes all vehicles currently loaded in the application.',
    allTitle: 'Download all vehicles',
    allDescription: 'This file is generated each hour and is available only in CSV format.',
    agencySelect: 'Agency',
    downloadButton: 'Download'
  },
  onboarding: {
    changeLang: 'En français?',
    welcome: 'Welcome to Transit Tracker',
    headline: 'The public transport network, from home',
    getStarted: 'Get started',
    btnBack: 'Back',
    btnNext: 'Next',
    btnDone: 'Done',
    conditionsTitle: 'Important information',
    conditionsHeadline: 'Please read the following information before proceeding.',
    conditionsBody: '<ul><li>The purpose of this application is to offer an overview of the public transportation network in some regions.</li>' +
      '<li>The data on this website is given as is and should not be used as a public transport timetable. The accuracy and reliability of the data is not guaranteed.</li>' +
      '<li>Data is available through the open data programs of several transit agencies.</li>' +
      '<li>Your preferences are saved in your browser.</li>' +
      '<li>Some data is sent to Matomo, for statistical purposes. These metrics allow me to improve the application depending on the use of certain components. The data remains anonymous at all times. You can, at any time, opt out from statistics by <a href="/opt-out/en">clicking here</a> or with the link located in the application settings.</li></ul>',
    contributions: 'Transit Tracker is an open source project released under the <a href="https://github.com/FelixINX/transit-tracker/blob/master/LICENSE">MIT license</a> and is possible thanks to many open source projects and free products, including : <a href="https://vuetifyjs.com">Vuetify</a>, <a href="https://laravel.com">Laravel</a>, <a href="https://ploi.io">Ploi</a> and <a href="https://backpackforlaravel.com/">Backpack</a>.',
    regionTitle: 'Region',
    regionHeadline: 'Choose the region you want to see first.',
    regionTip: 'Quickly change regions using the map icon, located in the upper right corner',
    agenciesTitle: 'Agencies',
    agenciesHeadline: 'Choose the agencies you want to see.',
    agenciesWarning: 'On a mobile device, start with one or two agencies, otherwise your device will have trouble keeping up!',
    settingsTitle: 'Settings',
    settingsHeadline: 'Customize the experience to your liking.',
    setRefreshLabel: 'Auto refresh',
    setRefreshCaption: 'Fetch new data every minute. Not recommended on mobile connections (3G/LTE).',
    setDarkLabel: 'Dark mode',
    setDarkCaption: 'Reduces battery usage.',
    setPathLabel: 'Default tab',
    setPathCaption: 'Will be displayed by default on each launch.',
    addHomeLabel: 'Add to home screen',
    addHomeCaption: 'Optional. The app will be much easier to find!',
    addHomeButtonInstall: 'Install',
    addHomeButtonSuccess: 'Success',
    addHomeButtonError: 'Error'
  }
}
