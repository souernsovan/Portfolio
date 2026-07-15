<x-admin-layout title="Skills">
    <div class="mb-6 flex justify-end gap-3">
        <a href="{{ route('admin.skill-categories.index') }}" class="border-app text-body rounded-lg border px-4 py-2 text-sm font-semibold hover:border-neutral-400 dark:hover:border-white/30">
            Manage categories
        </a>
        <a href="{{ route('admin.skills.create') }}" class="btn-primary rounded-lg px-4 py-2 text-sm font-semibold">
            + New skill
        </a>
    </div>

    <div class="border-app overflow-x-auto rounded-xl border">
        <table class="w-full text-left text-sm">
            <thead>
                <tr class="thead-row text-faint border-b text-xs font-semibold uppercase tracking-wider">
                    <th class="px-4 py-3 font-medium">Name</th>
                    <th class="px-4 py-3 font-medium">Category</th>
                    <th class="px-4 py-3 font-medium">Proficiency</th>
                    <th class="px-4 py-3 text-right font-medium">Actions</th>
                </tr>
            </thead>
            <tbody class="divide-app">
                @forelse($skills as $skill)
                    <tr class="row-hover transition">
                        <td class="text-heading px-4 py-3 font-medium whitespace-nowrap">{{ $skill->name }}</td>
                        <td class="text-body px-4 py-3">{{ $skill->category?->name ?? '—' }}</td>
                        <td class="px-4 py-3">
                            <div class="flex items-center gap-3">
                                <div class="h-1.5 w-32 overflow-hidden rounded-full bg-neutral-200 dark:bg-white/5">
                                    <div class="h-full rounded-full bg-emerald-500 dark:bg-emerald-400" style="width: {{ min(100, max(0, $skill->level)) }}%"></div>
                                </div>
                                <span class="text-muted">{{ $skill->level }}%</span>
                            </div>
                        </td>
                        <td class="px-4 py-3">
                            <div class="flex items-center justify-end gap-4">
                                <a href="{{ route('admin.skills.edit', $skill) }}" class="link-accent">Edit</a>
                                <form method="POST" action="{{ route('admin.skills.destroy', $skill) }}" onsubmit="return confirm('Delete this skill?')">
                                    @csrf
                                    @method('DELETE')
                                    <button type="submit" class="text-red-600 hover:text-red-700 dark:text-red-400 dark:hover:text-red-300">Delete</button>
                                </form>
                            </div>
                        </td>
                    </tr>
                @empty
                    @include('admin.partials.empty-row', [
                        'colspan' => 4,
                        'message' => 'No skills yet.',
                        'ctaRoute' => route('admin.skills.create'),
                        'ctaLabel' => 'Add your first one',
                    ])
                @endforelse
            </tbody>
        </table>
    </div>
</x-admin-layout>
