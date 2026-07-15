<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsTo;

class Skill extends Model
{
    protected $fillable = [
        'name',
        'category_id',
        'level',
        'sort_order',
    ];

    public function category(): BelongsTo
    {
        return $this->belongsTo(SkillCategory::class);
    }
}
