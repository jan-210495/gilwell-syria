@php
    $pageTitle = $field($page, 'title', $labels['gallery']);
    $summary = $field($page, 'summary');
@endphp

@extends('public.layout')

@section('title', $field($page, 'seo_title', $pageTitle))
@section('description', $field($page, 'seo_description', $summary))

@section('content')
    <section class="section section--listing">
        @include('public.partials.page-hero', [
            'eyebrow' => $labels['gallery'],
            'title' => $pageTitle,
            'summary' => $summary,
        ])

        @include('public.partials.body', ['body' => $field($page, 'body')])

        @if ($albums->isNotEmpty())
            <div class="card-grid card-grid--compact">
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
@endsection
