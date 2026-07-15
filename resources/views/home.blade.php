@extends('layouts.app')

@section('content')
    @php
        $name = $profile->name ?? 'Your Name';
        $role = $profile->role ?? 'Full-Stack Developer';
        $tagline = $profile->tagline ?? 'I design and build clean, fast, reliable web applications.';
        $about = $profile->about ?? 'Add your bio from the admin panel at /admin — tell visitors who you are, what you work on, and what you care about.';
        $initials = collect(explode(' ', $name))->map(fn ($p) => mb_substr($p, 0, 1))->take(2)->implode('');
        $navItems = [
            ['id' => 'about', 'label' => 'About'],
            ...($experiences->isNotEmpty() ? [['id' => 'experience', 'label' => 'Experience']] : []),
            ['id' => 'skills', 'label' => 'Skills'],
            ['id' => 'projects', 'label' => 'Projects'],
            ...($testimonials->isNotEmpty() ? [['id' => 'testimonials', 'label' => 'Testimonials']] : []),
            ['id' => 'contact', 'label' => 'Contact'],
        ];
        $allTechTags = $projects->flatMap(fn ($project) => $project->techStackList())->unique()->values();
    @endphp

    <div class="pointer-events-none fixed inset-0 overflow-hidden">
        <div class="animate-blob-a absolute -top-40 left-1/2 h-144 w-xl -translate-x-1/2 rounded-full bg-emerald-500/10 blur-3xl"></div>
        <div class="animate-blob-b absolute top-1/3 right-0 h-104 w-104 rounded-full bg-teal-500/5 blur-3xl"></div>
    </div>

    <!-- Nav -->
    <header id="site-header" class="panel-header sticky top-0 z-50 border-b backdrop-blur transition-shadow duration-300">
        <nav class="mx-auto flex max-w-5xl items-center justify-between px-6 py-4">
            <a href="#top" class="text-heading font-semibold tracking-tight">{{ $name }}</a>

            <div class="hidden gap-8 text-sm sm:flex">
                @foreach($navItems as $item)
                    <a href="#{{ $item['id'] }}" data-nav-link="{{ $item['id'] }}" class="nav-link-idle relative transition-colors duration-300
                        after:absolute after:-bottom-1 after:left-0 after:h-px after:w-0 after:bg-emerald-500 after:transition-all after:duration-300 hover:after:w-full dark:after:bg-emerald-400">
                        {{ $item['label'] }}
                    </a>
                @endforeach
            </div>

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

                <a href="#about" class="pill-accent hidden rounded-full px-4 py-1.5 text-sm font-medium transition-all duration-300 hover:-translate-y-0.5 hover:shadow-lg hover:shadow-emerald-500/10 sm:inline-block">
                    Portfolio
                </a>
                <button type="button" id="menu-toggle" aria-label="Toggle menu" aria-expanded="false"
                        class="nav-item flex h-9 w-9 items-center justify-center rounded-lg transition sm:hidden">
                    <svg xmlns="http://www.w3.org/2000/svg" fill="none" viewBox="0 0 24 24" stroke-width="1.5" stroke="currentColor" class="h-5 w-5">
                        <path stroke-linecap="round" stroke-linejoin="round" d="M3.75 6.75h16.5M3.75 12h16.5m-16.5 5.25h16.5" />
                    </svg>
                </button>
            </div>
        </nav>

        <div id="mobile-menu" class="border-app-subtle hidden border-t px-6 py-4 sm:hidden">
            <div class="flex flex-col gap-1">
                @foreach($navItems as $item)
                    <a href="#{{ $item['id'] }}" class="text-body surface-2-hover rounded-lg px-3 py-2.5 text-sm transition hover:text-heading">{{ $item['label'] }}</a>
                @endforeach
                <a href="#about" class="pill-accent mt-2 rounded-lg px-3 py-2.5 text-center text-sm font-medium">Portfolio</a>
            </div>
        </div>
    </header>

    <main id="top">
        <!-- Hero -->
        <section class="relative mx-auto flex max-w-5xl flex-col items-center px-6 pb-24 pt-20 text-center sm:pt-28">
            <div class="reveal-scale relative mb-8 flex h-32 w-32 items-center justify-center sm:h-36 sm:w-36">
                <span class="animate-avatar-glow absolute inset-0 rounded-full bg-linear-to-br from-emerald-400 via-teal-400 to-emerald-600 blur-lg"></span>
                <span class="animate-spin-slow absolute -inset-1.5 rounded-full border-2 border-dashed border-emerald-500/30 dark:border-emerald-400/30"></span>
                <span class="surface-2 relative flex h-full w-full items-center justify-center overflow-hidden rounded-full border-4 border-neutral-100 text-3xl font-semibold text-emerald-600 shadow-xl dark:border-neutral-950 dark:text-emerald-300">
                    @if($profile?->avatar_url)
                        <img src="{{ $profile->avatar_url }}" alt="{{ $name }}" class="h-full w-full object-cover">
                    @else
                        {{ $initials ?: 'YN' }}
                    @endif
                </span>
            </div>
            <p class="reveal text-accent mb-3 text-sm font-medium uppercase tracking-[0.2em]" style="--reveal-delay: 80ms">{{ $role }}</p>
            <h1 class="reveal text-gradient max-w-3xl text-4xl font-bold tracking-tight sm:text-6xl" style="--reveal-delay: 140ms">
                {{ $name }}
            </h1>
            <p class="reveal text-muted mt-6 max-w-xl text-lg" style="--reveal-delay: 220ms">
                {{ $tagline }}
            </p>
            <div class="reveal mt-10 flex flex-wrap items-center justify-center gap-4" style="--reveal-delay: 300ms">
                <a href="#projects" class="btn-primary rounded-lg px-6 py-3 text-sm font-semibold transition-all duration-300 hover:-translate-y-0.5 hover:shadow-lg hover:shadow-emerald-500/20 active:translate-y-0 active:scale-95">
                    View my work
                </a>
                <a href="#contact" class="btn-outline rounded-lg px-6 py-3 text-sm font-semibold transition-all duration-300 hover:-translate-y-0.5 active:translate-y-0 active:scale-95">
                    Get in touch
                </a>
                @if (!empty($profile?->resume_url))
                    <a href="{{ $profile->resume_url }}" target="_blank" rel="noopener" class="link-muted text-sm font-medium underline underline-offset-4">
                        Download résumé
                    </a>
                @endif
            </div>

            <a href="#about" aria-label="Scroll to about section" class="circle-btn animate-bounce-slow reveal mt-16 flex h-10 w-10 items-center justify-center rounded-full" style="--reveal-delay: 500ms">
                <svg xmlns="http://www.w3.org/2000/svg" fill="none" viewBox="0 0 24 24" stroke-width="1.5" stroke="currentColor" class="h-4 w-4">
                    <path stroke-linecap="round" stroke-linejoin="round" d="M19.5 8.25l-7.5 7.5-7.5-7.5" />
                </svg>
            </a>
        </section>

        <!-- Stats -->
        @if(collect($stats)->filter()->isNotEmpty())
            <section class="border-app-subtle border-t px-6 py-12">
                <div class="reveal mx-auto grid max-w-5xl grid-cols-2 gap-8 text-center sm:grid-cols-4">
                    @if($stats['years_experience'])
                        <div>
                            <p class="counter text-heading text-3xl font-bold sm:text-4xl" data-count-to="{{ $stats['years_experience'] }}">0</p>
                            <p class="text-faint mt-1 text-xs uppercase tracking-wider">Years experience</p>
                        </div>
                    @endif
                    <div>
                        <p class="counter text-heading text-3xl font-bold sm:text-4xl" data-count-to="{{ $stats['projects'] }}">0</p>
                        <p class="text-faint mt-1 text-xs uppercase tracking-wider">Projects shipped</p>
                    </div>
                    <div>
                        <p class="counter text-heading text-3xl font-bold sm:text-4xl" data-count-to="{{ $stats['technologies'] }}">0</p>
                        <p class="text-faint mt-1 text-xs uppercase tracking-wider">Technologies</p>
                    </div>
                    @if($stats['happy_clients'])
                        <div>
                            <p class="counter text-heading text-3xl font-bold sm:text-4xl" data-count-to="{{ $stats['happy_clients'] }}">0</p>
                            <p class="text-faint mt-1 text-xs uppercase tracking-wider">Happy clients</p>
                        </div>
                    @endif
                </div>
            </section>
        @endif

        <!-- About -->
        <section id="about" class="border-app-subtle border-t px-6 py-20">
            <div class="mx-auto max-w-3xl">
                <h2 class="text-accent reveal text-sm font-semibold uppercase tracking-[0.2em]">About</h2>
                <p class="text-body reveal mt-4 whitespace-pre-line text-lg leading-relaxed" style="--reveal-delay: 100ms">{{ $about }}</p>

                @if($profile && ($profile->location || $profile->email))
                    <div class="text-muted reveal mt-8 flex flex-wrap gap-6 text-sm" style="--reveal-delay: 180ms">
                        @if($profile->location)
                            <div class="flex items-center gap-2">
                                <span class="text-accent">&#9679;</span> {{ $profile->location }}
                            </div>
                        @endif
                        @if($profile->email)
                            <a href="mailto:{{ $profile->email }}" class="flex items-center gap-2 transition hover:text-neutral-900 dark:hover:text-white">
                                <span class="text-accent">&#9679;</span> {{ $profile->email }}
                            </a>
                        @endif
                    </div>
                @endif
            </div>
        </section>

        <!-- Experience -->
        @if($experiences->isNotEmpty())
            <section id="experience" class="border-app-subtle border-t px-6 py-20">
                <div class="mx-auto max-w-3xl">
                    <h2 class="text-accent reveal text-sm font-semibold uppercase tracking-[0.2em]">Experience</h2>
                    <p class="text-body reveal mt-4 text-lg" style="--reveal-delay: 100ms">Where I've worked and what I've done.</p>

                    <div class="border-app mt-10 space-y-10 border-l pl-8">
                        @foreach($experiences as $experience)
                            <div class="reveal relative" style="--reveal-delay: {{ 120 + $loop->index * 90 }}ms">
                                <span class="absolute left-[-2.35rem] top-1 flex h-4 w-4 items-center justify-center rounded-full border-2 border-neutral-100 dark:border-neutral-950 {{ $experience->isCurrent() ? 'bg-emerald-500 dark:bg-emerald-400' : 'bg-neutral-300 dark:bg-neutral-600' }}"></span>

                                <div class="flex flex-wrap items-baseline justify-between gap-2">
                                    <h3 class="text-heading text-lg font-semibold">{{ $experience->role }}</h3>
                                    <span class="text-faint text-xs font-medium uppercase tracking-wider">
                                        {{ $experience->start_date->format('M Y') }} &ndash;
                                        {{ $experience->isCurrent() ? 'Present' : $experience->end_date->format('M Y') }}
                                    </span>
                                </div>
                                <p class="mt-1 text-sm font-medium text-emerald-600 dark:text-emerald-300">
                                    {{ $experience->company }}{{ $experience->location ? ' · '.$experience->location : '' }}
                                </p>
                                @if($experience->description)
                                    <p class="text-muted mt-3 whitespace-pre-line text-sm leading-relaxed">{{ $experience->description }}</p>
                                @endif
                            </div>
                        @endforeach
                    </div>
                </div>
            </section>
        @endif

        <!-- Skills -->
        <section id="skills" class="border-app-subtle border-t px-6 py-20">
            <div class="mx-auto max-w-5xl">
                <h2 class="text-accent reveal text-sm font-semibold uppercase tracking-[0.2em]">Skills</h2>
                <p class="text-body reveal mt-4 text-lg" style="--reveal-delay: 100ms">Tools and technologies I work with regularly.</p>

                @if($skills->isEmpty())
                    <p class="text-muted mt-8">Skills you add in the admin panel will show up here.</p>
                @else
                    <div class="mt-10 grid gap-10 sm:grid-cols-2">
                        @foreach($skills as $category => $items)
                            <div class="reveal" style="--reveal-delay: {{ 120 + $loop->index * 80 }}ms">
                                <h3 class="text-faint mb-4 text-xs font-semibold uppercase tracking-wider">{{ $category }}</h3>
                                <div class="space-y-4">
                                    @foreach($items as $skill)
                                        <div>
                                            <div class="mb-1.5 flex items-center justify-between text-sm">
                                                <span class="text-heading">{{ $skill->name }}</span>
                                                <span class="text-muted">{{ $skill->level }}%</span>
                                            </div>
                                            <div class="h-1.5 w-full overflow-hidden rounded-full bg-neutral-200 dark:bg-white/5">
                                                <div class="skill-bar-fill h-full rounded-full bg-linear-to-r from-emerald-500 to-emerald-300" data-skill-level="{{ min(100, max(0, $skill->level)) }}"></div>
                                            </div>
                                        </div>
                                    @endforeach
                                </div>
                            </div>
                        @endforeach
                    </div>
                @endif
            </div>
        </section>

        <!-- Projects -->
        <section id="projects" class="border-app-subtle border-t px-6 py-20">
            <div class="mx-auto max-w-5xl">
                <h2 class="text-accent reveal text-sm font-semibold uppercase tracking-[0.2em]">Projects</h2>
                <p class="text-body reveal mt-4 text-lg" style="--reveal-delay: 100ms">A selection of things I've built.</p>

                @if($projects->isEmpty())
                    <p class="text-muted mt-8">Projects you add in the admin panel will show up here.</p>
                @else
                    @if($allTechTags->isNotEmpty())
                        <div class="reveal mt-8 flex flex-wrap gap-2" id="project-filters" style="--reveal-delay: 160ms">
                            <button type="button" data-filter="all" class="filter-btn filter-active rounded-full px-3.5 py-1.5 text-xs font-medium">
                                All
                            </button>
                            @foreach($allTechTags as $tag)
                                <button type="button" data-filter="{{ $tag }}" class="filter-btn filter-idle rounded-full px-3.5 py-1.5 text-xs font-medium">
                                    {{ $tag }}
                                </button>
                            @endforeach
                        </div>
                    @endif

                    <div class="mt-8 grid gap-6 sm:grid-cols-2 lg:grid-cols-3" id="project-grid">
                        @foreach($projects as $project)
                            <article data-tags="{{ implode(',', $project->techStackList()) }}" class="reveal-scale project-card surface-1 group relative flex flex-col overflow-hidden rounded-2xl transition-all duration-300 hover:-translate-y-1 hover:border-emerald-500/30 hover:shadow-2xl hover:shadow-emerald-500/5 dark:hover:border-emerald-400/30" style="--reveal-delay: {{ $loop->index * 90 }}ms">
                                <a href="{{ route('projects.show', $project) }}" class="block">
                                    @if($project->image_url)
                                        <div class="aspect-video w-full overflow-hidden bg-neutral-100 dark:bg-neutral-900">
                                            <img src="{{ $project->image_url }}" alt="{{ $project->title }}" class="h-full w-full object-cover transition duration-500 group-hover:scale-105">
                                        </div>
                                    @endif
                                </a>
                                <div class="flex flex-1 flex-col p-6">
                                    <div class="flex items-start justify-between gap-3">
                                        <a href="{{ route('projects.show', $project) }}">
                                            <h3 class="text-heading text-lg font-semibold transition-colors group-hover:text-emerald-600 dark:group-hover:text-emerald-300">{{ $project->title }}</h3>
                                        </a>
                                        @if($project->featured)
                                            <span class="badge-accent shrink-0 rounded-full px-2.5 py-1 text-xs font-medium">Featured</span>
                                        @endif
                                    </div>
                                    <p class="text-muted mt-2 flex-1 text-sm leading-relaxed">{{ $project->summary }}</p>

                                    @if($project->techStackList())
                                        <div class="mt-4 flex flex-wrap gap-2">
                                            @foreach($project->techStackList() as $tech)
                                                <span class="surface-2 text-muted rounded-md px-2 py-1 text-xs">{{ $tech }}</span>
                                            @endforeach
                                        </div>
                                    @endif

                                    <div class="mt-5 flex gap-4 text-sm font-medium">
                                        <a href="{{ route('projects.show', $project) }}" class="text-heading inline-flex items-center gap-1 transition hover:gap-2">
                                            Details <span aria-hidden="true">&rarr;</span>
                                        </a>
                                        @if($project->project_url)
                                            <a href="{{ $project->project_url }}" target="_blank" rel="noopener" class="link-accent inline-flex items-center gap-1 transition hover:gap-2">
                                                Live site <span aria-hidden="true">&rarr;</span>
                                            </a>
                                        @endif
                                        @if($project->github_url)
                                            <a href="{{ $project->github_url }}" target="_blank" rel="noopener" class="link-muted inline-flex items-center gap-1 hover:gap-2">
                                                Source <span aria-hidden="true">&rarr;</span>
                                            </a>
                                        @endif
                                    </div>
                                </div>
                            </article>
                        @endforeach
                    </div>
                @endif
            </div>
        </section>

        <!-- Testimonials -->
        @if($testimonials->isNotEmpty())
            <section id="testimonials" class="border-app-subtle border-t px-6 py-20">
                <div class="mx-auto max-w-5xl">
                    <h2 class="text-accent reveal text-sm font-semibold uppercase tracking-[0.2em]">Testimonials</h2>
                    <p class="text-body reveal mt-4 text-lg" style="--reveal-delay: 100ms">What people I've worked with have to say.</p>

                    <div class="mt-10 grid gap-6 sm:grid-cols-2">
                        @foreach($testimonials as $testimonial)
                            <figure class="reveal-scale surface-1 rounded-2xl p-6 transition-all duration-300 hover:-translate-y-1 hover:border-emerald-500/30 dark:hover:border-emerald-400/30" style="--reveal-delay: {{ $loop->index * 100 }}ms">
                                <div class="flex text-amber-500 dark:text-amber-400" aria-hidden="true">
                                    @for($i = 0; $i < 5; $i++)
                                        <svg xmlns="http://www.w3.org/2000/svg" viewBox="0 0 20 20" fill="currentColor" class="h-4 w-4 {{ $i < $testimonial->rating ? '' : 'text-neutral-300 dark:text-neutral-700' }}">
                                            <path d="M10 1.5l2.6 5.27 5.82.85-4.21 4.1.99 5.8L10 14.9l-5.2 2.73.99-5.8-4.21-4.1 5.82-.85L10 1.5z" />
                                        </svg>
                                    @endfor
                                </div>
                                <blockquote class="text-body mt-4 text-sm leading-relaxed">&ldquo;{{ $testimonial->content }}&rdquo;</blockquote>
                                <figcaption class="mt-5 flex items-center gap-3">
                                    @if($testimonial->author_avatar_url)
                                        <img src="{{ $testimonial->author_avatar_url }}" alt="{{ $testimonial->author_name }}" class="h-9 w-9 rounded-full object-cover">
                                    @else
                                        <span class="surface-2 text-accent flex h-9 w-9 items-center justify-center rounded-full text-xs font-semibold">
                                            {{ mb_strtoupper(mb_substr($testimonial->author_name, 0, 1)) }}
                                        </span>
                                    @endif
                                    <div>
                                        <p class="text-heading text-sm font-medium">{{ $testimonial->author_name }}</p>
                                        @if($testimonial->author_role)
                                            <p class="text-faint text-xs">{{ $testimonial->author_role }}</p>
                                        @endif
                                    </div>
                                </figcaption>
                            </figure>
                        @endforeach
                    </div>
                </div>
            </section>
        @endif

        <!-- Contact -->
        <section id="contact" class="border-app-subtle border-t px-6 py-20">
            <div class="mx-auto max-w-2xl">
                <h2 class="text-accent reveal text-sm font-semibold uppercase tracking-[0.2em]">Contact</h2>
                <p class="text-body reveal mt-4 text-lg" style="--reveal-delay: 100ms">Have a project in mind, or just want to say hi? Send me a message.</p>

                @if (session('status'))
                    <div class="alert-success mt-6 animate-[fade-in_0.4s_ease-out] rounded-lg border px-4 py-3 text-sm">
                        {{ session('status') }}
                    </div>
                @endif

                <form method="POST" action="{{ route('contact.store') }}" id="contact-form" class="reveal mt-8 space-y-5" style="--reveal-delay: 180ms">
                    @csrf
                    <div class="grid gap-5 sm:grid-cols-2">
                        <div>
                            <label for="name" class="text-muted mb-1.5 block text-sm">Name</label>
                            <input type="text" name="name" id="name" value="{{ old('name') }}" required
                                class="field-input w-full rounded-lg px-4 py-2.5 text-sm">
                            @error('name')<p class="mt-1 text-xs text-red-600 dark:text-red-400">{{ $message }}</p>@enderror
                        </div>
                        <div>
                            <label for="email" class="text-muted mb-1.5 block text-sm">Email</label>
                            <input type="email" name="email" id="email" value="{{ old('email') }}" required
                                class="field-input w-full rounded-lg px-4 py-2.5 text-sm">
                            @error('email')<p class="mt-1 text-xs text-red-600 dark:text-red-400">{{ $message }}</p>@enderror
                        </div>
                    </div>
                    <div>
                        <label for="subject" class="text-muted mb-1.5 block text-sm">Subject</label>
                        <input type="text" name="subject" id="subject" value="{{ old('subject') }}"
                            class="field-input w-full rounded-lg px-4 py-2.5 text-sm">
                    </div>
                    <div>
                        <label for="message" class="text-muted mb-1.5 block text-sm">Message</label>
                        <textarea name="message" id="message" rows="5" required
                            class="field-input w-full rounded-lg px-4 py-2.5 text-sm">{{ old('message') }}</textarea>
                        @error('message')<p class="mt-1 text-xs text-red-600 dark:text-red-400">{{ $message }}</p>@enderror
                    </div>
                    <button type="submit" class="btn-primary group relative overflow-hidden rounded-lg px-6 py-3 text-sm font-semibold transition-all duration-300 hover:-translate-y-0.5 hover:shadow-lg hover:shadow-emerald-500/20 active:translate-y-0 active:scale-95 disabled:cursor-wait disabled:opacity-70">
                        <span class="submit-label">Send message</span>
                    </button>
                </form>

                @if($profile && ($profile->github_url || $profile->linkedin_url || $profile->twitter_url))
                    <div class="reveal mt-10 flex gap-6 text-sm font-medium" style="--reveal-delay: 260ms">
                        @if($profile->github_url)<a href="{{ $profile->github_url }}" target="_blank" rel="noopener" class="link-muted">GitHub</a>@endif
                        @if($profile->linkedin_url)<a href="{{ $profile->linkedin_url }}" target="_blank" rel="noopener" class="link-muted">LinkedIn</a>@endif
                        @if($profile->twitter_url)<a href="{{ $profile->twitter_url }}" target="_blank" rel="noopener" class="link-muted">Twitter</a>@endif
                    </div>
                @endif
            </div>
        </section>
    </main>

    <footer class="border-app-subtle text-faintest border-t px-6 py-8 text-center text-sm">
        &copy; {{ date('Y') }} {{ $name }}. Built with Laravel &amp; Tailwind CSS.
    </footer>

    <!-- Back to top -->
    <button type="button" id="to-top" aria-label="Back to top"
            class="border-app text-body fixed bottom-6 right-6 z-40 flex h-11 w-11 -translate-y-2 items-center justify-center rounded-full border bg-white/90 opacity-0 shadow-lg backdrop-blur transition-all duration-300 pointer-events-none hover:border-emerald-500/30 hover:text-neutral-900 dark:bg-neutral-900/90 dark:hover:border-emerald-400/30 dark:hover:text-white">
        <svg xmlns="http://www.w3.org/2000/svg" fill="none" viewBox="0 0 24 24" stroke-width="1.5" stroke="currentColor" class="h-5 w-5">
            <path stroke-linecap="round" stroke-linejoin="round" d="M4.5 15.75l7.5-7.5 7.5 7.5" />
        </svg>
    </button>

    <!-- Contact success modal -->
    <div id="success-modal" @if(session('status')) data-autoshow="true" @endif
         class="fixed inset-0 z-60 hidden items-center justify-center bg-black/60 px-6 backdrop-blur-sm" role="dialog" aria-modal="true" aria-labelledby="success-modal-title">
        <div id="success-modal-panel" class="panel-card w-full max-w-sm scale-95 rounded-2xl border p-8 text-center opacity-0 shadow-2xl transition-all duration-300">
            <div class="badge-accent mx-auto flex h-14 w-14 items-center justify-center rounded-full">
                <svg xmlns="http://www.w3.org/2000/svg" fill="none" viewBox="0 0 24 24" stroke-width="2" stroke="currentColor" class="h-7 w-7">
                    <path stroke-linecap="round" stroke-linejoin="round" d="m4.5 12.75 6 6 9-13.5" />
                </svg>
            </div>
            <h3 id="success-modal-title" class="text-heading mt-5 text-lg font-semibold">Message sent!</h3>
            <p class="text-muted mt-2 text-sm leading-relaxed">
                Thanks for reaching out — please wait, we'll respond to your email soon.
            </p>
            <button type="button" id="success-modal-close" class="btn-primary mt-6 w-full rounded-lg px-6 py-2.5 text-sm font-semibold">
                Got it
            </button>
        </div>
    </div>

    <script>
        document.addEventListener('DOMContentLoaded', () => {
            // Contact success modal
            const modal = document.getElementById('success-modal');
            const modalPanel = document.getElementById('success-modal-panel');
            const modalClose = document.getElementById('success-modal-close');
            if (modal && modal.dataset.autoshow === 'true') {
                const openModal = () => {
                    modal.classList.remove('hidden');
                    modal.classList.add('flex');
                    requestAnimationFrame(() => {
                        modalPanel.classList.remove('scale-95', 'opacity-0');
                        modalPanel.classList.add('scale-100', 'opacity-100');
                    });
                };
                const closeModal = () => {
                    modalPanel.classList.remove('scale-100', 'opacity-100');
                    modalPanel.classList.add('scale-95', 'opacity-0');
                    setTimeout(() => {
                        modal.classList.add('hidden');
                        modal.classList.remove('flex');
                    }, 200);
                };
                openModal();
                modalClose.addEventListener('click', closeModal);
                modal.addEventListener('click', (event) => {
                    if (event.target === modal) closeModal();
                });
                document.addEventListener('keydown', (event) => {
                    if (event.key === 'Escape' && !modal.classList.contains('hidden')) closeModal();
                });
            }

            // Scroll-reveal animations
            const revealEls = document.querySelectorAll('.reveal, .reveal-scale');
            const revealObserver = new IntersectionObserver((entries) => {
                entries.forEach((entry) => {
                    if (!entry.isIntersecting) return;
                    entry.target.classList.add('is-visible');
                    entry.target.querySelectorAll('[data-skill-level]').forEach((bar) => {
                        bar.style.width = bar.dataset.skillLevel + '%';
                    });
                    revealObserver.unobserve(entry.target);
                });
            }, { threshold: 0.15 });
            revealEls.forEach((el) => revealObserver.observe(el));

            // Header shadow + back-to-top visibility on scroll
            const header = document.getElementById('site-header');
            const toTop = document.getElementById('to-top');
            const onScroll = () => {
                const scrolled = window.scrollY > 40;
                header.classList.toggle('shadow-lg', scrolled);
                header.classList.toggle('shadow-black/30', scrolled);

                const showTop = window.scrollY > 500;
                toTop.classList.toggle('opacity-0', !showTop);
                toTop.classList.toggle('opacity-100', showTop);
                toTop.classList.toggle('pointer-events-none', !showTop);
                toTop.classList.toggle('translate-y-0', showTop);
                toTop.classList.toggle('-translate-y-2', !showTop);
            };
            document.addEventListener('scroll', onScroll, { passive: true });
            onScroll();
            toTop.addEventListener('click', () => window.scrollTo({ top: 0, behavior: 'smooth' }));

            // Mobile menu toggle
            const menuToggle = document.getElementById('menu-toggle');
            const mobileMenu = document.getElementById('mobile-menu');
            menuToggle.addEventListener('click', () => {
                const isOpen = !mobileMenu.classList.contains('hidden');
                mobileMenu.classList.toggle('hidden');
                menuToggle.setAttribute('aria-expanded', String(!isOpen));
            });
            mobileMenu.querySelectorAll('a').forEach((a) => a.addEventListener('click', () => mobileMenu.classList.add('hidden')));

            // Scroll-spy active nav link
            const navLinks = document.querySelectorAll('[data-nav-link]');
            const spyObserver = new IntersectionObserver((entries) => {
                entries.forEach((entry) => {
                    const link = document.querySelector(`[data-nav-link="${entry.target.id}"]`);
                    if (!link) return;
                    if (entry.isIntersecting) {
                        navLinks.forEach((l) => l.classList.remove('nav-link-active'));
                        navLinks.forEach((l) => l.classList.add('nav-link-idle'));
                        link.classList.remove('nav-link-idle');
                        link.classList.add('nav-link-active');
                    }
                });
            }, { rootMargin: '-45% 0px -50% 0px' });
            document.querySelectorAll('main section[id]').forEach((s) => spyObserver.observe(s));

            // Contact form submit loading state
            const form = document.getElementById('contact-form');
            if (form) {
                form.addEventListener('submit', () => {
                    const btn = form.querySelector('button[type="submit"]');
                    const label = btn?.querySelector('.submit-label');
                    if (btn && label) {
                        btn.disabled = true;
                        label.textContent = 'Sending…';
                    }
                });
            }

            // Animated stat counters, triggered once when scrolled into view
            const counters = document.querySelectorAll('.counter');
            const counterObserver = new IntersectionObserver((entries) => {
                entries.forEach((entry) => {
                    if (!entry.isIntersecting) return;
                    const el = entry.target;
                    const target = parseInt(el.dataset.countTo, 10) || 0;
                    const duration = 1200;
                    const start = performance.now();
                    const step = (now) => {
                        const progress = Math.min((now - start) / duration, 1);
                        const eased = 1 - Math.pow(1 - progress, 3);
                        el.textContent = Math.round(eased * target);
                        if (progress < 1) requestAnimationFrame(step);
                    };
                    requestAnimationFrame(step);
                    counterObserver.unobserve(el);
                });
            }, { threshold: 0.5 });
            counters.forEach((el) => counterObserver.observe(el));

            // Project tag filters
            const filterButtons = document.querySelectorAll('.filter-btn');
            const projectCards = document.querySelectorAll('.project-card');
            filterButtons.forEach((btn) => {
                btn.addEventListener('click', () => {
                    filterButtons.forEach((b) => {
                        b.classList.remove('filter-active');
                        b.classList.add('filter-idle');
                    });
                    btn.classList.add('filter-active');
                    btn.classList.remove('filter-idle');

                    const filter = btn.dataset.filter;
                    projectCards.forEach((card) => {
                        const tags = (card.dataset.tags || '').split(',');
                        const show = filter === 'all' || tags.includes(filter);
                        card.classList.toggle('hidden', !show);
                    });
                });
            });
        });
    </script>
@endsection
