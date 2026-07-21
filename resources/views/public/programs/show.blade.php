@php
    $title = $field($program, 'title');
    $summary = $field($program, 'summary');
@endphp

@extends('public.layout')

@section('title', $title)
@section('description', $summary)

@section('content')
    <article class="section detail-layout">
        @include('public.partials.page-hero', [
            'eyebrow' => $labels['programs'],
            'title' => $title,
            'summary' => $summary,
            'actions' => [
                ['href' => url("/{$locale}/contact"), 'label' => $labels['contact'], 'variant' => 'button--primary'],
                ['href' => url("/{$locale}/programs"), 'label' => $labels['explore_programs'], 'variant' => 'button--secondary'],
            ],
        ])

        @include('public.partials.media-frame', [
            'path' => $program->image_path,
            'alt' => $title,
            'label' => $labels['programs'],
        ])

        @include('public.partials.body', ['body' => $field($program, 'body')])
    </article>
@endsection
