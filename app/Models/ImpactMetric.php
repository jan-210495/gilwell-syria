<?php

namespace App\Models;

use App\Models\Concerns\HasPublicationWorkflow;
use Database\Factories\ImpactMetricFactory;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class ImpactMetric extends Model
{
    /** @use HasFactory<ImpactMetricFactory> */
    use HasFactory, HasPublicationWorkflow;

    /**
     * @var array<int, string>
     */
    protected $guarded = ['id'];

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
