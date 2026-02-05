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
@section('meta_description', $category->meta_description)

@section('content')
    <div class="min-h-screen bg-white dark:bg-zinc-900 rounded-2xl border border-cyan-200/50 dark:border-cyan-800/30 shadow-sm shadow-cyan-200/10 dark:shadow-cyan-950/10 scroll-mt-24 pt-6">
        <div class="max-w-7xl mx-auto px-4 sm:px-6 lg:px-8 pb-6">
            {{-- Smart Breadcrumbs with Arrow Navigation --}}
            <div x-data="{ 
                canScrollLeft: false, 
                canScrollRight: false,
                updateScrollState() {
                    const el = this.$refs.scrollContainer;
                    if (!el) return;
                    this.canScrollLeft = el.scrollLeft > 2;
                    this.canScrollRight = el.scrollWidth > (el.clientWidth + el.scrollLeft + 2);
                },
                scroll(direction) {
                    const el = this.$refs.scrollContainer;
                    const scrollAmount = Math.min(el.clientWidth * 0.8, 300);
                    el.scrollBy({ left: direction === 'left' ? -scrollAmount : scrollAmount, behavior: 'smooth' });
                }
            }" x-init="
                $nextTick(() => updateScrollState());
                new ResizeObserver(() => updateScrollState()).observe($refs.scrollContainer);
            " @resize.window.debounce.100ms="updateScrollState()" class="relative group mb-6">
                
                {{-- Left Arrow --}}
                <button x-show="canScrollLeft" x-cloak x-transition.opacity @click="scroll('left')" 
                    class="absolute left-0 top-1/2 -translate-y-1/2 z-20 p-2 bg-white dark:bg-zinc-800 shadow-xl rounded-full border-2 border-cyan-500 text-cyan-600 dark:text-cyan-400 hover:bg-cyan-50 dark:hover:bg-cyan-900/30 transition-all duration-200 sm:-ml-[23px] sm:-mt-[2px]">
                    <svg class="w-4 h-4" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M15 19l-7-7 7-7"/></svg>
                </button>

                {{-- Scrollable Container --}}
                <nav x-ref="scrollContainer" @scroll.debounce.50ms="updateScrollState()" 
                    class="overflow-x-auto scroll-smooth"
                    style="scrollbar-width: none; -ms-overflow-style: none;">
                    <style>
                        [x-ref='scrollContainer']::-webkit-scrollbar { display: none; }
                    </style>
                    <ol class="flex items-center gap-2 min-w-max pb-1 px-1">
                        <li>
                            <a href="{{ route('home') }}"
                                class="flex items-center h-9 px-4 rounded-xl bg-white dark:bg-zinc-800 border border-cyan-200/50 dark:border-cyan-800/30 shadow-sm text-zinc-600 dark:text-zinc-400 hover:border-cyan-500 hover:text-cyan-600 dark:hover:text-cyan-400 transition-all duration-300 group">
                                <svg class="w-3.5 h-3.5 mr-2 text-zinc-400 group-hover:text-cyan-500 transition-colors" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M3 12l2-2m0 0l7-7 7 7M5 10v10a1 1 0 001 1h3m10-11l2 2m-2-2v10a1 1 0 01-1 1h-3m-6 0a1 1 0 001-1v-4a1 1 0 011-1h2a1 1 0 011 1v4a1 1 0 001 1m-6 0h6"/>
                                </svg>
                                <span class="text-sm font-semibold">Главная</span>
                            </a>
                        </li>
                        @foreach($category->getBreadcrumbs() as $breadcrumb)
                            <li class="flex items-center">
                                <svg class="w-3.5 h-3.5 text-zinc-300 dark:text-zinc-600" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M9 5l7 7-7 7"></path>
                                </svg>
                            </li>
                            <li>
                                @if(!$loop->last)
                                    <a href="{{ route('category.show', $breadcrumb->slug) }}"
                                        class="flex items-center h-9 px-4 rounded-xl bg-white dark:bg-zinc-800 border border-cyan-200/50 dark:border-cyan-800/30 shadow-sm text-zinc-600 dark:text-zinc-400 hover:border-cyan-500 hover:text-cyan-600 dark:hover:text-cyan-400 transition-all duration-300 group">
                                        <span class="text-sm font-semibold">{{ $breadcrumb->title }}</span>
                                    </a>
                                @else
                                    <div class="flex items-center h-9 px-4 rounded-xl bg-cyan-50 dark:bg-cyan-950/30 border border-cyan-200/50 dark:border-cyan-800/30 text-cyan-600 dark:text-cyan-400 shadow-sm">
                                        <span class="text-sm font-bold tracking-tight">{{ $breadcrumb->title }}</span>
                                    </div>
                                @endif
                            </li>
                        @endforeach
                    </ol>
                </nav>

                {{-- Right Arrow --}}
                <button x-show="canScrollRight" x-cloak x-transition.opacity @click="scroll('right')" 
                    class="absolute right-0 top-1/2 -translate-y-1/2 z-20 p-2 bg-white dark:bg-zinc-800 shadow-xl rounded-full border-2 border-cyan-500 text-cyan-600 dark:text-cyan-400 hover:bg-cyan-50 dark:hover:bg-cyan-900/30 transition-all duration-200 sm:-mr-[23px] sm:-mt-[2px]">
                    <svg class="w-4 h-4" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M9 5l7 7-7 7"/></svg>
                </button>
            </div>

            <!-- Category Overview & Structure -->
            <div class="mb-8">
                <div class="bg-white dark:bg-zinc-800 rounded-2xl p-5 border border-cyan-200/50 dark:border-cyan-800/30 shadow-sm relative overflow-hidden group/card">
                    {{-- Decorative Background --}}
                    <div class="absolute top-0 right-0 w-64 h-64 bg-gradient-to-br from-cyan-50/50 to-blue-50/50 dark:from-cyan-950/20 dark:to-blue-900/20 rounded-full blur-2xl -mr-16 -mt-16 pointer-events-none opacity-0 group-hover/card:opacity-100 transition-opacity duration-700"></div>

                    {{-- Main Header (Root) --}}
                    <div class="relative z-10 flex items-start gap-4 md:gap-6">
                        {{-- Image Container (Left) - Hidden on Mobile --}}
                        <div class="hidden md:flex shrink-0 w-20 h-20 md:w-28 md:h-28 rounded-xl bg-gradient-to-br from-cyan-50 to-blue-50 dark:from-cyan-900/20 dark:to-blue-900/20 border border-cyan-100 dark:border-cyan-800/30 items-center justify-center p-2">
                            @if(file_exists(public_path('images/placeholders/' . $category->slug . '.png')))
                                <img src="{{ asset('images/placeholders/' . $category->slug . '.png') }}" alt="{{ $category->title }}" class="w-full h-full object-contain">
                            @else
                                <svg xmlns="http://www.w3.org/2000/svg" class="w-10 h-10 md:w-14 md:h-14 text-cyan-600 dark:text-cyan-400" fill="none" viewBox="0 0 24 24" stroke="currentColor">
                                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="1.5" d="M19 11H5m14 0a2 2 0 012 2v6a2 2 0 01-2 2H5a2 2 0 01-2-2v-6a2 2 0 012-2m14 0V9a2 2 0 00-2-2M5 11V9a2 2 0 012-2m0 0V5a2 2 0 012-2h6a2 2 0 012 2v2M7 7h10" />
                                </svg>
                            @endif
                        </div>
                        
                        {{-- Content (Right) --}}
                        <div class="flex-1 min-w-0 pt-1">
                            <h1 class="text-xl md:text-2xl font-bold text-zinc-900 dark:text-zinc-50 tracking-tight mb-2">
                                {{ $category->title }}
                            </h1>
                            
                            @if($category->description)
                                <p class="text-sm text-zinc-600 dark:text-zinc-400 leading-relaxed">
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

                            <div class="relative md:ml-6 space-y-2">
                                {{-- Vertical Guide Line (Desktop Only) --}}
                                <div class="hidden md:block absolute left-0 top-0 bottom-6 w-px bg-gradient-to-b from-cyan-300/50 to-zinc-200 dark:from-cyan-700/50 dark:to-zinc-700"></div>

                                @foreach($category->children as $child)
                                    <div class="relative md:pl-8 group">
                                        {{-- Horizontal Connector (Desktop Only) --}}
                                        <div class="hidden md:block absolute left-0 top-[1.75rem] w-8 h-px bg-cyan-300/50 dark:bg-cyan-700/50">
                                            <div class="absolute right-0 top-1/2 -mt-[2px] w-1 h-1 rounded-full bg-cyan-400 dark:bg-cyan-600"></div>
                                        </div>
                                        
                                        {{-- Node Card --}}
                                        <a href="{{ route('category.show', $child->slug) }}" 
                                           class="flex flex-col md:flex-row md:items-center gap-3 p-3 md:p-4 rounded-xl border border-cyan-200/50 dark:border-cyan-800/30 bg-white dark:bg-zinc-800/80 hover:border-cyan-400 dark:hover:border-cyan-500 hover:shadow-md hover:-translate-y-0.5 transition-all duration-300">
                                            
                                            {{-- Icon & Titles --}}
                                            <div class="flex items-center gap-3 flex-1 min-w-0">
                                                <div class="w-10 h-10 flex-shrink-0 rounded-lg bg-cyan-50 dark:bg-cyan-900/20 flex items-center justify-center text-cyan-600 dark:text-cyan-400 group-hover:scale-105 group-hover:bg-cyan-100 dark:group-hover:bg-cyan-800/30 transition-all duration-300">
                                                    <svg class="w-5 h-5" fill="none" viewBox="0 0 24 24" stroke="currentColor">
                                                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="1.5" d="M3 7v10a2 2 0 002 2h14a2 2 0 002-2V9a2 2 0 00-2-2h-6l-2-2H5a2 2 0 00-2 2z" />
                                                    </svg>
                                                </div>
                                                
                                                <div class="flex-1 min-w-0">
                                                    <h3 class="text-sm md:text-base font-bold text-zinc-900 dark:text-zinc-100 group-hover:text-cyan-600 dark:group-hover:text-cyan-400 transition-colors truncate md:line-clamp-1">
                                                        {{ $child->title }}
                                                    </h3>
                                                    @if($child->description)
                                                        <p class="hidden md:block text-xs text-zinc-500 dark:text-zinc-400 line-clamp-1 mt-1">
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
                <div class="mb-8" x-data="bentoLoader('{{ $posts->nextPageUrl() }}')">
                    <h2 id="materials-start" class="text-xl md:text-2xl font-bold text-zinc-800 dark:text-zinc-100 flex items-center mb-6">
                        <span class="w-1.5 h-8 bg-gradient-to-b from-cyan-400 to-blue-600 rounded-full mr-3 shadow-lg shadow-cyan-500/30"></span>
                        Материалы в этой категории
                        <span class="ml-3 px-3 py-1 text-sm font-medium text-cyan-600 dark:text-cyan-400 bg-cyan-50 dark:bg-cyan-900/20 border border-cyan-100 dark:border-cyan-800 rounded-full">
                            {{ $posts->total() }}
                        </span>
                    </h2>

                    {{-- Bento Grid --}}
                    <x-bento-grid :bentoData="$bentoData" />

                    {{-- Load More Button --}}
                    <div class="mt-12 flex justify-center" x-show="nextPageUrl" x-cloak>
                        <button @click="loadMore" :disabled="isLoading" 
                            class="group relative inline-flex items-center justify-center px-8 py-3 bg-white dark:bg-zinc-800 border border-cyan-200 dark:border-cyan-800 rounded-full shadow-lg shadow-cyan-500/10 hover:shadow-cyan-500/20 hover:border-cyan-400 dark:hover:border-cyan-600 transition-all duration-300 disabled:opacity-70 disabled:cursor-not-allowed overflow-hidden">
                            
                            {{-- Hover effect bg --}}
                            <div class="absolute inset-0 bg-cyan-50 dark:bg-cyan-900/20 translate-y-full group-hover:translate-y-0 transition-transform duration-300"></div>
                            
                            <span class="relative flex items-center gap-3 text-zinc-700 dark:text-zinc-200 group-hover:text-cyan-700 dark:group-hover:text-cyan-300 font-medium">
                                <span x-text="isLoading ? 'Загрузка...' : 'Показать ещё'">Показать ещё</span>
                                <svg x-show="!isLoading" class="w-4 h-4 transform group-hover:translate-y-1 transition-transform" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M19 9l-7 7-7-7"></path>
                                </svg>
                                <svg x-show="isLoading" class="w-4 h-4 animate-spin" fill="none" viewBox="0 0 24 24">
                                    <circle class="opacity-25" cx="12" cy="12" r="10" stroke="currentColor" stroke-width="4"></circle>
                                    <path class="opacity-75" fill="currentColor" d="M4 12a8 8 0 018-8V0C5.373 0 0 5.373 0 12h4zm2 5.291A7.962 7.962 0 014 12H0c0 3.042 1.135 5.824 3 7.938l3-2.647z"></path>
                                </svg>
                            </span>
                        </button>
                    </div>

                    <script>
                        document.addEventListener('alpine:init', () => {
                            Alpine.data('bentoLoader', (initialUrl) => ({
                                nextPageUrl: initialUrl,
                                isLoading: false,

                                async loadMore() {
                                    if (!this.nextPageUrl || this.isLoading) return;

                                    this.isLoading = true;
                                    try {
                                        const response = await fetch(this.nextPageUrl, {
                                            headers: {
                                                'X-Requested-With': 'XMLHttpRequest',
                                                'Accept': 'application/json'
                                            }
                                        });

                                        if (!response.ok) throw new Error('Network response was not ok');

                                        const data = await response.json();

                                        // Добавляем HTML в десктопный контейнер
                                        if (data.desktop && this.$refs.desktopGrid) {
                                            this.$refs.desktopGrid.insertAdjacentHTML('beforeend', data.desktop);
                                        }

                                        // Добавляем HTML в мобильный контейнер
                                        if (data.mobile && this.$refs.mobileGrid) {
                                            this.$refs.mobileGrid.insertAdjacentHTML('beforeend', data.mobile);
                                        }

                                        this.nextPageUrl = data.nextPageUrl;

                                    } catch (error) {
                                        console.error('Ошибка при загрузке статей:', error);
                                    } finally {
                                        this.isLoading = false;
                                    }
                                }
                            }));
                        });
                    </script>
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