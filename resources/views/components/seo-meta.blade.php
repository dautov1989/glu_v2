{{-- SEO Meta Component --}}
@props([
    'title' => null,
    'description' => null,
    'keywords' => null,
    'image' => null,
    'type' => 'website',
    'url' => null,
    'publishedTime' => null,
    'modifiedTime' => null,
    'author' => null,
    'noindex' => false,
])

@php
    // Defaults
    $siteTitle = config('app.name', 'Glucosa');
    $defaultDescription = 'Glucosa - Всё о сахарном диабете. Полезная информация, советы врачей и практические рекомендации для контроля глюкозы.';
    $defaultImage = asset('images/og-image.jpg');
    
    // Prepare values
    $pageTitle = $title ? $title . ' | ' . $siteTitle : $siteTitle;
    $metaDescription = $description ?? $defaultDescription;
    $ogImage = $image ?? $defaultImage;
    $canonicalUrl = $url ?? url()->current();
@endphp

{{-- Basic Meta Tags --}}
<title>{{ $pageTitle }}</title>
<meta name="description" content="{{ $metaDescription }}">
@if($keywords)
<meta name="keywords" content="{{ $keywords }}">
@endif

{{-- Robots --}}
@if($noindex)
<meta name="robots" content="noindex, nofollow">
@else
<meta name="robots" content="index, follow, max-snippet:-1, max-image-preview:large, max-video-preview:-1">
@endif

{{-- Canonical URL --}}
<link rel="canonical" href="{{ $canonicalUrl }}">

{{-- Open Graph Meta Tags --}}
<meta property="og:locale" content="ru_RU">
<meta property="og:type" content="{{ $type }}">
<meta property="og:title" content="{{ $title ?? $siteTitle }}">
<meta property="og:description" content="{{ $metaDescription }}">
<meta property="og:url" content="{{ $canonicalUrl }}">
<meta property="og:site_name" content="{{ $siteTitle }}">
<meta property="og:image" content="{{ $ogImage }}">
<meta property="og:image:width" content="1200">
<meta property="og:image:height" content="630">

@if($type === 'article')
    @if($publishedTime)
    <meta property="article:published_time" content="{{ $publishedTime }}">
    @endif
    @if($modifiedTime)
    <meta property="article:modified_time" content="{{ $modifiedTime }}">
    @endif
    @if($author)
    <meta property="article:author" content="{{ $author }}">
    @endif
    <meta property="article:section" content="Здоровье">
    @if($keywords)
        @foreach(array_slice(explode(',', $keywords), 0, 3) as $tag)
            <meta property="article:tag" content="{{ trim($tag) }}">
        @endforeach
    @else
        <meta property="article:tag" content="диабет">
    @endif
@endif

{{-- Twitter Card Meta Tags --}}
<meta name="twitter:card" content="summary_large_image">
<meta name="twitter:title" content="{{ $title ?? $siteTitle }}">
<meta name="twitter:description" content="{{ $metaDescription }}">
<meta name="twitter:image" content="{{ $ogImage }}">

{{-- Additional SEO Meta Tags --}}
<meta name="author" content="{{ $author ?? $siteTitle }}">

{{-- Favicon and Icons (already in head.blade.php, but good to have here) --}}
<link rel="icon" href="/favicon.ico" sizes="any">
<link rel="icon" href="/favicon.svg" type="image/svg+xml">
<link rel="apple-touch-icon" href="/apple-touch-icon.png">
