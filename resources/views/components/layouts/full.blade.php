<!DOCTYPE html>
<html lang="{{ str_replace('_', '-', app()->getLocale()) }}" class="dark">

<head>
    @include('partials.head')
</head>

<body class="min-h-screen bg-white dark:bg-zinc-800">
    <x-header />
    <x-search-bar />

    @hasSection('content')
        @yield('content')
    @else
        {{ $slot }}
    @endif

    <x-footer />

    @fluxScripts
</body>

</html>