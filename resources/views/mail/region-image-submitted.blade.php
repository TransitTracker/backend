<x-mail::message>
# New Region Image Submission

A new header image has been submitted for the **{{ $regionImage->region->name }}** region.

**Author:** {{ $regionImage->author_name }}
@if($regionImage->author_link)
**Author Link:** {{ $regionImage->author_link }}
@endif

**Description:**
{{ $regionImage->description }}

<x-mail::button :url="route('filament.admin.resources.region-images.edit', ['record' => $regionImage->id])">
Review in Filament
</x-mail::button>

Thanks,<br>
{{ config('app.name') }}
</x-mail::message>
