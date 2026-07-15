<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class Project extends Model
{
    protected $fillable = [
        'title',
        'slug',
        'summary',
        'description',
        'image_url',
        'tech_stack',
        'project_url',
        'github_url',
        'featured',
        'sort_order',
    ];

    protected $casts = [
        'featured' => 'boolean',
    ];

    public function techStackList(): array
    {
        return array_filter(array_map('trim', explode(',', (string) $this->tech_stack)));
    }

    public function getRouteKeyName(): string
    {
        return 'slug';
    }
}
