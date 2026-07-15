<x-admin-layout title="Dashboard" :subtitle="'Welcome back, ' . (auth()->user()->name ?? 'Admin') . '.'">
    <div class="grid gap-5 sm:grid-cols-2 lg:grid-cols-4">
        @php
            $cards = [
                ['label' => 'Projects', 'value' => $stats['projects'], 'icon' => '<path stroke-linecap="round" stroke-linejoin="round" d="M2.25 12.75V12A2.25 2.25 0 0 1 4.5 9.75h15A2.25 2.25 0 0 1 21.75 12v.75m-19.5 0v6a2.25 2.25 0 0 0 2.25 2.25h15a2.25 2.25 0 0 0 2.25-2.25v-6m-19.5 0 5.03-5.03a2.25 2.25 0 0 1 1.591-.659h5.758a2.25 2.25 0 0 1 1.591.659l5.03 5.03" />', 'href' => route('admin.projects.index')],
                ['label' => 'Skills', 'value' => $stats['skills'], 'icon' => '<path stroke-linecap="round" stroke-linejoin="round" d="M3 13.125C3 12.504 3.504 12 4.125 12h2.25c.621 0 1.125.504 1.125 1.125v6.75C7.5 20.496 6.996 21 6.375 21h-2.25A1.125 1.125 0 0 1 3 19.875v-6.75ZM9.75 8.625c0-.621.504-1.125 1.125-1.125h2.25c.621 0 1.125.504 1.125 1.125v11.25c0 .621-.504 1.125-1.125 1.125h-2.25a1.125 1.125 0 0 1-1.125-1.125V8.625ZM16.5 4.125c0-.621.504-1.125 1.125-1.125h2.25C20.496 3 21 3.504 21 4.125v15.75c0 .621-.504 1.125-1.125 1.125h-2.25a1.125 1.125 0 0 1-1.125-1.125V4.125Z" />', 'href' => route('admin.skills.index')],
                ['label' => 'Messages', 'value' => $stats['messages'], 'icon' => '<path stroke-linecap="round" stroke-linejoin="round" d="M21.75 6.75v10.5a2.25 2.25 0 0 1-2.25 2.25h-15a2.25 2.25 0 0 1-2.25-2.25V6.75m19.5 0A2.25 2.25 0 0 0 19.5 4.5h-15a2.25 2.25 0 0 0-2.25 2.25m19.5 0v.243a2.25 2.25 0 0 1-1.07 1.916l-7.5 4.615a2.25 2.25 0 0 1-2.36 0L3.32 8.91a2.25 2.25 0 0 1-1.07-1.916V6.75" />', 'href' => route('admin.messages.index')],
                ['label' => 'Unread', 'value' => $stats['unread_messages'], 'icon' => '<path stroke-linecap="round" stroke-linejoin="round" d="M9.813 15.904 9 18.75l-.813-2.846a4.5 4.5 0 0 0-3.09-3.09L2.25 12l2.846-.813a4.5 4.5 0 0 0 3.09-3.09L9 5.25l.813 2.846a4.5 4.5 0 0 0 3.09 3.09L15.75 12l-2.846.813a4.5 4.5 0 0 0-3.09 3.09Z" />', 'href' => route('admin.messages.index'), 'accent' => true],
            ];
        @endphp

        @foreach($cards as $card)
            <a href="{{ $card['href'] }}" class="stat-card group">
                <div class="flex items-center justify-between">
                    <p class="text-faint text-xs font-semibold uppercase tracking-wider">{{ $card['label'] }}</p>
                    <span class="h-9 w-9 {{ !empty($card['accent']) ? 'icon-chip-accent' : 'icon-chip' }}">
                        <svg xmlns="http://www.w3.org/2000/svg" fill="none" viewBox="0 0 24 24" stroke-width="1.5" stroke="currentColor" class="h-5 w-5">
                            {!! $card['icon'] !!}
                        </svg>
                    </span>
                </div>
                <p class="mt-4 text-4xl font-semibold {{ !empty($card['accent']) && $card['value'] > 0 ? 'text-emerald-600 dark:text-emerald-300' : 'text-heading' }}">{{ $card['value'] }}</p>
            </a>
        @endforeach
    </div>

    <div class="mt-6 grid gap-6 lg:grid-cols-2">
        <div class="panel-card rounded-2xl border p-6">
            <div class="mb-1 flex items-center justify-between">
                <h2 class="text-heading font-medium">Messages, last 14 days</h2>
            </div>
            <p class="text-muted mb-4 text-sm">New contact-form submissions per day.</p>
            @include('admin.partials.line-chart', ['points' => $messagesTrend, 'id' => 'messages-trend-chart', 'ariaLabel' => 'Messages received per day over the last 14 days'])
        </div>

        <div class="panel-card rounded-2xl border p-6">
            <div class="mb-1 flex items-center justify-between">
                <h2 class="text-heading font-medium">Skills by category</h2>
            </div>
            <p class="text-muted mb-5 text-sm">Average proficiency per category.</p>
            @if(empty($skillsByCategory))
                <p class="text-muted text-sm">Add skills in the admin panel to see this breakdown.</p>
            @else
                @include('admin.partials.category-bars', ['bars' => $skillsByCategory, 'id' => 'skills-category-bars'])
            @endif
        </div>
    </div>

    <div class="mt-6 grid gap-6 lg:grid-cols-3">
        <div class="panel-card rounded-2xl border p-6 lg:col-span-2">
            <div class="mb-5 flex items-center justify-between">
                <h2 class="text-heading font-medium">Recent messages</h2>
                <a href="{{ route('admin.messages.index') }}" class="link-accent text-sm">View all &rarr;</a>
            </div>

            @if($recentMessages->isEmpty())
                <p class="text-muted text-sm">No messages yet. They'll show up here as soon as someone uses your contact form.</p>
            @else
                <div class="divide-app">
                    @foreach($recentMessages as $message)
                        <a href="{{ route('admin.messages.show', $message) }}" class="flex items-center justify-between gap-4 py-3.5 text-sm transition hover:text-neutral-900 dark:hover:text-white">
                            <div class="flex min-w-0 items-center gap-3">
                                @unless($message->read_at)
                                    <span class="h-2 w-2 shrink-0 rounded-full bg-emerald-500 dark:bg-emerald-400"></span>
                                @endunless
                                <div class="min-w-0">
                                    <span class="font-medium {{ $message->read_at ? 'text-body' : 'text-heading' }}">{{ $message->name }}</span>
                                    <span class="text-muted"> &mdash; {{ $message->subject ?: 'No subject' }}</span>
                                </div>
                            </div>
                            <span class="text-faintest shrink-0">{{ $message->created_at->diffForHumans() }}</span>
                        </a>
                    @endforeach
                </div>
            @endif
        </div>

        <div class="panel-card rounded-2xl border p-6">
            <h2 class="text-heading mb-5 font-medium">Quick actions</h2>
            <div class="space-y-2">
                <a href="{{ route('admin.projects.create') }}" class="nav-item flex items-center gap-3 rounded-lg px-3 py-2.5 text-sm transition">
                    <span class="icon-chip-accent h-8 w-8">+</span>
                    Add a project
                </a>
                <a href="{{ route('admin.skills.create') }}" class="nav-item flex items-center gap-3 rounded-lg px-3 py-2.5 text-sm transition">
                    <span class="icon-chip-accent h-8 w-8">+</span>
                    Add a skill
                </a>
                <a href="{{ route('admin.experiences.create') }}" class="nav-item flex items-center gap-3 rounded-lg px-3 py-2.5 text-sm transition">
                    <span class="icon-chip-accent h-8 w-8">+</span>
                    Add experience
                </a>
                <a href="{{ route('admin.testimonials.create') }}" class="nav-item flex items-center gap-3 rounded-lg px-3 py-2.5 text-sm transition">
                    <span class="icon-chip-accent h-8 w-8">+</span>
                    Add testimonial
                </a>
                <a href="{{ route('admin.profile.edit') }}" class="nav-item flex items-center gap-3 rounded-lg px-3 py-2.5 text-sm transition">
                    <span class="icon-chip-accent h-8 w-8">&#9998;</span>
                    Edit profile
                </a>
                <a href="{{ route('home') }}" target="_blank" class="nav-item flex items-center gap-3 rounded-lg px-3 py-2.5 text-sm transition">
                    <span class="icon-chip-accent h-8 w-8">&rarr;</span>
                    View live site
                </a>
            </div>
        </div>
    </div>
</x-admin-layout>
