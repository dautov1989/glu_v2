<aside class="w-full lg:w-64 flex-shrink-0 space-y-6">
    
    <!-- Tip of the Day Widget -->
    <div class="relative group">
        <div class="absolute -inset-0.5 bg-gradient-to-r from-cyan-500/20 to-blue-500/20 rounded-xl blur opacity-0 group-hover:opacity-100 transition-opacity duration-300"></div>
        <div class="relative bg-white dark:bg-zinc-900 rounded-xl border border-cyan-200/50 dark:border-cyan-800/30 p-6 shadow-lg shadow-cyan-200/20 dark:shadow-cyan-900/10">
            <div class="flex items-center gap-2 mb-4">
                <div class="w-8 h-8 bg-gradient-to-br from-cyan-500 to-blue-500 rounded-lg flex items-center justify-center text-white shadow-lg shadow-cyan-500/30">
                    <svg xmlns="http://www.w3.org/2000/svg" fill="none" viewBox="0 0 24 24" stroke-width="2" stroke="currentColor" class="w-5 h-5">
                        <path stroke-linecap="round" stroke-linejoin="round" d="M12 18v-5.25m0 0a6.01 6.01 0 0 0 1.5-.189m-1.5.189a6.01 6.01 0 0 1-1.5-.189m3.75 7.478a12.06 12.06 0 0 1-4.5 0m3.75 2.383a14.406 14.406 0 0 1-3 0M14.25 18v-.192c0-.983.658-1.823 1.508-2.316a7.5 7.5 0 1 0-7.517 0c.85.493 1.509 1.333 1.509 2.316V18" />
                    </svg>
                </div>
                <h3 class="text-sm font-bold bg-gradient-to-r from-cyan-700 to-blue-700 dark:from-cyan-300 dark:to-blue-300 bg-clip-text text-transparent">Совет дня</h3>
            </div>
            <p class="text-sm text-zinc-700 dark:text-zinc-300 leading-relaxed mb-3">
                💧 Пейте достаточно воды! Рекомендуется 8-10 стаканов в день для поддержания нормального уровня глюкозы.
            </p>
            <div class="flex items-center gap-2 text-xs text-cyan-600 dark:text-cyan-400">
                <svg xmlns="http://www.w3.org/2000/svg" fill="none" viewBox="0 0 24 24" stroke-width="2" stroke="currentColor" class="w-3 h-3">
                    <path stroke-linecap="round" stroke-linejoin="round" d="M12 6v6h4.5m4.5 0a9 9 0 1 1-18 0 9 9 0 0 1 18 0Z" />
                </svg>
                <span>Обновляется ежедневно</span>
            </div>
        </div>
    </div>

    <!-- Quick HE Calculator Widget -->
    <div class="relative group" x-data="{ grams: 50, result: 0 }" x-init="$watch('grams', value => result = (value / 12).toFixed(1))">
        <div class="absolute -inset-0.5 bg-gradient-to-r from-cyan-500/20 to-blue-500/20 rounded-xl blur opacity-0 group-hover:opacity-100 transition-opacity duration-300"></div>
        <div class="relative bg-white dark:bg-zinc-900 rounded-xl border border-cyan-200/50 dark:border-cyan-800/30 p-6 shadow-lg shadow-cyan-200/20 dark:shadow-cyan-900/10">
            <div class="flex items-center gap-2 mb-5">
                <div class="w-8 h-8 bg-gradient-to-br from-cyan-500 to-blue-500 rounded-lg flex items-center justify-center text-white shadow-lg shadow-cyan-500/30">
                    <svg xmlns="http://www.w3.org/2000/svg" fill="none" viewBox="0 0 24 24" stroke-width="2" stroke="currentColor" class="w-5 h-5">
                        <path stroke-linecap="round" stroke-linejoin="round" d="M15.75 15.75V18m-7.5-6.75h.008v.008H8.25v-.008Zm0 2.25h.008v.008H8.25V13.5Zm0 2.25h.008v.008H8.25v-.008Zm0 2.25h.008v.008H8.25V18Zm2.498-6.75h.007v.008h-.007v-.008Zm0 2.25h.007v.008h-.007V13.5Zm0 2.25h.007v.008h-.007v-.008Zm0 2.25h.007v.008h-.007V18Zm2.504-6.75h.008v.008h-.008v-.008Zm0 2.25h.008v.008h-.008V13.5Zm0 2.25h.008v.008h-.008v-.008Zm0 2.25h.008v.008h-.008V18Zm2.498-6.75h.008v.008h-.008v-.008Zm0 2.25h.008v.008h-.008V13.5ZM8.25 6h7.5v2.25h-7.5V6ZM12 2.25c-1.892 0-3.758.11-5.593.322C5.307 2.7 4.5 3.65 4.5 4.757V19.5a2.25 2.25 0 0 0 2.25 2.25h10.5a2.25 2.25 0 0 0 2.25-2.25V4.757c0-1.108-.806-2.057-1.907-2.185A48.507 48.507 0 0 0 12 2.25Z" />
                    </svg>
                </div>
                <h3 class="text-sm font-bold bg-gradient-to-r from-cyan-700 to-blue-700 dark:from-cyan-300 dark:to-blue-300 bg-clip-text text-transparent">Калькулятор ХЕ</h3>
            </div>
            
            <div class="space-y-4">
                <div>
                    <label class="text-xs text-zinc-600 dark:text-zinc-400 mb-2 block">Граммы углеводов:</label>
                    <input type="range" x-model="grams" min="0" max="200" step="5" class="w-full h-2 bg-gradient-to-r from-cyan-200 to-blue-200 dark:from-cyan-900/30 dark:to-blue-900/30 rounded-lg appearance-none cursor-pointer accent-cyan-500">
                    <div class="flex justify-between text-xs text-zinc-500 mt-1">
                        <span>0г</span>
                        <span class="font-semibold text-cyan-600 dark:text-cyan-400" x-text="grams + 'г'"></span>
                        <span>200г</span>
                    </div>
                </div>
                
                <div class="bg-gradient-to-br from-cyan-50 to-blue-50 dark:from-cyan-950/30 dark:to-blue-950/30 rounded-lg p-4 border border-cyan-200/50 dark:border-cyan-800/30">
                    <div class="text-center">
                        <div class="text-xs text-cyan-700 dark:text-cyan-400 mb-1">Хлебные единицы:</div>
                        <div class="text-3xl font-bold bg-gradient-to-r from-cyan-600 to-blue-600 dark:from-cyan-400 dark:to-blue-400 bg-clip-text text-transparent" x-text="result"></div>
                        <div class="text-xs text-zinc-500 mt-1">ХЕ</div>
                    </div>
                </div>
            </div>
        </div>
    </div>

    <!-- Glucose Levels Reference Widget -->
    <div class="relative group">
        <div class="absolute -inset-0.5 bg-gradient-to-r from-cyan-500/20 to-blue-500/20 rounded-xl blur opacity-0 group-hover:opacity-100 transition-opacity duration-300"></div>
        <div class="relative bg-white dark:bg-zinc-900 rounded-xl border border-cyan-200/50 dark:border-cyan-800/30 p-6 shadow-lg shadow-cyan-200/20 dark:shadow-cyan-900/10">
            <div class="flex items-center gap-2 mb-5">
                <div class="w-8 h-8 bg-gradient-to-br from-cyan-500 to-blue-500 rounded-lg flex items-center justify-center text-white shadow-lg shadow-cyan-500/30">
                    <svg xmlns="http://www.w3.org/2000/svg" fill="none" viewBox="0 0 24 24" stroke-width="2" stroke="currentColor" class="w-5 h-5">
                        <path stroke-linecap="round" stroke-linejoin="round" d="M3 13.125C3 12.504 3.504 12 4.125 12h2.25c.621 0 1.125.504 1.125 1.125v6.75C7.5 20.496 6.996 21 6.375 21h-2.25A1.125 1.125 0 0 1 3 19.875v-6.75ZM9.75 8.625c0-.621.504-1.125 1.125-1.125h2.25c.621 0 1.125.504 1.125 1.125v11.25c0 .621-.504 1.125-1.125 1.125h-2.25a1.125 1.125 0 0 1-1.125-1.125V8.625ZM16.5 4.125c0-.621.504-1.125 1.125-1.125h2.25C20.496 3 21 3.504 21 4.125v15.75c0 .621-.504 1.125-1.125 1.125h-2.25a1.125 1.125 0 0 1-1.125-1.125V4.125Z" />
                    </svg>
                </div>
                <h3 class="text-sm font-bold bg-gradient-to-r from-cyan-700 to-blue-700 dark:from-cyan-300 dark:to-blue-300 bg-clip-text text-transparent">Норма глюкозы</h3>
            </div>
            
            <div class="space-y-3">
                <div class="space-y-2">
                    <div class="flex items-center justify-between text-xs">
                        <span class="text-zinc-600 dark:text-zinc-400">Натощак</span>
                        <span class="font-semibold text-cyan-600 dark:text-cyan-400">3.9-5.5 ммоль/л</span>
                    </div>
                    <div class="h-2 bg-gradient-to-r from-cyan-200 to-cyan-400 rounded-full"></div>
                </div>
                
                <div class="space-y-2">
                    <div class="flex items-center justify-between text-xs">
                        <span class="text-zinc-600 dark:text-zinc-400">Через 2ч после еды</span>
                        <span class="font-semibold text-blue-600 dark:text-blue-400">< 7.8 ммоль/л</span>
                    </div>
                    <div class="h-2 bg-gradient-to-r from-blue-200 to-blue-400 rounded-full"></div>
                </div>
                
                <div class="space-y-2">
                    <div class="flex items-center justify-between text-xs">
                        <span class="text-zinc-600 dark:text-zinc-400">Критический уровень</span>
                        <span class="font-semibold text-zinc-600 dark:text-zinc-400">> 11.1 ммоль/л</span>
                    </div>
                    <div class="h-2 bg-gradient-to-r from-zinc-300 to-zinc-400 rounded-full"></div>
                </div>
            </div>
            
            <div class="mt-4 p-3 bg-cyan-50 dark:bg-cyan-950/30 rounded-lg border border-cyan-200/50 dark:border-cyan-800/30">
                <p class="text-xs text-cyan-700 dark:text-cyan-300">
                    ⚠️ Всегда консультируйтесь с врачом для индивидуальных рекомендаций
                </p>
            </div>
        </div>
    </div>

    <!-- Popular Posts Widget -->
    <div class="relative group">
        <div class="absolute -inset-0.5 bg-gradient-to-r from-cyan-500/20 to-blue-500/20 rounded-xl blur opacity-0 group-hover:opacity-100 transition-opacity duration-300"></div>
        <div class="relative bg-white dark:bg-zinc-900 rounded-xl border border-cyan-200/50 dark:border-cyan-800/30 p-6 shadow-lg shadow-cyan-200/20 dark:shadow-cyan-900/10">
            <div class="flex items-center gap-2 mb-5">
                <div class="w-1 h-6 bg-gradient-to-b from-cyan-500 to-blue-500 rounded-full"></div>
                <h3 class="text-sm font-bold bg-gradient-to-r from-cyan-700 to-blue-700 dark:from-cyan-300 dark:to-blue-300 bg-clip-text text-transparent">Популярное</h3>
            </div>
            <div class="space-y-4">
                @foreach([
                    ['title' => 'Как контролировать сахар в крови без стресса', 'date' => '24 Ноя 2025'],
                    ['title' => '10 продуктов с низким гликемическим индексом', 'date' => '23 Ноя 2025'],
                    ['title' => 'Спорт при диабете: с чего начать', 'date' => '22 Ноя 2025']
                ] as $post)
                    <div class="flex gap-3 group/post cursor-pointer p-2 -mx-2 rounded-lg hover:bg-cyan-50 dark:hover:bg-cyan-900/20 transition-all duration-200">
                        <div class="w-16 h-16 bg-gradient-to-br from-cyan-100 to-blue-100 dark:from-cyan-900/30 dark:to-blue-900/30 rounded-lg flex-shrink-0 overflow-hidden relative">
                            <div class="absolute inset-0 bg-gradient-to-br from-cyan-400/20 to-blue-400/20 group-hover/post:scale-110 transition-transform duration-300"></div>
                            <div class="absolute inset-0 flex items-center justify-center text-2xl">
                                {{ ['🩺', '🥗', '🏃'][$loop->index] }}
                            </div>
                        </div>
                        <div class="flex-1 min-w-0">
                            <h4 class="text-sm font-medium text-zinc-800 dark:text-zinc-200 group-hover/post:text-cyan-600 dark:group-hover/post:text-cyan-400 transition-colors line-clamp-2 mb-1">
                                {{ $post['title'] }}
                            </h4>
                            <div class="flex items-center gap-1.5 text-xs text-zinc-500">
                                <svg xmlns="http://www.w3.org/2000/svg" fill="none" viewBox="0 0 24 24" stroke-width="1.5" stroke="currentColor" class="w-3 h-3">
                                    <path stroke-linecap="round" stroke-linejoin="round" d="M6.75 3v2.25M17.25 3v2.25M3 18.75V7.5a2.25 2.25 0 0 1 2.25-2.25h13.5A2.25 2.25 0 0 1 21 7.5v11.25m-18 0A2.25 2.25 0 0 0 5.25 21h13.5A2.25 2.25 0 0 0 21 18.75m-18 0v-7.5A2.25 2.25 0 0 1 5.25 9h13.5A2.25 2.25 0 0 1 21 11.25v7.5" />
                                </svg>
                                <span>{{ $post['date'] }}</span>
                            </div>
                        </div>
                    </div>
                @endforeach
            </div>
        </div>
    </div>

    <!-- Newsletter Widget -->
    <div class="relative group">
        <div class="absolute -inset-0.5 bg-gradient-to-r from-cyan-500/20 to-blue-500/20 rounded-xl blur opacity-0 group-hover:opacity-100 transition-opacity duration-300"></div>
        <div class="relative bg-white dark:bg-zinc-900 rounded-xl border border-cyan-200/50 dark:border-cyan-800/30 p-6 shadow-lg shadow-cyan-200/20 dark:shadow-cyan-900/10">
            <div class="flex items-center gap-2 mb-3">
                <div class="w-8 h-8 bg-gradient-to-br from-cyan-500 to-blue-500 rounded-lg flex items-center justify-center text-white shadow-lg shadow-cyan-500/30">
                    <svg xmlns="http://www.w3.org/2000/svg" fill="none" viewBox="0 0 24 24" stroke-width="2" stroke="currentColor" class="w-5 h-5">
                        <path stroke-linecap="round" stroke-linejoin="round" d="M21.75 6.75v10.5a2.25 2.25 0 0 1-2.25 2.25h-15a2.25 2.25 0 0 1-2.25-2.25V6.75m19.5 0A2.25 2.25 0 0 0 19.5 4.5h-15a2.25 2.25 0 0 0-2.25 2.25m19.5 0v.243a2.25 2.25 0 0 1-1.07 1.916l-7.5 4.615a2.25 2.25 0 0 1-2.36 0L3.32 8.91a2.25 2.25 0 0 1-1.07-1.916V6.75" />
                    </svg>
                </div>
                <h3 class="text-sm font-bold bg-gradient-to-r from-cyan-700 to-blue-700 dark:from-cyan-300 dark:to-blue-300 bg-clip-text text-transparent">Подписка на новости</h3>
            </div>
            <p class="text-sm text-zinc-700 dark:text-zinc-300 mb-4">Получайте полезные советы и новости о диабете каждую неделю.</p>
            <input type="email" placeholder="Ваш Email" class="w-full text-sm px-4 py-2.5 rounded-lg border border-cyan-200 dark:border-cyan-800 bg-white dark:bg-zinc-900 focus:outline-none focus:ring-2 focus:ring-cyan-400 focus:border-transparent mb-3 transition-all duration-200">
            <button class="w-full bg-gradient-to-r from-cyan-500 to-blue-500 hover:from-cyan-600 hover:to-blue-600 text-white text-sm font-bold py-2.5 rounded-lg shadow-lg shadow-cyan-500/30 hover:shadow-cyan-500/50 transition-all duration-300 hover:scale-105 active:scale-95 flex items-center justify-center gap-2">
                <span>Подписаться</span>
                <svg xmlns="http://www.w3.org/2000/svg" fill="none" viewBox="0 0 24 24" stroke-width="2" stroke="currentColor" class="w-4 h-4">
                    <path stroke-linecap="round" stroke-linejoin="round" d="M13.5 4.5 21 12m0 0-7.5 7.5M21 12H3" />
                </svg>
            </button>
        </div>
    </div>

</aside>
