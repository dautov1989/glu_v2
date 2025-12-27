@section('seo-meta')
    <x-seo-meta 
        title="Glucosa - Всё о сахарном диабете и контроле глюкозы"
        description="Информационный портал о сахарном диабете. Полезные статьи, советы врачей, калькуляторы и практические рекомендации для контроля уровня глюкозы в крови."
        keywords="диабет, сахарный диабет, глюкоза, уровень сахара, диабет 1 типа, диабет 2 типа, контроль глюкозы"
        type="website"
    />
    <x-schema-org type="website" />
    <x-schema-org type="organization" />
@endsection

<x-layouts.app title="Home">
    <div class="p-8 space-y-8 bg-white dark:bg-zinc-900">
        
        <!-- Hero Slider Section -->
        <div class="relative" 
             x-data="{
                 currentSlide: 0,
                 slides: [
                     {
                         badge: '💙 Ваш личный помощник в управлении диабетом',
                         title: 'Живите полной жизнью',
                         subtitle: 'с диабетом!',
                         description: 'Тысячи людей уже научились контролировать сахар и наслаждаться каждым днем. Присоединяйтесь к нашему сообществу!',
                         image: 'images/slider/slide-1.png',
                         bgGradient: 'from-cyan-900/80 to-blue-900/80'
                     },
                     {
                         badge: '🎯 Знания — это сила!',
                         title: 'Узнайте всё о',
                         subtitle: 'контроле глюкозы',
                         description: 'Проверенная информация от врачей, актуальные исследования и практические советы для вашего здоровья',
                         image: 'images/slider/slide-2.png',
                         bgGradient: 'from-blue-900/80 to-purple-900/80'
                     },
                     {
                         badge: '🌟 Вместе мы сильнее!',
                         title: 'Поддержка 24/7',
                         subtitle: 'от сообщества',
                         description: 'Делитесь опытом, задавайте вопросы, находите друзей. Вы не одиноки в этом пути!',
                         image: 'images/slider/slide-3.png',
                         bgGradient: 'from-purple-900/80 to-pink-900/80'
                     }
                 ],
                 autoplay: null,
                 init() {
                     this.startAutoplay();
                 },
                 startAutoplay() {
                     this.autoplay = setInterval(() => {
                         this.next();
                     }, 5000);
                 },
                 stopAutoplay() {
                     clearInterval(this.autoplay);
                 },
                 next() {
                     this.currentSlide = (this.currentSlide + 1) % this.slides.length;
                 },
                 prev() {
                     this.currentSlide = (this.currentSlide - 1 + this.slides.length) % this.slides.length;
                 },
                 goTo(index) {
                     this.currentSlide = index;
                     this.stopAutoplay();
                     this.startAutoplay();
                 }
             }"
             @mouseenter="stopAutoplay()"
             @mouseleave="startAutoplay()">
            
            <!-- Slider Container -->
            <div class="relative overflow-hidden rounded-xl border border-cyan-200/30 dark:border-cyan-800/20 shadow-lg" style="min-height: 500px;">
                <template x-for="(slide, index) in slides" :key="index">
                    <div x-show="currentSlide === index"
                         x-transition:enter="transition ease-out duration-700 transform"
                         x-transition:enter-start="opacity-0 scale-105"
                         x-transition:enter-end="opacity-100 scale-100"
                         x-transition:leave="transition ease-in duration-700 transform absolute inset-0"
                         x-transition:leave-start="opacity-100 scale-100"
                         x-transition:leave-end="opacity-0 scale-105"
                         class="absolute inset-0 w-full h-full flex items-center justify-center text-center p-4 md:p-12 overflow-hidden">
                        
                        <!-- Background Image -->
                        <img :src="slide.image" class="absolute inset-0 w-full h-full object-cover" alt="Slider Background">
                        
                        <!-- Gradient Overlay -->
                        <div class="absolute inset-0 bg-gradient-to-br" :class="slide.bgGradient"></div>
                        
                        <!-- Content -->
                        <div class="relative z-10 max-w-3xl mx-auto space-y-4 md:space-y-6 flex flex-col items-center justify-center h-full">
                            <div class="inline-flex items-center gap-2 bg-white/20 backdrop-blur-md text-white px-3 py-1.5 md:px-4 md:py-2 rounded-full text-xs md:text-sm font-semibold border border-white/30 shadow-lg">
                                <span x-text="slide.badge"></span>
                            </div>
                            
                            <h1 class="text-3xl sm:text-4xl md:text-5xl lg:text-6xl font-bold text-white drop-shadow-lg leading-tight">
                                <span x-text="slide.title"></span>
                                <br class="hidden sm:block">
                                <span class="text-cyan-300 block sm:inline mt-1 sm:mt-0" x-text="slide.subtitle"></span>
                            </h1>
                            
                            <p class="text-sm sm:text-lg md:text-xl text-white/90 max-w-xl md:max-w-2xl mx-auto font-medium drop-shadow-md px-8 md:px-0" x-text="slide.description"></p>
                            
                            <div class="flex flex-col sm:flex-row gap-3 md:gap-4 justify-center pt-2 md:pt-6 w-full sm:w-auto px-4 sm:px-0">
                                <a href="{{ route('articles.index') }}" class="w-full sm:w-auto px-6 py-3 md:px-8 md:py-4 bg-gradient-to-r from-cyan-500 to-blue-500 hover:from-cyan-400 hover:to-blue-400 text-white font-bold rounded-xl shadow-lg shadow-cyan-500/40 hover:shadow-cyan-400/60 transition-all duration-300 hover:scale-105 active:scale-95 flex items-center justify-center gap-2 border border-white/20 text-sm md:text-base">
                                    <span>Начать изучение</span>
                                    <svg xmlns="http://www.w3.org/2000/svg" fill="none" viewBox="0 0 24 24" stroke-width="2" stroke="currentColor" class="w-4 h-4 md:w-5 md:h-5">
                                        <path stroke-linecap="round" stroke-linejoin="round" d="M13.5 4.5 21 12m0 0-7.5 7.5M21 12H3" />
                                    </svg>
                                </a>
                                <a href="{{ route('home') }}" class="w-full sm:w-auto px-6 py-3 md:px-8 md:py-4 bg-white/10 hover:bg-white/20 backdrop-blur-md text-white font-bold rounded-xl border border-white/30 hover:border-white/50 shadow-lg transition-all duration-300 hover:scale-105 flex items-center justify-center gap-2 text-sm md:text-base">
                                    <svg xmlns="http://www.w3.org/2000/svg" fill="none" viewBox="0 0 24 24" stroke-width="2" stroke="currentColor" class="w-4 h-4 md:w-5 md:h-5">
                                        <path stroke-linecap="round" stroke-linejoin="round" d="M12 6.042A8.967 8.967 0 0 0 6 3.75c-1.052 0-2.062.18-3 .512v14.25A8.987 8.987 0 0 1 6 18c2.305 0 4.408.867 6 2.292m0-14.25a8.966 8.966 0 0 1 6-2.292c1.052 0 2.062.18 3 .512v14.25A8.987 8.987 0 0 0 18 18a8.967 8.967 0 0 0-6 2.292m0-14.25v14.25" />
                                    </svg>
                                    <span>О проекте</span>
                                </a>
                            </div>
                        </div>
                    </div>
                </template>
                
                <!-- Navigation Arrows -->
                <button @click="prev()" class="absolute left-2 md:left-4 top-1/2 -translate-y-1/2 w-8 h-8 md:w-10 md:h-10 bg-white/40 md:bg-white/80 dark:bg-zinc-800/40 dark:md:bg-zinc-800/80 hover:bg-white md:hover:bg-white dark:hover:bg-zinc-800 rounded-full flex items-center justify-center text-white md:text-zinc-700 dark:md:text-zinc-300 shadow-lg backdrop-blur-sm transition-all duration-300 hover:scale-110 z-20">
                    <svg xmlns="http://www.w3.org/2000/svg" fill="none" viewBox="0 0 24 24" stroke-width="2" stroke="currentColor" class="w-4 h-4 md:w-5 md:h-5">
                        <path stroke-linecap="round" stroke-linejoin="round" d="M15.75 19.5 8.25 12l7.5-7.5" />
                    </svg>
                </button>
                <button @click="next()" class="absolute right-2 md:right-4 top-1/2 -translate-y-1/2 w-8 h-8 md:w-10 md:h-10 bg-white/40 md:bg-white/80 dark:bg-zinc-800/40 dark:md:bg-zinc-800/80 hover:bg-white md:hover:bg-white dark:hover:bg-zinc-800 rounded-full flex items-center justify-center text-white md:text-zinc-700 dark:md:text-zinc-300 shadow-lg backdrop-blur-sm transition-all duration-300 hover:scale-110 z-20">
                    <svg xmlns="http://www.w3.org/2000/svg" fill="none" viewBox="0 0 24 24" stroke-width="2" stroke="currentColor" class="w-4 h-4 md:w-5 md:h-5">
                        <path stroke-linecap="round" stroke-linejoin="round" d="m8.25 4.5 7.5 7.5-7.5 7.5" />
                    </svg>
                </button>
                

            </div>
        </div>

        <!-- Stats Section -->
        <div class="grid grid-cols-1 md:grid-cols-3 gap-6">
            @foreach([
                ['icon' => '📚', 'number' => $articlesCount, 'label' => 'Статей'],
                ['icon' => '👥', 'number' => $usersCount >= 1000 ? $usersCount : '1000+', 'label' => 'Пользователей'],
                ['icon' => '⭐', 'number' => '1000+', 'label' => 'Историй успеха']
            ] as $stat)
                <div class="bg-white dark:bg-zinc-900 rounded-xl border border-cyan-200/30 dark:border-cyan-800/20 p-6 text-center shadow-md hover:shadow-lg transition-all duration-300 hover:scale-105">
                    <div class="text-5xl mb-3">{{ $stat['icon'] }}</div>
                    <div class="text-3xl font-bold bg-gradient-to-r from-cyan-600 to-blue-600 dark:from-cyan-400 dark:to-blue-400 bg-clip-text text-transparent mb-1">
                        {{ $stat['number'] }}
                    </div>
                    <div class="text-sm text-zinc-600 dark:text-zinc-400 font-medium">{{ $stat['label'] }}</div>
                </div>
            @endforeach
        </div>

        <!-- Features Section -->
        <div class="grid grid-cols-1 md:grid-cols-2 gap-6">
            @foreach([
                ['image' => 'simptomy.png', 'title' => 'Симптомы', 'desc' => 'Распознавание и понимание признаков', 'slug' => 'simptomy'],
                ['image' => 'pitanie.png', 'title' => 'Рецепты и питание', 'desc' => 'Вкусные и полезные рецепты', 'slug' => 'pitanie'],
                ['image' => 'sport.png', 'title' => 'Спорт и активность', 'desc' => 'Программы тренировок и советы', 'slug' => 'sport'],
                ['image' => 'diabet-1-tipa.png', 'title' => 'Диабет 1 типа', 'desc' => 'Инсулинотерапия и управление', 'slug' => 'diabet-1-tipa'],
                ['image' => 'diabet-2-tipa.png', 'title' => 'Диабет 2 типа', 'desc' => 'Медикаменты и контроль веса', 'slug' => 'diabet-2-tipa'],
                ['image' => 'gadzety-i-rasxodniki.png', 'title' => 'Гаджеты и Расходники', 'desc' => 'Современные устройства и аксессуары', 'slug' => 'gadzety-i-rasxodniki']
            ] as $feature)
                <a href="{{ route('category.show', $feature['slug']) }}" class="block bg-white dark:bg-zinc-900 rounded-xl border border-cyan-200/30 dark:border-cyan-800/20 overflow-hidden shadow-md hover:shadow-xl hover:border-cyan-400/50 dark:hover:border-cyan-600/50 transition-all duration-300 hover:scale-[1.02] group">
                    <div class="flex items-center gap-0">
                        <!-- Wide Image Container for 16:9 -->
                        <div class="w-40 flex-shrink-0 overflow-hidden bg-gradient-to-br from-cyan-50 to-blue-50 dark:from-cyan-900/20 dark:to-blue-900/20 relative" style="aspect-ratio: 16/9;">
                            <img src="{{ asset('images/placeholders/' . $feature['image']) }}" alt="{{ $feature['title'] }}" class="w-full h-full object-contain group-hover:scale-110 transition-transform duration-500 p-2">
                        </div>
                        <!-- Text Content -->
                        <div class="flex-1 p-5 flex items-center justify-between gap-3">
                            <div class="flex-1">
                                <h3 class="text-sm md:text-base font-bold text-zinc-800 dark:text-zinc-200 mb-1.5 group-hover:text-cyan-600 dark:group-hover:text-cyan-400 transition-colors line-clamp-1">
                                    {{ $feature['title'] }}
                                </h3>
                                <p class="text-xs md:text-sm text-zinc-600 dark:text-zinc-400 line-clamp-1">
                                    {{ $feature['desc'] }}
                                </p>
                            </div>
                            <!-- Arrow Icon -->
                            <svg xmlns="http://www.w3.org/2000/svg" fill="none" viewBox="0 0 24 24" stroke-width="2" stroke="currentColor" class="w-5 h-5 flex-shrink-0 text-zinc-300 group-hover:text-cyan-500 dark:group-hover:text-cyan-400 transition-all duration-300 group-hover:translate-x-1">
                                <path stroke-linecap="round" stroke-linejoin="round" d="m8.25 4.5 7.5 7.5-7.5 7.5" />
                            </svg>
                        </div>
                    </div>
                </a>
            @endforeach
        </div>

        <!-- Latest Articles Section -->
        @if($latestPosts->count() > 0)
        <div class="mt-12">
            <div class="flex items-center justify-between mb-6">
                <div>
                    <h2 class="text-2xl md:text-3xl font-bold text-zinc-800 dark:text-zinc-100 mb-2">
                        📰 Последние статьи
                    </h2>
                    <p class="text-sm text-zinc-600 dark:text-zinc-400">
                        Свежие материалы и актуальная информация о диабете
                    </p>
                </div>
                <a href="{{ route('articles.index') }}" class="hidden md:flex items-center gap-2 px-6 py-3 bg-gradient-to-r from-cyan-500 to-blue-500 hover:from-cyan-600 hover:to-blue-600 text-white font-semibold rounded-xl shadow-lg shadow-cyan-500/30 hover:shadow-cyan-500/40 transition-all duration-300 hover:scale-105">
                    <span>Все статьи</span>
                    <svg xmlns="http://www.w3.org/2000/svg" fill="none" viewBox="0 0 24 24" stroke-width="2" stroke="currentColor" class="w-5 h-5">
                        <path stroke-linecap="round" stroke-linejoin="round" d="m8.25 4.5 7.5 7.5-7.5 7.5" />
                    </svg>
                </a>
            </div>

            <div class="grid grid-cols-1 md:grid-cols-2 lg:grid-cols-3 xl:grid-cols-4 gap-6">
                @foreach($latestPosts as $post)
                <a href="{{ route('post.show', $post->slug) }}" class="group block bg-white dark:bg-zinc-900 rounded-xl border border-cyan-200/30 dark:border-cyan-800/20 overflow-hidden shadow-md hover:shadow-xl hover:border-cyan-400/50 dark:hover:border-cyan-600/50 transition-all duration-300 hover:scale-105 flex flex-col h-full relative">
                    <!-- Category Header (Top Center) -->
                    <div class="px-3 py-1.5 border-b border-zinc-100 dark:border-zinc-800 bg-zinc-50/50 dark:bg-zinc-800/30">
                        <div class="text-[10px] font-bold uppercase tracking-wider text-center text-cyan-600 dark:text-cyan-400 truncate">
                            {{ $post->category->title }}
                        </div>
                    </div>

                    <!-- Post Image -->
                    <div class="relative w-full overflow-hidden bg-white dark:bg-zinc-800/50" style="aspect-ratio: 16/9;">
                        @if($post->image)
                            <img src="{{ $post->image }}" alt="{{ $post->title }}" class="w-full h-full object-contain group-hover:scale-110 transition-transform duration-300">
                        @else
                            <img src="{{ asset('images/medical_placeholder.png') }}" alt="{{ $post->title }}" class="w-full h-full object-contain group-hover:scale-110 transition-transform duration-300 opacity-80">
                        @endif
                    </div>

                    <!-- Post Content -->
                    <div class="p-4 pb-14 flex-1">
                        <h3 class="text-sm font-bold text-zinc-800 dark:text-zinc-200 mb-0 leading-tight line-clamp-4 group-hover:text-cyan-600 dark:group-hover:text-cyan-400 transition-colors">
                            {{ $post->title }}
                        </h3>

                        <div class="absolute bottom-4 left-4 right-4 flex items-center justify-between text-[11px] text-zinc-400 border-t border-zinc-100 dark:border-zinc-800 pt-3">
                            <div class="flex items-center gap-1.5">
                                <span>{{ $post->published_at->format('d.m.Y') }}</span>
                            </div>
                            <div class="flex items-center gap-1">
                                <svg xmlns="http://www.w3.org/2000/svg" fill="none" viewBox="0 0 24 24" stroke-width="2" stroke="currentColor" class="w-3.5 h-3.5">
                                    <path stroke-linecap="round" stroke-linejoin="round" d="M2.036 12.322a1.012 1.012 0 0 1 0-.639C3.423 7.51 7.36 4.5 12 4.5c4.638 0 8.573 3.007 9.963 7.178.07.207.07.431 0 .639C20.577 16.49 16.64 19.5 12 19.5c-4.638 0-8.573-3.007-9.963-7.178Z" />
                                    <path stroke-linecap="round" stroke-linejoin="round" d="M15 12a3 3 0 1 1-6 0 3 3 0 0 1 6 0Z" />
                                </svg>
                                <span>{{ $post->views }}</span>
                            </div>
                        </div>
                    </div>
                </a>
                @endforeach
            </div>

            <!-- Mobile "All Articles" Button -->
            <div class="mt-6 md:hidden">
                <a href="{{ route('articles.index') }}" class="flex items-center justify-center gap-2 w-full px-6 py-3 bg-gradient-to-r from-cyan-500 to-blue-500 hover:from-cyan-600 hover:to-blue-600 text-white font-semibold rounded-xl shadow-lg shadow-cyan-500/30 hover:shadow-cyan-500/40 transition-all duration-300">
                    <span>Все статьи</span>
                    <svg xmlns="http://www.w3.org/2000/svg" fill="none" viewBox="0 0 24 24" stroke-width="2" stroke="currentColor" class="w-5 h-5">
                        <path stroke-linecap="round" stroke-linejoin="round" d="m8.25 4.5 7.5 7.5-7.5 7.5" />
                    </svg>
                </a>
            </div>
        </div>
        @endif

    </div>
</x-layouts.app>
