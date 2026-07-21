<?php

namespace App\Models;

use App\Enums\MediaType;
use App\Models\Concerns\HasPublicationWorkflow;
use Database\Factories\MediaItemFactory;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsTo;

class MediaItem extends Model
{
    /** @use HasFactory<MediaItemFactory> */
    use HasFactory, HasPublicationWorkflow;

    /**
     * @var array<int, string>
     */
    protected $guarded = ['id'];

    /**
     * @return BelongsTo<GalleryAlbum, $this>
     */
    public function galleryAlbum(): BelongsTo
    {
        return $this->belongsTo(GalleryAlbum::class);
    }

    /**
     * @return array<string, string>
     */
    protected function casts(): array
    {
        return [
            'media_type' => MediaType::class,
            'sort_order' => 'integer',
            ...$this->publishableCasts(),
        ];
    }
}
