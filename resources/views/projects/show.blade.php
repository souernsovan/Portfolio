@extends('layouts.app')

@section('content')
    <div class="pointer-events-none fixed inset-0 overflow-hidden">
        <div class="animate-blob-a absolute -top-40 left-1/2 h-144 w-xl -translate-x-1/2 rounded-full bg-emerald-500/10 blur-3xl"></div>
    </div>

    <header class="panel-header sticky top-0 z-50 border-b backdrop-blur">
        <nav class="mx-auto flex max-w-3xl items-center justify-between px-6 py-4">
            <a href="{{ route('home') }}" class="link-muted inline-flex items-center gap-2 text-sm font-medium">
                <svg xmlns="http://www.w3.org/2000/svg" fill="none" viewBox="0 0 24 24" stroke-width="1.5" stroke="currentColor" class="h-4 w-4">
                    <path stroke-linecap="round" stroke-linejoin="round" d="M10.5 19.5 3 12m0 0 7.5-7.5M3 12h18" />
                </svg>
                Back to portfolio
            </a>
            <div class="flex items-center gap-2">
                <button type="button" onclick="window.__toggleTheme()" title="Toggle light / dark theme" aria-label="Toggle light / dark theme"
                        class="nav-item flex h-9 w-9 items-center justify-center rounded-lg transition">
                    <svg xmlns="http://www.w3.org/2000/svg" fill="none" viewBox="0 0 24 24" stroke-width="1.5" stroke="currentColor" class="h-5 w-5 dark:hidden">
                        <path stroke-linecap="round" stroke-linejoin="round" d="M12 3v2.25m6.364.386-1.591 1.591M21 12h-2.25m-.386 6.364-1.591-1.591M12 18.75V21m-4.773-4.227-1.591 1.591M5.25 12H3m4.227-4.773L5.636 5.636M15.75 12a3.75 3.75 0 1 1-7.5 0 3.75 3.75 0 0 1 7.5 0Z" />
                    </svg>
                    <svg xmlns="http://www.w3.org/2000/svg" fill="none" viewBox="0 0 24 24" stroke-width="1.5" stroke="currentColor" class="hidden h-5 w-5 dark:block">
                        <path stroke-linecap="round" stroke-linejoin="round" d="M21.752 15.002A9.72 9.72 0 0 1 18 15.75c-5.385 0-9.75-4.365-9.75-9.75 0-1.33.266-2.597.748-3.752A9.753 9.753 0 0 0 3 11.25C3 16.635 7.365 21 12.75 21a9.753 9.753 0 0 0 9.002-5.998Z" />
                    </svg>
                </button>
                <a href="{{ route('home') }}#contact" class="pill-accent rounded-full px-4 py-1.5 text-sm font-medium">
                    Say hello
                </a>
            </div>
        </nav>
    </header>

    <main class="mx-auto max-w-3xl px-6 pb-24 pt-16">
        <div class="reveal is-visible">
            <div class="flex flex-wrap items-center gap-3">
                @if($project->featured)
                    <span class="badge-accent rounded-full px-2.5 py-1 text-xs font-medium">Featured</span>
                @endif
                @foreach($project->techStackList() as $tech)
                    <span class="surface-2 text-muted rounded-md px-2 py-1 text-xs">{{ $tech }}</span>
                @endforeach
            </div>

            <h1 class="text-heading mt-4 text-3xl font-bold tracking-tight sm:text-4xl">{{ $project->title }}</h1>
            <p class="text-muted mt-4 text-lg leading-relaxed">{{ $project->summary }}</p>

            <div class="mt-6 flex flex-wrap gap-4 text-sm font-medium">
                @if($project->project_url)
                    <a href="{{ $project->project_url }}" target="_blank" rel="noopener" class="btn-primary inline-flex items-center gap-2 rounded-lg px-5 py-2.5 transition">
                        Visit live site
                        <svg xmlns="http://www.w3.org/2000/svg" fill="none" viewBox="0 0 24 24" stroke-width="2" stroke="currentColor" class="h-4 w-4">
                            <path stroke-linecap="round" stroke-linejoin="round" d="M13.5 6H5.25A2.25 2.25 0 0 0 3 8.25v10.5A2.25 2.25 0 0 0 5.25 21h10.5A2.25 2.25 0 0 0 18 18.75V10.5m-10.5 6L21 3m0 0h-5.25M21 3v5.25" />
                        </svg>
                    </a>
                @endif
                @if($project->github_url)
                    <a href="{{ $project->github_url }}" target="_blank" rel="noopener" class="btn-outline inline-flex items-center gap-2 rounded-lg px-5 py-2.5">
                        View source
                    </a>
                @endif
            </div>
        </div>

        @if($project->image_url)
            <div class="reveal is-visible surface-1 mt-10 overflow-hidden rounded-2xl" style="--reveal-delay: 100ms">
                <img src="{{ $project->image_url }}" alt="{{ $project->title }}" class="w-full object-cover">
            </div>
        @endif

        @if($project->description)
            <div class="text-body reveal is-visible mt-10 max-w-none" style="--reveal-delay: 150ms">
                <p class="whitespace-pre-line leading-relaxed">{{ $project->description }}</p>
            </div>
        @endif

        @if($moreProjects->isNotEmpty())
            <div class="border-app-subtle mt-20 border-t pt-10">
                <h2 class="text-accent text-sm font-semibold uppercase tracking-[0.2em]">More projects</h2>
                <div class="mt-6 grid gap-4 sm:grid-cols-2">
                    @foreach($moreProjects as $more)
                        <a href="{{ route('projects.show', $more) }}" class="surface-1 group rounded-xl p-5 transition hover:border-emerald-500/30 dark:hover:border-emerald-400/30">
                            <h3 class="text-heading font-semibold transition-colors group-hover:text-emerald-600 dark:group-hover:text-emerald-300">{{ $more->title }}</h3>
                            <p class="text-muted mt-1 text-sm">{{ $more->summary }}</p>
                        </a>
                    @endforeach
                </div>
            </div>
        @endif
    </main>

    <footer class="border-app-subtle text-faintest border-t px-6 py-8 text-center text-sm">
        &copy; {{ date('Y') }} {{ $profile->name ?? 'Portfolio' }}. Built with Laravel &amp; Tailwind CSS.
    </footer>
@endsection
