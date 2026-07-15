@csrf

<div class="space-y-5">
    <div class="grid gap-5 sm:grid-cols-2">
        <div>
            <label for="role" class="text-muted mb-1.5 block text-sm">Role / title</label>
            <input type="text" name="role" id="role" value="{{ old('role', $experience->role ?? '') }}" required
                class="field-input w-full rounded-lg px-4 py-2.5 text-sm">
            @error('role')<p class="mt-1 text-xs text-red-600 dark:text-red-400">{{ $message }}</p>@enderror
        </div>
        <div>
            <label for="company" class="text-muted mb-1.5 block text-sm">Company</label>
            <input type="text" name="company" id="company" value="{{ old('company', $experience->company ?? '') }}" required
                class="field-input w-full rounded-lg px-4 py-2.5 text-sm">
            @error('company')<p class="mt-1 text-xs text-red-600 dark:text-red-400">{{ $message }}</p>@enderror
        </div>
    </div>

    <div>
        <label for="location" class="text-muted mb-1.5 block text-sm">Location (optional)</label>
        <input type="text" name="location" id="location" value="{{ old('location', $experience->location ?? '') }}"
            class="field-input w-full rounded-lg px-4 py-2.5 text-sm">
    </div>

    <div class="grid gap-5 sm:grid-cols-2">
        <div>
            <label for="start_date" class="text-muted mb-1.5 block text-sm">Start date</label>
            <input type="date" name="start_date" id="start_date" value="{{ old('start_date', optional($experience->start_date ?? null)->format('Y-m-d')) }}" required
                class="field-input w-full rounded-lg px-4 py-2.5 text-sm">
            @error('start_date')<p class="mt-1 text-xs text-red-600 dark:text-red-400">{{ $message }}</p>@enderror
        </div>
        <div>
            <label for="end_date" class="text-muted mb-1.5 block text-sm">End date (leave blank if current)</label>
            <input type="date" name="end_date" id="end_date" value="{{ old('end_date', optional($experience->end_date ?? null)->format('Y-m-d')) }}"
                class="field-input w-full rounded-lg px-4 py-2.5 text-sm">
            @error('end_date')<p class="mt-1 text-xs text-red-600 dark:text-red-400">{{ $message }}</p>@enderror
        </div>
    </div>

    <div>
        <label for="description" class="text-muted mb-1.5 block text-sm">Description (optional)</label>
        <textarea name="description" id="description" rows="4"
            class="field-input w-full rounded-lg px-4 py-2.5 text-sm">{{ old('description', $experience->description ?? '') }}</textarea>
    </div>

    <div>
        <label for="sort_order" class="text-muted mb-1.5 block text-sm">Sort order</label>
        <input type="number" name="sort_order" id="sort_order" value="{{ old('sort_order', $experience->sort_order ?? 0) }}"
            class="field-input w-full max-w-xs rounded-lg px-4 py-2.5 text-sm">
    </div>

    <div class="flex gap-3 pt-2">
        <button type="submit" class="btn-primary rounded-lg px-6 py-3 text-sm font-semibold">
            Save
        </button>
        <a href="{{ route('admin.experiences.index') }}" class="border-app text-body rounded-lg border px-6 py-3 text-sm font-semibold hover:border-neutral-400 dark:hover:border-white/30">
            Cancel
        </a>
    </div>
</div>
