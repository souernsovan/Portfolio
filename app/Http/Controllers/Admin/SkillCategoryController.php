<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Models\SkillCategory;
use Illuminate\Http\RedirectResponse;
use Illuminate\Http\Request;
use Illuminate\View\View;

class SkillCategoryController extends Controller
{
    public function index(): View
    {
        $categories = SkillCategory::withCount('skills')->orderBy('sort_order')->orderBy('name')->get();

        return view('admin.skill-categories.index', compact('categories'));
    }

    public function store(Request $request): RedirectResponse
    {
        $data = $request->validate([
            'name' => ['required', 'string', 'max:255', 'unique:skill_categories,name'],
        ]);

        $data['sort_order'] = SkillCategory::max('sort_order') + 1;

        SkillCategory::create($data);

        return redirect()->route('admin.skill-categories.index')->with('status', 'Category added.');
    }

    public function update(Request $request, SkillCategory $skillCategory): RedirectResponse
    {
        $data = $request->validate([
            'name' => ['required', 'string', 'max:255', 'unique:skill_categories,name,' . $skillCategory->id],
        ]);

        $skillCategory->update($data);

        return redirect()->route('admin.skill-categories.index')->with('status', 'Category updated.');
    }

    public function destroy(SkillCategory $skillCategory): RedirectResponse
    {
        if ($skillCategory->skills()->exists()) {
            return redirect()->route('admin.skill-categories.index')
                ->with('status', "Can't delete \"{$skillCategory->name}\" — it still has skills assigned to it.");
        }

        $skillCategory->delete();

        return redirect()->route('admin.skill-categories.index')->with('status', 'Category deleted.');
    }
}
