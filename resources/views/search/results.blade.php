<x-layouts.app title="Результаты поиска: {{ $query }}">
    <div x-data="{
        viewMode: localStorage.getItem('postsViewMode') || 'grid',
        setViewMode(mode) {
            this.viewMode = mode;
            localStorage.setItem('postsViewMode', mode);
        }
    }" x-init="
        if (window.innerWidth < 768) {
            setTimeout(() => {
                const target = document.getElementById('search-results-start');
                if (target) {
                    const yOffset = -100; // Отступ под хедер (80px) + воздух
                    const y = target.getBoundingClientRect().top + window.pageYOffset + yOffset;
                    window.scrollTo({top: y, behavior: 'smooth'});
                } else {
                    $el.scrollIntoView({ behavior: 'smooth', block: 'start' });
                }
            }, 300);
        }
    "
        class="pt-6 pb-6 sm:pb-10 bg-white dark:bg-zinc-900 rounded-2xl border border-cyan-200/50 dark:border-cyan-800/30 shadow-sm shadow-cyan-200/10 dark:shadow-cyan-950/10">
        <div class="max-w-7xl mx-auto px-4 sm:px-6 lg:px-8">
            {{-- Smart Breadcrumbs with Arrow Navigation --}}
            <div x-data="{ 
                canScrollLeft: false, 
                canScrollRight: false,
                updateScrollState() {
                    const el = this.$refs.scrollContainer;
                    if (!el) return;
                    this.canScrollLeft = el.scrollLeft > 5;
                    this.canScrollRight = el.scrollWidth > (el.clientWidth + el.scrollLeft + 5);
                },
                scroll(direction) {
                    const el = this.$refs.scrollContainer;
                    const scrollAmount = Math.min(el.clientWidth * 0.7, 300);
                    el.scrollBy({ left: direction === 'left' ? -scrollAmount : scrollAmount, behavior: 'smooth' });
                }
            }" x-init="
                $nextTick(() => {
                    updateScrollState();
                    // Повторный замер через секунду на случай ленивой отрисовки
                    setTimeout(() => updateScrollState(), 1000);
                });
                new ResizeObserver(() => updateScrollState()).observe($refs.scrollContainer);
            " @resize.window.debounce.100ms="updateScrollState()" class="relative mb-6">

                {{-- Left Arrow --}}
                <button x-show="canScrollLeft" @click="scroll('left')"
                    class="absolute left-0 top-1/2 -translate-y-1/2 z-20 p-2 bg-white dark:bg-zinc-800 shadow-xl rounded-full border-2 border-cyan-500 text-cyan-600 dark:text-cyan-400 hover:bg-cyan-50 dark:hover:bg-cyan-900/30 transition-all duration-200 sm:-ml-[23px] sm:-mt-[2px]">
                    <svg class="w-4 h-4" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M15 19l-7-7 7-7" />
                    </svg>
                </button>

                {{-- Scrollable Container --}}
                <nav x-ref="scrollContainer" @scroll.debounce.50ms="updateScrollState()"
                    class="overflow-x-auto scroll-smooth" style="scrollbar-width: none; -ms-overflow-style: none;">
                    <style>
                        [x-ref='scrollContainer']::-webkit-scrollbar {
                            display: none;
                        }
                    </style>
                    <ol class="flex items-center gap-2 min-w-max pb-1 px-1">
                        <li>
                            <a href="{{ route('home') }}"
                                class="flex items-center h-9 px-4 rounded-xl bg-white dark:bg-zinc-800 border border-cyan-200/50 dark:border-cyan-800/30 shadow-sm text-zinc-600 dark:text-zinc-400 hover:border-cyan-500 hover:text-cyan-600 dark:hover:text-cyan-400 transition-all duration-300 group">
                                <svg class="w-3.5 h-3.5 mr-2 text-zinc-400 group-hover:text-cyan-500 transition-colors"
                                    fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
                                        d="M3 12l2-2m0 0l7-7 7 7M5 10v10a1 1 0 001 1h3m10-11l2 2m-2-2v10a1 1 0 01-1 1h-3m-6 0a1 1 0 001-1v-4a1 1 0 011-1h2a1 1 0 011 1v4a1 1 0 001 1m-6 0h6" />
                                </svg>
                                <span class="text-sm font-semibold">Главная</span>
                            </a>
                        </li>
                        <li class="flex items-center">
                            <svg class="w-3.5 h-3.5 text-zinc-300 dark:text-zinc-600" fill="none" stroke="currentColor"
                                viewBox="0 0 24 24">
                                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M9 5l7 7-7 7">
                                </path>
                            </svg>
                        </li>
                        <li>
                            <div
                                class="flex items-center h-9 px-4 rounded-xl bg-cyan-50 dark:bg-cyan-950/30 border border-cyan-200/50 dark:border-cyan-800/30 text-cyan-600 dark:text-cyan-400 shadow-sm">
                                <svg class="w-3.5 h-3.5 mr-2" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
                                        d="M21 21l-6-6m2-5a7 7 0 11-14 0 7 7 0 0114 0z" />
                                </svg>
                                <span class="text-sm font-bold tracking-tight">Поиск</span>
                            </div>
                        </li>
                    </ol>
                </nav>

                {{-- Right Arrow --}}
                <button x-show="canScrollRight" @click="scroll('right')"
                    class="absolute right-0 top-1/2 -translate-y-1/2 z-20 p-2 bg-white dark:bg-zinc-800 shadow-xl rounded-full border-2 border-cyan-500 text-cyan-600 dark:text-cyan-400 hover:bg-cyan-50 dark:hover:bg-cyan-900/30 transition-all duration-200 sm:-mr-[23px] sm:-mt-[2px]">
                    <svg class="w-4 h-4" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M9 5l7 7-7 7" />
                    </svg>
                </button>
            </div>

            {{-- Compact Header Card --}}
            <div id="search-results-start"
                class="bg-white dark:bg-zinc-800 rounded-xl sm:rounded-2xl p-3 sm:p-6 border border-cyan-200/50 dark:border-cyan-800/30 shadow-sm mb-4 sm:mb-6">
                <div class="flex flex-col sm:flex-row sm:items-center justify-between gap-3 sm:gap-4">
                    <div class="space-y-0.5 sm:space-y-1">
                        <h1
                            class="text-base sm:text-2xl font-bold text-zinc-900 dark:text-zinc-100 tracking-tight leading-tight">
                            Результаты поиска: <span class="text-cyan-600 dark:text-cyan-400">"{{ $query }}"</span>
                        </h1>
                        <div class="flex items-center gap-1.5 text-xs sm:text-sm text-zinc-500 dark:text-zinc-400">
                            <svg class="w-3.5 h-3.5 text-zinc-400" fill="none" viewBox="0 0 24 24"
                                stroke="currentColor">
                                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
                                    d="M19 11H5m14 0a2 2 0 012 2v6a2 2 0 01-2 2H5a2 2 0 01-2-2v-6a2 2 0 012-2m14 0V9a2 2 0 00-2-2M5 11V9a2 2 0 012-2m0 0V5a2 2 0 012-2h6a2 2 0 012 2v2M7 7h10" />
                            </svg>
                            <span>Найдено {{ $posts->total() }}
                                {{ trans_choice('статья|статьи|статей', $posts->total()) }}</span>
                        </div>
                    </div>

                    {{-- View Mode Toggle --}}
                    <div
                        class="flex items-center bg-zinc-50 dark:bg-zinc-900/50 border border-zinc-200 dark:border-zinc-700 rounded-lg sm:rounded-xl p-0.5 sm:p-1 shadow-sm self-start sm:self-center">
                        <button @click="setViewMode('grid')"
                            :class="viewMode === 'grid' ? 'bg-white dark:bg-zinc-700 text-cyan-600 dark:text-cyan-400 shadow-sm' : 'text-zinc-500 dark:text-zinc-500 hover:text-zinc-700 dark:hover:text-zinc-300'"
                            class="flex items-center gap-1.5 px-2.5 py-1.5 sm:px-3 sm:py-1.5 rounded-md sm:rounded-lg transition-all duration-200 text-[10px] sm:text-xs font-bold uppercase tracking-wider">
                            <svg class="w-3.5 h-3.5" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
                                    d="M4 6a2 2 0 012-2h2a2 2 0 012 2v2a2 2 0 01-2 2H6a2 2 0 01-2-2V6zM14 6a2 2 0 012-2h2a2 2 0 012 2v2a2 2 0 01-2 2h-2a2 2 0 01-2-2V6zM4 16a2 2 0 012-2h2a2 2 0 012 2v2a2 2 0 01-2 2H6a2 2 0 01-2-2v-2zM14 16a2 2 0 012-2h2a2 2 0 012 2v2a2 2 0 01-2 2h-2a2 2 0 01-2-2v-2z">
                                </path>
                            </svg>
                            <span>Сетка</span>
                        </button>
                        <button @click="setViewMode('list')"
                            :class="viewMode === 'list' ? 'bg-white dark:bg-zinc-700 text-cyan-600 dark:text-cyan-400 shadow-sm' : 'text-zinc-500 dark:text-zinc-500 hover:text-zinc-700 dark:hover:text-zinc-300'"
                            class="flex items-center gap-1.5 px-2.5 py-1.5 sm:px-3 sm:py-1.5 rounded-md sm:rounded-lg transition-all duration-200 text-[10px] sm:text-xs font-bold uppercase tracking-wider">
                            <svg class="w-3.5 h-3.5" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
                                    d="M4 6h16M4 12h16M4 18h16"></path>
                            </svg>
                            <span>Список</span>
                        </button>
                    </div>
                </div>
            </div>

            @if($posts->count() > 0)
                <div class="space-y-6">
                    {{-- Grid/List layout continues here... --}}
                    @php /* The rest of the logic remains inside this x-data scope */ @endphp


                    <div :class="{ 
                                                                                    'grid grid-cols-2 sm:grid-cols-2 lg:grid-cols-3 xl:grid-cols-4 gap-3 sm:gap-6': viewMode === 'grid', 
                                                                                    'flex flex-col gap-3': viewMode === 'list' 
                                                                                }">
                        @foreach($posts as $post)
                            <article
                                :class="{ 
                                                                                                                                                            'flex flex-col h-full': viewMode === 'grid',
                                                                                                                                                            'flex flex-row items-stretch': viewMode === 'list'
                                                                                                                                                        }"
                                class="bg-white dark:bg-zinc-800 rounded-xl overflow-hidden border border-cyan-200/50 dark:border-cyan-800/30 shadow-sm hover:shadow-md transition-all duration-200 group relative">

                                {{-- Category Header (Only for Grid Mode) --}}
                                @if($post->category)
                                    <div x-show="viewMode === 'grid'"
                                        class="px-3 py-2 border-b border-cyan-100/50 dark:border-cyan-900/20 bg-zinc-50/50 dark:bg-zinc-800/30 flex justify-center">
                                        <div
                                            class="px-3 py-1 bg-white dark:bg-zinc-700 rounded-lg shadow-sm border border-cyan-100 dark:border-cyan-900/30 text-[10px] font-bold text-cyan-600 dark:text-cyan-400 uppercase tracking-wider truncate max-w-full">
                                            {{ $post->category->title }}
                                        </div>
                                    </div>
                                @endif

                                {{-- Image Container --}}
                                <div :class="{ 
                                                                                                                                                            'w-full aspect-[16/9]': viewMode === 'grid',
                                                                                                                                                            'w-36 aspect-video sm:w-64 md:w-72 flex-shrink-0': viewMode === 'list'
                                                                                                                                                        }"
                                    class="relative overflow-hidden bg-zinc-100 dark:bg-zinc-900/50">
                                    <a href="{{ route('post.show', $post->slug) }}"
                                        class="block w-full h-full absolute inset-0">
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
                                <div :class="{ 
                                                                                                                                                            'p-2 sm:p-4 sm:pb-16': viewMode === 'grid', 
                                                                                                                                                            'p-2 sm:px-4 sm:py-2 pl-3 sm:pl-4': viewMode === 'list' 
                                                                                                                                                        }"
                                    class="flex flex-col flex-1 relative min-w-0">

                                    {{-- Meta --}}
                                    <div :class="{ 'mb-2': viewMode === 'grid', 'mb-1': viewMode === 'list' }"
                                        class="flex items-center text-[10px] sm:text-[11px] text-zinc-400 gap-2 whitespace-nowrap overflow-hidden text-ellipsis">
                                        <span>{{ $post->published_at->format('d.m.Y') }}</span>
                                        <span class="w-1 h-1 bg-zinc-300 rounded-full flex-shrink-0"></span>
                                        <div class="flex items-center gap-1">
                                            <svg xmlns="http://www.w3.org/2000/svg" class="w-3 h-3" fill="none"
                                                viewBox="0 0 24 24" stroke="currentColor">
                                                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
                                                    d="M15 12a3 3 0 11-6 0 3 3 0 016 0z" />
                                                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
                                                    d="M2.458 12C3.732 7.943 7.523 5 12 5c4.478 0 8.268 2.943 9.542 7-1.274 4.057-5.064 7-9.542 7-4.477 0-8.268-2.943-9.542-7z" />
                                            </svg>
                                            <span class="mr-1">{{ $post->views }}</span>
                                        </div>
                                        @if($post->category)
                                            <span x-show="viewMode === 'list'"
                                                class="w-1 h-1 bg-zinc-300 rounded-full flex-shrink-0"></span>
                                            <span x-show="viewMode === 'list'"
                                                class="text-cyan-600 dark:text-cyan-400 font-bold uppercase truncate max-w-[100px] sm:max-w-none">
                                                {{ $post->category->title }}
                                            </span>
                                        @endif
                                    </div>

                                    {{-- Title --}}
                                    <h3 class="font-bold text-zinc-800 dark:text-zinc-100 group-hover:text-cyan-600 dark:group-hover:text-cyan-400 transition-colors leading-tight"
                                        :class="{ 
                                                                                                                                                                    'text-xs sm:text-sm mb-2 line-clamp-4': viewMode === 'grid', 
                                                                                                                                                                    'text-sm sm:text-lg mb-0 sm:mb-1 line-clamp-3 sm:line-clamp-2': viewMode === 'list' 
                                                                                                                                                                }">
                                        <a href="{{ route('post.show', $post->slug) }}">
                                            {{ $post->title }}
                                        </a>
                                    </h3>

                                    {{-- Excerpt (Hidden on Mobile) --}}
                                    <p class="text-sm text-zinc-500 dark:text-zinc-400 leading-relaxed"
                                        :class="{ 
                                                                                                                                                                   'hidden': viewMode === 'grid', 
                                                                                                                                                                   'hidden sm:block line-clamp-2 mb-0': viewMode === 'list' 
                                                                                                                                                               }">
                                        {{ $post->excerpt }}
                                    </p>

                                    {{-- Footer (Hidden on Mobile) --}}
                                    <div class="border-t border-cyan-100/50 dark:border-cyan-900/20 items-center justify-between"
                                        :class="{ 
                                                                                                                                                                    'hidden sm:flex absolute bottom-4 left-4 right-4 pt-3': viewMode === 'grid', 
                                                                                                                                                                    'hidden sm:flex mt-2 pt-2': viewMode === 'list' 
                                                                                                                                                                }">
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
            @else
                <div
                    class="text-center py-16 bg-white dark:bg-zinc-800 rounded-2xl border border-dashed border-cyan-200/50 dark:border-cyan-800/30">
                    <div
                        class="inline-flex items-center justify-center w-16 h-16 rounded-full bg-zinc-100 dark:bg-zinc-700/50 mb-4">
                        <svg xmlns="http://www.w3.org/2000/svg" fill="none" viewBox="0 0 24 24" stroke-width="1.5"
                            stroke="currentColor" class="w-8 h-8 text-zinc-400">
                            <path stroke-linecap="round" stroke-linejoin="round"
                                d="m21 21-5.197-5.197m0 0A7.5 7.5 0 1 0 5.196 5.196a7.5 7.5 0 0 0 10.607 10.607Z" />
                        </svg>
                    </div>
                    <h3 class="text-lg font-medium text-zinc-900 dark:text-zinc-100">Ничего не найдено</h3>
                    <p class="mt-2 text-zinc-500 dark:text-zinc-400 max-w-sm mx-auto">
                        К сожалению, по вашему запросу ничего не найдено. Попробуйте изменить поисковый запрос или
                        используйте навигацию по категориям.
                    </p>
                    <a href="{{ route('home') }}"
                        class="inline-flex items-center gap-2 mt-6 px-4 py-2 bg-cyan-600 hover:bg-cyan-700 text-white rounded-lg transition-colors">
                        <svg xmlns="http://www.w3.org/2000/svg" fill="none" viewBox="0 0 24 24" stroke-width="2"
                            stroke="currentColor" class="w-4 h-4">
                            <path stroke-linecap="round" stroke-linejoin="round"
                                d="m2.25 12 8.954-8.955c.44-.439 1.152-.439 1.591 0L21.75 12M4.5 9.75v10.125c0 .621.504 1.125 1.125 1.125H9.75v-4.875c0-.621.504-1.125 1.125-1.125h2.25c.621 0 1.125.504 1.125 1.125V21h4.125c.621 0 1.125-.504 1.125-1.125V9.75M8.25 21h8.25" />
                        </svg>
                        На главную
                    </a>
                </div>
            @endif
        </div>
    </div>
</x-layouts.app>