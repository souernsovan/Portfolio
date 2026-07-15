@csrf

<div class="space-y-5">
    <div>
        <label for="title" class="text-muted mb-1.5 block text-sm">Title</label>
        <input type="text" name="title" id="title" value="{{ old('title', $project->title ?? '') }}" required
            class="field-input w-full rounded-lg px-4 py-2.5 text-sm">
        @error('title')<p class="mt-1 text-xs text-red-600 dark:text-red-400">{{ $message }}</p>@enderror
    </div>

    <div>
        <label for="summary" class="text-muted mb-1.5 block text-sm">Short summary</label>
        <input type="text" name="summary" id="summary" value="{{ old('summary', $project->summary ?? '') }}" required maxlength="500"
            class="field-input w-full rounded-lg px-4 py-2.5 text-sm">
        @error('summary')<p class="mt-1 text-xs text-red-600 dark:text-red-400">{{ $message }}</p>@enderror
    </div>

    <div>
        <label for="description" class="text-muted mb-1.5 block text-sm">Full description (optional)</label>
        <textarea name="description" id="description" rows="4"
            class="field-input w-full rounded-lg px-4 py-2.5 text-sm">{{ old('description', $project->description ?? '') }}</textarea>
    </div>

    <div>
        <label class="text-muted mb-1.5 block text-sm">Project image</label>
        <div class="flex items-center gap-5">
            <span id="project-image-preview-wrap" class="surface-2 flex h-20 w-32 shrink-0 items-center justify-center overflow-hidden rounded-lg text-xs">
                @if(!empty($project->image_url ?? null))
                    <img id="project-image-preview" src="{{ $project->image_url }}" alt="{{ $project->title }}" class="h-full w-full object-cover">
                @else
                    <img id="project-image-preview" src="" alt="" class="hidden h-full w-full object-cover">
                    <span id="project-image-preview-fallback" class="text-faint">No image</span>
                @endif
            </span>
            <div>
                <label for="image" class="btn-outline inline-block cursor-pointer rounded-lg px-4 py-2 text-sm font-medium">
                    Choose image
                    <input type="file" name="image" id="image" accept="image/*" class="hidden">
                </label>
                @if(!empty($project->image_url ?? null))
                    <label class="text-muted mt-2 flex items-center gap-2 text-sm">
                        <input type="checkbox" name="remove_image" value="1" class="border-app rounded bg-transparent text-red-600 focus:ring-red-500/50 dark:text-red-400">
                        Remove current image
                    </label>
                @endif
                @error('image')<p class="mt-1 text-xs text-red-600 dark:text-red-400">{{ $message }}</p>@enderror
                <p class="text-faint mt-1 text-xs">JPG, PNG or WEBP. Max 4MB.</p>
            </div>
        </div>
    </div>

    <div>
        <label for="tech_stack" class="text-muted mb-1.5 block text-sm">Tech stack (comma separated)</label>
        <input type="text" name="tech_stack" id="tech_stack" value="{{ old('tech_stack', $project->tech_stack ?? '') }}" placeholder="Laravel, Vue, MySQL"
            class="field-input w-full rounded-lg px-4 py-2.5 text-sm">
    </div>

    <div class="grid gap-5 sm:grid-cols-2">
        <div>
            <label for="project_url" class="text-muted mb-1.5 block text-sm">Live URL</label>
            <input type="text" name="project_url" id="project_url" value="{{ old('project_url', $project->project_url ?? '') }}"
                class="field-input w-full rounded-lg px-4 py-2.5 text-sm">
        </div>
        <div>
            <label for="github_url" class="text-muted mb-1.5 block text-sm">GitHub URL</label>
            <input type="text" name="github_url" id="github_url" value="{{ old('github_url', $project->github_url ?? '') }}"
                class="field-input w-full rounded-lg px-4 py-2.5 text-sm">
        </div>
    </div>

    <div class="grid gap-5 sm:grid-cols-2">
        <div>
            <label for="sort_order" class="text-muted mb-1.5 block text-sm">Sort order</label>
            <input type="number" name="sort_order" id="sort_order" value="{{ old('sort_order', $project->sort_order ?? 0) }}"
                class="field-input w-full rounded-lg px-4 py-2.5 text-sm">
        </div>
        <label class="text-muted mt-7 flex items-center gap-2 text-sm">
            <input type="checkbox" name="featured" value="1" {{ old('featured', $project->featured ?? false) ? 'checked' : '' }}
                class="border-app rounded bg-transparent text-emerald-600 focus:ring-emerald-500/50 dark:text-emerald-400 dark:focus:ring-emerald-400/50">
            Featured project
        </label>
    </div>

    <div class="flex gap-3 pt-2">
        <button type="submit" class="btn-primary rounded-lg px-6 py-3 text-sm font-semibold">
            Save
        </button>
        <a href="{{ route('admin.projects.index') }}" class="border-app text-body rounded-lg border px-6 py-3 text-sm font-semibold hover:border-neutral-400 dark:hover:border-white/30">
            Cancel
        </a>
    </div>
</div>

<script>
    document.getElementById('image')?.addEventListener('change', (event) => {
        const file = event.target.files?.[0];
        if (!file) return;

        const preview = document.getElementById('project-image-preview');
        const fallback = document.getElementById('project-image-preview-fallback');
        const reader = new FileReader();
        reader.onload = () => {
            preview.src = reader.result;
            preview.classList.remove('hidden');
            fallback?.classList.add('hidden');
        };
        reader.readAsDataURL(file);
    });
</script>
