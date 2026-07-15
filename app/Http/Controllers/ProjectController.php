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

        return view('projects.show', compact('project', 'profile', 'moreProjects'));
    }
}
