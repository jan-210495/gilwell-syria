<?php

use App\Enums\MediaType;
use App\Enums\PublishStatus;
use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    public function up(): void
    {
        Schema::create('site_settings', function (Blueprint $table) {
            $table->id();
            $table->string('key')->unique();
            $table->string('site_name_en');
            $table->string('site_name_ar');
            $table->string('tagline_en')->nullable();
            $table->string('tagline_ar')->nullable();
            $table->string('contact_email')->nullable();
            $table->string('contact_phone')->nullable();
            $table->string('whatsapp_phone')->nullable();
            $table->text('address_en')->nullable();
            $table->text('address_ar')->nullable();
            $table->string('office_hours_en')->nullable();
            $table->string('office_hours_ar')->nullable();
            $table->string('map_url')->nullable();
            $table->string('facebook_url')->nullable();
            $table->string('instagram_url')->nullable();
            $table->string('youtube_url')->nullable();
            $table->string('partnership_email')->nullable();
            $table->timestamps();
        });

        Schema::create('pages', function (Blueprint $table) {
            $table->id();
            $table->string('slug')->unique();
            $this->titleBodyColumns($table);
            $this->seoColumns($table);
            $table->string('hero_image_path')->nullable();
            $this->sortColumn($table);
            $this->publishColumns($table);
            $table->timestamps();
        });

        Schema::create('programs', function (Blueprint $table) {
            $table->id();
            $table->string('slug')->unique();
            $this->titleBodyColumns($table);
            $table->string('image_path')->nullable();
            $table->string('document_path')->nullable();
            $this->sortColumn($table);
            $this->publishColumns($table);
            $table->timestamps();
        });

        Schema::create('impact_metrics', function (Blueprint $table) {
            $table->id();
            $table->string('label_en');
            $table->string('label_ar');
            $table->string('value');
            $table->string('unit_en')->nullable();
            $table->string('unit_ar')->nullable();
            $table->text('description_en')->nullable();
            $table->text('description_ar')->nullable();
            $this->sortColumn($table);
            $this->publishColumns($table);
            $table->timestamps();
        });

        Schema::create('impact_stories', function (Blueprint $table) {
            $table->id();
            $table->string('slug')->unique();
            $this->titleBodyColumns($table);
            $this->seoColumns($table);
            $table->string('image_path')->nullable();
            $this->sortColumn($table);
            $this->publishColumns($table);
            $table->timestamps();
        });

        Schema::create('partners', function (Blueprint $table) {
            $table->id();
            $table->string('slug')->unique();
            $table->string('name_en');
            $table->string('name_ar');
            $table->text('description_en')->nullable();
            $table->text('description_ar')->nullable();
            $table->string('logo_path')->nullable();
            $table->string('website_url')->nullable();
            $this->sortColumn($table);
            $this->publishColumns($table);
            $table->timestamps();
        });

        Schema::create('gallery_albums', function (Blueprint $table) {
            $table->id();
            $table->string('slug')->unique();
            $table->string('title_en');
            $table->string('title_ar');
            $table->text('description_en')->nullable();
            $table->text('description_ar')->nullable();
            $table->string('cover_image_path')->nullable();
            $this->sortColumn($table);
            $this->publishColumns($table);
            $table->timestamps();
        });

        Schema::create('media_items', function (Blueprint $table) {
            $table->id();
            $table->foreignId('gallery_album_id')->nullable()->constrained()->nullOnDelete();
            $table->string('media_type')->default(MediaType::Image->value)->index();
            $table->string('path');
            $table->string('thumbnail_path')->nullable();
            $table->string('title_en')->nullable();
            $table->string('title_ar')->nullable();
            $table->string('alt_text_en')->nullable();
            $table->string('alt_text_ar')->nullable();
            $table->text('caption_en')->nullable();
            $table->text('caption_ar')->nullable();
            $this->sortColumn($table);
            $this->publishColumns($table);
            $table->timestamps();
        });

        Schema::create('news_posts', function (Blueprint $table) {
            $table->id();
            $table->string('slug')->unique();
            $this->titleBodyColumns($table);
            $this->seoColumns($table);
            $table->string('image_path')->nullable();
            $table->string('document_path')->nullable();
            $this->sortColumn($table);
            $this->publishColumns($table);
            $table->timestamps();
        });

        Schema::create('events', function (Blueprint $table) {
            $table->id();
            $table->string('slug')->unique();
            $this->titleBodyColumns($table);
            $table->string('location_en')->nullable();
            $table->string('location_ar')->nullable();
            $table->dateTime('starts_at')->nullable()->index();
            $table->dateTime('ends_at')->nullable();
            $this->seoColumns($table);
            $table->string('image_path')->nullable();
            $table->string('document_path')->nullable();
            $this->sortColumn($table);
            $this->publishColumns($table);
            $table->timestamps();
        });
    }

    public function down(): void
    {
        Schema::dropIfExists('events');
        Schema::dropIfExists('news_posts');
        Schema::dropIfExists('media_items');
        Schema::dropIfExists('gallery_albums');
        Schema::dropIfExists('partners');
        Schema::dropIfExists('impact_stories');
        Schema::dropIfExists('impact_metrics');
        Schema::dropIfExists('programs');
        Schema::dropIfExists('pages');
        Schema::dropIfExists('site_settings');
    }

    private function titleBodyColumns(Blueprint $table): void
    {
        $table->string('title_en');
        $table->string('title_ar');
        $table->text('summary_en')->nullable();
        $table->text('summary_ar')->nullable();
        $table->longText('body_en')->nullable();
        $table->longText('body_ar')->nullable();
    }

    private function seoColumns(Blueprint $table): void
    {
        $table->string('seo_title_en')->nullable();
        $table->string('seo_title_ar')->nullable();
        $table->text('seo_description_en')->nullable();
        $table->text('seo_description_ar')->nullable();
    }

    private function sortColumn(Blueprint $table): void
    {
        $table->unsignedInteger('sort_order')->default(0)->index();
    }

    private function publishColumns(Blueprint $table): void
    {
        $table->string('status')->default(PublishStatus::Draft->value)->index();
        $table->timestamp('published_at')->nullable()->index();
    }
};
