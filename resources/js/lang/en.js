export default {
  app: {
    tabHome: 'Home',
    tabMap: 'Map',
    tabTable: 'Table',
    tabSettings: 'Settings',
    snackbarBold: 'Warning!',
    snackbarText: 'Data from some agencies are outdated and should be used with caution.',
    snackbarBtn: 'Close'
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
    creditsTitle: 'Credits'
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
    changeEffect: 'Some changes will not take effect before the next application startup.',
    reloadButton: 'Restart',
    agenciesTitle: 'Agencies',
    agenciesBody: 'You can select as many agencies as you want. <b>Please remember that the number of agencies you ' +
      'choose will impact the download size and the performance of this application, especially on mobile devices.</b>',
    otherTitle: 'Other settings',
    otherAutoRefresh: 'Auto refresh',
    otherAutoRefreshMessage: 'Warning! This option consumes more internet. Usually, updates are done every minute.',
    otherDefaultTab: 'Default tab on launch',
    otherLanguage: 'Language',
    otherTheme: 'Theme',
    otherLightTheme: 'Light',
    otherDarkTheme: 'Dark',
    aboutTitle: 'About this application',
    aboutBody: 'This application is made by FelixINX. Data is available through open data programs.' +
      'A problem, a comment or a suggestion? <a href="https://forms.gle/3qGEuNKs7pGKMijs9" class="white--text">Contact me</a>',
    aboutSource: 'Source code'
  },
  configuration: {
    languageStep: 'Language',
    conditionsStep: 'Conditions',
    agenciesStep: 'Agencies',
    settingsStep: 'Settings',
    languageTitle: 'Welcome to Montréal Transit Tracker',
    languageBody: 'Version 2.0 &mdash; This is a beta version, please report any bug on ' +
      '<a href="https://cptdb.ca/topic/19090-montr%C3%A9al-transit-tracker/">CPTDB</a> or ' +
      '<a href="https://github.com/felixinx/montreal-transit-tracker/issues">GitHub</a>',
    conditionsTitle: 'Please read the following information before continuing:',
    conditionsBody: '<p class="body-1">The purpose of this application is to offer an overview of the public transportation network in some regions.</p>' +
      '<p class="body-1">The data on this website is given as is and should not be used as a public transport timetable. The accuracy and reliability of the data is not guaranteed.</p>' +
      '<p class="body-1">Data is available through the open data programs of several transit agencies.</p>' +
      '<p class="body-1">Your preferences are saved in your browser. Google Analytics is used for statistical purposes.</p>',
    conditionsAgree: 'Continue',
    agenciesTitle: 'Choose the agencies you want to see:',
    agenciesSelectAll: 'Select all',
    agenciesContinue: 'Continue',
    regionStep: 'Region',
    regionTitle: 'Choose the region you want to see first',
    regionChangeLater: 'You can always change the region later using the map icon, located in the top right corner',
    regionContinue: 'Continue',
    settingsTitle: 'Settings',
    settingsChangeLater: 'All settings can be changed later.',
    settingsDone: 'Done',
    toolbarTitle: 'Configuration',
    cancel: 'Cancel'
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
  }
}
