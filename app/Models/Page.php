<?php

namespace App\Models;

use App\Models\Concerns\HasPublicationWorkflow;
use Database\Factories\PageFactory;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Page extends Model
{
    /** @use HasFactory<PageFactory> */
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
            'sort_order' => 'integer',
            ...$this->publishableCasts(),
        ];
    }
}
