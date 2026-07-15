<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Models\Skill;
use App\Models\SkillCategory;
use Illuminate\Http\RedirectResponse;
use Illuminate\Http\Request;
use Illuminate\View\View;

class SkillController extends Controller
{
    public function index(): View
    {
        $skills = Skill::with('category')->orderBy('sort_order')->get()
            ->sortBy(fn (Skill $skill) => $skill->category?->name)
            ->values();

        return view('admin.skills.index', compact('skills'));
    }

    public function create(): View
    {
        $categories = SkillCategory::orderBy('sort_order')->orderBy('name')->get();

        return view('admin.skills.create', compact('categories'));
    }

    public function store(Request $request): RedirectResponse
    {
        Skill::create($this->validateData($request));

        return redirect()->route('admin.skills.index')->with('status', 'Skill created.');
    }

    public function edit(Skill $skill): View
    {
        $categories = SkillCategory::orderBy('sort_order')->orderBy('name')->get();

        return view('admin.skills.edit', compact('skill', 'categories'));
    }

    public function update(Request $request, Skill $skill): RedirectResponse
    {
        $skill->update($this->validateData($request));

        return redirect()->route('admin.skills.index')->with('status', 'Skill updated.');
    }

    public function destroy(Skill $skill): RedirectResponse
    {
        $skill->delete();

        return redirect()->route('admin.skills.index')->with('status', 'Skill deleted.');
    }

    private function validateData(Request $request): array
    {
        $data = $request->validate([
            'name' => ['required', 'string', 'max:255'],
            'category_id' => ['required', 'exists:skill_categories,id'],
            'level' => ['required', 'integer', 'min:0', 'max:100'],
            'sort_order' => ['nullable', 'integer'],
        ]);

        $data['sort_order'] = $data['sort_order'] ?? 0;

        return $data;
    }
}
