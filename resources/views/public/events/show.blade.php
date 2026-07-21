@php
    $title = $field($event, 'seo_title', $field($event, 'title'));
    $pageTitle = $field($event, 'title');
    $summary = $field($event, 'summary');
    $eventMeta = collect([$dateLabel($event->starts_at), $field($event, 'location')])->filter()->implode(' · ');
@endphp

@extends('public.layout')

@section('title', $title)
@section('description', $field($event, 'seo_description', $summary))

@section('content')
    <article class="section detail-layout">
        @include('public.partials.page-hero', [
            'eyebrow' => $eventMeta ?: $labels['events'],
            'title' => $pageTitle,
            'summary' => $summary,
            'actions' => [
                ['href' => url("/{$locale}/contact"), 'label' => $labels['contact'], 'variant' => 'button--primary'],
            ],
        ])

        @include('public.partials.media-frame', [
            'path' => $event->image_path,
            'alt' => $pageTitle,
            'label' => $labels['events'],
        ])

        @include('public.partials.body', ['body' => $field($event, 'body')])
    </article>
@endsection
