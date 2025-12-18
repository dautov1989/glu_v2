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

            <!-- Category Overview & Structure -->
            <div class="mb-8">
                <div class="bg-white dark:bg-zinc-800 rounded-2xl p-5 border border-zinc-200 dark:border-zinc-700 shadow-sm relative overflow-hidden group/card">
                    {{-- Decorative Background --}}
                    <div class="absolute top-0 right-0 w-64 h-64 bg-gradient-to-br from-cyan-50/50 to-blue-50/50 dark:from-cyan-950/20 dark:to-blue-900/20 rounded-full blur-2xl -mr-16 -mt-16 pointer-events-none opacity-0 group-hover/card:opacity-100 transition-opacity duration-700"></div>

                    {{-- Main Header (Root) --}}
                    <div class="relative z-10 flex flex-col md:flex-row md:items-start gap-4">
                        {{-- Icon --}}
                        @if(file_exists(public_path('images/placeholders/' . $category->slug . '.png')))
                            <div class="flex-shrink-0 w-16 h-16 rounded-xl flex items-center justify-center shadow-lg shadow-cyan-500/10 bg-white dark:bg-zinc-900 border border-cyan-100 dark:border-cyan-800/30">
                                <img src="{{ asset('images/placeholders/' . $category->slug . '.png') }}" alt="{{ $category->title }}" class="w-full h-full object-contain">
                            </div>
                        @else
                            <div class="flex-shrink-0 w-12 h-12 rounded-xl bg-gradient-to-br from-cyan-500 to-blue-600 flex items-center justify-center text-white shadow-lg shadow-cyan-500/20">
                                <svg xmlns="http://www.w3.org/2000/svg" class="w-6 h-6" fill="none" viewBox="0 0 24 24" stroke="currentColor">
                                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M19 11H5m14 0a2 2 0 012 2v6a2 2 0 01-2 2H5a2 2 0 01-2-2v-6a2 2 0 012-2m14 0V9a2 2 0 00-2-2M5 11V9a2 2 0 012-2m0 0V5a2 2 0 012-2h6a2 2 0 012 2v2M7 7h10" />
                                </svg>
                            </div>
                        @endif
                        
                        {{-- Content --}}
                        <div class="flex-1 min-w-0">
                            <div class="flex items-center gap-3 mb-2">
                                <h1 class="text-xl sm:text-2xl font-bold text-zinc-900 dark:text-zinc-50 tracking-tight">
                                    {{ $category->title }}
                                </h1>
                            </div>
                            
                            @if($category->description)
                                <p class="text-sm text-zinc-600 dark:text-zinc-400 max-w-4xl leading-relaxed">
                                    {{ $category->description }}
                                </p>
                            @endif
                        </div>
                    </div>

                    {{-- Subcategories Tree (If Any) --}}
                    @if($category->children->count() > 0)
                        <div class="relative z-10 mt-6 pt-6 border-t border-zinc-100 dark:border-zinc-700/50">
                            <div class="flex items-center gap-2 mb-4 text-xs font-bold text-zinc-400 dark:text-zinc-500 uppercase tracking-wider">
                                <svg class="w-3.5 h-3.5" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M4 6h16M4 12h16m-7 6h7"></path></svg>
                                Содержание раздела
                            </div>

                            <div class="relative ml-6 space-y-2">
                                {{-- Vertical Guide Line --}}
                                <div class="absolute left-0 top-0 bottom-6 w-px bg-gradient-to-b from-cyan-300/50 to-zinc-200 dark:from-cyan-700/50 dark:to-zinc-700"></div>

                                @foreach($category->children as $child)
                                    <div class="relative pl-8 group">
                                        {{-- Horizontal Connector --}}
                                        <div class="absolute left-0 top-[1.75rem] w-8 h-px bg-cyan-300/50 dark:bg-cyan-700/50">
                                            <div class="absolute right-0 top-1/2 -mt-[2px] w-1 h-1 rounded-full bg-cyan-400 dark:bg-cyan-600"></div>
                                        </div>
                                        
                                        {{-- Node Card --}}
                                        <a href="{{ route('category.show', $child->slug) }}" 
                                           class="flex flex-col md:flex-row md:items-center gap-3 p-4 rounded-xl border border-zinc-200 dark:border-zinc-700 bg-white dark:bg-zinc-800/80 hover:border-cyan-400 dark:hover:border-cyan-500 hover:shadow-md hover:-translate-y-0.5 transition-all duration-300">
                                            
                                            {{-- Icon & Titles --}}
                                            <div class="flex items-center gap-3 flex-1">
                                                <div class="w-10 h-10 rounded-lg bg-cyan-50 dark:bg-cyan-900/20 flex items-center justify-center text-cyan-600 dark:text-cyan-400 group-hover:scale-105 group-hover:bg-cyan-100 dark:group-hover:bg-cyan-800/30 transition-all duration-300">
                                                    <svg class="w-5 h-5" fill="none" viewBox="0 0 24 24" stroke="currentColor">
                                                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="1.5" d="M3 7v10a2 2 0 002 2h14a2 2 0 002-2V9a2 2 0 00-2-2h-6l-2-2H5a2 2 0 00-2 2z" />
                                                    </svg>
                                                </div>
                                                
                                                <div class="flex-1 min-w-0">
                                                    <h3 class="text-base font-bold text-zinc-900 dark:text-zinc-100 group-hover:text-cyan-600 dark:group-hover:text-cyan-400 transition-colors truncate">
                                                        {{ $child->title }}
                                                    </h3>
                                                    @if($child->description)
                                                        <p class="text-xs text-zinc-500 dark:text-zinc-400 line-clamp-1">
                                                            {{ $child->description }}
                                                        </p>
                                                    @endif
                                                </div>
                                            </div>

                                            {{-- Meta & Action --}}
                                            <div class="hidden md:flex items-center justify-end gap-4 min-w-[140px]">
                                                 <div class="text-[10px] font-semibold text-zinc-400 uppercase tracking-wide flex items-center gap-2">
                                                    @if($child->children->count() > 0)
                                                        <span class="flex items-center gap-1 bg-zinc-50 dark:bg-zinc-700/50 px-2 py-1 rounded">
                                                            {{ $child->children->count() }} разд.
                                                        </span>
                                                    @endif
                                                    <span class="flex items-center gap-1 bg-zinc-50 dark:bg-zinc-700/50 px-2 py-1 rounded">
                                                        {{ $child->posts_count ?? $child->posts->count() }} ст.
                                                    </span>
                                                 </div>
                                                 
                                                 <div class="w-6 h-6 rounded-full border border-zinc-200 dark:border-zinc-600 flex items-center justify-center text-zinc-400 group-hover:border-cyan-500 group-hover:text-cyan-500 group-hover:rotate-45 transition-all duration-300">
                                                    <svg class="w-3 h-3" fill="none" viewBox="0 0 24 24" stroke="currentColor">
                                                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M5 19L19 5M19 5H9m10 0v10" />
                                                    </svg>
                                                 </div>
                                            </div>
                                        </a>
                                    </div>
                                @endforeach
                            </div>
                        </div>
                    @endif
                </div>
            </div>

            <!-- Posts Grid -->
            @if($posts->count() > 0)
                <div x-data="{
                    viewMode: localStorage.getItem('postsViewMode') || 'grid',
                    setViewMode(mode) {
                        this.viewMode = mode;
                        localStorage.setItem('postsViewMode', mode);
                    }
                }">
                    <div class="flex flex-col sm:flex-row sm:items-center sm:justify-between mb-4 gap-4">
                        <h2 class="text-lg font-semibold text-zinc-800 dark:text-zinc-200 flex items-center">
                            <span class="w-1 h-6 bg-cyan-500 rounded-full mr-3"></span>
                            Материалы в этой категории
                        </h2>

                        <div class="flex items-center gap-3">
                            <!-- View Mode Toggle -->
                            <div class="flex items-center bg-white dark:bg-zinc-800 border border-zinc-200 dark:border-zinc-700 rounded-lg p-1 shadow-sm">
                                <button @click="setViewMode('grid')" 
                                    :class="viewMode === 'grid' ? 'bg-cyan-500 text-white' : 'text-zinc-600 dark:text-zinc-400 hover:text-zinc-800 dark:hover:text-zinc-200'"
                                    class="p-2 rounded-md transition-all duration-200"
                                    title="Карточный вид">
                                    <svg class="w-4 h-4" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M4 6a2 2 0 012-2h2a2 2 0 012 2v2a2 2 0 01-2 2H6a2 2 0 01-2-2V6zM14 6a2 2 0 012-2h2a2 2 0 012 2v2a2 2 0 01-2 2h-2a2 2 0 01-2-2V6zM4 16a2 2 0 012-2h2a2 2 0 012 2v2a2 2 0 01-2 2H6a2 2 0 01-2-2v-2zM14 16a2 2 0 012-2h2a2 2 0 012 2v2a2 2 0 01-2 2h-2a2 2 0 01-2-2v-2z"></path>
                                    </svg>
                                </button>
                                <button @click="setViewMode('list')" 
                                    :class="viewMode === 'list' ? 'bg-cyan-500 text-white' : 'text-zinc-600 dark:text-zinc-400 hover:text-zinc-800 dark:hover:text-zinc-200'"
                                    class="p-2 rounded-md transition-all duration-200"
                                    title="Списочный вид">
                                    <svg class="w-4 h-4" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M4 6h16M4 12h16M4 18h16"></path>
                                    </svg>
                                </button>
                            </div>

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
                    </div>

                    <div :class="{ 
                        'grid grid-cols-1 sm:grid-cols-2 lg:grid-cols-3 xl:grid-cols-4 gap-6': viewMode === 'grid', 
                        'flex flex-col gap-4': viewMode === 'list' 
                    }">
                        @foreach($posts as $post)
                            <article
                                :class="{ 
                                    'flex flex-col h-full': viewMode === 'grid',
                                    'flex flex-col sm:flex-row h-auto sm:items-stretch': viewMode === 'list'
                                }"
                                class="bg-white dark:bg-zinc-800 rounded-xl overflow-hidden border border-zinc-200 dark:border-zinc-700 shadow-sm hover:shadow-md transition-all duration-200 group relative">
                                
                                {{-- Image Container --}}
                                <div :class="{ 
                                    'w-full aspect-[16/9]': viewMode === 'grid',
                                    'w-full h-48 sm:w-64 md:w-72 sm:h-auto flex-shrink-0': viewMode === 'list'
                                }" class="relative overflow-hidden bg-zinc-100 dark:bg-zinc-900/50">
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
                                    <div class="flex items-center text-[11px] text-zinc-400 mb-2 gap-2 whitespace-nowrap overflow-hidden text-ellipsis">
                                        <span>{{ $post->published_at->format('d.m.Y') }}</span>
                                        <span class="w-1 h-1 bg-zinc-300 rounded-full flex-shrink-0"></span>
                                        <span>{{ $post->views }} просмотров</span>
                                    </div>

                                    {{-- Title --}}
                                    <h3 class="text-base font-bold text-zinc-800 dark:text-zinc-100 mb-2 group-hover:text-cyan-600 dark:group-hover:text-cyan-400 transition-colors leading-tight"
                                        :class="{ 'line-clamp-2': viewMode === 'grid', 'line-clamp-1 sm:line-clamp-2': viewMode === 'list' }">
                                        <a href="{{ route('post.show', $post->slug) }}">
                                            {{ $post->title }}
                                        </a>
                                    </h3>

                                    {{-- Excerpt --}}
                                    <p class="text-sm text-zinc-500 dark:text-zinc-400 mb-4 leading-relaxed"
                                       :class="{ 'line-clamp-3 flex-1': viewMode === 'grid', 'line-clamp-2 sm:line-clamp-3': viewMode === 'list' }">
                                        {{ $post->excerpt }}
                                    </p>

                                    {{-- Footer --}}
                                    <div class="pt-3 border-t border-zinc-100 dark:border-zinc-700/50 flex items-center justify-between"
                                        :class="{ 'mt-auto': viewMode === 'grid', 'mt-2': viewMode === 'list' }">
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
                </div>
            @endif

            {{-- Empty State для листовых категорий без статей --}}
            @if($posts->count() === 0 && $category->children->count() === 0)
                <div class="flex items-center justify-center py-16">
                    <div class="max-w-md w-full">
                        <div class="bg-gradient-to-br from-cyan-50 to-blue-50 dark:from-cyan-950/20 dark:to-blue-950/20 rounded-2xl p-8 border border-cyan-100 dark:border-cyan-900/30 shadow-lg">
                            {{-- Иконка --}}
                            <div class="flex justify-center mb-6">
                                <div class="relative">
                                    <div class="absolute inset-0 bg-cyan-400 dark:bg-cyan-600 rounded-full blur-xl opacity-30 animate-pulse"></div>
                                    <div class="relative bg-white dark:bg-zinc-800 rounded-full p-6 shadow-lg">
                                        <svg class="w-12 h-12 text-cyan-500 dark:text-cyan-400" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" 
                                                d="M12 6.253v13m0-13C10.832 5.477 9.246 5 7.5 5S4.168 5.477 3 6.253v13C4.168 18.477 5.754 18 7.5 18s3.332.477 4.5 1.253m0-13C13.168 5.477 14.754 5 16.5 5c1.747 0 3.332.477 4.5 1.253v13C19.832 18.477 18.247 18 16.5 18c-1.746 0-3.332.477-4.5 1.253">
                                            </path>
                                        </svg>
                                    </div>
                                </div>
                            </div>

                            {{-- Заголовок --}}
                            <h3 class="text-xl font-bold text-center text-zinc-800 dark:text-zinc-100 mb-3">
                                Скоро здесь появятся статьи
                            </h3>

                            {{-- Описание --}}
                            <p class="text-center text-sm text-zinc-600 dark:text-zinc-400 mb-6 leading-relaxed">
                                Мы активно работаем над наполнением этого раздела качественным контентом. 
                                Новые статьи появятся совсем скоро!
                            </p>

                            {{-- Призыв к действию --}}
                            <div class="flex flex-col sm:flex-row gap-3 justify-center">
                                <a href="{{ route('home') }}" 
                                    class="inline-flex items-center justify-center px-5 py-2.5 bg-cyan-500 hover:bg-cyan-600 dark:bg-cyan-600 dark:hover:bg-cyan-700 text-white text-sm font-semibold rounded-lg transition-all duration-200 shadow-md hover:shadow-lg">
                                    <svg class="w-4 h-4 mr-2" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M3 12l2-2m0 0l7-7 7 7M5 10v10a1 1 0 001 1h3m10-11l2 2m-2-2v10a1 1 0 01-1 1h-3m-6 0a1 1 0 001-1v-4a1 1 0 011-1h2a1 1 0 011 1v4a1 1 0 001 1m-6 0h6"></path>
                                    </svg>
                                    На главную
                                </a>
                                
                                <a href="{{ route('articles.index') }}" 
                                    class="inline-flex items-center justify-center px-5 py-2.5 bg-white dark:bg-zinc-800 hover:bg-zinc-50 dark:hover:bg-zinc-700 text-zinc-700 dark:text-zinc-300 text-sm font-semibold rounded-lg border border-zinc-200 dark:border-zinc-700 transition-all duration-200 shadow-sm hover:shadow-md">
                                    <svg class="w-4 h-4 mr-2" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M19 11H5m14 0a2 2 0 012 2v6a2 2 0 01-2 2H5a2 2 0 01-2-2v-6a2 2 0 012-2m14 0V9a2 2 0 00-2-2M5 11V9a2 2 0 012-2m0 0V5a2 2 0 012-2h6a2 2 0 012 2v2M7 7h10"></path>
                                    </svg>
                                    Все статьи
                                </a>
                            </div>

                            {{-- Дополнительная информация --}}
                            <div class="mt-6 pt-6 border-t border-cyan-200 dark:border-cyan-900/30">
                                <p class="text-xs text-center text-zinc-500 dark:text-zinc-500">
                                    💡 Подпишитесь на обновления, чтобы не пропустить новые материалы
                                </p>
                            </div>
                        </div>
                    </div>
                </div>
            @endif
        </div>
    </div>
@endsection