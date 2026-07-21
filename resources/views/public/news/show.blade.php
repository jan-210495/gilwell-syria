@php
    $title = $field($post, 'seo_title', $field($post, 'title'));
    $pageTitle = $field($post, 'title');
    $summary = $field($post, 'summary');
@endphp

@extends('public.layout')

@section('title', $title)
@section('description', $field($post, 'seo_description', $summary))

@section('content')
    <article class="section detail-layout">
        @include('public.partials.page-hero', [
            'eyebrow' => $dateLabel($post->published_at) ?: $labels['news'],
            'title' => $pageTitle,
            'summary' => $summary,
        ])

        @include('public.partials.media-frame', [
            'path' => $post->image_path,
            'alt' => $pageTitle,
            'label' => $labels['news'],
        ])

        @include('public.partials.body', ['body' => $field($post, 'body')])
    </article>
@endsection
