<!DOCTYPE html>
<html lang="en" class="scroll-smooth">
<head>
    <meta charset="utf-8">
    <meta name="viewport" content="width=device-width, initial-scale=1">
    <title>{{ $profile->name ?? 'Portfolio' }} &mdash; {{ $profile->role ?? 'Developer' }}</title>
    <meta name="description" content="{{ $profile->tagline ?? 'Personal portfolio' }}">
    @include('partials.theme-init')

    <link rel="preconnect" href="https://fonts.bunny.net">
    <link href="https://fonts.bunny.net/css?family=instrument-sans:400,500,600,700" rel="stylesheet" />

    @vite(['resources/css/app.css', 'resources/js/app.js'])
</head>
<body class="theme-shell font-sans antialiased selection:bg-emerald-500/30 selection:text-white">
    @yield('content')
</body>
</html>
