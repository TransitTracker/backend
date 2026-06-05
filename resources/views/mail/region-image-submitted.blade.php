<x-mail::message>
# New Region Image Submission

**{{ $regionImages->count() }}** new header images have been submitted for the **{{ $regionImages->first()->region->name }}** region.

**Author:** {{ $regionImages->first()->author_name }}
@if($regionImages->first()->author_link)
**Author Link:** {{ $regionImages->first()->author_link }}
@endif

**Description:**
{{ $regionImages->first()->description }}

You can review and accept individual images in the Filament admin panel:

<x-mail::button :url="route('filament.admin.resources.region-images.index')">
Open Region Images
</x-mail::button>

Thanks,<br>
{{ config('app.name') }}
</x-mail::message>