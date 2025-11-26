@extends('components.layouts.app')

@section('title', $category->meta_title ?? $category->title . ' | Glucosa')
@section('meta_description', $category->meta_description ?? $category->description)

@section('content')
    <div
        class="min-h-screen bg-gradient-to-br from-white via-cyan-50/30 to-white dark:from-zinc-900 dark:via-cyan-950/20 dark:to-zinc-900">
        <div class="max-w-7xl mx-auto px-4 sm:px-6 lg:px-8 py-8">
            <!-- Breadcrumbs -->
            <nav class="mb-6">
                <ol class="flex items-center space-x-2 text-sm text-zinc-500 dark:text-zinc-400">
                    <li>
                        <a href="{{ route('home') }}"
                            class="hover:text-cyan-600 dark:hover:text-cyan-400 transition-colors">
                            Главная
                        </a>
                    </li>
                    @foreach($category->getBreadcrumbs() as $breadcrumb)
                        <li class="flex items-center">
                            <svg class="w-3 h-3 mx-1 text-zinc-300" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M9 5l7 7-7 7"></path>
                            </svg>
                            @if($loop->last)
                                <span class="font-medium text-zinc-700 dark:text-zinc-300">{{ $breadcrumb->title }}</span>
                            @else
                                <a href="{{ route('category.show', $breadcrumb->slug) }}"
                                    class="hover:text-cyan-600 dark:hover:text-cyan-400 transition-colors">
                                    {{ $breadcrumb->title }}
                                </a>
                            @endif
                        </li>
                    @endforeach
                </ol>
            </nav>

            <!-- Category Header -->
            <div class="mb-6 border-b border-zinc-100 dark:border-zinc-800 pb-4">
                <h1 class="text-2xl font-bold text-zinc-800 dark:text-zinc-100 mb-2">
                    {{ $category->title }}
                </h1>

                @if($category->description)
                    <p class="text-sm text-zinc-500 dark:text-zinc-400 max-w-4xl leading-relaxed">
                        {{ $category->description }}
                    </p>
                @endif
            </div>

            <!-- Subcategories Grid -->
            @if($category->children->count() > 0)
                <div class="mb-10">
                    <h2 class="text-lg font-semibold text-zinc-800 dark:text-zinc-200 mb-4 flex items-center">
                        <span class="w-1 h-6 bg-cyan-500 rounded-full mr-3"></span>
                        Подкатегории
                    </h2>

                    <div class="grid grid-cols-1 sm:grid-cols-2 lg:grid-cols-4 gap-4">
                        @foreach($category->children as $child)
                            <a href="{{ route('category.show', $child->slug) }}"
                                class="group relative bg-white dark:bg-zinc-800 rounded-xl p-4 border border-zinc-200 dark:border-zinc-700 hover:border-cyan-300 dark:hover:border-cyan-700 shadow-sm hover:shadow-md transition-all duration-200">

                                <div class="flex flex-col h-full">
                                    <h3
                                        class="text-base font-semibold text-zinc-800 dark:text-zinc-200 mb-2 group-hover:text-cyan-600 dark:group-hover:text-cyan-400 transition-colors">
                                        {{ $child->title }}
                                    </h3>

                                    @if($child->description)
                                        <p class="text-xs text-zinc-500 dark:text-zinc-400 mb-3 line-clamp-2 leading-relaxed">
                                            {{ $child->description }}
                                        </p>
                                    @endif

                                    @if($child->children->count() > 0)
                                        <div
                                            class="mt-auto pt-3 border-t border-zinc-50 dark:border-zinc-700/50 flex items-center text-[10px] uppercase tracking-wider text-zinc-400 font-medium group-hover:text-cyan-600 dark:group-hover:text-cyan-400 transition-colors">
                                            {{ $child->children->count() }} {{ Str::plural('раздел', $child->children->count()) }}
                                            <svg class="w-3 h-3 ml-1 transform group-hover:translate-x-1 transition-transform"
                                                fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M9 5l7 7-7 7">
                                                </path>
                                            </svg>
                                        </div>
                                    @endif
                                </div>
                            </a>
                        @endforeach
                    </div>
                </div>
            @endif

            <!-- Posts Grid -->
            @if($posts->count() > 0)
                <div>
                    <h2 class="text-lg font-semibold text-zinc-800 dark:text-zinc-200 mb-4 flex items-center">
                        <span class="w-1 h-6 bg-cyan-500 rounded-full mr-3"></span>
                        Материалы в этой категории
                    </h2>

                    <div class="grid grid-cols-1 md:grid-cols-2 lg:grid-cols-3 xl:grid-cols-4 gap-6">
                        @foreach($posts as $post)
                            <article
                                class="bg-white dark:bg-zinc-800 rounded-xl overflow-hidden border border-zinc-200 dark:border-zinc-700 shadow-sm hover:shadow-md transition-all duration-200 group flex flex-col h-full">
                                @if($post->image)
                                    <div class="aspect-[16/9] w-full overflow-hidden">
                                        <img src="{{ $post->image }}" alt="{{ $post->title }}"
                                            class="w-full h-full object-cover group-hover:scale-105 transition-transform duration-500">
                                    </div>
                                @else
                                    <div class="aspect-[16/9] w-full overflow-hidden">
                                        <img src="{{ asset('images/medical_placeholder.png') }}" alt="{{ $post->title }}"
                                            class="w-full h-full object-cover group-hover:scale-105 transition-transform duration-500 opacity-80">
                                    </div>
                                @endif

                                <div class="p-4 flex flex-col flex-1">
                                    <div class="flex items-center text-[11px] text-zinc-400 mb-2 space-x-2">
                                        <span>{{ $post->published_at->format('d.m.Y') }}</span>
                                        <span class="w-1 h-1 bg-zinc-300 rounded-full"></span>
                                        <span>{{ $post->views }} просмотров</span>
                                    </div>

                                    <h3
                                        class="text-base font-bold text-zinc-800 dark:text-zinc-100 mb-2 line-clamp-2 group-hover:text-cyan-600 dark:group-hover:text-cyan-400 transition-colors">
                                        <a href="{{ route('post.show', $post->slug) }}">
                                            {{ $post->title }}
                                        </a>
                                    </h3>

                                    <p class="text-sm text-zinc-500 dark:text-zinc-400 line-clamp-3 mb-4 flex-1 leading-relaxed">
                                        {{ $post->excerpt }}
                                    </p>

                                    <div class="mt-auto pt-3 border-t border-zinc-100 dark:border-zinc-700">
                                        <a href="{{ route('post.show', $post->slug) }}"
                                            class="text-cyan-600 dark:text-cyan-400 text-xs font-semibold hover:text-cyan-700 dark:hover:text-cyan-300 flex items-center uppercase tracking-wide">
                                            Читать статью
                                            <svg class="w-3 h-3 ml-1 transform group-hover:translate-x-1 transition-transform"
                                                fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
                                                    d="M17 8l4 4m0 0l-4 4m4-4H3"></path>
                                            </svg>
                                        </a>
                                    </div>
                                </div>
                            </article>
                        @endforeach
                    </div>

                    <div class="mt-8">
                        {{ $posts->links() }}
                    </div>
                </div>
            @endif
        </div>
    </div>
@endsection