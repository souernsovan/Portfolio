<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="utf-8">
    <meta name="viewport" content="width=device-width, initial-scale=1">
    <title>Admin Login</title>
    @include('partials.theme-init', ['scope' => 'admin'])

    <link rel="preconnect" href="https://fonts.bunny.net">
    <link href="https://fonts.bunny.net/css?family=instrument-sans:400,500,600,700" rel="stylesheet" />

    @vite(['resources/css/app.css', 'resources/js/app.js'])
</head>
<body class="theme-shell flex min-h-screen items-center justify-center px-6 font-sans antialiased">
    <div class="w-full max-w-sm">
        <div class="mb-8 flex justify-center">
            <button type="button" onclick="window.__toggleTheme()" title="Toggle light / dark theme" aria-label="Toggle light / dark theme"
                    class="nav-item flex h-9 w-9 items-center justify-center rounded-lg transition">
                <svg xmlns="http://www.w3.org/2000/svg" fill="none" viewBox="0 0 24 24" stroke-width="1.5" stroke="currentColor" class="h-5 w-5 dark:hidden">
                    <path stroke-linecap="round" stroke-linejoin="round" d="M12 3v2.25m6.364.386-1.591 1.591M21 12h-2.25m-.386 6.364-1.591-1.591M12 18.75V21m-4.773-4.227-1.591 1.591M5.25 12H3m4.227-4.773L5.636 5.636M15.75 12a3.75 3.75 0 1 1-7.5 0 3.75 3.75 0 0 1 7.5 0Z" />
                </svg>
                <svg xmlns="http://www.w3.org/2000/svg" fill="none" viewBox="0 0 24 24" stroke-width="1.5" stroke="currentColor" class="hidden h-5 w-5 dark:block">
                    <path stroke-linecap="round" stroke-linejoin="round" d="M21.752 15.002A9.72 9.72 0 0 1 18 15.75c-5.385 0-9.75-4.365-9.75-9.75 0-1.33.266-2.597.748-3.752A9.753 9.753 0 0 0 3 11.25C3 16.635 7.365 21 12.75 21a9.753 9.753 0 0 0 9.002-5.998Z" />
                </svg>
            </button>
        </div>

        <h1 class="text-heading mb-1 text-center text-xl font-semibold">Admin Login</h1>
        <p class="text-muted mb-8 text-center text-sm">Sign in to manage your portfolio.</p>

        @if ($errors->any())
            <div class="alert-error mb-6 rounded-lg border px-4 py-3 text-sm">
                {{ $errors->first() }}
            </div>
        @endif

        <form method="POST" action="{{ route('admin.login.attempt') }}" class="space-y-5">
            @csrf
            <div>
                <label for="email" class="text-muted mb-1.5 block text-sm">Email</label>
                <input type="email" name="email" id="email" value="{{ old('email') }}" required autofocus
                    class="field-input w-full rounded-lg px-4 py-2.5 text-sm">
            </div>
            <div>
                <label for="password" class="text-muted mb-1.5 block text-sm">Password</label>
                <input type="password" name="password" id="password" required
                    class="field-input w-full rounded-lg px-4 py-2.5 text-sm">
            </div>
            <label class="text-muted flex items-center gap-2 text-sm">
                <input type="checkbox" name="remember" class="border-app rounded bg-transparent text-emerald-600 focus:ring-emerald-500/50 dark:text-emerald-400 dark:focus:ring-emerald-400/50">
                Remember me
            </label>
            <button type="submit" class="btn-primary w-full rounded-lg px-6 py-3 text-sm font-semibold transition">
                Sign in
            </button>
        </form>

        <a href="{{ route('home') }}" class="text-muted mt-8 block text-center text-sm hover:text-neutral-900 dark:hover:text-white">&larr; Back to site</a>
    </div>
</body>
</html>
