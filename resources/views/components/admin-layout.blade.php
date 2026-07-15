<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="utf-8">
    <meta name="viewport" content="width=device-width, initial-scale=1">
    <title>Admin &mdash; {{ $title ?? 'Dashboard' }}</title>
    @include('partials.theme-init', ['scope' => 'admin'])

    <link rel="preconnect" href="https://fonts.bunny.net">
    <link href="https://fonts.bunny.net/css?family=instrument-sans:400,500,600,700" rel="stylesheet" />

    @vite(['resources/css/app.css', 'resources/js/app.js'])
</head>
<body class="theme-shell flex h-screen overflow-hidden font-sans antialiased">
    @php
        $unreadCount = \App\Models\ContactMessage::whereNull('read_at')->count();
        $navItems = [
            [
                'route' => 'admin.dashboard', 'label' => 'Dashboard', 'pattern' => 'admin.dashboard',
                'icon' => '<path stroke-linecap="round" stroke-linejoin="round" d="M3.75 6a2.25 2.25 0 0 1 2.25-2.25h2.25A2.25 2.25 0 0 1 10.5 6v2.25a2.25 2.25 0 0 1-2.25 2.25H6a2.25 2.25 0 0 1-2.25-2.25V6ZM3.75 15.75A2.25 2.25 0 0 1 6 13.5h2.25a2.25 2.25 0 0 1 2.25 2.25V18a2.25 2.25 0 0 1-2.25 2.25H6A2.25 2.25 0 0 1 3.75 18v-2.25ZM13.5 6a2.25 2.25 0 0 1 2.25-2.25H18A2.25 2.25 0 0 1 20.25 6v2.25A2.25 2.25 0 0 1 18 10.5h-2.25a2.25 2.25 0 0 1-2.25-2.25V6ZM13.5 15.75a2.25 2.25 0 0 1 2.25-2.25H18a2.25 2.25 0 0 1 2.25 2.25V18A2.25 2.25 0 0 1 18 20.25h-2.25A2.25 2.25 0 0 1 13.5 18v-2.25Z" />',
            ],
            [
                'route' => 'admin.projects.index', 'label' => 'Projects', 'pattern' => 'admin.projects.*',
                'icon' => '<path stroke-linecap="round" stroke-linejoin="round" d="M2.25 12.75V12A2.25 2.25 0 0 1 4.5 9.75h15A2.25 2.25 0 0 1 21.75 12v.75m-19.5 0v6a2.25 2.25 0 0 0 2.25 2.25h15a2.25 2.25 0 0 0 2.25-2.25v-6m-19.5 0 5.03-5.03a2.25 2.25 0 0 1 1.591-.659h5.758a2.25 2.25 0 0 1 1.591.659l5.03 5.03" />',
            ],
            [
                'route' => 'admin.skills.index', 'label' => 'Skills', 'pattern' => 'admin.skills.*',
                'icon' => '<path stroke-linecap="round" stroke-linejoin="round" d="M3 13.125C3 12.504 3.504 12 4.125 12h2.25c.621 0 1.125.504 1.125 1.125v6.75C7.5 20.496 6.996 21 6.375 21h-2.25A1.125 1.125 0 0 1 3 19.875v-6.75ZM9.75 8.625c0-.621.504-1.125 1.125-1.125h2.25c.621 0 1.125.504 1.125 1.125v11.25c0 .621-.504 1.125-1.125 1.125h-2.25a1.125 1.125 0 0 1-1.125-1.125V8.625ZM16.5 4.125c0-.621.504-1.125 1.125-1.125h2.25C20.496 3 21 3.504 21 4.125v15.75c0 .621-.504 1.125-1.125 1.125h-2.25a1.125 1.125 0 0 1-1.125-1.125V4.125Z" />',
            ],
            [
                'route' => 'admin.experiences.index', 'label' => 'Experience', 'pattern' => 'admin.experiences.*',
                'icon' => '<path stroke-linecap="round" stroke-linejoin="round" d="M20.25 14.15v4.25c0 1.094-.787 2.036-1.872 2.18-2.087.277-4.216.42-6.378.42s-4.291-.143-6.378-.42c-1.085-.144-1.872-1.086-1.872-2.18v-4.25m16.5 0a2.18 2.18 0 0 0 .75-1.661V8.706c0-1.081-.768-2.015-1.837-2.175a48.114 48.114 0 0 0-3.413-.387m4.5 8.006c-.194.165-.42.295-.673.38A23.978 23.978 0 0 1 12 15.75c-2.648 0-5.195-.429-7.577-1.22a2.016 2.016 0 0 1-.673-.38m0 0A2.18 2.18 0 0 1 3 12.489V8.706c0-1.081.768-2.015 1.837-2.175a48.111 48.111 0 0 1 3.413-.387m7.5 0V5.25A2.25 2.25 0 0 0 13.5 3h-3a2.25 2.25 0 0 0-2.25 2.25v.894m7.5 0a48.667 48.667 0 0 0-7.5 0" />',
            ],
            [
                'route' => 'admin.testimonials.index', 'label' => 'Testimonials', 'pattern' => 'admin.testimonials.*',
                'icon' => '<path stroke-linecap="round" stroke-linejoin="round" d="M7.5 8.25h9m-9 3H12m-9.75 1.51c0 1.6 1.123 2.994 2.707 3.227 1.087.16 2.185.283 3.293.369V21l4.184-4.183a1.14 1.14 0 0 1 .778-.332 48.294 48.294 0 0 0 5.83-.498c1.585-.233 2.708-1.626 2.708-3.228V6.741c0-1.602-1.123-2.995-2.707-3.228A48.394 48.394 0 0 0 12 3c-2.392 0-4.744.175-7.043.513C3.373 3.746 2.25 5.14 2.25 6.741v6.018Z" />',
            ],
            [
                'route' => 'admin.messages.index', 'label' => 'Messages', 'pattern' => 'admin.messages.*',
                'icon' => '<path stroke-linecap="round" stroke-linejoin="round" d="M21.75 6.75v10.5a2.25 2.25 0 0 1-2.25 2.25h-15a2.25 2.25 0 0 1-2.25-2.25V6.75m19.5 0A2.25 2.25 0 0 0 19.5 4.5h-15a2.25 2.25 0 0 0-2.25 2.25m19.5 0v.243a2.25 2.25 0 0 1-1.07 1.916l-7.5 4.615a2.25 2.25 0 0 1-2.36 0L3.32 8.91a2.25 2.25 0 0 1-1.07-1.916V6.75" />',
                'badge' => $unreadCount,
            ],
            [
                'route' => 'admin.profile.edit', 'label' => 'Profile', 'pattern' => 'admin.profile.*',
                'icon' => '<path stroke-linecap="round" stroke-linejoin="round" d="M17.982 18.725A7.488 7.488 0 0 0 12 15.75a7.488 7.488 0 0 0-5.982 2.975m11.963 0a9 9 0 1 0-11.963 0m11.963 0A8.966 8.966 0 0 1 12 21a8.966 8.966 0 0 1-5.982-2.275M15 9.75a3 3 0 1 1-6 0 3 3 0 0 1 6 0Z" />',
            ],
        ];
        $userName = auth()->user()->name ?? 'Admin';
        $userEmail = auth()->user()->email ?? '';
        $userInitial = mb_strtoupper(mb_substr($userName, 0, 1));
    @endphp

    <!-- Sidebar -->
    <aside class="panel-sidebar flex h-screen w-64 shrink-0 flex-col overflow-y-auto border-r py-6">
        <a href="{{ route('admin.dashboard') }}" class="mb-8 flex items-center gap-2.5 px-6">
            <span class="badge-accent flex h-8 w-8 items-center justify-center rounded-lg">
                <svg xmlns="http://www.w3.org/2000/svg" fill="none" viewBox="0 0 24 24" stroke-width="1.5" stroke="currentColor" class="h-5 w-5">
                    <path stroke-linecap="round" stroke-linejoin="round" d="m6.75 7.5 3-3 3 3m-3-3v11.25m6-2.25-3 3-3-3m3 3V6.75" />
                </svg>
            </span>
            <span class="text-heading text-lg font-semibold tracking-tight">Admin</span>
        </a>

        <nav class="flex-1 space-y-1 px-3 text-sm">
            @foreach($navItems as $item)
                @php $active = request()->routeIs($item['pattern']); @endphp
                <a href="{{ route($item['route']) }}"
                   class="group relative flex items-center gap-3 rounded-lg px-3 py-2.5 font-medium transition {{ $active ? 'nav-item-active' : 'nav-item' }}">
                    @if($active)
                        <span class="absolute -left-3 h-5 w-1 rounded-r-full bg-emerald-500 dark:bg-emerald-400"></span>
                    @endif
                    <svg xmlns="http://www.w3.org/2000/svg" fill="none" viewBox="0 0 24 24" stroke-width="1.5" stroke="currentColor" class="h-5 w-5 shrink-0 {{ $active ? 'text-emerald-600 dark:text-emerald-300' : 'text-faint' }}">
                        {!! $item['icon'] !!}
                    </svg>
                    <span class="flex-1">{{ $item['label'] }}</span>
                    @if(!empty($item['badge']))
                        <span class="rounded-full bg-emerald-500 px-2 py-0.5 text-xs font-semibold text-white dark:bg-emerald-400 dark:text-neutral-950">{{ $item['badge'] }}</span>
                    @endif
                </a>
            @endforeach
        </nav>
    </aside>

    <!-- Main column -->
    <div class="flex h-screen flex-1 flex-col overflow-y-auto">
        <!-- Header -->
        <header class="panel-header sticky top-0 z-20 flex shrink-0 items-center justify-between border-b px-8 py-4 backdrop-blur">
            <div>
                <h1 class="text-heading text-lg font-semibold">{{ $title ?? 'Dashboard' }}</h1>
                @isset($subtitle)
                    <p class="text-muted text-sm">{{ $subtitle }}</p>
                @endisset
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

                <a href="{{ route('home') }}" target="_blank" class="nav-item flex items-center gap-2 rounded-lg px-3 py-2 text-sm font-medium transition">
                    <svg xmlns="http://www.w3.org/2000/svg" fill="none" viewBox="0 0 24 24" stroke-width="1.5" stroke="currentColor" class="h-4 w-4 shrink-0">
                        <path stroke-linecap="round" stroke-linejoin="round" d="M13.5 6H5.25A2.25 2.25 0 0 0 3 8.25v10.5A2.25 2.25 0 0 0 5.25 21h10.5A2.25 2.25 0 0 0 18 18.75V10.5m-10.5 6L21 3m0 0h-5.25M21 3v5.25" />
                    </svg>
                    View site
                </a>

                <details class="group relative">
                    <summary class="surface-1-hover flex cursor-pointer list-none items-center gap-2 rounded-lg px-2 py-1.5 transition [&::-webkit-details-marker]:hidden">
                        <span class="surface-2 text-heading flex h-8 w-8 shrink-0 items-center justify-center rounded-full text-sm font-semibold">
                            {{ $userInitial }}
                        </span>
                        <span class="hidden text-left sm:block">
                            <span class="text-heading block max-w-40 truncate text-sm font-medium">{{ $userName }}</span>
                        </span>
                        <svg xmlns="http://www.w3.org/2000/svg" fill="none" viewBox="0 0 24 24" stroke-width="1.5" stroke="currentColor" class="text-faint h-4 w-4 shrink-0 transition group-open:rotate-180">
                            <path stroke-linecap="round" stroke-linejoin="round" d="m19.5 8.25-7.5 7.5-7.5-7.5" />
                        </svg>
                    </summary>

                    <div class="panel-dropdown absolute right-0 z-30 mt-2 w-56 rounded-xl border p-2 shadow-2xl">
                        <div class="border-app-subtle mb-1 border-b px-3 py-2">
                            <p class="text-heading truncate text-sm font-medium">{{ $userName }}</p>
                            <p class="text-muted truncate text-xs">{{ $userEmail }}</p>
                        </div>

                        <a href="{{ route('admin.profile.edit') }}" class="nav-item flex items-center gap-2.5 rounded-lg px-3 py-2 text-sm transition">
                            <svg xmlns="http://www.w3.org/2000/svg" fill="none" viewBox="0 0 24 24" stroke-width="1.5" stroke="currentColor" class="text-faint h-4 w-4 shrink-0">
                                <path stroke-linecap="round" stroke-linejoin="round" d="M17.982 18.725A7.488 7.488 0 0 0 12 15.75a7.488 7.488 0 0 0-5.982 2.975m11.963 0a9 9 0 1 0-11.963 0m11.963 0A8.966 8.966 0 0 1 12 21a8.966 8.966 0 0 1-5.982-2.275M15 9.75a3 3 0 1 1-6 0 3 3 0 0 1 6 0Z" />
                            </svg>
                            Edit profile
                        </a>

                        <form method="POST" action="{{ route('admin.logout') }}">
                            @csrf
                            <button type="submit" class="flex w-full items-center gap-2.5 rounded-lg px-3 py-2 text-left text-sm text-red-600 transition hover:bg-red-500/10 dark:text-red-400">
                                <svg xmlns="http://www.w3.org/2000/svg" fill="none" viewBox="0 0 24 24" stroke-width="1.5" stroke="currentColor" class="h-4 w-4 shrink-0">
                                    <path stroke-linecap="round" stroke-linejoin="round" d="M8.25 9V5.25A2.25 2.25 0 0 1 10.5 3h6a2.25 2.25 0 0 1 2.25 2.25v13.5A2.25 2.25 0 0 1 16.5 21h-6a2.25 2.25 0 0 1-2.25-2.25V15m-3 0-3-3m0 0 3-3m-3 3H15" />
                                </svg>
                                Log out
                            </button>
                        </form>
                    </div>
                </details>
            </div>
        </header>

        <!-- Page content -->
        <div class="flex-1 p-6">
            <div class="panel-card min-h-[calc(100vh-6.5rem)] w-full rounded-2xl border p-8">
                @if (session('status'))
                    <div class="alert-success mb-6 rounded-lg border px-4 py-3 text-sm">
                        {{ session('status') }}
                    </div>
                @endif

                {{ $slot }}
            </div>
        </div>
    </div>

    <script>
        document.addEventListener('click', (event) => {
            document.querySelectorAll('details[open]').forEach((details) => {
                if (!details.contains(event.target)) {
                    details.removeAttribute('open');
                }
            });
        });
    </script>
</body>
</html>
