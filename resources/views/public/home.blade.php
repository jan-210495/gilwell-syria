@php
    $siteName = $field($settings, 'site_name', 'GilwellSyria');
    $title = $field($page, 'seo_title', $siteName);
    $heroTitle = $siteName;
    $heroSummary = $field($settings, 'tagline', $field($page, 'summary'));
    $heroBody = $field($page, 'body');
    $heroImage = asset('images/gilwellsyria-hero-training.png');
    $heroImageWebp = asset('images/gilwellsyria-hero-training.webp');
@endphp

@extends('public.layout')

@section('title', $title)
@section('description', $field($page, 'seo_description', $heroSummary))
@section('preload')
    <link rel="preload" as="image" href="{{ $heroImageWebp }}" type="image/webp" fetchpriority="high">
@endsection

@section('content')
    <section class="home-hero home-hero--editorial" style="--hero-image-fallback: url('{{ $heroImage }}'); --hero-image: image-set(url('{{ $heroImageWebp }}') type('image/webp'), url('{{ $heroImage }}') type('image/png'))">
        <div class="home-hero__inner">
            <div class="home-hero__content">
                <p class="eyebrow">{{ $labels['home'] }}</p>
                <h1>{{ $heroTitle }}</h1>
                @if ($heroSummary !== '')
                    <p class="lead">{{ $heroSummary }}</p>
                @endif
                @include('public.partials.body', ['body' => $heroBody])
                <div class="action-row">
                    <a class="button button--primary" href="{{ url("/{$locale}/contact") }}">{{ $labels['contact'] }}</a>
                    <a class="button button--secondary" href="{{ url("/{$locale}/contact") }}">{{ $labels['partner_with_us'] }}</a>
                    <a class="button button--text" href="{{ url("/{$locale}/programs") }}">{{ $labels['explore_programs'] }}</a>
                </div>
            </div>
        </div>
    </section>

    <section class="credibility-strip">
        <div class="section__header">
            <p class="eyebrow">{{ $labels['impact'] }}</p>
            <h2>{{ $labels['impact'] }}</h2>
        </div>
        @if ($impactMetrics->isNotEmpty())
            <div class="metric-grid">
                @foreach ($impactMetrics as $metric)
                    @include('public.partials.metric-card', [
                        'metric' => $metric,
                        'label' => $field($metric, 'label'),
                        'unit' => $field($metric, 'unit'),
                        'description' => $field($metric, 'description'),
                    ])
                @endforeach
            </div>
        @else
            @include('public.partials.empty-state', ['message' => $labels['empty_impact']])
        @endif
    </section>

    <section class="section section--program-feature">
        <div class="section__header">
            <p class="eyebrow">{{ $labels['latest_programs'] }}</p>
            <h2>{{ $labels['programs'] }}</h2>
        </div>
        @if ($programs->isNotEmpty())
            <div class="card-grid">
                @foreach ($programs as $program)
                    @include('public.partials.record-card', [
                        'title' => $field($program, 'title'),
                        'summary' => $field($program, 'summary'),
                        'url' => url("/{$locale}/programs/{$program->slug}"),
                        'label' => $labels['programs'],
                        'imagePath' => $program->image_path,
                        'actionLabel' => $labels['read_program'],
                    ])
                @endforeach
            </div>
        @else
            @include('public.partials.empty-state', ['message' => $labels['empty_programs']])
        @endif
    </section>

    <section class="section section--partner-wall">
        <div class="section__header">
            <p class="eyebrow">{{ $labels['partners'] }}</p>
            <h2>{{ $labels['partners'] }}</h2>
        </div>
        @if ($partners->isNotEmpty())
            <div class="logo-grid">
                @foreach ($partners as $partner)
                    <article class="partner-tile">
                        @include('public.partials.media-frame', [
                            'path' => $partner->logo_path,
                            'alt' => $field($partner, 'name'),
                            'label' => $field($partner, 'name'),
                        ])
                        <h3>{{ $field($partner, 'name') }}</h3>
                    </article>
                @endforeach
            </div>
        @else
            @include('public.partials.empty-state', ['message' => $labels['empty_partners']])
        @endif
    </section>

    <section class="section section--gallery-feature">
        <div class="section__header">
            <p class="eyebrow">{{ $labels['latest_gallery'] }}</p>
            <h2>{{ $labels['gallery'] }}</h2>
        </div>
        @if ($albums->isNotEmpty())
            <div class="card-grid">
                @foreach ($albums as $album)
                    @include('public.partials.record-card', [
                        'title' => $field($album, 'title'),
                        'summary' => $field($album, 'description'),
                        'url' => url("/{$locale}/gallery/{$album->slug}"),
                        'label' => $labels['albums'],
                        'meta' => $labels['photo_count'].': '.$album->published_media_items_count,
                        'imagePath' => $album->cover_image_path,
                        'actionLabel' => $labels['view_album'],
                    ])
                @endforeach
            </div>
        @else
            @include('public.partials.empty-state', ['message' => $labels['empty_albums']])
        @endif
    </section>

    <section class="section section--content-feed">
        <div>
            <div class="section__header">
                <p class="eyebrow">{{ $labels['latest_news'] }}</p>
                <h2>{{ $labels['news'] }}</h2>
            </div>
            @if ($newsPosts->isNotEmpty())
                <div class="stack-list">
                    @foreach ($newsPosts as $post)
                        @include('public.partials.record-card', [
                            'title' => $field($post, 'title'),
                            'summary' => $field($post, 'summary'),
                            'url' => url("/{$locale}/news/{$post->slug}"),
                            'label' => $dateLabel($post->published_at) ?: $labels['news'],
                            'imagePath' => $post->image_path,
                            'actionLabel' => $labels['read_article'],
                        ])
                    @endforeach
                </div>
            @else
                @include('public.partials.empty-state', ['message' => $labels['empty_news']])
            @endif
        </div>

        <div>
            <div class="section__header">
                <p class="eyebrow">{{ $labels['latest_events'] }}</p>
                <h2>{{ $labels['events'] }}</h2>
            </div>
            @if ($events->isNotEmpty())
                <div class="stack-list">
                    @foreach ($events as $event)
                        @include('public.partials.record-card', [
                            'title' => $field($event, 'title'),
                            'summary' => $field($event, 'summary'),
                            'url' => url("/{$locale}/events/{$event->slug}"),
                            'label' => $dateLabel($event->starts_at) ?: $labels['events'],
                            'meta' => $field($event, 'location'),
                            'imagePath' => $event->image_path,
                            'actionLabel' => $labels['read_event'],
                        ])
                    @endforeach
                </div>
            @else
                @include('public.partials.empty-state', ['message' => $labels['empty_events']])
            @endif
        </div>
    </section>
@endsection
