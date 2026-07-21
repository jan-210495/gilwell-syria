<?php

namespace App\Models;

use App\Models\Concerns\HasPublicationWorkflow;
use Database\Factories\EventFactory;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Event extends Model
{
    /** @use HasFactory<EventFactory> */
    use HasFactory, HasPublicationWorkflow;

    /**
     * @var array<int, string>
     */
    protected $guarded = ['id'];

    public function getRouteKeyName(): string
    {
        return 'slug';
    }

    /**
     * @return array<string, string>
     */
    protected function casts(): array
    {
        return [
            'starts_at' => 'datetime',
            'ends_at' => 'datetime',
            'sort_order' => 'integer',
            ...$this->publishableCasts(),
        ];
    }
}
