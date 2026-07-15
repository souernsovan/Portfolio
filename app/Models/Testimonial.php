<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class Testimonial extends Model
{
    protected $fillable = [
        'author_name',
        'author_role',
        'author_avatar_url',
        'content',
        'rating',
        'sort_order',
    ];
}
