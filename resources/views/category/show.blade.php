@section('seo-meta')
    <x-seo-meta 
        :title="$category->meta_title ?? $category->title"
        :description="$category->meta_description ?? $category->description"
        :keywords="'диабет, ' . $category->title . ', статьи о диабете'"
        type="website"
        :url="route('category.show', $category->slug)"
    />
    
    {{-- Breadcrumb Schema --}}
    @php
        $breadcrumbItems = [
            ['name' => 'Главная', 'url' => route('home')]
        ];
        foreach($category->getBreadcrumbs() as $breadcrumb) {
            $breadcrumbItems[] = [
                'name' => $breadcrumb->title,
                'url' => route('category.show', $breadcrumb->slug)
            ];
        }
    @endphp
    <x-schema-org type="breadcrumb" :data="['items' => $breadcrumbItems]" />
@endsection

@extends('components.layouts.app')

@section('title', $category->meta_title ?? $category->title . ' | Glucosa')
@section('meta_description', $category->meta_description ?? $category->description)

@section('content')
    <div x-data x-init="
        if (window.innerWidth < 768) {
            setTimeout(() => {
                $el.scrollIntoView({ behavior: 'smooth', block: 'start' });
            }, 100);
        }
    " class="min-h-screen bg-gradient-to-br from-white via-cyan-50/30 to-white dark:from-zinc-900 dark:via-cyan-950/20 dark:to-zinc-900 scroll-mt-24">
        <div class="max-w-7xl mx-auto px-4 sm:px-6 lg:px-8 py-8">
            <!-- Breadcrumbs -->
            <nav class="mb-6">
                <ol class="flex flex-wrap items-center gap-2 text-sm text-zinc-500 dark:text-zinc-400">
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
                    <div class="flex flex-col sm:flex-row sm:items-center sm:justify-between mb-4 gap-4">
                        <h2 class="text-lg font-semibold text-zinc-800 dark:text-zinc-200 flex items-center">
                            <span class="w-1 h-6 bg-cyan-500 rounded-full mr-3"></span>
                            Материалы в этой категории
                        </h2>

                        <!-- Sort Dropdown -->
                        <div x-data="{ open: false }" class="relative">
                            <button @click="open = !open" @click.away="open = false"
                                class="flex items-center gap-2 px-4 py-2 bg-white dark:bg-zinc-800 border border-zinc-200 dark:border-zinc-700 rounded-lg text-sm font-medium text-zinc-700 dark:text-zinc-300 hover:border-cyan-300 dark:hover:border-cyan-700 transition-all duration-200 shadow-sm hover:shadow-md">
                                <svg class="w-4 h-4" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
                                        d="M3 4h13M3 8h9m-9 4h6m4 0l4-4m0 0l4 4m-4-4v12"></path>
                                </svg>
                                <span>
                                    @switch($sortBy ?? 'date_desc')
                                        @case('date_asc')
                                            Сначала старые
                                        @break

                                        @case('date_desc')
                                            Сначала новые
                                        @break

                                        @case('views')
                                            По популярности
                                        @break

                                        @case('title')
                                            По названию (А-Я)
                                        @break
                                    @endswitch
                                </span>
                                <svg class="w-4 h-4 transition-transform" :class="{ 'rotate-180': open }" fill="none"
                                    stroke="currentColor" viewBox="0 0 24 24">
                                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M19 9l-7 7-7-7">
                                    </path>
                                </svg>
                            </button>

                            <!-- Dropdown Menu -->
                            <div x-show="open" x-transition:enter="transition ease-out duration-200"
                                x-transition:enter-start="opacity-0 scale-95" x-transition:enter-end="opacity-100 scale-100"
                                x-transition:leave="transition ease-in duration-150"
                                x-transition:leave-start="opacity-100 scale-100" x-transition:leave-end="opacity-0 scale-95"
                                class="absolute right-0 mt-2 w-56 bg-white dark:bg-zinc-800 border border-zinc-200 dark:border-zinc-700 rounded-lg shadow-xl z-10"
                                style="display: none;">
                                <div class="py-1">
                                    <a href="{{ route('category.show', ['slug' => $category->slug, 'sort' => 'date_desc']) }}"
                                        class="flex items-center gap-3 px-4 py-2.5 text-sm text-zinc-700 dark:text-zinc-300 hover:bg-cyan-50 dark:hover:bg-cyan-950/30 transition-colors {{ ($sortBy ?? 'date_desc') === 'date_desc' ? 'bg-cyan-50 dark:bg-cyan-950/30 text-cyan-600 dark:text-cyan-400 font-medium' : '' }}">
                                        <svg class="w-4 h-4" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
                                                d="M12 8v4l3 3m6-3a9 9 0 11-18 0 9 9 0 0118 0z"></path>
                                        </svg>
                                        Сначала новые
                                    </a>
                                    <a href="{{ route('category.show', ['slug' => $category->slug, 'sort' => 'date_asc']) }}"
                                        class="flex items-center gap-3 px-4 py-2.5 text-sm text-zinc-700 dark:text-zinc-300 hover:bg-cyan-50 dark:hover:bg-cyan-950/30 transition-colors {{ ($sortBy ?? 'date_desc') === 'date_asc' ? 'bg-cyan-50 dark:bg-cyan-950/30 text-cyan-600 dark:text-cyan-400 font-medium' : '' }}">
                                        <svg class="w-4 h-4" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
                                                d="M12 8v4l3 3m6-3a9 9 0 11-18 0 9 9 0 0118 0z"></path>
                                        </svg>
                                        Сначала старые
                                    </a>
                                    <a href="{{ route('category.show', ['slug' => $category->slug, 'sort' => 'views']) }}"
                                        class="flex items-center gap-3 px-4 py-2.5 text-sm text-zinc-700 dark:text-zinc-300 hover:bg-cyan-50 dark:hover:bg-cyan-950/30 transition-colors {{ ($sortBy ?? 'date_desc') === 'views' ? 'bg-cyan-50 dark:bg-cyan-950/30 text-cyan-600 dark:text-cyan-400 font-medium' : '' }}">
                                        <svg class="w-4 h-4" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
                                                d="M15 12a3 3 0 11-6 0 3 3 0 016 0z"></path>
                                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
                                                d="M2.458 12C3.732 7.943 7.523 5 12 5c4.478 0 8.268 2.943 9.542 7-1.274 4.057-5.064 7-9.542 7-4.477 0-8.268-2.943-9.542-7z">
                                            </path>
                                        </svg>
                                        По популярности
                                    </a>
                                    <a href="{{ route('category.show', ['slug' => $category->slug, 'sort' => 'title']) }}"
                                        class="flex items-center gap-3 px-4 py-2.5 text-sm text-zinc-700 dark:text-zinc-300 hover:bg-cyan-50 dark:hover:bg-cyan-950/30 transition-colors {{ ($sortBy ?? 'date_desc') === 'title' ? 'bg-cyan-50 dark:bg-cyan-950/30 text-cyan-600 dark:text-cyan-400 font-medium' : '' }}">
                                        <svg class="w-4 h-4" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
                                                d="M3 4h13M3 8h9m-9 4h9m5-4v12m0 0l-4-4m4 4l4-4"></path>
                                        </svg>
                                        По названию (А-Я)
                                    </a>
                                </div>
                            </div>
                        </div>
                    </div>

                    <div class="grid grid-cols-1 md:grid-cols-2 lg:grid-cols-3 xl:grid-cols-4 gap-6">
                        @foreach($posts as $post)
                            <article
                                class="bg-white dark:bg-zinc-800 rounded-xl overflow-hidden border border-zinc-200 dark:border-zinc-700 shadow-sm hover:shadow-md transition-all duration-200 group flex flex-col h-full">
                                @if($post->image)
                                    <div class="aspect-[16/9] w-full overflow-hidden">
                                        <img src="{{ $post->image }}" alt="{{ $post->title }}"
                                            class="w-full h-full object-cover group-hover:scale-105 transition-transform duration-500"
                                            loading="lazy">
                                    </div>
                                @else
                                    <div class="aspect-[16/9] w-full overflow-hidden">
                                        <img src="{{ asset('images/medical_placeholder.png') }}" alt="{{ $post->title }}"
                                            class="w-full h-full object-cover group-hover:scale-105 transition-transform duration-500 opacity-80"
                                            loading="lazy">
                                    </div>
                                @endif

                                <div class="p-4 flex flex-col flex-1">
                                    <div class="flex items-center text-[11px] text-zinc-400 mb-2 gap-2 whitespace-nowrap overflow-hidden text-ellipsis">
                                        <span>{{ $post->published_at->format('d.m.Y') }}</span>
                                        <span class="w-1 h-1 bg-zinc-300 rounded-full flex-shrink-0"></span>
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