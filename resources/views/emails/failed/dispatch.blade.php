@component('mail::message')
# [App\Jobs\DispatchAgencies] {{ $agencySlug }} has failed

<div class="code">{{ $responseString }}</div>

@component('mail::button', ['url' => env('APP_URL') . '/horizon'])
    Launch Horizon
@endcomponent

@component('mail::button', ['url' => env('APP_URL') . '/admin'])
    Launch the admin panel
@endcomponent

<style>
    .code {
        overflow-wrap: break-word;
        padding: 10px;
        background-color: #2d3648;
        color: white;
        border-radius: 5px;
        margin-bottom: 15px;3309
    }
</style>

@endcomponent
