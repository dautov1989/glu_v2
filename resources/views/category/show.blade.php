@extends('components.layouts.app')

@section('content')
    <div
        class="min-h-screen bg-gradient-to-br from-white via-cyan-50/30 to-white dark:from-zinc-900 dark:via-cyan-950/20 dark:to-zinc-900">
        <div class="max-w-7xl mx-auto px-4 sm:px-6 lg:px-8 py-12">
            <!-- Breadcrumbs -->
            <nav class="mb-8">
                <ol class="flex items-center space-x-2 text-sm">
                    <li>
                        <a href="{{ route('home') }}"
                            class="text-cyan-600 hover:text-cyan-700 dark:text-cyan-400 dark:hover:text-cyan-300">
                            Главная
                        </a>
                    </li>
                    @foreach($category->getBreadcrumbs() as $breadcrumb)
                        <li class="flex items-center">
                            <svg class="w-4 h-4 mx-2 text-zinc-400" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M9 5l7 7-7 7"></path>
                            </svg>
                            @if($loop->last)
                                <span class="text-zinc-700 dark:text-zinc-300 font-semibold">{{ $breadcrumb->title }}</span>
                            @else
                                <a href="{{ route('category.show', $breadcrumb->slug) }}"
                                    class="text-cyan-600 hover:text-cyan-700 dark:text-cyan-400 dark:hover:text-cyan-300">
                                    {{ $breadcrumb->title }}
                                </a>
                            @endif
                        </li>
                    @endforeach
                </ol>
            </nav>

            <!-- Category Header -->
            <div class="mb-12">
                <h1
                    class="text-4xl md:text-5xl font-bold bg-gradient-to-r from-cyan-600 via-blue-600 to-cyan-600 dark:from-cyan-400 dark:via-blue-400 dark:to-cyan-400 bg-clip-text text-transparent mb-4">
                    {{ $category->title }}
                </h1>

                @if($category->description)
                    <p class="text-lg text-zinc-600 dark:text-zinc-400 max-w-3xl">
                        {{ $category->description }}
                    </p>
                @endif
            </div>

            <!-- Subcategories Grid -->
            @if($category->children->count() > 0)
                <div class="mb-12">
                    <h2 class="text-2xl font-bold text-zinc-800 dark:text-zinc-200 mb-6">Подкатегории</h2>

                    <div class="grid grid-cols-1 md:grid-cols-2 lg:grid-cols-3 gap-6">
                        @foreach($category->children as $child)
                            <a href="{{ route('category.show', $child->slug) }}"
                                class="group relative bg-white dark:bg-zinc-800 rounded-2xl p-6 border border-cyan-200/50 dark:border-cyan-800/50 shadow-lg shadow-cyan-200/20 dark:shadow-cyan-900/20 hover:shadow-xl hover:shadow-cyan-300/30 dark:hover:shadow-cyan-800/30 transition-all duration-300 hover:scale-105">

                                <!-- Gradient overlay on hover -->
                                <div
                                    class="absolute inset-0 bg-gradient-to-br from-cyan-500/5 to-blue-500/5 rounded-2xl opacity-0 group-hover:opacity-100 transition-opacity duration-300">
                                </div>

                                <div class="relative">
                                    <h3
                                        class="text-xl font-bold text-zinc-800 dark:text-zinc-200 mb-2 group-hover:text-cyan-600 dark:group-hover:text-cyan-400 transition-colors">
                                        {{ $child->title }}
                                    </h3>

                                    @if($child->description)
                                        <p class="text-sm text-zinc-600 dark:text-zinc-400 mb-4 line-clamp-2">
                                            {{ $child->description }}
                                        </p>
                                    @endif

                                    @if($child->children->count() > 0)
                                        <div class="flex items-center text-xs text-cyan-600 dark:text-cyan-400">
                                            <svg class="w-4 h-4 mr-1" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
                                                    d="M9 5H7a2 2 0 00-2 2v12a2 2 0 002 2h10a2 2 0 002-2V7a2 2 0 00-2-2h-2M9 5a2 2 0 002 2h2a2 2 0 002-2M9 5a2 2 0 012-2h2a2 2 0 012 2">
                                                </path>
                                            </svg>
                                            {{ $child->children->count() }} {{ Str::plural('подкатегория', $child->children->count()) }}
                                        </div>
                                    @endif
                                </div>
                            </a>
                        @endforeach
                    </div>
                </div>
            @endif

            <!-- Content Section (placeholder for future articles/posts) -->
            <div
                class="bg-white dark:bg-zinc-800 rounded-2xl p-8 border border-cyan-200/50 dark:border-cyan-800/50 shadow-lg">
                <h2 class="text-2xl font-bold text-zinc-800 dark:text-zinc-200 mb-6">Материалы в этой категории</h2>

                <div class="text-center py-12">
                    <svg class="w-16 h-16 mx-auto text-zinc-300 dark:text-zinc-600 mb-4" fill="none" stroke="currentColor"
                        viewBox="0 0 24 24">
                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
                            d="M9 12h6m-6 4h6m2 5H7a2 2 0 01-2-2V5a2 2 0 012-2h5.586a1 1 0 01.707.293l5.414 5.414a1 1 0 01.293.707V19a2 2 0 01-2 2z">
                        </path>
                    </svg>
                    <p class="text-zinc-500 dark:text-zinc-400">
                        Материалы для этой категории скоро появятся
                    </p>
                </div>
            </div>
        </div>
    </div>
@endsection