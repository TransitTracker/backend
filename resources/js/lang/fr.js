export default {
  app: {
    tabHome: 'Accueil',
    tabMap: 'Carte',
    tabTable: 'Liste',
    tabSettings: 'Réglages',
    snackbarBold: 'Attention!',
    snackbarText: 'Les données de certaines agences ne sont pas à jour et doivent être utilisées avec prudence.',
    snackbarBtn: 'Fermer',
    regionAriaLabel: 'Changer de région'
  },
  home: {
    welcome: 'Bienvenue dans ',
    version: 'Version',
    exitBeta: 'Quitter la version bêta',
    download: 'Télécharger',
    vehicleTotal: 'véhicules actifs',
    secondsAgo: 'secondes',
    minutesAgo: 'minutes',
    outdated: 'Pas à jour',
    creditsTitle: 'Crédits',
    refreshAriaLabel: 'Rafraîchir'
  },
  mapFooter: {
    select: 'Veuillez sélectionner un véhicule pour y consulter toutes les informations'
  },
  mapBottomSheet: {
    close: 'Fermer',
    search: 'Rechercher sur le wiki du CPTDB',
    moreInfo: 'Plus d\'informations sur ',
    route: 'Route :',
    headsign: 'Destination :',
    tripId: 'Trip ID :',
    searchTrip: 'Voir les départs reliés (par Gerbil)',
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
    changeEffect: 'Certains changements ne prendront pas effet avant le prochain démarrage de l\'application.',
    reloadButton: 'Redémarrer',
    agenciesTitle: 'Agences',
    agenciesBody: 'Vous pouvez choisir autant d\'agences que vous le souhaitez. <b>N\'oubliez pas que le nombre d\'agences que vous choisissez ' +
      'aura une incidence sur la taille du téléchargement et les performances de cette application, en particulier sur les appareils mobiles.</b>',
    agenciesTip: 'Utilisez le bouton situé en haut à droite pour changer de région.',
    otherTitle: 'Autres réglages',
    otherAutoRefresh: 'Actualisation automatique',
    otherAutoRefreshMessage: 'Attention! Cette option consomme plus d\'internet. Habituellement, les mises à jours se font à chaque minute.',
    otherDefaultTab: 'Page par défaut lors du démarrage',
    otherLanguage: 'Langue',
    otherTheme: 'Thème',
    otherLightTheme: 'Lumineux',
    otherDarkTheme: 'Sombre',
    aboutTitle: 'À propos de cette application',
    aboutBody: 'Cette application est conçue par FelixINX. Les données sont disponibles grâce aux programmes de données ouvertes. ' +
      'Un problème, un commentaire ou une suggestion? <a href="https://forms.gle/3qGEuNKs7pGKMijs9" class="white--text">Contactez-moi</a>',
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
    conditionsTitle: 'Veuillez lire les informations suivantes avant de continuer :',
    conditionsBody: '<p class="body-1">Cette application à pour but d\'offrir une vue d\'ensemble du réseau de transport en commun dans certaines régions.</p>' +
      '<p class="body-1">Les données de cette application sont présentées telles quelles et ne doivent pas être utilisées comme horaire de transport en commun. L\'exactitude et la fiabilité des données ne sont pas garanties.</p>' +
      '<p class="body-1">Les données sont disponibles grâce aux programmes de données ouvertes de plusieurs agences de transport en commun.</p>' +
      '<p class="body-1">Vos préférences sont sauvegardés dans votre navigateur. Google Analytics est utilisé à des fins statistiques.</p>',
    conditionsAgree: 'Continuer',
    agenciesTitle: 'Choisissez les agences que vous voulez voir :',
    agenciesSelectAll: 'Tout sélectionner',
    agenciesContinue: 'Continuer',
    regionStep: 'Région',
    regionTitle: 'Choisissez la région que vous voulez voir en premier',
    regionChangeLater: 'Vous pouvez toujours changer la région en utilisant l\'icône de carte, situé dans le coin supérieur droit',
    regionContinue: 'Continuer',
    settingsTitle: 'Réglages',
    settingsChangeLater: 'Tous les réglages peuvent être changer par la suite.',
    settingsDone: 'Terminer',
    toolbarTitle: 'Configuration',
    cancel: 'Annuler'
  },
  alert: {
    readMore: 'Lire plus',
    markAsRead: 'Marquer comme lu',
    close: 'Fermer'
  },
  download: {
    cardTitle: 'Télécharger des données',
    loadedTitle: 'Télécharger les véhicules chargés',
    loadedDescription: 'Ce fichier comprend tous les véhicules actuellement chargés dans l\'application.',
    allTitle: 'Télécharger tous les véhicules',
    allDescription: 'Ce fichier est généré toutes les heures et n\'est disponible qu\'au format CSV.',
    agencySelect: 'Agence',
    downloadButton: 'Télécharger'
  }
}
