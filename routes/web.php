<?php

use App\Models\Event;
use App\Models\GalleryAlbum;
use App\Models\ImpactMetric;
use App\Models\ImpactStory;
use App\Models\NewsPost;
use App\Models\Page;
use App\Models\Partner;
use App\Models\Program;
use App\Models\SiteSetting;
use Illuminate\Support\Facades\Route;

Route::redirect('/', '/en');

Route::pattern('locale', 'en|ar');

$labelsFor = function (string $locale): array {
    return $locale === 'ar'
        ? [
            'about' => 'عن جيلويل سوريا',
            'albums' => 'الألبومات',
            'contact' => 'تواصل معنا',
            'contact_details' => 'بيانات التواصل',
            'email' => 'البريد الإلكتروني',
            'empty_albums' => 'لا توجد ألبومات منشورة بعد.',
            'empty_events' => 'لا توجد فعاليات أو تدريبات منشورة بعد.',
            'empty_gallery_items' => 'لا توجد مواد منشورة في هذا الألبوم بعد.',
            'empty_impact' => 'لا توجد تحديثات أثر منشورة بعد.',
            'empty_news' => 'لا توجد أخبار منشورة بعد.',
            'empty_partners' => 'لا يوجد شركاء منشورون بعد.',
            'empty_programs' => 'لا توجد برامج منشورة بعد.',
            'events' => 'الفعاليات والتدريب',
            'explore_programs' => 'استكشف البرامج',
            'gallery' => 'المعرض',
            'home' => 'الرئيسية',
            'impact' => 'الأثر',
            'latest_events' => 'فعاليات وتدريبات قادمة',
            'latest_gallery' => 'من المعرض',
            'latest_news' => 'آخر الأخبار',
            'latest_programs' => 'البرامج',
            'location' => 'الموقع',
            'map' => 'الخريطة',
            'nav_label' => 'التنقل الرئيسي',
            'news' => 'الأخبار',
            'office_hours' => 'ساعات العمل',
            'partners' => 'الشركاء',
            'partnerships' => 'الشراكات',
            'partner_with_us' => 'تعاون معنا',
            'phone' => 'الهاتف',
            'photo_count' => 'عدد المواد',
            'programs' => 'البرامج',
            'published' => 'منشور',
            'read_article' => 'اقرأ الخبر',
            'read_event' => 'تفاصيل الفعالية',
            'read_program' => 'تفاصيل البرنامج',
            'skip' => 'تجاوز إلى المحتوى',
            'social' => 'القنوات الاجتماعية',
            'view_album' => 'عرض الألبوم',
            'visit_partner' => 'زيارة الشريك',
            'whatsapp' => 'واتساب',
        ]
        : [
            'about' => 'About',
            'albums' => 'Albums',
            'contact' => 'Contact us',
            'contact_details' => 'Contact details',
            'email' => 'Email',
            'empty_albums' => 'No published albums yet.',
            'empty_events' => 'No published events or trainings yet.',
            'empty_gallery_items' => 'No published media in this album yet.',
            'empty_impact' => 'No published impact updates yet.',
            'empty_news' => 'No published news yet.',
            'empty_partners' => 'No published partners yet.',
            'empty_programs' => 'No published programs yet.',
            'events' => 'Events & Training',
            'explore_programs' => 'Explore programs',
            'gallery' => 'Gallery',
            'home' => 'Home',
            'impact' => 'Impact',
            'latest_events' => 'Upcoming events and training',
            'latest_gallery' => 'From the gallery',
            'latest_news' => 'Latest news',
            'latest_programs' => 'Programs',
            'location' => 'Location',
            'map' => 'Map',
            'nav_label' => 'Main navigation',
            'news' => 'News',
            'office_hours' => 'Office hours',
            'partners' => 'Partners',
            'partnerships' => 'Partnerships',
            'partner_with_us' => 'Partner with us',
            'phone' => 'Phone',
            'photo_count' => 'Media items',
            'programs' => 'Programs',
            'published' => 'Published',
            'read_article' => 'Read article',
            'read_event' => 'Event details',
            'read_program' => 'Program details',
            'skip' => 'Skip to content',
            'social' => 'Social channels',
            'view_album' => 'View album',
            'visit_partner' => 'Visit partner',
            'whatsapp' => 'WhatsApp',
        ];
};

$baseViewData = function (string $locale) use ($labelsFor): array {
    app()->setLocale($locale);

    $settings = SiteSetting::query()->where('key', 'main')->first()
        ?? SiteSetting::query()->first();

    $field = function (?object $record, string $base, ?string $fallback = '') use ($locale): string {
        if (! $record) {
            return (string) $fallback;
        }

        $localized = $record->{$base.'_'.$locale} ?? null;
        $english = $record->{$base.'_en'} ?? null;

        return trim((string) ($localized ?: $english ?: $fallback));
    };

    $date = function (mixed $date) use ($locale): ?string {
        if (! $date) {
            return null;
        }

        return $date
            ->locale($locale)
            ->translatedFormat($locale === 'ar' ? 'j F Y' : 'F j, Y');
    };

    return [
        'dateLabel' => $date,
        'dir' => $locale === 'ar' ? 'rtl' : 'ltr',
        'field' => $field,
        'labels' => $labelsFor($locale),
        'locale' => $locale,
        'settings' => $settings,
    ];
};

$publicView = function (string $locale, string $view, array $data = []) use ($baseViewData) {
    return view($view, [
        ...$baseViewData($locale),
        ...$data,
    ]);
};

$publishedPage = fn (string $slug): ?Page => Page::published()
    ->where('slug', $slug)
    ->first();

