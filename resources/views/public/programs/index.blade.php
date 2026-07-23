@php
    $pageTitle = $field($page, 'title', $labels['programs']);
    $summary = $field($page, 'summary');
@endphp

@extends('public.layout')

@section('title', $field($page, 'seo_title', $pageTitle))
@section('description', $field($page, 'seo_description', $summary))

@section('content')
    <section class="section section--listing">
        @include('public.partials.page-hero', [
            'eyebrow' => $labels['programs'],
            'title' => $pageTitle,
            'summary' => $summary,
            'actions' => [
                ['href' => url("/{$locale}/contact"), 'label' => $labels['contact'], 'variant' => 'button--primary'],
                ['href' => url("/{$locale}/contact"), 'label' => $labels['partner_with_us'], 'variant' => 'button--secondary'],
            ],
        ])

        @include('public.partials.body', ['body' => $field($page, 'body')])

        @if ($programs->isNotEmpty())
            <div class="card-grid card-grid--featured">
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
@endsection
