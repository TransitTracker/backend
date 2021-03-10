<!-- PROJECT SHIELDS -->
<!--
*** I'm using markdown "reference style" links for readability.
*** Reference links are enclosed in brackets [ ] instead of parentheses ( ).
*** See the bottom of this document for the declaration of the reference variables
*** for contributors-url, forks-url, etc. This is an optional, concise syntax you may use.
*** https://www.markdownguide.org/basic-syntax/#reference-style-links
-->
[![Forks][forks-shield]][forks-url]
[![Stargazers][stars-shield]][stars-url]
[![Issues][issues-shield]][issues-url]
[![MIT License][license-shield]][license-url]



<!-- PROJECT LOGO -->
<br />
<p align="center">
  <a href="https://github.com/felixinx/transit-tracker">
    <img src="https://raw.githubusercontent.com/FelixINX/transit-tracker/master/public/svg/logo.svg" alt="Logo" width="80" height="80">
  </a>

  <h3 align="center">Transit Tracker</h3>

  <p align="center">
    An application to view almost all public transport buses, trains and trams, in the Montreal and Toronto regions
    <br />
    <a href="https://transittracker.ca"><strong>Launch the app »</strong></a>
    <br />
    <br />
    <a href="https://github.com/felixinx/transit-tracker/issues">Report Bug</a>
    ·
    <a href="https://github.com/felixinx/transit-tracker/issues">Request Feature</a>
  </p>
</p>



<!-- TABLE OF CONTENTS -->
## Table of Contents

* [About the Project](#about-the-project)
  * [Built With](#built-with)
* [Getting Started](#getting-started)
  * [Prerequisites](#prerequisites)
  * [Installation](#installation)
* [Usage](#usage)
* [Contributing](#contributing)
* [License](#license)
* [Contact](#contact)
* [Acknowledgements](#acknowledgements)



<!-- ABOUT THE PROJECT -->
## About The Project

[![Product Name Screen Shot][product-screenshot]](https://transittracker.ca)

The goal: to see the thousands of STM buses on a single map. After a first version, Transit Tracker version 2 appears with a new interface, new functionalities and new agencies, including exo and RTL, as well as TTC in Toronto!

### Built With

* [Laravel](https://github.com/laravel/laravel)
* [VueJS](https://github.com/vuejs/vue)
* [Vuetify](https://github.com/vuetifyjs/vuetify)



<!-- GETTING STARTED -->
## Getting Started

To get a local copy up and running follow these simple steps.

### Prerequisites

You will have to install the following software on your machine.
* PHP 
* NodeJS and npm
* Composer

### Installation
 
1. Clone the repo
```sh
git clone https://github.com/felixinx/transit-tracker.git
``` 
2. Edit the environment variables
3. Install Composer dependencies
```sh
composer install
```
4. Install npm packages
```sh
npm install
```
5. Generate the front-end UI
```sh
npm run dev
```
5. Migrate the database
```sh
php artisan migrate
```
6. Publish Horizon assets
```sh
php artisan horizon:publish
```

<!-- CONTRIBUTING -->
## Contributing

Contributions are what make the open source community such an amazing place to be learn, inspire, and create. Any contributions you make are **greatly appreciated**.

1. Fork the Project
2. Create your Feature Branch (`git checkout -b feature/AmazingFeature`)
3. Commit your Changes (`git commit -m 'Add some AmazingFeature'`)
4. Push to the Branch (`git push origin feature/AmazingFeature`)
5. Open a Pull Request



<!-- LICENSE -->
## License

Distributed under the MIT License. See `LICENSE` for more information.



<!-- CONTACT -->
## Contact

Félix Desjardins - [@felixinx](https://twitter.com/felixinx)

Project Link: [https://transittracker.ca](https://transittracker.ca)

Twitter: [https://twitter.com/ttrackerca](https://twitter.com/ttrackerca)



<!-- ACKNOWLEDGEMENTS -->
## Acknowledgements

This project is possible thanks to the open data programs of public transport organizations.





<!-- MARKDOWN LINKS & IMAGES -->
[forks-shield]: https://img.shields.io/github/forks/felixinx/transit-tracker.svg?style=flat-square
[forks-url]: https://github.com/felixinx/transit-tracker/network/members
[stars-shield]: https://img.shields.io/github/stars/felixinx/transit-tracker.svg?style=flat-square
[stars-url]: https://github.com/felixinx/transit-tracker/stargazers
[issues-shield]: https://img.shields.io/github/issues/felixinx/transit-tracker.svg?style=flat-square
[issues-url]: https://github.com/felixinx/transit-tracker/issues
[license-shield]: https://img.shields.io/github/license/felixinx/transit-tracker.svg?style=flat-square
[license-url]: https://github.com/felixinx/transit-tracker/blob/master/LICENSE.txt
[product-screenshot]: public/img/demo.png