<!DOCTYPE html>
<html lang="{{ str_replace('_', '-', app()->getLocale()) }}">

<head>
    <meta charset="utf-8">
    <meta name="viewport" content="width=device-width, initial-scale=1">
    <title>{{ config('app.name') }} Admin</title>
    @vite(['resources/css/app.css', 'resources/js/app.js'])
    <style>
        :root {
            --wp-admin-sidebar: #1d2327;
            --wp-admin-sidebar-hover: #2c3338;
            --wp-admin-sidebar-active: #2271b1;
            --wp-admin-bg: #f0f0f1;
        }
    </style>
</head>

<body class="bg-[var(--wp-admin-bg)] font-sans antialiased">
    <div class="min-h-screen flex">
        <!-- Sidebar -->
        <aside class="w-64 bg-[var(--wp-admin-sidebar)] text-gray-300 flex-shrink-0">
            <div class="p-4 flex items-center space-x-2 border-b border-gray-700">
                <x-app-logo-icon class="w-8 h-8 fill-current text-white" />
                <span class="font-bold text-white uppercase tracking-wider text-sm">{{ config('app.name') }}</span>
            </div>

            <nav class="mt-4 px-2 space-y-1">
                <a href="{{ route('admin.dashboard') }}"
                    class="flex items-center px-4 py-2 text-sm font-medium rounded-md {{ request()->routeIs('admin.dashboard') ? 'bg-[var(--wp-admin-sidebar-active)] text-white' : 'hover:bg-[var(--wp-admin-sidebar-hover)] hover:text-white' }}">
                    <svg class="mr-3 h-5 w-5" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
                            d="M3 12l2-2m0 0l7-7 7 7M5 10v10a1 1 0 001 1h3m10-11l2 2m-2-2v10a1 1 0 01-1 1h-3m-6 0a1 1 0 001-1v-4a1 1 0 011-1h2a1 1 0 011 1v4a1 1 0 001 1m-6 0h6" />
                    </svg>
                    Dashboard
                </a>

                <a href="{{ route('admin.comments') }}"
                    class="flex items-center px-4 py-2 text-sm font-medium rounded-md {{ request()->routeIs('admin.comments') ? 'bg-[var(--wp-admin-sidebar-active)] text-white' : 'hover:bg-[var(--wp-admin-sidebar-hover)] hover:text-white' }}">
                    <svg class="mr-3 h-5 w-5" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
                            d="M8 10h.01M12 10h.01M16 10h.01M9 16H5a2 2 0 01-2-2V6a2 2 0 012-2h14a2 2 0 012 2v8a2 2 0 01-2 2h-5l-5 5v-5z" />
                    </svg>
                    Комментарии
                </a>

                <a href="{{ route('admin.users') }}"
                    class="flex items-center px-4 py-2 text-sm font-medium rounded-md {{ request()->routeIs('admin.users') ? 'bg-[var(--wp-admin-sidebar-active)] text-white' : 'hover:bg-[var(--wp-admin-sidebar-hover)] hover:text-white' }}">
                    <svg class="mr-3 h-5 w-5" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
                            d="M12 4.354a4 4 0 110 5.292M15 21H3v-1a6 6 0 0112 0v1zm0 0h6v-1a6 6 0 00-9-5.197M13 7a4 4 0 11-8 0 4 4 0 018 0z" />
                    </svg>
                    Пользователи
                </a>

                <a href="{{ route('admin.api-tester') }}"
                    class="flex items-center px-4 py-2 text-sm font-medium rounded-md {{ request()->routeIs('admin.api-tester') ? 'bg-[var(--wp-admin-sidebar-active)] text-white' : 'hover:bg-[var(--wp-admin-sidebar-hover)] hover:text-white' }}">
                    <svg class="mr-3 h-5 w-5" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
                            d="M19.428 15.428a2 2 0 00-1.022-.547l-2.387-.477a6 6 0 00-3.86.517l-.318.158a6 6 0 01-3.86.517L6.05 15.21a2 2 0 00-1.806.547M8 4h8l-1 1v5.172a2 2 0 00.586 1.414l5 5c1.26 1.26.367 3.414-1.415 3.414H4.828c-1.782 0-2.674-2.154-1.414-3.414l5-5A2 2 0 009 10.172V5L8 4z" />
                    </svg>
                    API Тестер
                </a>

                <a href="{{ route('admin.affiliate-links.index') }}"
                    class="flex items-center px-4 py-2 text-sm font-medium rounded-md {{ request()->routeIs('admin.affiliate-links.*') ? 'bg-[var(--wp-admin-sidebar-active)] text-white' : 'hover:bg-[var(--wp-admin-sidebar-hover)] hover:text-white' }}">
                    <svg class="mr-3 h-5 w-5" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
                            d="M13.828 10.172a4 4 0 00-5.656 0l-4 4a4 4 0 105.656 5.656l1.102-1.101m-.758-4.826L10.242 9.242m-4.242 4.242l-.758 4.826L10.242 9.242" />
                    </svg>
                    Партнерские ссылки
                </a>

                <a href="{{ route('admin.settings.profile') }}"
                    class="flex items-center px-4 py-2 text-sm font-medium rounded-md {{ request()->routeIs('admin.settings.*') ? 'bg-[var(--wp-admin-sidebar-active)] text-white' : 'hover:bg-[var(--wp-admin-sidebar-hover)] hover:text-white' }}">
                    <svg class="mr-3 h-5 w-5" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
                            d="M10.325 4.317c.426-1.756 2.924-1.756 3.35 0a1.724 1.724 0 002.573 1.066c1.543-.94 3.31.826 2.37 2.37a1.724 1.724 0 001.065 2.572c1.756.426 1.756 2.924 0 3.35a1.724 1.724 0 00-1.066 2.573c.94 1.543-.826 3.31-2.37 2.37a1.724 1.724 0 00-2.572 1.065c-.426 1.756-2.924 1.756-3.35 0a1.724 1.724 0 00-2.573-1.066c-1.543.94-3.31-.826-2.37-2.37a1.724 1.724 0 00-1.065-2.572c-1.756-.426-1.756-2.924 0-3.35a1.724 1.724 0 001.066-2.573c-.94-1.543.826-3.31 2.37-2.37.996.608 2.296.07 2.572-1.065z" />
                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
                            d="M15 12a3 3 0 11-6 0 3 3 0 016 0z" />
                    </svg>
                    Настройки
                </a>
            </nav>

            <div class="mt-auto p-4 border-t border-gray-700">
                <a href="{{ route('home') }}"
                    class="flex items-center px-4 py-2 text-sm font-medium text-gray-400 hover:text-white">
                    <svg class="mr-3 h-5 w-5" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
                            d="M10 19l-7-7m0 0l7-7m-7 7h18" />
                    </svg>
                    На сайт
                </a>
            </div>
        </aside>

        <!-- Main Content -->
        <main class="flex-1 overflow-y-auto">
            <header class="bg-white shadow-sm h-12 flex items-center px-6 justify-between">
                <h1 class="text-lg font-semibold text-gray-800">
                    @yield('title', 'Admin Panel')
                </h1>
                <div class="flex items-center space-x-4">
                    <span class="text-sm text-gray-600">{{ auth()->user()->name }}</span>
                    <form method="POST" action="{{ route('logout') }}">
                        @csrf
                        <button type="submit" class="text-sm text-red-600 hover:text-red-800">Выйти</button>
                    </form>
                </div>
            </header>

            <div class="p-6">
                @yield('content')
            </div>
        </main>
    </div>
</body>

</html>