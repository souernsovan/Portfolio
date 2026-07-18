<!DOCTYPE html>
<html lang="en" class="scroll-smooth">
<head>
    @php
        $metaTitle = $seoTitle ?? (($profile->name ?? 'Portfolio') . ' — ' . ($profile->role ?? 'Developer'));
        $metaDescription = $seoDescription ?? ($profile->tagline ?? 'Personal portfolio');
        $metaImage = $seoImage ?? ($profile->avatar_url ?? null);
        if ($metaImage && ! str_starts_with($metaImage, 'http')) {
            $metaImage = url($metaImage);
        }
        $metaUrl = $seoUrl ?? url()->current();
        $metaType = $seoType ?? 'website';
    @endphp
    <meta charset="utf-8">
    <meta name="viewport" content="width=device-width, initial-scale=1">
    <title>{{ $metaTitle }}</title>
    <meta name="description" content="{{ $metaDescription }}">
    <link rel="canonical" href="{{ $metaUrl }}">

    <meta property="og:type" content="{{ $metaType }}">
    <meta property="og:site_name" content="{{ $profile->name ?? 'Portfolio' }}">
    <meta property="og:title" content="{{ $metaTitle }}">
    <meta property="og:description" content="{{ $metaDescription }}">
    <meta property="og:url" content="{{ $metaUrl }}">
    @if($metaImage)
        <meta property="og:image" content="{{ $metaImage }}">
    @endif

    <meta name="twitter:card" content="{{ $metaImage ? 'summary_large_image' : 'summary' }}">
    <meta name="twitter:title" content="{{ $metaTitle }}">
    <meta name="twitter:description" content="{{ $metaDescription }}">
    @if($metaImage)
        <meta name="twitter:image" content="{{ $metaImage }}">
    @endif
    @if($profile?->twitter_url)
        <meta name="twitter:site" content="{{ $profile->twitter_url }}">
    @endif
    @include('partials.theme-init')

    <link rel="preconnect" href="https://fonts.bunny.net">
    <link href="https://fonts.bunny.net/css?family=instrument-sans:400,500,600,700" rel="stylesheet" />

    @vite(['resources/css/app.css', 'resources/js/app.js'])
</head>
<body class="theme-shell font-sans antialiased selection:bg-emerald-500/30 selection:text-white">
    @yield('content')
</body>
</html>
