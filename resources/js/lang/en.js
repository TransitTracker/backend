export default {
  app: {
    name: 'Montréal Transit Tracker',
    tabHome: 'Home',
    tabMap: 'Map',
    tabTable: 'Table',
    tabSettings: 'Settings',
    snackbarBold: 'Warning!',
    snackbarText: 'Data from some agencies are outdated and should be used with caution.',
    snackbarBtn: 'Close'
  },
  home: {
    welcome: 'Welcome to',
    version: 'Version',
    exitBeta: 'Exit beta version',
    vehicleTotal: 'vehicles are active',
    secondsAgo: 'seconds ago',
    minutesAgo: 'minutes ago',
    outdated: 'Outdated',
    whatsNewTitle: 'What\'s new?',
    whatsNewBody: '<b>Montréal Transit Tracker version 2 introduces several new features and changes that enhance your experience.</b>' +
      '<ul>' +
      '<li>New interface</li>' +
      '<li>More agencies</li>' +
      '<li>Auto refresh</li>' +
      '<li>Detailed information on vehicles and their trip</li>' +
      '</ul>',
    communityTitle: 'Community',
    communityBody: 'Visit the <a href="https://cptdb.ca" class="white--text">Canadian Public Transit Discussion Board</a> ' +
      'to share your sightings. For more information on agencies and vehicles, visit the ' +
      '<a href="https://cptdb.ca/wiki/index.php/Main_Page" class="white--text">wiki</a>. To discuss about this application, ' +
      'visit the <a href="https://cptdb.ca/topic/19090-montr%C3%A9al-transit-tracker/php" class="white--text">official thread</a>.'
  },
  mapFooter: {
    select: 'Please select a vehicle to see more information'
  },
  mapBottomSheet: {
    close: 'Close',
    search: 'Search on CPTDB wiki',
    moreInfo: 'More info on',
    headsign: 'Headsign:',
    tripId: 'Trip ID:',
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
    changeEffect: 'Agencies changes will not be taken into account until the next refresh or the next start of the application.',
    agenciesTitle: 'Agencies',
    agenciesBody: 'You can select as many agencies as you want. <b>Please remember that the number of agencies you ' +
      'choose will impact the download size and the performance of this application, especially on mobile devices.</b>',
    otherTitle: 'Other settings',
    otherAutoRefresh: 'Auto refresh',
    otherDefaultTab: 'Default tab on launch',
    otherLanguage: 'Language',
    aboutTitle: 'About this application',
    aboutBody: 'This application is made by FelixINX. Data is from the <a class="white--text" href="https://stm.info">Société de ' +
      'transport de Montréal</a>, the <a class="white--text" href="https://stl.laval.qc.ca">Société de transport de Laval</a> trough ' +
      '<a class="white--text" href="https://nextbus.com">Nextbus</a> and <a class="white--text" href="https://exo.quebec">exo</a>.',
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
    conditionsTitle: 'Please read and accept the terms below before continuing:',
    conditionsBody: '<p class="body-1">The data on this website is given as is and should not be used as a public transport timetable. The accuracy and reliability of the data is not guaranteed.</p>' +
      '<p class="body-1">Montreal Transit Tracker, Société de transport de Montréal, Société de transport de Laval and exo are not responsible for the use of the data presented on this site.</p>' +
      '<p class="body-1">The data comes from the following agencies:</p>' +
      '<ul class="body-1 mb-4">' +
      '<li><a href="http://stm.info">Société de transport de Montréal (STM)</a></li>' +
      '<li><a href="https://stl.laval.qc.ca">Société de transport de Laval (STL)</a></li>' +
      '<li><a href="https://exo.quebec">exo</a> (including exo buses, exo trains and Réseau de transport de Longueuil buses)</li>' +
      '</ul>' +
      '<p class="body-2">The above data are all available under the <a href="https://creativecommons.org/licenses/by/4.0/deed.en">Creative Common 4.0 CC BY</a> license.</p>' +
      '<p class="body-2">Google Analytics is used for statistical purposes. During beta versions, when an error occurs, some data will be sent to Bugsnap to help resolve errors and bugs.</p>',
    conditionsAgree: 'I agree, continue',
    agenciesTitle: 'Choose the agencies you want to see:',
    agenciesContinue: 'Continue',
    settingsTitle: 'Settings',
    settingsDone: 'Done'
  },
  alert: {
    readMore: 'Read more',
    markAsRead: 'Mark as read',
    close: 'Close'
  }
}
