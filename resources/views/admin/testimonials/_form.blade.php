@csrf

<div class="space-y-5">
    <div class="grid gap-5 sm:grid-cols-2">
        <div>
            <label for="author_name" class="text-muted mb-1.5 block text-sm">Author name</label>
            <input type="text" name="author_name" id="author_name" value="{{ old('author_name', $testimonial->author_name ?? '') }}" required
                class="field-input w-full rounded-lg px-4 py-2.5 text-sm">
            @error('author_name')<p class="mt-1 text-xs text-red-600 dark:text-red-400">{{ $message }}</p>@enderror
        </div>
        <div>
            <label for="author_role" class="text-muted mb-1.5 block text-sm">Author role / company (optional)</label>
            <input type="text" name="author_role" id="author_role" value="{{ old('author_role', $testimonial->author_role ?? '') }}"
                class="field-input w-full rounded-lg px-4 py-2.5 text-sm">
        </div>
    </div>

    <div>
        <label for="author_avatar_url" class="text-muted mb-1.5 block text-sm">Author avatar URL (optional)</label>
        <input type="text" name="author_avatar_url" id="author_avatar_url" value="{{ old('author_avatar_url', $testimonial->author_avatar_url ?? '') }}"
            class="field-input w-full rounded-lg px-4 py-2.5 text-sm">
    </div>

    <div>
        <label for="content" class="text-muted mb-1.5 block text-sm">Testimonial</label>
        <textarea name="content" id="content" rows="4" required
            class="field-input w-full rounded-lg px-4 py-2.5 text-sm">{{ old('content', $testimonial->content ?? '') }}</textarea>
        @error('content')<p class="mt-1 text-xs text-red-600 dark:text-red-400">{{ $message }}</p>@enderror
    </div>

    <div class="grid gap-5 sm:grid-cols-2">
        <div>
            <label for="rating" class="text-muted mb-1.5 block text-sm">Rating (1&ndash;5)</label>
            <input type="number" name="rating" id="rating" min="1" max="5" value="{{ old('rating', $testimonial->rating ?? 5) }}" required
                class="field-input w-full rounded-lg px-4 py-2.5 text-sm">
            @error('rating')<p class="mt-1 text-xs text-red-600 dark:text-red-400">{{ $message }}</p>@enderror
        </div>
        <div>
            <label for="sort_order" class="text-muted mb-1.5 block text-sm">Sort order</label>
            <input type="number" name="sort_order" id="sort_order" value="{{ old('sort_order', $testimonial->sort_order ?? 0) }}"
                class="field-input w-full rounded-lg px-4 py-2.5 text-sm">
        </div>
    </div>

    <div class="flex gap-3 pt-2">
        <button type="submit" class="btn-primary rounded-lg px-6 py-3 text-sm font-semibold">
            Save
        </button>
        <a href="{{ route('admin.testimonials.index') }}" class="border-app text-body rounded-lg border px-6 py-3 text-sm font-semibold hover:border-neutral-400 dark:hover:border-white/30">
            Cancel
        </a>
    </div>
</div>
