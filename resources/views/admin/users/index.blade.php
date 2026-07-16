<x-admin-layout title="Admin Users" subtitle="Manage who can log in and edit this portfolio.">
    <div class="mb-6 flex justify-end">
        <a href="{{ route('admin.users.create') }}" class="btn-primary rounded-lg px-4 py-2 text-sm font-semibold">
            + New user
        </a>
    </div>

    <div class="border-app overflow-x-auto rounded-xl border">
        <table class="w-full text-left text-sm">
            <thead>
                <tr class="thead-row text-faint border-b text-xs font-semibold uppercase tracking-wider">
                    <th class="px-4 py-3 font-medium">Name</th>
                    <th class="px-4 py-3 font-medium">Email</th>
                    <th class="px-4 py-3 font-medium">Joined</th>
                    <th class="px-4 py-3 text-right font-medium">Actions</th>
                </tr>
            </thead>
            <tbody class="divide-app">
                @forelse($users as $user)
                    <tr class="row-hover transition">
                        <td class="px-4 py-3">
                            <div class="flex items-center gap-2">
                                <span class="text-heading font-medium whitespace-nowrap">{{ $user->name }}</span>
                                @if($user->id === auth()->id())
                                    <span class="badge-accent rounded-full px-2 py-0.5 text-xs">You</span>
                                @endif
                            </div>
                        </td>
                        <td class="text-body px-4 py-3">{{ $user->email }}</td>
                        <td class="text-faintest px-4 py-3 whitespace-nowrap">{{ $user->created_at->format('M j, Y') }}</td>
                        <td class="px-4 py-3">
                            <div class="flex items-center justify-end gap-4">
                                <a href="{{ route('admin.users.edit', $user) }}" class="link-accent">Edit</a>
                                @if($user->id !== auth()->id())
                                    <form method="POST" action="{{ route('admin.users.destroy', $user) }}" onsubmit="return confirm('Delete this user?')">
                                        @csrf
                                        @method('DELETE')
                                        <button type="submit" class="text-red-600 hover:text-red-700 dark:text-red-400 dark:hover:text-red-300">Delete</button>
                                    </form>
                                @endif
                            </div>
                        </td>
                    </tr>
                @empty
                    @include('admin.partials.empty-row', [
                        'colspan' => 4,
                        'message' => 'No users yet.',
                    ])
                @endforelse
            </tbody>
        </table>
    </div>
</x-admin-layout>
