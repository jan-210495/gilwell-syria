@php
    $path ??= null;
    $alt ??= '';
    $label ??= 'GilwellSyria';
    $imageUrl = $path && file_exists(public_path($path)) ? asset($path) : null;
@endphp

<div class="media-frame">
    @if ($imageUrl)
        <img class="media-frame__image" src="{{ $imageUrl }}" alt="{{ $alt }}" loading="lazy">
    @else
        <div class="media-frame__placeholder" aria-hidden="true">
            <span>{{ $label }}</span>
        </div>
    @endif
</div>
