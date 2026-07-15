<x-admin-layout title="Experience">
    <div class="mb-6 flex justify-end">
        <a href="{{ route('admin.experiences.create') }}" class="btn-primary rounded-lg px-4 py-2 text-sm font-semibold">
            + New experience
        </a>
    </div>

    <div class="border-app overflow-x-auto rounded-xl border">
        <table class="w-full text-left text-sm">
            <thead>
                <tr class="thead-row text-faint border-b text-xs font-semibold uppercase tracking-wider">
                    <th class="px-4 py-3 font-medium">Role</th>
                    <th class="px-4 py-3 font-medium">Company</th>
                    <th class="px-4 py-3 font-medium">Period</th>
                    <th class="px-4 py-3 text-right font-medium">Actions</th>
                </tr>
            </thead>
            <tbody class="divide-app">
                @forelse($experiences as $experience)
                    <tr class="row-hover transition">
                        <td class="text-heading px-4 py-3 font-medium whitespace-nowrap">{{ $experience->role }}</td>
                        <td class="text-body px-4 py-3">{{ $experience->company }}</td>
                        <td class="text-muted px-4 py-3 whitespace-nowrap">
                            {{ $experience->start_date->format('M Y') }} &ndash;
                            {{ $experience->end_date ? $experience->end_date->format('M Y') : 'Present' }}
                        </td>
                        <td class="px-4 py-3">
                            <div class="flex items-center justify-end gap-4">
                                <a href="{{ route('admin.experiences.edit', $experience) }}" class="link-accent">Edit</a>
                                <form method="POST" action="{{ route('admin.experiences.destroy', $experience) }}" onsubmit="return confirm('Delete this experience entry?')">
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
                        'message' => 'No work experience yet.',
                        'ctaRoute' => route('admin.experiences.create'),
                        'ctaLabel' => 'Add your first role',
                    ])
                @endforelse
            </tbody>
        </table>
    </div>
</x-admin-layout>
