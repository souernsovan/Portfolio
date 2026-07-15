<x-admin-layout title="Projects">
    <div class="mb-6 flex justify-end">
        <a href="{{ route('admin.projects.create') }}" class="btn-primary rounded-lg px-4 py-2 text-sm font-semibold">
            + New project
        </a>
    </div>

    <div class="border-app overflow-x-auto rounded-xl border">
        <table class="w-full text-left text-sm">
            <thead>
                <tr class="thead-row text-faint border-b text-xs font-semibold uppercase tracking-wider">
                    <th class="px-4 py-3 font-medium">Title</th>
                    <th class="px-4 py-3 font-medium">Summary</th>
                    <th class="px-4 py-3 font-medium">Tech stack</th>
                    <th class="px-4 py-3 font-medium">Featured</th>
                    <th class="px-4 py-3 text-right font-medium">Actions</th>
                </tr>
            </thead>
            <tbody class="divide-app">
                @forelse($projects as $project)
                    <tr class="row-hover transition">
                        <td class="text-heading px-4 py-3 font-medium whitespace-nowrap">{{ $project->title }}</td>
                        <td class="text-body max-w-xs truncate px-4 py-3">{{ $project->summary }}</td>
                        <td class="text-muted px-4 py-3">{{ $project->tech_stack ?: '—' }}</td>
                        <td class="px-4 py-3">
                            @if($project->featured)
                                <span class="badge-accent rounded-full px-2 py-0.5 text-xs">Featured</span>
                            @else
                                <span class="text-faintest">—</span>
                            @endif
                        </td>
                        <td class="px-4 py-3">
                            <div class="flex items-center justify-end gap-4">
                                <a href="{{ route('admin.projects.edit', $project) }}" class="link-accent">Edit</a>
                                <form method="POST" action="{{ route('admin.projects.destroy', $project) }}" onsubmit="return confirm('Delete this project?')">
                                    @csrf
                                    @method('DELETE')
                                    <button type="submit" class="text-red-600 hover:text-red-700 dark:text-red-400 dark:hover:text-red-300">Delete</button>
                                </form>
                            </div>
                        </td>
                    </tr>
                @empty
                    @include('admin.partials.empty-row', [
                        'colspan' => 5,
                        'message' => 'No projects yet.',
                        'ctaRoute' => route('admin.projects.create'),
                        'ctaLabel' => 'Create your first one',
                    ])
                @endforelse
            </tbody>
        </table>
    </div>
</x-admin-layout>
