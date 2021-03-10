<div class="m-t-10 m-b-10 p-l-10 p-r-10 p-t-10 p-b-10">
    <div class="row">
        <div class="col-12 col-md-6">
            <small>Static info</small>
            <p class="mb-1"><b>GTFS trip:</b> {{ $entry->gtfs_trip }}</p>
            <p class="mb-1"><b>Route:</b> {{ $entry->route }}</p>
            <p class="mb-1"><b>Start:</b> {{ $entry->start }}</p>
            <p class="mb-1"><b>Stop sequence:</b> {{ $entry->stop_sequence }}</p>
            <p class="mb-1"><b>Bearing:</b> {{ $entry->bearing }}</p>
            <p class="mb-1"><b>Speed:</b> {{ $entry->speed }}</p>
            <p class="mb-1"><b>Position:</b> {{ $entry->lat }}, {{ $entry->lon }}</p>
        </div>
        <div class="col-12 col-md-6">
            <small>Trip relationship</small>
            <p class="mb-1"><b>Internal trip_id:</b> {{ $entry->trip_id }}</p>
            <p class="mb-1"><b>Trip id:</b> {{ $entry->trip->trip_id }}</p>
            <p class="mb-1"><b>Trip headsign:</b> {{ $entry->trip->trip_headsign }}</p>
            <p class="mb-1"><b>Trip short name:</b> {{ $entry->trip->trip_short_name }}</p>
            <p class="mb-1"><b>Route color:</b> <span class="badge" style="background-color: {{ $entry->trip->route_color }}">&nbsp;</span> {{ $entry->trip->route_color }}</p>
            <p class="mb-1"><b>Route text color:</b> <span class="badge" style="background-color: {{ $entry->trip->route_text_color }}">&nbsp;</span> {{ $entry->trip->route_text_color }}</p>
            <p class="mb-1"><b>Route short name:</b> {{ $entry->trip->route_short_name }}</p>
            <p class="mb-1"><b>Route long name:</b> {{ $entry->trip->route_long_name }}</p>
            <p class="mb-1"><b>Internal service_id:</b> {{ $entry->trip->service_id }}</p>
        </div>
    </div>
</div>
<style>
    .color-preview {
        width: 15px;
        height: 15px;
    }
    .badge {
        width: 18px;
    }
</style>
<div class="clearfix"></div>