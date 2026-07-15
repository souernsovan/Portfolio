<x-admin-layout title="Messages">
    <div class="border-app overflow-x-auto rounded-xl border">
        <table class="w-full text-left text-sm">
            <thead>
                <tr class="thead-row text-faint border-b text-xs font-semibold uppercase tracking-wider">
                    <th class="px-4 py-3 font-medium">From</th>
                    <th class="px-4 py-3 font-medium">Subject</th>
                    <th class="px-4 py-3 font-medium">Received</th>
                    <th class="px-4 py-3 text-right font-medium">Actions</th>
                </tr>
            </thead>
            <tbody class="divide-app">
                @forelse($messages as $message)
                    <tr class="row-hover transition">
                        <td class="px-4 py-3">
                            <a href="{{ route('admin.messages.show', $message) }}" class="flex items-center gap-2">
                                @unless($message->read_at)
                                    <span class="h-2 w-2 shrink-0 rounded-full bg-emerald-500 dark:bg-emerald-400"></span>
                                @endunless
                                <div class="min-w-0">
                                    <p class="font-medium whitespace-nowrap {{ $message->read_at ? 'text-body' : 'text-heading' }}">{{ $message->name }}</p>
                                    <p class="text-faint truncate text-xs">{{ $message->email }}</p>
                                </div>
                            </a>
                        </td>
                        <td class="text-body max-w-xs truncate px-4 py-3">
                            <a href="{{ route('admin.messages.show', $message) }}" class="inline-flex items-center gap-2">
                                {{ $message->subject ?: 'No subject' }}
                                @if($message->replied_at)
                                    <span class="badge-accent shrink-0 rounded-full px-2 py-0.5 text-xs">Replied</span>
                                @endif
                            </a>
                        </td>
                        <td class="text-faintest px-4 py-3 whitespace-nowrap">{{ $message->created_at->diffForHumans() }}</td>
                        <td class="px-4 py-3">
                            <div class="flex items-center justify-end gap-4">
                                <a href="{{ route('admin.messages.show', $message) }}" class="link-accent">View</a>
                                <form method="POST" action="{{ route('admin.messages.destroy', $message) }}" onsubmit="return confirm('Delete this message?')">
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
                        'message' => 'No messages yet.',
                    ])
                @endforelse
            </tbody>
        </table>
    </div>

    @if($messages->isNotEmpty())
        <div class="mt-6">
            {{ $messages->links() }}
        </div>
    @endif
</x-admin-layout>
