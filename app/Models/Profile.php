<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class Profile extends Model
{
    protected $fillable = [
        'name',
        'role',
        'tagline',
        'about',
        'email',
        'location',
        'avatar_url',
        'resume_url',
        'github_url',
        'linkedin_url',
        'twitter_url',
    ];
}
