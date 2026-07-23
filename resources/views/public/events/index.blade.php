@php
    $pageTitle = $field($page, 'title', $labels['events']);
    $summary = $field($page, 'summary');
@endphp

@extends('public.layout')

@section('title', $field($page, 'seo_title', $pageTitle))
@section('description', $field($page, 'seo_description', $summary))

@section('content')
    <section class="section section--listing">
        @include('public.partials.page-hero', [
            'eyebrow' => $labels['events'],
            'title' => $pageTitle,
            'summary' => $summary,
            'actions' => [
                ['href' => url("/{$locale}/contact"), 'label' => $labels['contact'], 'variant' => 'button--primary'],
            ],
        ])

        @include('public.partials.body', ['body' => $field($page, 'body')])

        @if ($events->isNotEmpty())
            <div class="card-grid card-grid--compact">
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
    </section>
@endsection
