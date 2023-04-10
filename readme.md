# Backend for Transit Tracker

This repository contains the backend services for [Transit Tracker](https://transittracker.ca). The server is powered by a Laravel application (PHP). The main application is hosted in the [frontend](https://github.com/transittracker/frontend) repository (a NuxtJS app), but some frontend parts are hosted here (will be detailled below).

## Parts

- [Developper home page](https://api.transittracker.ca/)
- API : currently [V2](https://api.transittracker.ca/v2), V2.1 coming soon
- [exo VIN Project](https://api.transittracker.ca/vin): a collaborative effort to associate VIN numbers to fleet numbers. exo GTFS-RT feeds only include the Vehicule Identification Number (VIN) as a Vehicule ID.
- Admin panel (with Filament)

## Services

The backend services use multiple services, some hosted on the same server and other hosted elsewere. Where possible, a local installation is preffered.

For local developpement, only a small portion of those services are necessary to run the base application. Optional service might throw an error, but can be ignored.

### MySQL

**Required.**

SQLite can work, but some migrations will not run. MySQL is the recommended way to go.

### Redis

**Required.**

Used for caching and job management (through Horizon).

### Horizon

**Mandatory, but can be replaced with `php artisan queue:work`**

[Laravel Horizon](https://laravel.com/docs/10.x/horizon) is the services use to manage the queues where long running jobs are running.

To start the service, run `php artisan horizon`

The following queue are used (a redesign is coming):

- `vehicles` Realtime data update
- `notifications` All notifications
- `gtfs` Static data update
- `ohdear` Jobs related to the OhDear monitoring service
- `misc` All others jobs

### Websockets

Optional.

Used for frontend automatic realtime refresh. Using [Beyond Code Laravel Websockets](https://beyondco.de/docs/laravel-websockets/getting-started/introduction).

### Slack

Optional.

Used for admin notifications about late jobs and invalid static data.

### OhDear

Optional.

Used for monitoring on production, everything running well.

### Cloudflare Turnstile

Optional.

Used for VIN suggestion human validation. Bypassed on local.

### print-gtfs-rt-cli

Optional.

Used for some GTFS-RT feeds that do not work with the PHP implementation (so far, Zenbus feeds).

## Run the server

### Requirements

- PHP (^8.1) with [all extensions required](https://laravel.com/docs/10.x/deployment#server-requirements) by Laravel
- MySQL
- Redis
- Yarn (or npm)

1. `composer install`
2. `cp .env.example .env` check the settings and make sure to create a database
3. `php artisan key:generate`
4. `php artisan migrate`
5. `php artisan horizon:publish`
6. `yarn install`
7. `php artisan tinker` then create a user
   1. `User::create(['name' => 'Admin', 'email' => 'admin@example.org', 'password' => bcrypt('password')]);`
   2. Don’t forget to adjust the `.env` variables, `MAIL_TO`
8. Go to `/admin` and create a region and an agency to get started

### Commands to run the server

One process each.

1. `yarn dev`
2. `php artisan serve`
3. `php artisan horizon`
4. `php artisan websocket:serve`

### Current deploy script

For production environnement.

```bash
php artisan migrate --force

yarn install
yarn build

php artisan config:cache
php artisan event:cache
php artisan horizon:terminate
php artisan horizon:publish
php artisan log-viewer:publish
php artisan icons:cache
php artisan route:cache
php artisan schedule-monitor:sync
php artisan view:cache
php artisan websockets:restart
```
