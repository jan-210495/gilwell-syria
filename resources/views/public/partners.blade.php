@php
    $pageTitle = $field($page, 'title', $labels['partners']);
    $summary = $field($page, 'summary');
@endphp

@extends('public.layout')

@section('title', $field($page, 'seo_title', $pageTitle))
@section('description', $field($page, 'seo_description', $summary))

@section('content')
    <section class="section">
        @include('public.partials.page-hero', [
            'eyebrow' => $labels['partners'],
            'title' => $pageTitle,
            'summary' => $summary,
            'actions' => [
                ['href' => url("/{$locale}/contact"), 'label' => $labels['partner_with_us'], 'variant' => 'button--primary'],
            ],
        ])

        @include('public.partials.body', ['body' => $field($page, 'body')])

        @if ($partners->isNotEmpty())
            <div class="card-grid">
                @foreach ($partners as $partner)
                    @include('public.partials.record-card', [
                        'title' => $field($partner, 'name'),
                        'summary' => $field($partner, 'description'),
                        'url' => $partner->website_url,
                        'external' => true,
                        'label' => $labels['partners'],
                        'imagePath' => $partner->logo_path,
                        'actionLabel' => $partner->website_url ? $labels['visit_partner'] : null,
                    ])
                @endforeach
            </div>
        @else
            @include('public.partials.empty-state', ['message' => $labels['empty_partners']])
        @endif
    </section>
@endsection
