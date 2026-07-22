@php
    $siteName = $field($settings, 'site_name', 'GilwellSyria');
    $tagline = $field($settings, 'tagline');
    $otherLocale = $locale === 'ar' ? 'en' : 'ar';
    $segments = request()->segments();
    $segments[0] = $otherLocale;
    $languageUrl = url('/'.implode('/', $segments));
    $languageLabel = $locale === 'ar' ? 'English' : 'العربية';
    $navItems = [
        ['href' => url("/{$locale}"), 'label' => $labels['home'], 'match' => "{$locale}"],
        ['href' => url("/{$locale}/about"), 'label' => $labels['about'], 'match' => "{$locale}/about"],
        ['href' => url("/{$locale}/programs"), 'label' => $labels['programs'], 'match' => "{$locale}/programs*"],
        ['href' => url("/{$locale}/impact"), 'label' => $labels['impact'], 'match' => "{$locale}/impact"],
        ['href' => url("/{$locale}/partners"), 'label' => $labels['partners'], 'match' => "{$locale}/partners"],
        ['href' => url("/{$locale}/gallery"), 'label' => $labels['gallery'], 'match' => "{$locale}/gallery*"],
        ['href' => url("/{$locale}/news"), 'label' => $labels['news'], 'match' => "{$locale}/news*"],
        ['href' => url("/{$locale}/events"), 'label' => $labels['events'], 'match' => "{$locale}/events*"],
    ];
@endphp
<!doctype html>
<html lang="{{ $locale }}" dir="{{ $dir }}">
    <head>
        <meta charset="utf-8">
        <meta name="viewport" content="width=device-width, initial-scale=1">
        <title>@hasSection('title')@yield('title') | {{ $siteName }}@else{{ $siteName }}@endif</title>
        <meta name="description" content="@yield('description', $tagline ?: $siteName)">
        @yield('preload')
        @vite(['resources/css/app.css', 'resources/js/app.js'])
    </head>
    <body class="public-site">
        <a class="skip-link" href="#main-content">{{ $labels['skip'] }}</a>

        <header class="site-header">
            <div class="site-header__inner">
                <a class="brand" href="{{ url("/{$locale}") }}" aria-label="{{ $siteName }}">
                    <img class="brand__logo" src="{{ asset('images/gilwellsyria-logo.jpeg') }}" alt="{{ $siteName }}">
                    <span class="brand__text">
                        <strong>{{ $siteName }}</strong>
                        @if ($tagline !== '')
                            <span>{{ $tagline }}</span>
                        @endif
                    </span>
                </a>

                <nav class="site-nav" aria-label="{{ $labels['nav_label'] }}">
                    @foreach ($navItems as $item)
                        @php($active = request()->is($item['match']))
                        <a class="site-nav__link {{ $active ? 'is-active' : '' }}" href="{{ $item['href'] }}" @if ($active) aria-current="page" @endif>
                            {{ $item['label'] }}
                        </a>
                    @endforeach
                </nav>

                <div class="site-header__actions">
                    <a class="language-switch" href="{{ $languageUrl }}" hreflang="{{ $otherLocale }}">{{ $languageLabel }}</a>
                    <a class="button button--primary" href="{{ url("/{$locale}/contact") }}">{{ $labels['contact'] }}</a>
                </div>
            </div>
        </header>

        <main id="main-content" tabindex="-1">
            @yield('content')
        </main>

        <footer class="site-footer">
            <div class="site-footer__inner">
                <div class="site-footer__brand">
                    <img class="site-footer__logo" src="{{ asset('images/gilwellsyria-logo.jpeg') }}" alt="{{ $siteName }}">
                    <div>
                        <strong>{{ $siteName }}</strong>
                        @if ($tagline !== '')
                            <p>{{ $tagline }}</p>
                        @endif
                    </div>
                </div>

                <div class="site-footer__links" aria-label="{{ $labels['nav_label'] }}">
                    @foreach ($navItems as $item)
                        <a href="{{ $item['href'] }}">{{ $item['label'] }}</a>
                    @endforeach
                </div>

                <div class="site-footer__contact">
                    <strong>{{ $labels['contact_details'] }}</strong>
                    @if ($settings?->contact_email)
                        <a href="mailto:{{ $settings->contact_email }}">{{ $settings->contact_email }}</a>
                    @endif
                    @if ($settings?->contact_phone)
                        <a href="tel:{{ preg_replace('/\s+/', '', $settings->contact_phone) }}">{{ $settings->contact_phone }}</a>
                    @endif
                    <a href="{{ url("/{$locale}/contact") }}">{{ $labels['partner_with_us'] }}</a>
                </div>
            </div>
        </footer>
    </body>
</html>
