@php
    $title = $field($page, 'seo_title', $field($page, 'title', $emptyTitle ?? ''));
    $pageTitle = $field($page, 'title', $emptyTitle ?? '');
    $summary = $field($page, 'summary');
@endphp

@extends('public.layout')

@section('title', $title)
@section('description', $field($page, 'seo_description', $summary))

@section('content')
    <section class="section">
        @include('public.partials.page-hero', [
            'eyebrow' => $labels['about'],
            'title' => $pageTitle,
            'summary' => $summary,
            'actions' => [
                ['href' => url("/{$locale}/programs"), 'label' => $labels['explore_programs'], 'variant' => 'button--secondary'],
                ['href' => url("/{$locale}/contact"), 'label' => $labels['contact'], 'variant' => 'button--primary'],
            ],
        ])

        @include('public.partials.body', ['body' => $field($page, 'body')])
    </section>
@endsection
