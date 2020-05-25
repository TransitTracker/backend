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
    emptyTitle: 'Aucune agence sélectionnée',
    emptyBody: 'Vous n\'avez pas sélectionné d\'agence pour cette région. Rendez-vous dans les réglages pour ajouter des agences ou changez de région en utilisant le bouton du coin supérieur droit.',
    emptyButton: 'Ajouter des agences',
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
    agenciesTitle: 'Agences',
    agenciesBody: 'Sur un appareil mobile, commencez avec une ou deux agences, l\'application sera plus performante!',
    agenciesApply: 'Appliquer les changements',
    changeRegion: 'Changer',
    activeRegion: 'Active',
    otherTitle: 'Autres réglages',
    otherLanguageLabel: 'Langue',
    otherLanguageCaption: 'Language',
    otherOptOut: 'Se retirer des statistiques',
    otherChanges: 'Les changements dans cette section sont appliqués instantanément.',
    aboutTitle: 'À propos de cette application',
    aboutBody: 'Cette application est conçue par FelixINX. Les données sont disponibles grâce aux programmes de données ouvertes. ' +
      'Un problème, un commentaire ou une suggestion? <a href="https://forms.gle/3qGEuNKs7pGKMijs9" class="white--text">Contactez-moi</a>',
    aboutSource: 'Code source',
    aboutContributions: 'L\'application Transit Tracker ne serait pas possible sans de nombreux projets open-source et produits gratuits, dont : <a class="white--text" href="https://vuetifyjs.com">Vuetify</a>, <a class="white--text" href="https://laravel.com">Laravel</a>, <a class="white--text" href="https://ploi.io">Ploi</a> et <a class="white--text" href="https://backpackforlaravel.com/">Backpack</a>.'
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
  },
  onboarding: {
    changeLang: 'In English?',
    welcome: 'Bienvenue dans Transit Tracker',
    headline: 'Le réseau de transport en commun, à partir de la maison',
    getStarted: 'Commencer',
    btnBack: 'Précédent',
    btnNext: 'Suivant',
    btnDone: 'Terminer',
    conditionsTitle: 'Informations importantes',
    conditionsHeadline: 'Veuillez lire les informations suivantes avant de continuer.',
    conditionsBody: '<ul><li>Cette application a pour but d\'offrir une vue d\'ensemble du réseau de transport en commun dans certaines régions.</li>' +
      '<li>Les données de cette application sont présentées telles quelles et ne doivent pas être utilisées comme horaire de transport en commun. L\'exactitude et la fiabilité des données ne sont pas garanties.</li>' +
      '<li>Les données sont disponibles grâce aux programmes de données ouvertes de plusieurs agences de transport en commun.</li>' +
      '<li>Vos préférences sont sauvegardées dans votre navigateur.</li>' +
      '<li>Quelques données sont transmises à Matomo, à des fins de statistiques. Ces données me permettent d\'améliorer l\'application en fonction de l\'usage de certaines composantes. En tout temps, les données restent anonymes. Vous pouvez, à n\'importe quel moment, vous retirer des statistiques en <a href="/opt-out/fr">cliquant ici</a> ou avec le lien situé dans les paramètres de l\'application.</li></ul>',
    contributions: 'Transit Tracker est un projet open source distribué sous <a href="https://github.com/FelixINX/transit-tracker/blob/master/LICENSE">licence MIT</a> ne serait pas possible sans de nombreux projets open source et produits gratuits, dont : <a href="https://vuetifyjs.com">Vuetify</a>, <a href="https://laravel.com">Laravel</a>, <a href="https://ploi.io">Ploi</a> et <a href="https://backpackforlaravel.com/">Backpack</a>.',
    regionTitle: 'Région',
    regionHeadline: 'Choisissez la région que vous voulez voir en premier.',
    regionTip: 'Changer rapidement de région en utilisant l\'icône de carte, situé dans le coin supérieur droit',
    agenciesTitle: 'Agences',
    agenciesHeadline: 'Choisissez les agences que vous voulez voir.',
    agenciesWarning: 'Sur un appareil mobile, commencez avec une ou deux agences, l\'application sera plus performante!',
    settingsTitle: 'Réglages',
    settingsHeadline: 'Personnalisez l\'expérience à votre goût.',
    setRefreshLabel: 'Actualisation automatique',
    setRefreshCaption: 'Mise à jour des données à chaque minute. Non recommandé sur les connexions mobiles (3G/LTE).',
    setDarkLabel: 'Thème sombre',
    setDarkCaption: 'Réduit l\'utilisation de la batterie.',
    setPathLabel: 'Page par défaut',
    setPathCaption: 'Sera affiché à chaque lancement de l\'application.',
    addHomeLabel: 'Ajouter à l\'écran d\'accueil',
    addHomeCaption: 'Optionel. Beaucoup plus facile à trouver!',
    addHomeButtonInstall: 'Installer',
    addHomeButtonSuccess: 'Succès',
    addHomeButtonError: 'Erreur'
  }
}
