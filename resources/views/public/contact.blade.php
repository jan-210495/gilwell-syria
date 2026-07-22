@php
    $pageTitle = $field($page, 'title', $labels['contact']);
    $summary = $field($page, 'summary', $field($settings, 'tagline'));
    $address = $field($settings, 'address');
    $officeHours = $field($settings, 'office_hours');
    $socialLinks = collect([
        'Facebook' => $settings?->facebook_url,
        'Instagram' => $settings?->instagram_url,
        'YouTube' => $settings?->youtube_url,
    ])->filter();
@endphp

@extends('public.layout')

@section('title', $field($page, 'seo_title', $pageTitle))
@section('description', $field($page, 'seo_description', $summary))

@section('content')
    <section class="section section--contact">
        @include('public.partials.page-hero', [
            'eyebrow' => $labels['contact_details'],
            'title' => $pageTitle,
            'summary' => $summary,
        ])

        @include('public.partials.body', ['body' => $field($page, 'body')])

        <div class="contact-grid contact-grid--wide">
            @if ($settings?->contact_email)
                <section class="contact-block">
                    <p class="eyebrow">{{ $labels['email'] }}</p>
                    <h2>{{ $labels['contact'] }}</h2>
                    <a href="mailto:{{ $settings->contact_email }}">{{ $settings->contact_email }}</a>
                </section>
            @endif

            @if ($settings?->partnership_email)
                <section class="contact-block">
                    <p class="eyebrow">{{ $labels['partnerships'] }}</p>
                    <h2>{{ $labels['partner_with_us'] }}</h2>
                    <a href="mailto:{{ $settings->partnership_email }}">{{ $settings->partnership_email }}</a>
                </section>
            @endif

            @if ($settings?->contact_phone || $settings?->whatsapp_phone)
                <section class="contact-block">
                    <p class="eyebrow">{{ $labels['phone'] }}</p>
                    <h2>{{ $labels['phone'] }}</h2>
                    @if ($settings?->contact_phone)
                        <a href="tel:{{ preg_replace('/\s+/', '', $settings->contact_phone) }}">{{ $settings->contact_phone }}</a>
                    @endif
                    @if ($settings?->whatsapp_phone)
                        <a href="tel:{{ preg_replace('/\s+/', '', $settings->whatsapp_phone) }}">{{ $labels['whatsapp'] }}: {{ $settings->whatsapp_phone }}</a>
                    @endif
                </section>
            @endif

            @if ($address !== '')
                <section class="contact-block">
                    <p class="eyebrow">{{ $labels['location'] }}</p>
                    <h2>{{ $labels['location'] }}</h2>
                    <p>{{ $address }}</p>
                    @if ($settings?->map_url)
                        <a class="text-link" href="{{ $settings->map_url }}" target="_blank" rel="noopener noreferrer">{{ $labels['map'] }}</a>
                    @endif
                </section>
            @endif

            @if ($officeHours !== '')
                <section class="contact-block">
                    <p class="eyebrow">{{ $labels['office_hours'] }}</p>
                    <h2>{{ $labels['office_hours'] }}</h2>
                    <p>{{ $officeHours }}</p>
                </section>
            @endif

            @if ($socialLinks->isNotEmpty())
                <section class="contact-block">
                    <p class="eyebrow">{{ $labels['social'] }}</p>
                    <h2>{{ $labels['social'] }}</h2>
                    @foreach ($socialLinks as $name => $href)
                        <a href="{{ $href }}" target="_blank" rel="noopener noreferrer">{{ $name }}</a>
                    @endforeach
                </section>
            @endif
        </div>
    </section>
@endsection
