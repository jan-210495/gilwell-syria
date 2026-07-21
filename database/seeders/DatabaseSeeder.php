<?php

namespace Database\Seeders;

use App\Enums\MediaType;
use App\Enums\PublishStatus;
use App\Enums\UserRole;
use App\Models\Event;
use App\Models\GalleryAlbum;
use App\Models\ImpactMetric;
use App\Models\ImpactStory;
use App\Models\MediaItem;
use App\Models\NewsPost;
use App\Models\Page;
use App\Models\Partner;
use App\Models\Program;
use App\Models\SiteSetting;
use App\Models\User;
use Illuminate\Database\Console\Seeds\WithoutModelEvents;
use Illuminate\Database\Seeder;
use Illuminate\Support\Facades\Hash;

class DatabaseSeeder extends Seeder
{
    use WithoutModelEvents;

    /**
     * Seed the application's database.
     */
    public function run(): void
    {
        $publishedAt = now();

        // Local development credentials:
        // admin@gilwellsyria.local / password
        // editor@gilwellsyria.local / password
        User::query()->updateOrCreate(
            ['email' => 'admin@gilwellsyria.local'],
            [
                'name' => 'GilwellSyria Admin',
                'password' => Hash::make('password'),
                'role' => UserRole::Admin,
                'email_verified_at' => $publishedAt,
            ],
        );

        User::query()->updateOrCreate(
            ['email' => 'editor@gilwellsyria.local'],
            [
                'name' => 'GilwellSyria Editor',
                'password' => Hash::make('password'),
                'role' => UserRole::Editor,
                'email_verified_at' => $publishedAt,
            ],
        );

        SiteSetting::query()->updateOrCreate(
            ['key' => 'main'],
            [
                'site_name_en' => 'GilwellSyria',
                'site_name_ar' => 'جيلويل سوريا',
                'tagline_en' => 'Training young leaders for service across Syria.',
                'tagline_ar' => 'تدريب قادة شباب للخدمة في سوريا.',
                'contact_email' => 'info@gilwellsyria.local',
                'partnership_email' => 'partnerships@gilwellsyria.local',
                'contact_phone' => '+963 11 000 0000',
                'whatsapp_phone' => '+963 944 000 000',
                'address_en' => 'Damascus, Syria',
                'address_ar' => 'دمشق، سوريا',
                'office_hours_en' => 'Sunday to Thursday, 9:00-17:00',
                'office_hours_ar' => 'من الأحد إلى الخميس، 9:00-17:00',
                'map_url' => 'https://maps.example.test/gilwell-syria',
                'facebook_url' => 'https://facebook.example.test/gilwellsyria',
                'instagram_url' => 'https://instagram.example.test/gilwellsyria',
                'youtube_url' => 'https://youtube.example.test/gilwellsyria',
            ],
        );

        foreach ($this->starterPages($publishedAt) as $page) {
            Page::query()->updateOrCreate(['slug' => $page['slug']], $page);
        }

        $program = Program::query()->updateOrCreate(
            ['slug' => 'leadership-training'],
            [
                'title_en' => 'Leadership Training',
                'title_ar' => 'التدريب القيادي',
                'summary_en' => 'Practical leadership training for youth volunteers and community teams.',
                'summary_ar' => 'تدريب قيادي عملي للشباب المتطوعين وفرق المجتمع.',
                'body_en' => 'GilwellSyria prepares youth leaders through structured learning, mentoring, and service projects.',
                'body_ar' => 'تؤهل جيلويل سوريا قادة شباب من خلال تعلم منظم وإرشاد ومشاريع خدمة.',
                'image_path' => 'cms/programs/leadership-training.jpg',
                'document_path' => 'cms/programs/leadership-training.pdf',
                'sort_order' => 1,
                'status' => PublishStatus::Published,
                'published_at' => $publishedAt,
            ],
        );

        ImpactMetric::query()->updateOrCreate(
            ['label_en' => 'Youth reached'],
            [
                'label_ar' => 'الشباب المستفيدون',
                'value' => '1200',
                'unit_en' => 'participants',
                'unit_ar' => 'مشارك',
                'description_en' => 'Participants reached through training and service activities.',
                'description_ar' => 'مشاركون وصلتهم أنشطة التدريب والخدمة.',
                'sort_order' => 1,
                'status' => PublishStatus::Published,
                'published_at' => $publishedAt,
            ],
        );

        ImpactStory::query()->updateOrCreate(
            ['slug' => 'leaders-serving-communities'],
            [
                'title_en' => 'Leaders serving communities',
                'title_ar' => 'قادة في خدمة المجتمع',
                'summary_en' => 'A youth team translated training into practical neighborhood service.',
                'summary_ar' => 'حوّل فريق شبابي التدريب إلى خدمة عملية في الحي.',
                'body_en' => 'After completing leadership modules, participants planned and delivered a community activity with local partners.',
                'body_ar' => 'بعد إكمال وحدات القيادة، خطط المشاركون ونفذوا نشاطا مجتمعيا مع شركاء محليين.',
                'seo_title_en' => 'GilwellSyria impact story',
                'seo_title_ar' => 'قصة أثر جيلويل سوريا',
                'seo_description_en' => 'A starter impact story for public smoke tests.',
                'seo_description_ar' => 'قصة أثر أولية لاختبارات الواجهة العامة.',
                'image_path' => 'cms/impact/leaders-serving-communities.jpg',
                'sort_order' => 1,
                'status' => PublishStatus::Published,
                'published_at' => $publishedAt,
            ],
        );

        Partner::query()->updateOrCreate(
            ['slug' => 'community-partner'],
            [
                'name_en' => 'Community Partner',
                'name_ar' => 'شريك مجتمعي',
                'description_en' => 'A sample partner supporting youth leadership programs.',
                'description_ar' => 'شريك تجريبي يدعم برامج القيادة الشبابية.',
                'logo_path' => 'cms/partners/community-partner.svg',
                'website_url' => 'https://partner.example.test',
                'sort_order' => 1,
                'status' => PublishStatus::Published,
                'published_at' => $publishedAt,
            ],
        );

        $album = GalleryAlbum::query()->updateOrCreate(
            ['slug' => 'field-activities'],
            [
                'title_en' => 'Field Activities',
                'title_ar' => 'أنشطة ميدانية',
                'description_en' => 'Starter gallery album for training and service moments.',
                'description_ar' => 'ألبوم أولي للحظات التدريب والخدمة.',
                'cover_image_path' => 'cms/gallery/field-activities-cover.jpg',
                'sort_order' => 1,
                'status' => PublishStatus::Published,
                'published_at' => $publishedAt,
            ],
        );

        MediaItem::query()->updateOrCreate(
            ['path' => 'cms/gallery/field-activity-01.jpg'],
            [
                'gallery_album_id' => $album->id,
                'media_type' => MediaType::Image,
                'thumbnail_path' => 'cms/gallery/field-activity-01-thumb.jpg',
                'title_en' => 'Training circle',
                'title_ar' => 'حلقة تدريب',
                'alt_text_en' => 'Youth participants in a training circle',
                'alt_text_ar' => 'مشاركون شباب في حلقة تدريب',
                'caption_en' => 'Participants reflect during a leadership training session.',
                'caption_ar' => 'مشاركون يتأملون خلال جلسة تدريب قيادي.',
                'sort_order' => 1,
                'status' => PublishStatus::Published,
                'published_at' => $publishedAt,
            ],
        );

        NewsPost::query()->updateOrCreate(
            ['slug' => 'new-training-cycle'],
            [
                'title_en' => 'New training cycle opens',
                'title_ar' => 'افتتاح دورة تدريبية جديدة',
                'summary_en' => 'GilwellSyria opens registration for a new youth leadership cycle.',
                'summary_ar' => 'تفتح جيلويل سوريا التسجيل لدورة قيادة شبابية جديدة.',
                'body_en' => 'The starter news post gives the public site real bilingual content for smoke testing.',
                'body_ar' => 'يوفر هذا الخبر الأولي محتوى ثنائي اللغة لاختبار الواجهة العامة.',
                'seo_title_en' => 'New GilwellSyria training cycle',
                'seo_title_ar' => 'دورة تدريبية جديدة من جيلويل سوريا',
                'seo_description_en' => 'Starter news content for GilwellSyria.',
                'seo_description_ar' => 'محتوى خبري أولي لجيلويل سوريا.',
                'image_path' => 'cms/news/new-training-cycle.jpg',
                'document_path' => null,
                'sort_order' => 1,
                'status' => PublishStatus::Published,
                'published_at' => $publishedAt,
            ],
        );

        Event::query()->updateOrCreate(
            ['slug' => 'introductory-open-day'],
            [
                'title_en' => 'Introductory Open Day',
                'title_ar' => 'يوم تعريفي مفتوح',
                'summary_en' => 'A public open day introducing the leadership training pathway.',
                'summary_ar' => 'يوم مفتوح للتعريف بمسار التدريب القيادي.',
                'body_en' => 'Visitors can meet trainers, ask questions, and learn how to join future activities.',
                'body_ar' => 'يمكن للزوار لقاء المدربين وطرح الأسئلة ومعرفة كيفية الانضمام للأنشطة القادمة.',
                'location_en' => 'Damascus',
                'location_ar' => 'دمشق',
                'starts_at' => $publishedAt->copy()->addWeeks(2)->setTime(10, 0),
                'ends_at' => $publishedAt->copy()->addWeeks(2)->setTime(13, 0),
                'seo_title_en' => 'GilwellSyria open day',
                'seo_title_ar' => 'يوم تعريفي لجيلويل سوريا',
                'seo_description_en' => 'Starter event content for public smoke tests.',
                'seo_description_ar' => 'محتوى فعالية أولي لاختبارات الواجهة العامة.',
                'image_path' => 'cms/events/introductory-open-day.jpg',
                'document_path' => null,
                'sort_order' => 1,
                'status' => PublishStatus::Published,
                'published_at' => $publishedAt,
            ],
        );

        $this->command?->info('Seeded local CMS users: admin@gilwellsyria.local / password, editor@gilwellsyria.local / password');
        $this->command?->info("Seeded starter program: {$program->slug}");
    }

