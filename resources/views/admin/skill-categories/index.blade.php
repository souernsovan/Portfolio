<x-admin-layout title="Skill Categories" subtitle="Manage the categories skills can be grouped under.">
    <div class="mb-6 flex justify-end">
        <a href="{{ route('admin.skills.index') }}" class="border-app text-body rounded-lg border px-4 py-2 text-sm font-semibold hover:border-neutral-400 dark:hover:border-white/30">
            &larr; Back to skills
        </a>
    </div>

    <div class="panel-card mb-6 rounded-2xl border p-6">
        <h2 class="text-heading mb-4 font-medium">Add category</h2>
        <form method="POST" action="{{ route('admin.skill-categories.store') }}" class="flex flex-wrap items-start gap-3">
            @csrf
            <div class="flex-1" style="min-width: 200px">
                <input type="text" name="name" placeholder="e.g. DevOps" required
                    class="field-input w-full rounded-lg px-4 py-2.5 text-sm">
                @error('name')<p class="mt-1 text-xs text-red-600 dark:text-red-400">{{ $message }}</p>@enderror
            </div>
            <button type="submit" class="btn-primary rounded-lg px-6 py-2.5 text-sm font-semibold">
                Add
            </button>
        </form>
    </div>

    <div class="border-app overflow-x-auto rounded-xl border">
        <table class="w-full text-left text-sm">
            <thead>
                <tr class="thead-row text-faint border-b text-xs font-semibold uppercase tracking-wider">
                    <th class="px-4 py-3 font-medium">Name</th>
                    <th class="px-4 py-3 font-medium">Skills using it</th>
                    <th class="px-4 py-3 text-right font-medium">Actions</th>
                </tr>
            </thead>
            <tbody class="divide-app">
                @forelse($categories as $category)
                    <tr class="row-hover transition">
                        <td class="px-4 py-3">
                            <form method="POST" action="{{ route('admin.skill-categories.update', $category) }}" class="flex items-center gap-2">
                                @csrf
                                @method('PUT')
                                <input type="text" name="name" value="{{ $category->name }}"
                                    class="field-input w-full max-w-xs rounded-lg px-3 py-1.5 text-sm">
                                <button type="submit" class="link-accent text-sm font-medium">Save</button>
                            </form>
                        </td>
                        <td class="text-muted px-4 py-3">{{ $category->skills_count }} skill{{ $category->skills_count === 1 ? '' : 's' }}</td>
                        <td class="px-4 py-3">
                            <div class="flex items-center justify-end gap-4">
                                <form method="POST" action="{{ route('admin.skill-categories.destroy', $category) }}" onsubmit="return confirm('Delete this category?')">
                                    @csrf
                                    @method('DELETE')
                                    <button type="submit" class="text-red-600 hover:text-red-700 dark:text-red-400 dark:hover:text-red-300">Delete</button>
                                </form>
                            </div>
                        </td>
                    </tr>
                @empty
                    @include('admin.partials.empty-row', [
                        'colspan' => 3,
                        'message' => 'No categories yet.',
                    ])
                @endforelse
            </tbody>
        </table>
    </div>
</x-admin-layout>
