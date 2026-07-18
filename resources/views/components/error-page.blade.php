@props(['code', 'title', 'message'])

<!DOCTYPE html>
<html lang="en" class="scroll-smooth">
<head>
    <meta charset="utf-8">
    <meta name="viewport" content="width=device-width, initial-scale=1">
    <meta name="robots" content="noindex">
    <title>{{ $code }} — {{ $title }}</title>
    @include('partials.theme-init')

    <link rel="preconnect" href="https://fonts.bunny.net">
    <link href="https://fonts.bunny.net/css?family=instrument-sans:400,500,600,700" rel="stylesheet" />

    @vite(['resources/css/app.css', 'resources/js/app.js'])
</head>
<body class="theme-shell font-sans antialiased selection:bg-emerald-500/30 selection:text-white">
    <div class="pointer-events-none fixed inset-0 overflow-hidden">
        <div class="animate-blob-a absolute -top-40 left-1/2 h-144 w-xl -translate-x-1/2 rounded-full bg-emerald-500/10 blur-3xl"></div>
        <div class="animate-blob-b absolute top-1/3 right-0 h-104 w-104 rounded-full bg-teal-500/5 blur-3xl"></div>
    </div>

    <main class="mx-auto flex min-h-screen max-w-3xl flex-col items-center justify-center px-6 py-24 text-center">
        <p class="text-gradient reveal is-visible text-7xl font-bold tracking-tight sm:text-8xl">{{ $code }}</p>
        <h1 class="text-heading reveal is-visible mt-6 text-2xl font-bold tracking-tight sm:text-3xl" style="--reveal-delay: 80ms">
            {{ $title }}
        </h1>
        <p class="text-muted reveal is-visible mt-4 max-w-md text-base leading-relaxed" style="--reveal-delay: 140ms">
            {{ $message }}
        </p>

        <div class="reveal is-visible mt-8 flex flex-wrap items-center justify-center gap-4 text-sm font-medium" style="--reveal-delay: 200ms">
            <a href="{{ route('home') }}" class="btn-primary inline-flex items-center gap-2 rounded-lg px-5 py-2.5 transition">
                <svg xmlns="http://www.w3.org/2000/svg" fill="none" viewBox="0 0 24 24" stroke-width="1.5" stroke="currentColor" class="h-4 w-4">
                    <path stroke-linecap="round" stroke-linejoin="round" d="m2.25 12 8.954-8.955c.44-.439 1.152-.439 1.591 0L21.75 12M4.5 9.75v10.125c0 .621.504 1.125 1.125 1.125H9.75v-4.875c0-.621.504-1.125 1.125-1.125h2.25c.621 0 1.125.504 1.125 1.125V21h4.125c.621 0 1.125-.504 1.125-1.125V9.75M8.25 21h8.25" />
                </svg>
                Back to home
            </a>
            <button type="button" onclick="history.back()" class="btn-outline inline-flex items-center gap-2 rounded-lg px-5 py-2.5 transition">
                Go back
            </button>
        </div>
    </main>
</body>
</html>
