@php
    $pageTitle = $field($page, 'title', $labels['news']);
    $summary = $field($page, 'summary');
@endphp

@extends('public.layout')

@section('title', $field($page, 'seo_title', $pageTitle))
@section('description', $field($page, 'seo_description', $summary))

@section('content')
    <section class="section section--listing">
        @include('public.partials.page-hero', [
            'eyebrow' => $labels['news'],
            'title' => $pageTitle,
            'summary' => $summary,
        ])

        @include('public.partials.body', ['body' => $field($page, 'body')])

        @if ($newsPosts->isNotEmpty())
            <div class="card-grid card-grid--compact">
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
    </section>
@endsection
