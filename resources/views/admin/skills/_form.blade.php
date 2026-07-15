@csrf

<div class="space-y-5">
    <div>
        <label for="name" class="text-muted mb-1.5 block text-sm">Name</label>
        <input type="text" name="name" id="name" value="{{ old('name', $skill->name ?? '') }}" required
            class="field-input w-full rounded-lg px-4 py-2.5 text-sm">
        @error('name')<p class="mt-1 text-xs text-red-600 dark:text-red-400">{{ $message }}</p>@enderror
    </div>

    @php
        $selectedCategoryId = (int) old('category_id', $skill->category_id ?? 0);
        $selectedCategory = $categories->firstWhere('id', $selectedCategoryId);
    @endphp

    <div>
        <div class="mb-1.5 flex items-center justify-between">
            <label class="text-muted block text-sm">Category</label>
            <a href="{{ route('admin.skill-categories.index') }}" class="link-accent text-xs font-medium">Manage categories</a>
        </div>

        <details id="category-picker" class="relative">
            <summary class="field-input flex w-full cursor-pointer list-none items-center justify-between rounded-lg px-4 py-2.5 text-sm [&::-webkit-details-marker]:hidden">
                <span id="category-picker-label" class="{{ $selectedCategory ? 'text-heading' : 'text-faint' }}">
                    {{ $selectedCategory->name ?? 'Choose a category…' }}
                </span>
                <svg xmlns="http://www.w3.org/2000/svg" fill="none" viewBox="0 0 24 24" stroke-width="1.5" stroke="currentColor" class="text-faint h-4 w-4 shrink-0">
                    <path stroke-linecap="round" stroke-linejoin="round" d="m19.5 8.25-7.5 7.5-7.5-7.5" />
                </svg>
            </summary>

            <div class="panel-dropdown absolute z-20 mt-2 max-h-60 w-full overflow-y-auto rounded-lg border p-1 shadow-2xl">
                @forelse($categories as $category)
                    <button type="button" data-value="{{ $category->id }}" data-label="{{ $category->name }}"
                            class="category-option nav-item block w-full rounded-lg px-3 py-2 text-left text-sm transition">
                        {{ $category->name }}
                    </button>
                @empty
                    <p class="text-faint px-3 py-2 text-sm">No categories yet.</p>
                @endforelse
            </div>
        </details>

        <input type="hidden" name="category_id" id="category_id" value="{{ $selectedCategoryId ?: '' }}">
        <p id="category_id-empty-error" class="mt-1 hidden text-xs text-red-600 dark:text-red-400">Please choose a category.</p>
        @error('category_id')<p class="mt-1 text-xs text-red-600 dark:text-red-400">{{ $message }}</p>@enderror
        @if($categories->isEmpty())
            <p class="text-faint mt-1 text-xs">No categories yet — <a href="{{ route('admin.skill-categories.index') }}" class="link-accent">create one first</a>.</p>
        @endif
    </div>

    <div class="grid gap-5 sm:grid-cols-2">
        <div>
            <label for="level" class="text-muted mb-1.5 block text-sm">Proficiency (0&ndash;100)</label>
            <input type="number" name="level" id="level" min="0" max="100" value="{{ old('level', $skill->level ?? 80) }}" required
                class="field-input w-full rounded-lg px-4 py-2.5 text-sm">
            @error('level')<p class="mt-1 text-xs text-red-600 dark:text-red-400">{{ $message }}</p>@enderror
        </div>
        <div>
            <label for="sort_order" class="text-muted mb-1.5 block text-sm">Sort order</label>
            <input type="number" name="sort_order" id="sort_order" value="{{ old('sort_order', $skill->sort_order ?? 0) }}"
                class="field-input w-full rounded-lg px-4 py-2.5 text-sm">
        </div>
    </div>

    <div class="flex gap-3 pt-2">
        <button type="submit" class="btn-primary rounded-lg px-6 py-3 text-sm font-semibold">
            Save
        </button>
        <a href="{{ route('admin.skills.index') }}" class="border-app text-body rounded-lg border px-6 py-3 text-sm font-semibold hover:border-neutral-400 dark:hover:border-white/30">
            Cancel
        </a>
    </div>
</div>

<script>
    (function () {
        const details = document.getElementById('category-picker');
        const label = document.getElementById('category-picker-label');
        const hiddenInput = document.getElementById('category_id');
        const emptyError = document.getElementById('category_id-empty-error');
        if (!details || !hiddenInput) return;

        details.querySelectorAll('.category-option').forEach((btn) => {
            btn.addEventListener('click', () => {
                hiddenInput.value = btn.dataset.value;
                label.textContent = btn.dataset.label;
                label.classList.remove('text-faint');
                label.classList.add('text-heading');
                details.removeAttribute('open');
                emptyError?.classList.add('hidden');
            });
        });

        details.closest('form')?.addEventListener('submit', (event) => {
            if (!hiddenInput.value) {
                event.preventDefault();
                details.setAttribute('open', '');
                emptyError?.classList.remove('hidden');
            }
        });
    })();
</script>
