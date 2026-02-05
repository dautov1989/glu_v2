@section('seo-meta')
    <x-seo-meta 
        title="Все статьи | Glucosa"
        description="Полезные статьи о сахарном диабете, советы врачей, новости медицины и практические рекомендации для контроля уровня глюкозы."
        keywords="статьи о диабете, новости диабета, советы диабетикам, лечение диабета"
        type="website"
        :url="route('articles.index')"
    />
    
    <x-schema-org type="website" />
    
    {{-- Breadcrumb Schema --}}
    @php
        $breadcrumbItems = [
            ['name' => 'Главная', 'url' => route('home')],
            ['name' => 'Все статьи', 'url' => route('articles.index')]
        ];
    @endphp
    <x-schema-org type="breadcrumb" :data="['items' => $breadcrumbItems]" />
@endsection

@extends('components.layouts.app')

@section('title', 'Все статьи | Glucosa')
@section('meta_description', 'Полезные статьи о сахарном диабете, советы врачей, новости медицины и практические рекомендации для контроля уровня глюкозы.')

@section('content')
    <div class="min-h-screen bg-gradient-to-br from-white via-cyan-50/30 to-white dark:from-zinc-900 dark:via-cyan-950/20 dark:to-zinc-900">
        <div class="max-w-7xl mx-auto px-4 sm:px-6 lg:px-8 py-8">
            <!-- Breadcrumbs -->
            <nav class="mb-6">
                <ol class="flex items-center space-x-2 text-sm text-zinc-500 dark:text-zinc-400">
                    <li>
                        <a href="{{ route('home') }}" class="hover:text-cyan-600 dark:hover:text-cyan-400 transition-colors">
                            Главная
                        </a>
                    </li>
                    <li class="flex items-center">
                        <svg class="w-3 h-3 mx-1 text-zinc-300" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M9 5l7 7-7 7"></path>
                        </svg>
                        <span class="font-medium text-zinc-700 dark:text-zinc-300">Все статьи</span>
                    </li>
                </ol>
            </nav>

            <!-- Header -->
            <div class="mb-8 border-b border-zinc-100 dark:border-zinc-800 pb-4">
                <h1 class="text-3xl font-bold text-zinc-800 dark:text-zinc-100 mb-2">
                    Все статьи
                </h1>
                <p class="text-sm text-zinc-500 dark:text-zinc-400 max-w-4xl leading-relaxed">
                    Библиотека знаний о сахарном диабете: новости, исследования, советы по питанию и образу жизни.
                </p>
            </div>

            <!-- Posts Grid -->
            @if($posts->count() > 0)
                <div class="flex flex-col sm:flex-row sm:items-center sm:justify-between mb-6 gap-4">
                    <h2 class="text-lg font-semibold text-zinc-800 dark:text-zinc-200 flex items-center">
                        <span class="w-1 h-6 bg-cyan-500 rounded-full mr-3"></span>
                        Последние публикации
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
                                    @case('date_asc') Сначала старые @break
                                    @case('date_desc') Сначала новые @break
                                    @case('views') По популярности @break
                                    @case('title') По названию (А-Я) @break
                                @endswitch
                            </span>
                            <svg class="w-4 h-4 transition-transform" :class="{ 'rotate-180': open }" fill="none"
                                stroke="currentColor" viewBox="0 0 24 24">
                                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M19 9l-7 7-7-7"></path>
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
                                <a href="{{ route('articles.index', ['sort' => 'date_desc']) }}"
                                    class="flex items-center gap-3 px-4 py-2.5 text-sm text-zinc-700 dark:text-zinc-300 hover:bg-cyan-50 dark:hover:bg-cyan-950/30 transition-colors {{ ($sortBy ?? 'date_desc') === 'date_desc' ? 'bg-cyan-50 dark:bg-cyan-950/30 text-cyan-600 dark:text-cyan-400 font-medium' : '' }}">
                                    Сначала новые
                                </a>
                                <a href="{{ route('articles.index', ['sort' => 'date_asc']) }}"
                                    class="flex items-center gap-3 px-4 py-2.5 text-sm text-zinc-700 dark:text-zinc-300 hover:bg-cyan-50 dark:hover:bg-cyan-950/30 transition-colors {{ ($sortBy ?? 'date_desc') === 'date_asc' ? 'bg-cyan-50 dark:bg-cyan-950/30 text-cyan-600 dark:text-cyan-400 font-medium' : '' }}">
                                    Сначала старые
                                </a>
                                <a href="{{ route('articles.index', ['sort' => 'views']) }}"
                                    class="flex items-center gap-3 px-4 py-2.5 text-sm text-zinc-700 dark:text-zinc-300 hover:bg-cyan-50 dark:hover:bg-cyan-950/30 transition-colors {{ ($sortBy ?? 'date_desc') === 'views' ? 'bg-cyan-50 dark:bg-cyan-950/30 text-cyan-600 dark:text-cyan-400 font-medium' : '' }}">
                                    По популярности
                                </a>
                                <a href="{{ route('articles.index', ['sort' => 'title']) }}"
                                    class="flex items-center gap-3 px-4 py-2.5 text-sm text-zinc-700 dark:text-zinc-300 hover:bg-cyan-50 dark:hover:bg-cyan-950/30 transition-colors {{ ($sortBy ?? 'date_desc') === 'title' ? 'bg-cyan-50 dark:bg-cyan-950/30 text-cyan-600 dark:text-cyan-400 font-medium' : '' }}">
                                    По названию (А-Я)
                                </a>
                            </div>
                        </div>
                    </div>
                </div>

                <div class="grid grid-cols-1 sm:grid-cols-2 lg:grid-cols-3 xl:grid-cols-4 gap-6">
                    @foreach($posts as $post)
                        <article class="bg-white dark:bg-zinc-800 rounded-xl overflow-hidden border border-zinc-200 dark:border-zinc-700 shadow-sm hover:shadow-md transition-all duration-200 group relative flex flex-col h-full">
                            
                            {{-- Image Container --}}
                            <div class="relative overflow-hidden bg-zinc-100 dark:bg-zinc-900/50 w-full aspect-[16/9]">
                                <a href="{{ route('post.show', $post->slug) }}" class="block w-full h-full absolute inset-0">
                                    @if($post->image)
                                        <img src="{{ $post->image }}" alt="{{ $post->title }}"
                                            class="w-full h-full object-contain group-hover:scale-105 transition-transform duration-500"
                                            loading="lazy">
                                    @else
                                        <img src="{{ asset('images/medical_placeholder.png') }}" alt="{{ $post->title }}"
                                            class="w-full h-full object-contain group-hover:scale-105 transition-transform duration-500 opacity-80"
                                            loading="lazy">
                                    @endif
                                </a>
                            </div>

                            {{-- Content Container --}}
                            <div class="p-4 flex flex-col flex-1 relative">
                                {{-- Meta --}}
                                <div class="mb-2 flex items-center text-[11px] text-zinc-400 gap-2 whitespace-nowrap overflow-hidden text-ellipsis">
                                    <span>{{ $post->published_at->format('d.m.Y') }}</span>
                                    <span class="w-1 h-1 bg-zinc-300 rounded-full flex-shrink-0"></span>
                                    <span>{{ $post->views }} просмотров</span>
                                </div>

                                {{-- Title --}}
                                <h3 class="text-base font-bold text-zinc-800 dark:text-zinc-100 group-hover:text-cyan-600 dark:group-hover:text-cyan-400 transition-colors leading-tight mb-2 line-clamp-2">
                                    <a href="{{ route('post.show', $post->slug) }}">
                                        {{ $post->title }}
                                    </a>
                                </h3>

                                {{-- Excerpt --}}
                                <p class="text-sm text-zinc-500 dark:text-zinc-400 leading-relaxed line-clamp-3 flex-1 mb-4">
                                    {{ $post->excerpt }}
                                </p>

                                {{-- Footer --}}
                                <div class="border-t border-zinc-100 dark:border-zinc-700/50 flex items-center justify-between mt-auto pt-3">
                                    <a href="{{ route('post.show', $post->slug) }}"
                                        class="text-cyan-600 dark:text-cyan-400 text-xs font-semibold hover:text-cyan-700 dark:hover:text-cyan-300 flex items-center uppercase tracking-wide group/btn">
                                        Читать
                                        <svg class="w-3 h-3 ml-1 transform group-hover/btn:translate-x-1 transition-transform"
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
            @else
                <div class="text-center py-12">
                    <p class="text-zinc-500 dark:text-zinc-400">Статей пока нет.</p>
                </div>
            @endif
        </div>
    </div>
@endsection
