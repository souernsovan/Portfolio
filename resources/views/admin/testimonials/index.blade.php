<x-admin-layout title="Testimonials">
    <div class="mb-6 flex justify-end">
        <a href="{{ route('admin.testimonials.create') }}" class="btn-primary rounded-lg px-4 py-2 text-sm font-semibold">
            + New testimonial
        </a>
    </div>

    <div class="border-app overflow-x-auto rounded-xl border">
        <table class="w-full text-left text-sm">
            <thead>
                <tr class="thead-row text-faint border-b text-xs font-semibold uppercase tracking-wider">
                    <th class="px-4 py-3 font-medium">Author</th>
                    <th class="px-4 py-3 font-medium">Quote</th>
                    <th class="px-4 py-3 font-medium">Rating</th>
                    <th class="px-4 py-3 text-right font-medium">Actions</th>
                </tr>
            </thead>
            <tbody class="divide-app">
                @forelse($testimonials as $testimonial)
                    <tr class="row-hover transition">
                        <td class="px-4 py-3">
                            <p class="text-heading font-medium whitespace-nowrap">{{ $testimonial->author_name }}</p>
                            @if($testimonial->author_role)
                                <p class="text-faint text-xs">{{ $testimonial->author_role }}</p>
                            @endif
                        </td>
                        <td class="text-body max-w-md truncate px-4 py-3">{{ $testimonial->content }}</td>
                        <td class="px-4 py-3 whitespace-nowrap text-amber-500">{{ str_repeat('★', $testimonial->rating) }}{{ str_repeat('☆', 5 - $testimonial->rating) }}</td>
                        <td class="px-4 py-3">
                            <div class="flex items-center justify-end gap-4">
                                <a href="{{ route('admin.testimonials.edit', $testimonial) }}" class="link-accent">Edit</a>
                                <form method="POST" action="{{ route('admin.testimonials.destroy', $testimonial) }}" onsubmit="return confirm('Delete this testimonial?')">
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
                        'message' => 'No testimonials yet.',
                        'ctaRoute' => route('admin.testimonials.create'),
                        'ctaLabel' => 'Add your first one',
                    ])
                @endforelse
            </tbody>
        </table>
    </div>
</x-admin-layout>
