<?php

namespace App\Http\Controllers;

use App\Models\Profile;
use App\Models\Project;
use Illuminate\View\View;

class ProjectController extends Controller
{
    public function show(Project $project): View
    {
        $profile = Profile::first();

        $moreProjects = Project::where('id', '!=', $project->id)
            ->orderByDesc('featured')
            ->orderBy('sort_order')
            ->take(2)
            ->get();

        $seoTitle = $project->title.' — '.($profile->name ?? 'Portfolio');
        $seoDescription = $project->summary;
        $seoImage = $project->image_url ?? $profile?->avatar_url;
        $seoUrl = route('projects.show', $project);
        $seoType = 'article';

        return view('projects.show', compact(
            'project', 'profile', 'moreProjects',
            'seoTitle', 'seoDescription', 'seoImage', 'seoUrl', 'seoType'
        ));
    }
}
