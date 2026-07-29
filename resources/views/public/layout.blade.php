@php
    $siteName = $field($settings, 'site_name', 'GilwellSyria');
    $tagline = $field($settings, 'tagline');
    $otherLocale = $locale === 'ar' ? 'en' : 'ar';
    $segments = request()->segments();
    $segments[0] = $otherLocale;
    $languageUrl = url('/'.implode('/', $segments));
    $languageLabel = $locale === 'ar' ? 'English' : 'العربية';
    $languageAriaLabel = $locale === 'ar' ? 'Switch language to English' : 'تغيير اللغة إلى العربية';
    $isHomePage = request()->is($locale);
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
        <link rel="icon" type="image/x-icon" sizes="16x16 32x32 48x48" href="{{ asset('favicon.ico') }}?v=20260729">
        @vite(['resources/css/app.css', 'resources/js/app.js'])
    </head>
    <body class="public-site">
        <a class="skip-link" href="#main-content">{{ $labels['skip'] }}</a>

        <header class="site-header {{ $isHomePage ? 'site-header--home' : 'site-header--readable is-scrolled' }}" data-site-header>
            <div class="site-header__inner">
                <a class="brand" href="{{ url("/{$locale}") }}" aria-label="{{ $siteName }}">
                    <img class="brand__logo brand__logo--transparent" src="{{ asset('images/gilwellsyria-logo-transparent.png') }}" alt="{{ $siteName }}">
                    <span class="brand__text">
                        <strong>{{ $siteName }}</strong>
                        @if ($tagline !== '')
                            <span>{{ $tagline }}</span>
                        @endif
                    </span>
                </a>

                <button class="menu-toggle" type="button" aria-label="{{ $labels['nav_label'] }}" aria-expanded="false" aria-controls="site-menu-panel" data-menu-toggle>
                    <span class="menu-toggle__line"></span>
                    <span class="menu-toggle__line"></span>
                    <span class="menu-toggle__line"></span>
                </button>

                <nav id="site-menu-panel" class="site-nav" aria-label="{{ $labels['nav_label'] }}" data-menu-panel>
                    @foreach ($navItems as $item)
                        @php($active = request()->is($item['match']))
                        <a class="site-nav__link {{ $active ? 'is-active' : '' }}" href="{{ $item['href'] }}" data-menu-close @if ($active) aria-current="page" @endif>
                            {{ $item['label'] }}
                        </a>
                    @endforeach
                </nav>

                <div class="site-header__actions">
                    <a class="language-switch language-switch--header" href="{{ $languageUrl }}" hreflang="{{ $otherLocale }}" aria-label="{{ $languageAriaLabel }}" data-menu-close>
                        <svg class="language-switch__icon" aria-hidden="true" viewBox="0 0 24 24" focusable="false">
                            <path d="M12 21a9 9 0 1 0 0-18 9 9 0 0 0 0 18Z"></path>
                            <path d="M3.6 9h16.8M3.6 15h16.8M12 3c2 2.2 3 5.2 3 9s-1 6.8-3 9M12 3c-2 2.2-3 5.2-3 9s1 6.8 3 9"></path>
                        </svg>
                        <span>{{ $languageLabel }}</span>
                    </a>
                    <a class="button button--primary site-header__contact" href="{{ url("/{$locale}/contact") }}" data-menu-close>{{ $labels['contact'] }}</a>
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
                    <a class="language-switch language-switch--footer" href="{{ $languageUrl }}" hreflang="{{ $otherLocale }}" aria-label="{{ $languageAriaLabel }}">
                        <svg class="language-switch__icon" aria-hidden="true" viewBox="0 0 24 24" focusable="false">
                            <path d="M12 21a9 9 0 1 0 0-18 9 9 0 0 0 0 18Z"></path>
                            <path d="M3.6 9h16.8M3.6 15h16.8M12 3c2 2.2 3 5.2 3 9s-1 6.8-3 9M12 3c-2 2.2-3 5.2-3 9s1 6.8 3 9"></path>
                        </svg>
                        <span>{{ $languageLabel }}</span>
                    </a>
                </div>
            </div>
        </footer>
    </body>
</html>
