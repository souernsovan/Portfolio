<?php

namespace App\Http\Controllers;

use App\Models\Experience;
use App\Models\Profile;
use App\Models\Project;
use App\Models\Skill;
use App\Models\Testimonial;
use Illuminate\View\View;

class HomeController extends Controller
{
    public function index(): View
    {
        $profile = Profile::first();
        $projects = Project::orderByDesc('featured')->orderBy('sort_order')->orderByDesc('id')->get();
        $skills = Skill::with('category')->orderBy('sort_order')->get()
            ->sortBy(fn (Skill $skill) => $skill->category?->name)
            ->groupBy(fn (Skill $skill) => $skill->category?->name ?? 'Other');
        $experiences = Experience::orderByDesc('start_date')->get();
        $testimonials = Testimonial::orderBy('sort_order')->orderByDesc('id')->get();

        $earliestStart = $experiences->min('start_date');

        $stats = [
            'years_experience' => $earliestStart ? max(1, (int) floor(now()->diffInYears($earliestStart, absolute: true))) : null,
            'projects' => $projects->count(),
            'technologies' => $skills->flatten()->count(),
            'happy_clients' => $testimonials->count(),
        ];

        return view('home', compact('profile', 'projects', 'skills', 'experiences', 'testimonials', 'stats'));
    }
}
