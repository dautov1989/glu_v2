@section('seo-meta')
    <x-seo-meta 
        title="Glucosa — Всё о сахарном диабете 1 и 2 типа: управление и питание"
        description="Информационный портал о сахарном диабете. Как контролировать уровень сахара в крови, что можно есть при диабете, симптомы, признаки и советы врачей."
        keywords="диабет, сахарный диабет, сахарный диабет 1 типа, сахарный диабет 2 типа, питание при диабете, что можно есть при диабете, симптомы диабета, контроль глюкозы"
        type="website"
    />
    <x-schema-org type="website" />
    <x-schema-org type="organization" />
@endsection

<x-layouts.app title="Home">
    <div class="p-4 sm:p-8 space-y-8 bg-white dark:bg-zinc-900 rounded-2xl border border-cyan-200/50 dark:border-cyan-800/30 shadow-sm shadow-cyan-200/10 dark:shadow-cyan-950/10">
        <h1 class="sr-only">Сахарный диабет: управление и жизнь без ограничений</h1>
        
        <!-- Insulin Calculator Section -->
        <x-insulin-calculator />
        
      

        <!-- Stats Section -->
        <div class="grid grid-cols-1 md:grid-cols-3 gap-6">
            @foreach([
                    ['icon' => '📚', 'number' => $articlesCount, 'label' => 'Статей'],
                    ['icon' => '👥', 'number' => $usersCount >= 1000 ? $usersCount : '1000+', 'label' => 'Пользователей'],
                    ['icon' => '⭐', 'number' => '1000+', 'label' => 'Историй успеха']
                ] as $stat)
                                                                                                                <div class="bg-white dark:bg-zinc-900 rounded-xl border border-cyan-200/50 dark:border-cyan-800/30 p-6 text-center shadow-md hover:shadow-lg transition-all duration-300 hover:scale-105">
                                                                                                                    <div class="text-5xl mb-3">{{ $stat['icon'] }}</div>
                                                                                                                    <div class="text-3xl font-bold bg-gradient-to-r from-cyan-600 to-blue-600 dark:from-cyan-400 dark:to-blue-400 bg-clip-text text-transparent mb-1">
                                                                                                                        {{ $stat['number'] }}
                                                                                                                    </div>
                                                                                                                    <div class="text-sm text-zinc-600 dark:text-zinc-400 font-medium">{{ $stat['label'] }}</div>
                                                                                                                </div>
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

                {{-- Bento Grid вместо стандартной сетки --}}
                <x-bento-grid :bentoData="$bentoData" />

                <!-- Mobile "All Articles" Button -->
                <div class="mt-8 md:hidden">
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
