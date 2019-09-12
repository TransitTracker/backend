export default {
  app: {
    name: 'Montréal Transit Tracker',
    tabHome: 'Accueil',
    tabMap: 'Carte',
    tabTable: 'Tableau',
    tabSettings: 'Réglages',
    snackbarBold: 'Attention!',
    snackbarText: 'Les données de certaines agences ne sont pas à jour et doivent être utilisées avec prudence.',
    snackbarBtn: 'Fermer'
  },
  home: {
    welcome: 'Bienvenue dans',
    version: 'Version',
    exitBeta: 'Quitter la version bêta',
    vehicleTotal: 'véhicules actifs',
    secondsAgo: 'secondes',
    minutesAgo: 'minutes',
    outdated: 'Pas à jour',
    whatsNewTitle: 'Quoi de neuf?',
    whatsNewBody: '<b>Montréal Transit Tracker version 2 introduit plusieurs nouvelles fonctionnalités et modifications pour améliorer votre expérience.</b>' +
      '<ul>' +
      '<li>Nouvelle interface</li>' +
      '<li>Beaucoup plus d\'agences (STL, autobus d\'exo et RTL)</li>' +
      '<li>Actualisation automatique</li>' +
      '<li>Informations détaillées sur les véhicules et leurs voyages</li>' +
      '<li>Traduction en français</li>' +
      '</ul>',
    communityTitle: 'Communauté',
    communityBody: 'Visitez le <a href="https://cptdb.ca" class="white--text">Canadian Public Transit Discussion Board (en anglais)</a> ' +
      'ou les <a href="http://metrodemontreal.com/forum/index.php" class="white--text">forums metrodemontreal.com</a> ' +
      'pour partagez vos observations. Pour plus d\'informations sur les agences et leurs véhicules, visitez le ' +
      '<a href="https://cptdb.ca/wiki/index.php/Main_Page" class="white--text">wiki (en anglais)</a>. Pour discuter de cette application, ' +
      'rendez-vous sur le sujet officiel <a href="https://cptdb.ca/topic/19090-montr%C3%A9al-transit-tracker/" class="white--text">en anglais, sur CPTDB</a> ' +
      'ou <a href="#" class="white--text">en français, sur les forums metrodemontreal.com</a>.'
  },
  mapFooter: {
    select: 'Veuillez sélectionner un véhicule pour y consulter toutes les informations'
  },
  mapBottomSheet: {
    close: 'Fermer',
    search: 'Rechercher sur le wiki du CPTDB',
    moreInfo: 'Plus d\'informations sur ',
    headsign: 'Destination :',
    tripId: 'Trip ID :',
    startTime: 'Heure de départ :',
    status: 'Statut :',
    stopSequence: 'Séquence d\'arrêt :',
    bearing: 'Direction :',
    speed: 'Vitesse :',
    departureNumber: 'Numéro du départ :'
  },
  table: {
    empty: 'Aucun véhicules !',
    dataRef: 'Numéro du véhicule',
    dataRoute: 'Route',
    dataHeadsign: 'Destination',
    dataTripId: 'Trip ID',
    dataStartTime: 'Heure de départ',
    action: 'Voir sur la carte'
  },
  settings: {
    changeEffect: 'Les changements d\'agences ne seront pas pris en compte avant la prochaine actualisation ou le prochain démarrage de l\'application.',
    agenciesTitle: 'Agences',
    agenciesBody: 'Vous pouvez choisir autant d\'agences que vous le souhaitez. <b>N\'oubliez pas que le nombre d\'agences que vous choisissez ' +
      'aura une incidence sur la taille du téléchargement et les performances de cette application, en particulier sur les appareils mobiles.</b>',
    otherTitle: 'Autres réglages',
    otherAutoRefresh: 'Actualisation automatique',
    otherDefaultTab: 'Page par défaut lors du démarrage',
    otherLanguage: 'Langue',
    aboutTitle: 'À propos de cette application',
    aboutBody: 'Cette application est conçue par FelixINX. Les données proviennent de la <a class="white--text" href="https://stm.info">Société de ' +
      'transport de Montréal</a>, la <a class="white--text" href="https://stl.laval.qc.ca">Société de transport de Laval</a> via ' +
      '<a class="white--text" href="https://nextbus.com">Nextbus</a> et <a class="white--text" href="https://exo.quebec">exo</a>.',
    aboutSource: 'Code source'
  },
  configuration: {
    languageStep: 'Langue',
    conditionsStep: 'Conditions',
    agenciesStep: 'Agences',
    settingsStep: 'Réglages',
    languageTitle: 'Bienvenue dans Montréal Transit Tracker',
    languageBody: 'Version 2.0 - Ceci est une version bêta, veuillez reporter tout bugs sur ' +
      '<a href="https://cptdb.ca/topic/19090-montr%C3%A9al-transit-tracker/">CPTDB (en anglais)</a>, ' +
      '<a href="#">metrodemontreal.com (bientôt)</a> ou ' +
      '<a href="https://github.com/felixinx/montreal-transit-tracker/issues">GitHub</a>',
    conditionsTitle: 'Veuillez lire et accepter les conditions ci-dessous avant de continuer :',
    conditionsBody: '<p class="body-1">Les données sur ce site sont données telles quelles et ne doivent pas être utilisées comme horaire de transport en commun. L\'exactitude et la fiabilité des données ne sont pas garanties.</p>' +
      '<p class="body-1">Montréal Transit Tracker, la Société de transport de Montréal, la Société de transport de Laval et exo ne sont pas responsables de l\'utilisation des données présentées sur ce site.</p>' +
      '<p class="body-1">Les données proviennent des agences suivantes:</p>' +
      '<ul class="body-1 mb-4">' +
      '<li><a href="http://stm.info">Société de transport de Montréal (STM)</a></li>' +
      '<li><a href="https://stl.laval.qc.ca">Société de transport de Laval (STL)</a></li>' +
      '<li><a href="https://exo.quebec">exo</a> (incluant les autobus d\'exo, les trains d\'exo et les autobus du Réseau de transport de Longueuil)</li>' +
      '</ul>' +
      '<p class="body-2">Les données ci-dessus sont toutes disponibles sous la licence  <a href="https://creativecommons.org/licenses/by/4.0/deed.en">Creative Common 4.0 CC BY</a>.</p>' +
      '<p class="body-2">Google Analytics est utilisé à des fins statistiques. Durant la version bêta, lorsqu\'une erreur se produit, certaines données sont envoyées à Bugsnap pour aider à résoudre les erreurs et les bogues.</p>',
    conditionsAgree: 'J\'accepte, continuer',
    agenciesTitle: 'Choisissez les agences que vous voulez voir :',
    agenciesContinue: 'Continuer',
    settingsTitle: 'Réglages',
    settingsDone: 'Terminer'
  }
}