$orderedPrograms = fn () => Program::published()
    ->orderBy('sort_order')
    ->orderBy('id');

$orderedImpactMetrics = fn () => ImpactMetric::published()
    ->orderBy('sort_order')
    ->orderBy('id');

$orderedImpactStories = fn () => ImpactStory::published()
    ->orderBy('sort_order')
    ->orderBy('id');

$orderedPartners = fn () => Partner::published()
    ->orderBy('sort_order')
    ->orderBy('id');

$orderedAlbums = fn () => GalleryAlbum::published()
    ->withCount([
        'mediaItems as published_media_items_count' => fn ($query) => $query->published(),
    ])
    ->orderBy('sort_order')
    ->orderBy('id');

$orderedNews = fn () => NewsPost::published()
    ->orderByDesc('published_at')
    ->orderBy('sort_order')
    ->orderBy('id');

$orderedEvents = fn () => Event::published()
    ->orderByRaw('starts_at IS NULL')
    ->orderBy('starts_at')
    ->orderBy('sort_order')
    ->orderBy('id');

Route::prefix('{locale}')->group(function () use (
    $orderedAlbums,
    $orderedEvents,
    $orderedImpactMetrics,
    $orderedImpactStories,
    $orderedNews,
    $orderedPartners,
    $orderedPrograms,
    $publicView,
    $publishedPage,
) {
    Route::get('/', function (string $locale) use (
        $orderedAlbums,
        $orderedEvents,
        $orderedImpactMetrics,
        $orderedImpactStories,
        $orderedNews,
        $orderedPartners,
        $orderedPrograms,
        $publicView,
        $publishedPage,
    ) {
        return $publicView($locale, 'public.home', [
            'albums' => $orderedAlbums()->take(3)->get(),
            'events' => $orderedEvents()->take(3)->get(),
            'impactMetrics' => $orderedImpactMetrics()->take(4)->get(),
            'impactStories' => $orderedImpactStories()->take(2)->get(),
            'newsPosts' => $orderedNews()->take(3)->get(),
            'page' => $publishedPage('home'),
            'partners' => $orderedPartners()->take(4)->get(),
            'programs' => $orderedPrograms()->take(3)->get(),
        ]);
    });

    Route::get('/about', function (string $locale) use ($publicView, $publishedPage) {
        return $publicView($locale, 'public.static-page', [
            'emptyTitle' => $locale === 'ar' ? 'عن جيلويل سوريا' : 'About GilwellSyria',
            'page' => $publishedPage('about') ?? abort(404),
        ]);
    });

    Route::get('/programs', function (string $locale) use ($orderedPrograms, $publicView, $publishedPage) {
        return $publicView($locale, 'public.programs.index', [
            'page' => $publishedPage('programs'),
            'programs' => $orderedPrograms()->get(),
        ]);
    });

    Route::get('/programs/{program}', function (string $locale, string $program) use ($publicView) {
        $program = Program::published()->where('slug', $program)->firstOrFail();

        return $publicView($locale, 'public.programs.show', [
            'program' => $program,
        ]);
    });

    Route::get('/impact', function (string $locale) use (
        $orderedImpactMetrics,
        $orderedImpactStories,
        $publicView,
        $publishedPage,
    ) {
        return $publicView($locale, 'public.impact', [
            'impactMetrics' => $orderedImpactMetrics()->get(),
            'impactStories' => $orderedImpactStories()->get(),
            'page' => $publishedPage('impact'),
        ]);
    });

    Route::get('/partners', function (string $locale) use ($orderedPartners, $publicView, $publishedPage) {
        return $publicView($locale, 'public.partners', [
            'page' => $publishedPage('partners'),
            'partners' => $orderedPartners()->get(),
        ]);
    });

    Route::get('/gallery', function (string $locale) use ($orderedAlbums, $publicView, $publishedPage) {
        return $publicView($locale, 'public.gallery.index', [
            'albums' => $orderedAlbums()->get(),
            'page' => $publishedPage('gallery'),
        ]);
    });

    Route::get('/gallery/{album}', function (string $locale, string $album) use ($publicView) {
        $album = GalleryAlbum::published()
            ->where('slug', $album)
            ->firstOrFail();

        return $publicView($locale, 'public.gallery.show', [
            'album' => $album,
            'mediaItems' => $album->mediaItems()
                ->published()
                ->orderBy('sort_order')
                ->orderBy('id')
                ->get(),
        ]);
    });

    Route::get('/news', function (string $locale) use ($orderedNews, $publicView, $publishedPage) {
        return $publicView($locale, 'public.news.index', [
            'newsPosts' => $orderedNews()->get(),
            'page' => $publishedPage('news'),
        ]);
    });

    Route::get('/news/{post}', function (string $locale, string $post) use ($publicView) {
        $post = NewsPost::published()->where('slug', $post)->firstOrFail();

        return $publicView($locale, 'public.news.show', [
            'post' => $post,
        ]);
    });

    Route::get('/events', function (string $locale) use ($orderedEvents, $publicView, $publishedPage) {
        return $publicView($locale, 'public.events.index', [
            'events' => $orderedEvents()->get(),
            'page' => $publishedPage('events'),
        ]);
    });

    Route::get('/events/{event}', function (string $locale, string $event) use ($publicView) {
        $event = Event::published()->where('slug', $event)->firstOrFail();

        return $publicView($locale, 'public.events.show', [
            'event' => $event,
        ]);
    });

    Route::get('/contact', function (string $locale) use ($publicView, $publishedPage) {
        return $publicView($locale, 'public.contact', [
            'page' => $publishedPage('contact'),
        ]);
    });
});
