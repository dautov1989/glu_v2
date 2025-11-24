<x-layouts.app title="Home">
    <div class="p-8 space-y-8 bg-white dark:bg-zinc-900">
        
        <!-- Hero Section -->
        <div class="relative">
            <div class="bg-gradient-to-br from-white to-cyan-50/30 dark:from-zinc-900 dark:to-cyan-950/10 rounded-xl border border-cyan-200/30 dark:border-cyan-800/20 p-12 text-center shadow-lg">
                <div class="max-w-3xl mx-auto space-y-6">
                    <div class="inline-flex items-center gap-2 bg-cyan-100 dark:bg-cyan-900/30 text-cyan-700 dark:text-cyan-300 px-4 py-2 rounded-full text-sm font-semibold border border-cyan-200 dark:border-cyan-800">
                        <svg xmlns="http://www.w3.org/2000/svg" fill="none" viewBox="0 0 24 24" stroke-width="2" stroke="currentColor" class="w-5 h-5">
                            <path stroke-linecap="round" stroke-linejoin="round" d="M9.813 15.904 9 18.75l-.813-2.846a4.5 4.5 0 0 0-3.09-3.09L2.25 12l2.846-.813a4.5 4.5 0 0 0 3.09-3.09L9 5.25l.813 2.846a4.5 4.5 0 0 0 3.09 3.09L15.75 12l-2.846.813a4.5 4.5 0 0 0-3.09 3.09ZM18.259 8.715 18 9.75l-.259-1.035a3.375 3.375 0 0 0-2.455-2.456L14.25 6l1.036-.259a3.375 3.375 0 0 0 2.455-2.456L18 2.25l.259 1.035a3.375 3.375 0 0 0 2.456 2.456L21.75 6l-1.035.259a3.375 3.375 0 0 0-2.456 2.456Z" />
                        </svg>
                        <span>База знаний для диабетиков СНГ</span>
                    </div>
                    
                    <h1 class="text-5xl md:text-6xl font-bold">
                        <span class="bg-gradient-to-r from-cyan-600 to-blue-600 dark:from-cyan-400 dark:to-blue-400 bg-clip-text text-transparent">
                            Добро пожаловать в
                        </span>
                        <br>
                        <span class="bg-gradient-to-r from-blue-600 to-cyan-600 dark:from-blue-400 dark:to-cyan-400 bg-clip-text text-transparent">
                            Glucosa
                        </span>
                    </h1>
                    
                    <p class="text-xl text-zinc-600 dark:text-zinc-400 max-w-2xl mx-auto">
                        Ваш надежный источник информации о диабете, здоровом питании и активном образе жизни
                    </p>
                    
                    <div class="flex flex-wrap gap-4 justify-center pt-4">
                        <button class="px-6 py-3 bg-gradient-to-r from-cyan-500 to-blue-500 hover:from-cyan-600 hover:to-blue-600 text-white font-semibold rounded-xl shadow-lg shadow-cyan-500/30 hover:shadow-cyan-500/50 transition-all duration-300 hover:scale-105 active:scale-95 flex items-center gap-2">
                            <span>Начать изучение</span>
                            <svg xmlns="http://www.w3.org/2000/svg" fill="none" viewBox="0 0 24 24" stroke-width="2" stroke="currentColor" class="w-5 h-5">
                                <path stroke-linecap="round" stroke-linejoin="round" d="M13.5 4.5 21 12m0 0-7.5 7.5M21 12H3" />
                            </svg>
                        </button>
                        <button class="px-6 py-3 bg-white dark:bg-zinc-800 hover:bg-cyan-50 dark:hover:bg-cyan-900/20 text-zinc-700 dark:text-zinc-300 font-semibold rounded-xl border border-zinc-200 dark:border-zinc-700 hover:border-cyan-300 dark:hover:border-cyan-700 shadow-md transition-all duration-300 hover:scale-105 flex items-center gap-2">
                            <svg xmlns="http://www.w3.org/2000/svg" fill="none" viewBox="0 0 24 24" stroke-width="2" stroke="currentColor" class="w-5 h-5">
                                <path stroke-linecap="round" stroke-linejoin="round" d="M12 6.042A8.967 8.967 0 0 0 6 3.75c-1.052 0-2.062.18-3 .512v14.25A8.987 8.987 0 0 1 6 18c2.305 0 4.408.867 6 2.292m0-14.25a8.966 8.966 0 0 1 6-2.292c1.052 0 2.062.18 3 .512v14.25A8.987 8.987 0 0 0 18 18a8.967 8.967 0 0 0-6 2.292m0-14.25v14.25" />
                            </svg>
                            <span>О проекте</span>
                        </button>
                    </div>
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
