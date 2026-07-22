@php
    $siteName = $field($settings, 'site_name', 'GilwellSyria');
    $title = $field($page, 'seo_title', $siteName);
    $heroTitle = $siteName;
    $heroSummary = $field($settings, 'tagline', $field($page, 'summary'));
    $heroBody = $field($page, 'body');
    $heroCorners = [
        [
            'key' => 'merit',
            'number' => '01',
            'color' => '#6B0F68',
            'label_en' => 'Merit',
            'label_ar' => 'الاستحقاق',
            'copy_en' => 'Earned growth through skill, service, and recognition.',
            'copy_ar' => 'نمو مستحق عبر المهارة والخدمة والتقدير.',
        ],
        [
            'key' => 'discipline',
            'number' => '02',
            'color' => '#2E5A2A',
            'label_en' => 'Discipline',
            'label_ar' => 'الانضباط',
            'copy_en' => 'Focused training, structure, and reliable practice.',
            'copy_ar' => 'تدريب مركز ونظام وممارسة موثوقة.',
        ],
        [
            'key' => 'honor',
            'number' => '03',
            'color' => '#E0AB00',
            'label_en' => 'Honor',
            'label_ar' => 'الشرف',
            'copy_en' => 'Dignified service and responsibility to others.',
            'copy_ar' => 'خدمة كريمة ومسؤولية تجاه الآخرين.',
        ],
        [
            'key' => 'tenacity',
            'number' => '04',
            'color' => '#0B3570',
            'label_en' => 'Tenacity',
            'label_ar' => 'المثابرة',
            'copy_en' => 'Perseverance through challenge and teamwork.',
            'copy_ar' => 'ثبات أمام التحدي بروح الفريق.',
        ],
        [
            'key' => 'loyalty',
            'number' => '05',
            'color' => '#B3121B',
            'label_en' => 'Loyalty',
            'label_ar' => 'الولاء',
            'copy_en' => 'Belonging, trust, and shared commitment.',
            'copy_ar' => 'انتماء وثقة والتزام مشترك.',
        ],
    ];
@endphp

@extends('public.layout')

@section('title', $title)
@section('description', $field($page, 'seo_description', $heroSummary))
@section('preload')
    <link rel="preload" as="image" href="{{ asset('images/hero-corners/optimized/merit.webp') }}" type="image/webp" fetchpriority="high">
@endsection

@section('content')
    <section class="home-hero home-hero--corners" aria-labelledby="home-hero-title">
        <div class="hero-corners__backdrop" aria-hidden="true">
            <ul class="hero-corners__panels" aria-label="{{ $locale === 'ar' ? 'زوايا جيلويل الخمس' : 'Five corners of Gilwell' }}">
                @foreach ($heroCorners as $corner)
                    @php
                        $cornerLabel = $locale === 'ar' ? $corner['label_ar'] : $corner['label_en'];
                        $cornerCopy = $locale === 'ar' ? $corner['copy_ar'] : $corner['copy_en'];
                        $cornerSource = asset("images/hero-corners/{$corner['key']}.png");
                        $cornerOptimized = asset("images/hero-corners/optimized/{$corner['key']}.webp");
                    @endphp
                    <li class="hero-corner-panel hero-corner-panel--{{ $corner['key'] }}" data-hero-corner="{{ $corner['key'] }}" style="--corner-color: {{ $corner['color'] }}; --corner-image-fallback: url('{{ $cornerSource }}'); --corner-image: image-set(url('{{ $cornerOptimized }}') type('image/webp'), url('{{ $cornerSource }}') type('image/png'));"><button class="hero-corner-panel__button" type="button" aria-label="{{ $cornerLabel }} - {{ $cornerCopy }}"><span class="hero-corner-panel__number">{{ $corner['number'] }}</span><span class="hero-corner-panel__value"><strong>{{ $cornerLabel }}</strong><span>{{ $cornerCopy }}</span></span></button></li>
                @endforeach
            </ul>
        </div>

        <div class="home-hero__inner">
            <div class="home-hero__content" data-reveal>
                <p class="eyebrow">{{ $labels['home'] }}</p>
                <h1 id="home-hero-title">{{ $heroTitle }}</h1>
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
