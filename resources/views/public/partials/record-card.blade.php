@php
    $title ??= '';
    $summary ??= '';
    $url ??= null;
    $label ??= null;
    $meta ??= null;
    $imagePath ??= null;
    $imageAlt ??= $title;
    $actionLabel ??= null;
    $external ??= false;
@endphp

<article class="content-card">
    @include('public.partials.media-frame', [
        'path' => $imagePath,
        'alt' => $imageAlt,
        'label' => $label ?: $title,
    ])
    <div class="content-card__body">
        @if ($label)
            <p class="eyebrow">{{ $label }}</p>
        @endif
        <h3>
            @if ($url)
                <a href="{{ $url }}" @if ($external) target="_blank" rel="noopener noreferrer" @endif>{{ $title }}</a>
            @else
                {{ $title }}
            @endif
        </h3>
        @if ($summary)
            <p>{{ $summary }}</p>
        @endif
        @if ($meta)
            <p class="meta">{{ $meta }}</p>
        @endif
        @if ($url && $actionLabel)
            <a class="text-link" href="{{ $url }}" @if ($external) target="_blank" rel="noopener noreferrer" @endif>{{ $actionLabel }}</a>
        @endif
    </div>
</article>
