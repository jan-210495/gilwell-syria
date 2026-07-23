@php
    $eyebrow ??= null;
    $summary ??= null;
    $actions ??= [];
@endphp

<header class="page-hero page-hero--substantial">
    <div class="page-hero__content">
        @if ($eyebrow)
            <p class="eyebrow">{{ $eyebrow }}</p>
        @endif
        <h1>{{ $title }}</h1>
        @if ($summary)
            <p class="lead">{{ $summary }}</p>
        @endif
        @if ($actions !== [])
            <div class="action-row">
                @foreach ($actions as $action)
                    <a class="button {{ $action['variant'] ?? 'button--secondary' }}" href="{{ $action['href'] }}">
                        {{ $action['label'] }}
                    </a>
                @endforeach
            </div>
        @endif
    </div>
</header>
