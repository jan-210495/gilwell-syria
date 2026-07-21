@php
    $title = $field($album, 'title');
    $summary = $field($album, 'description');
@endphp

@extends('public.layout')

@section('title', $title)
@section('description', $summary)

@section('content')
    <article class="section detail-layout">
        @include('public.partials.page-hero', [
            'eyebrow' => $labels['gallery'],
            'title' => $title,
            'summary' => $summary,
        ])

        @if ($mediaItems->isNotEmpty())
            <div class="gallery-grid">
                @foreach ($mediaItems as $item)
                    <figure class="gallery-item">
                        @include('public.partials.media-frame', [
                            'path' => $item->thumbnail_path ?: $item->path,
                            'alt' => $field($item, 'alt_text', $field($item, 'title')),
                            'label' => $field($item, 'title', $labels['gallery']),
                        ])
                        @if ($field($item, 'title') !== '' || $field($item, 'caption') !== '')
                            <figcaption>
                                @if ($field($item, 'title') !== '')
                                    <strong>{{ $field($item, 'title') }}</strong>
                                @endif
                                @if ($field($item, 'caption') !== '')
                                    <span>{{ $field($item, 'caption') }}</span>
                                @endif
                            </figcaption>
                        @endif
                    </figure>
                @endforeach
            </div>
        @else
            @include('public.partials.empty-state', ['message' => $labels['empty_gallery_items']])
        @endif
    </article>
@endsection
