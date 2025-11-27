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
                         class="absolute inset-0 w-full h-full flex items-center justify-center text-center p-12 overflow-hidden">
                        
                        <!-- Background Image -->
                        <img :src="slide.image" class="absolute inset-0 w-full h-full object-cover" alt="Slider Background">
                        
                        <!-- Gradient Overlay -->
                        <div class="absolute inset-0 bg-gradient-to-br" :class="slide.bgGradient"></div>
                        
                        <!-- Content -->
                        <div class="relative z-10 max-w-3xl mx-auto space-y-6">
                            <div class="inline-flex items-center gap-2 bg-white/20 backdrop-blur-md text-white px-4 py-2 rounded-full text-sm font-semibold border border-white/30 shadow-lg">
                                <span x-text="slide.badge"></span>
                            </div>
                            
                            <h1 class="text-5xl md:text-7xl font-bold text-white drop-shadow-lg">
                                <span x-text="slide.title"></span>
                                <br>
                                <span class="text-cyan-300" x-text="slide.subtitle"></span>
                            </h1>
                            
                            <p class="text-xl text-white/90 max-w-2xl mx-auto font-medium drop-shadow-md" x-text="slide.description"></p>
                            
                            <div class="flex flex-wrap gap-4 justify-center pt-6">
                                <button class="px-8 py-4 bg-gradient-to-r from-cyan-500 to-blue-500 hover:from-cyan-400 hover:to-blue-400 text-white font-bold rounded-xl shadow-lg shadow-cyan-500/40 hover:shadow-cyan-400/60 transition-all duration-300 hover:scale-105 active:scale-95 flex items-center gap-2 border border-white/20">
                                    <span>Начать изучение</span>
                                    <svg xmlns="http://www.w3.org/2000/svg" fill="none" viewBox="0 0 24 24" stroke-width="2" stroke="currentColor" class="w-5 h-5">
                                        <path stroke-linecap="round" stroke-linejoin="round" d="M13.5 4.5 21 12m0 0-7.5 7.5M21 12H3" />
                                    </svg>
                                </button>
                                <button class="px-8 py-4 bg-white/10 hover:bg-white/20 backdrop-blur-md text-white font-bold rounded-xl border border-white/30 hover:border-white/50 shadow-lg transition-all duration-300 hover:scale-105 flex items-center gap-2">
                                    <svg xmlns="http://www.w3.org/2000/svg" fill="none" viewBox="0 0 24 24" stroke-width="2" stroke="currentColor" class="w-5 h-5">
                                        <path stroke-linecap="round" stroke-linejoin="round" d="M12 6.042A8.967 8.967 0 0 0 6 3.75c-1.052 0-2.062.18-3 .512v14.25A8.987 8.987 0 0 1 6 18c2.305 0 4.408.867 6 2.292m0-14.25a8.966 8.966 0 0 1 6-2.292c1.052 0 2.062.18 3 .512v14.25A8.987 8.987 0 0 0 18 18a8.967 8.967 0 0 0-6 2.292m0-14.25v14.25" />
                                    </svg>
                                    <span>О проекте</span>
                                </button>
                            </div>
                        </div>
                    </div>
                </template>
                
                <!-- Navigation Arrows -->
                <button @click="prev()" class="absolute left-4 top-1/2 -translate-y-1/2 w-10 h-10 bg-white/80 dark:bg-zinc-800/80 hover:bg-white dark:hover:bg-zinc-800 rounded-full flex items-center justify-center text-zinc-700 dark:text-zinc-300 shadow-lg backdrop-blur-sm transition-all duration-300 hover:scale-110 z-10">
                    <svg xmlns="http://www.w3.org/2000/svg" fill="none" viewBox="0 0 24 24" stroke-width="2" stroke="currentColor" class="w-5 h-5">
                        <path stroke-linecap="round" stroke-linejoin="round" d="M15.75 19.5 8.25 12l7.5-7.5" />
                    </svg>
                </button>
                <button @click="next()" class="absolute right-4 top-1/2 -translate-y-1/2 w-10 h-10 bg-white/80 dark:bg-zinc-800/80 hover:bg-white dark:hover:bg-zinc-800 rounded-full flex items-center justify-center text-zinc-700 dark:text-zinc-300 shadow-lg backdrop-blur-sm transition-all duration-300 hover:scale-110 z-10">
                    <svg xmlns="http://www.w3.org/2000/svg" fill="none" viewBox="0 0 24 24" stroke-width="2" stroke="currentColor" class="w-5 h-5">
                        <path stroke-linecap="round" stroke-linejoin="round" d="m8.25 4.5 7.5 7.5-7.5 7.5" />
                    </svg>
                </button>
                
                <!-- Dots Navigation -->
                <div class="absolute bottom-6 left-1/2 -translate-x-1/2 flex gap-2 z-10">
                    <template x-for="(slide, index) in slides" :key="index">
                        <button @click="goTo(index)" 
                                class="w-2 h-2 rounded-full transition-all duration-300"
                                :class="currentSlide === index ? 'bg-cyan-500 w-8' : 'bg-zinc-400 hover:bg-cyan-400'">
                        </button>
                    </template>
                </div>
            </div>
        </div>

        <!-- Stats Section -->
        <div class="grid grid-cols-1 md:grid-cols-3 gap-6">
            @foreach([
                ['icon' => '📚', 'number' => '500+', 'label' => 'Статей'],
                ['icon' => '👥', 'number' => '10K+', 'label' => 'Пользователей'],
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
                ['icon' => '🩺', 'title' => 'Медицинская информация', 'desc' => 'Проверенные данные от специалистов'],
                ['icon' => '🥗', 'title' => 'Рецепты и питание', 'desc' => 'Вкусные и полезные рецепты'],
                ['icon' => '🏃', 'title' => 'Спорт и активность', 'desc' => 'Программы тренировок и советы'],
                ['icon' => '💊', 'title' => 'Лекарства и терапия', 'desc' => 'Информация о препаратах']
            ] as $feature)
                <div class="bg-white dark:bg-zinc-900 rounded-xl border border-cyan-200/30 dark:border-cyan-800/20 p-6 shadow-md hover:shadow-lg transition-all duration-300">
                    <div class="flex items-start gap-4">
                        <div class="w-12 h-12 bg-gradient-to-br from-cyan-100 to-blue-100 dark:from-cyan-900/30 dark:to-blue-900/30 rounded-xl flex items-center justify-center text-2xl flex-shrink-0">
                            {{ $feature['icon'] }}
                        </div>
                        <div class="flex-1">
                            <h3 class="text-lg font-bold text-zinc-800 dark:text-zinc-200 mb-2">
                                {{ $feature['title'] }}
                            </h3>
                            <p class="text-sm text-zinc-600 dark:text-zinc-400">
                                {{ $feature['desc'] }}
                            </p>
                        </div>
                    </div>
                </div>
            @endforeach
        </div>

    </div>
</x-layouts.app>
