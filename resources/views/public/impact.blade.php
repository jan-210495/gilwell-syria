@php
    $pageTitle = $field($page, 'title', $labels['impact']);
    $summary = $field($page, 'summary');
@endphp

@extends('public.layout')

@section('title', $field($page, 'seo_title', $pageTitle))
@section('description', $field($page, 'seo_description', $summary))

@section('content')
    <section class="section section--impact-report">
        @include('public.partials.page-hero', [
            'eyebrow' => $labels['impact'],
            'title' => $pageTitle,
            'summary' => $summary,
            'actions' => [
                ['href' => url("/{$locale}/contact"), 'label' => $labels['partner_with_us'], 'variant' => 'button--primary'],
            ],
        ])

        @include('public.partials.body', ['body' => $field($page, 'body')])

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
        @endif

        @if ($impactStories->isNotEmpty())
            <div class="card-grid">
                @foreach ($impactStories as $story)
                    @include('public.partials.record-card', [
                        'title' => $field($story, 'title'),
                        'summary' => $field($story, 'summary'),
                        'label' => $labels['impact'],
                        'imagePath' => $story->image_path,
                    ])
                @endforeach
            </div>
        @endif

        @if ($impactMetrics->isEmpty() && $impactStories->isEmpty())
            @include('public.partials.empty-state', ['message' => $labels['empty_impact']])
        @endif
    </section>
@endsection