    /**
     * @return array<int, array<string, mixed>>
     */
    private function starterPages(mixed $publishedAt): array
    {
        return [
            [
                'slug' => 'home',
                'title_en' => 'Home',
                'title_ar' => 'الرئيسية',
                'summary_en' => 'A bilingual home page for GilwellSyria.',
                'summary_ar' => 'صفحة رئيسية ثنائية اللغة لجيلويل سوريا.',
                'body_en' => 'GilwellSyria equips young people with leadership skills and service-minded training.',
                'body_ar' => 'تمنح جيلويل سوريا الشباب مهارات القيادة والتدريب المرتبط بروح الخدمة.',
                'seo_title_en' => 'GilwellSyria',
                'seo_title_ar' => 'جيلويل سوريا',
                'seo_description_en' => 'GilwellSyria youth leadership and service programs.',
                'seo_description_ar' => 'برامج القيادة والخدمة الشبابية في جيلويل سوريا.',
                'hero_image_path' => 'cms/pages/home-hero.jpg',
                'sort_order' => 1,
                'status' => PublishStatus::Published,
                'published_at' => $publishedAt,
            ],
            [
                'slug' => 'about',
                'title_en' => 'About GilwellSyria',
                'title_ar' => 'عن جيلويل سوريا',
                'summary_en' => 'An established nonprofit training youth leaders.',
                'summary_ar' => 'منظمة أهلية راسخة تدرب قادة شباب.',
                'body_en' => 'The about page gives the public site bilingual credibility content for v1.',
                'body_ar' => 'توفر صفحة التعريف محتوى موثوقا ثنائي اللغة للنسخة الأولى.',
                'seo_title_en' => 'About GilwellSyria',
                'seo_title_ar' => 'عن جيلويل سوريا',
                'seo_description_en' => 'Learn about GilwellSyria mission and work.',
                'seo_description_ar' => 'تعرف على رسالة جيلويل سوريا وعملها.',
                'hero_image_path' => 'cms/pages/about-hero.jpg',
                'sort_order' => 2,
                'status' => PublishStatus::Published,
                'published_at' => $publishedAt,
            ],
            [
                'slug' => 'programs',
                'title_en' => 'Programs',
                'title_ar' => 'البرامج',
                'summary_en' => 'Training and service pathways for youth leaders.',
                'summary_ar' => 'مسارات تدريب وخدمة لقادة الشباب.',
                'body_en' => 'The programs page introduces the core public program listing.',
                'body_ar' => 'تعرض صفحة البرامج قائمة البرامج العامة الأساسية.',
                'seo_title_en' => 'GilwellSyria programs',
                'seo_title_ar' => 'برامج جيلويل سوريا',
                'seo_description_en' => 'Explore GilwellSyria leadership and service programs.',
                'seo_description_ar' => 'استكشف برامج القيادة والخدمة في جيلويل سوريا.',
                'hero_image_path' => 'cms/pages/programs-hero.jpg',
                'sort_order' => 3,
                'status' => PublishStatus::Published,
                'published_at' => $publishedAt,
            ],
        ];
    }
}
