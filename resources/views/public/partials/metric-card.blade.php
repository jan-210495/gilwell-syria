<article class="metric-card metric-card--proof" data-reveal>
    <p class="metric-card__value">{{ $metric->value }} @if ($unit !== '')<span>{{ $unit }}</span>@endif</p>
    <h3>{{ $label }}</h3>
    @if ($description !== '')
        <p>{{ $description }}</p>
    @endif
</article>
