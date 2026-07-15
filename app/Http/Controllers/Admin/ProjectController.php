<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Models\Project;
use Illuminate\Http\RedirectResponse;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Storage;
use Illuminate\Support\Str;
use Illuminate\View\View;

class ProjectController extends Controller
{
    public function index(): View
    {
        $projects = Project::orderBy('sort_order')->orderByDesc('id')->get();

        return view('admin.projects.index', compact('projects'));
    }

    public function create(): View
    {
        return view('admin.projects.create');
    }

    public function store(Request $request): RedirectResponse
    {
        $data = $this->validateData($request);
        $data['slug'] = $this->uniqueSlug($data['title']);

        if ($request->hasFile('image')) {
            $data['image_url'] = Storage::url($request->file('image')->store('projects', 'public'));
        }

        Project::create($data);

        return redirect()->route('admin.projects.index')->with('status', 'Project created.');
    }

    public function edit(Project $project): View
    {
        return view('admin.projects.edit', compact('project'));
    }

    public function update(Request $request, Project $project): RedirectResponse
    {
        $data = $this->validateData($request);

        if ($data['title'] !== $project->title) {
            $data['slug'] = $this->uniqueSlug($data['title'], $project->id);
        }

        if ($request->hasFile('image')) {
            $this->deleteStoredImage($project);
            $data['image_url'] = Storage::url($request->file('image')->store('projects', 'public'));
        } elseif ($request->boolean('remove_image')) {
            $this->deleteStoredImage($project);
            $data['image_url'] = null;
        }

        $project->update($data);

        return redirect()->route('admin.projects.index')->with('status', 'Project updated.');
    }

    public function destroy(Project $project): RedirectResponse
    {
        $this->deleteStoredImage($project);
        $project->delete();

        return redirect()->route('admin.projects.index')->with('status', 'Project deleted.');
    }

    private function validateData(Request $request): array
    {
        $data = $request->validate([
            'title' => ['required', 'string', 'max:255'],
            'summary' => ['required', 'string', 'max:500'],
            'description' => ['nullable', 'string'],
            'image' => ['nullable', 'image', 'max:4096'],
            'remove_image' => ['nullable', 'boolean'],
            'tech_stack' => ['nullable', 'string', 'max:500'],
            'project_url' => ['nullable', 'string', 'max:2048'],
            'github_url' => ['nullable', 'string', 'max:2048'],
            'sort_order' => ['nullable', 'integer'],
        ]);

        $data['featured'] = $request->boolean('featured');
        $data['sort_order'] = $data['sort_order'] ?? 0;

        unset($data['image'], $data['remove_image']);

        return $data;
    }

    private function uniqueSlug(string $title, ?int $ignoreId = null): string
    {
        $base = Str::slug($title);
        $slug = $base;
        $i = 1;

        while (Project::where('slug', $slug)->when($ignoreId, fn ($q) => $q->where('id', '!=', $ignoreId))->exists()) {
            $slug = "{$base}-{$i}";
            $i++;
        }

        return $slug;
    }

    private function deleteStoredImage(Project $project): void
    {
        if ($project->image_url && str_starts_with($project->image_url, '/storage/')) {
            Storage::disk('public')->delete(str_replace('/storage/', '', $project->image_url));
        }
    }
}
