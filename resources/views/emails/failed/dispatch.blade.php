@component('mail::message')
# [App\Jobs\DispatchAgencies] {{ $agencySlug }} has failed

<div class="code">{{ $responseString }}</div>

Snooze notifications for this error:
- [for 2 hours]({{ $failedJob->signedSnoozeUrl(2) }})
- [for a day]({{ $failedJob->signedSnoozeUrl(24) }})
- [for 1 year]({{ $failedJob->signedSnoozeUrl(24 * 365) }})


@component('mail::button', ['url' => env('APP_URL') . '/admin'])
    Launch admin panel
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
