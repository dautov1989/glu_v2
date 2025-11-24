<aside class="w-full lg:w-64 flex-shrink-0 space-y-6">
    
    <!-- Categories Widget -->
    <div class="relative group">
        <div class="absolute -inset-0.5 bg-gradient-to-r from-cyan-500/20 to-blue-500/20 rounded-xl blur opacity-0 group-hover:opacity-100 transition-opacity duration-300"></div>
        <div class="relative bg-white dark:bg-zinc-900 rounded-xl border border-cyan-200/50 dark:border-cyan-800/30 p-6 shadow-lg shadow-cyan-200/20 dark:shadow-cyan-900/10">
            <div class="flex items-center gap-2 mb-5">
                <div class="w-1 h-6 bg-gradient-to-b from-cyan-500 to-blue-500 rounded-full"></div>
                <h3 class="text-lg font-bold bg-gradient-to-r from-cyan-700 to-blue-700 dark:from-cyan-300 dark:to-blue-300 bg-clip-text text-transparent">Категории</h3>
            </div>
            <ul class="space-y-2">
                @foreach([
                    ['name' => 'Диабет 1 типа', 'icon' => '💉', 'count' => 42],
                    ['name' => 'Диабет 2 типа', 'icon' => '💊', 'count' => 38],
                    ['name' => 'Питание', 'icon' => '🥗', 'count' => 56],
                    ['name' => 'Спорт', 'icon' => '🏃', 'count' => 29],
                    ['name' => 'Лекарства', 'icon' => '🩺', 'count' => 34],
                    ['name' => 'Истории успеха', 'icon' => '⭐', 'count' => 18]
                ] as $category)
                    <li>
                        <a href="#" class="flex items-center justify-between p-3 rounded-lg hover:bg-gradient-to-r hover:from-cyan-50 hover:to-blue-50 dark:hover:from-cyan-900/20 dark:hover:to-blue-900/20 transition-all duration-200 group/item">
                            <div class="flex items-center gap-3">
                                <span class="text-xl group-hover/item:scale-110 transition-transform duration-200">{{ $category['icon'] }}</span>
                                <span class="text-sm font-medium text-zinc-700 dark:text-zinc-300 group-hover/item:text-cyan-600 dark:group-hover/item:text-cyan-400 transition-colors">{{ $category['name'] }}</span>
                            </div>
                            <span class="text-xs bg-gradient-to-r from-cyan-100 to-blue-100 dark:from-cyan-900/30 dark:to-blue-900/30 text-cyan-700 dark:text-cyan-300 px-2.5 py-1 rounded-full font-semibold group-hover/item:from-cyan-500 group-hover/item:to-blue-500 group-hover/item:text-white transition-all duration-200">
                                {{ $category['count'] }}
                            </span>
                        </a>
                    </li>
                @endforeach
            </ul>
        </div>
    </div>

    <!-- Popular Posts Widget -->
    <div class="relative group">
        <div class="absolute -inset-0.5 bg-gradient-to-r from-blue-500/20 to-teal-500/20 rounded-xl blur opacity-0 group-hover:opacity-100 transition-opacity duration-300"></div>
        <div class="relative bg-white dark:bg-zinc-900 rounded-xl border border-blue-200/50 dark:border-blue-800/30 p-6 shadow-lg shadow-blue-200/20 dark:shadow-blue-900/10">
            <div class="flex items-center gap-2 mb-5">
                <div class="w-1 h-6 bg-gradient-to-b from-blue-500 to-teal-500 rounded-full"></div>
                <h3 class="text-lg font-bold bg-gradient-to-r from-blue-700 to-teal-700 dark:from-blue-300 dark:to-teal-300 bg-clip-text text-transparent">Популярное</h3>
            </div>
            <div class="space-y-4">
                @foreach([
                    ['title' => 'Как контролировать сахар в крови без стресса', 'date' => '24 Ноя 2025', 'color' => 'cyan'],
                    ['title' => '10 продуктов с низким гликемическим индексом', 'date' => '23 Ноя 2025', 'color' => 'blue'],
                    ['title' => 'Спорт при диабете: с чего начать', 'date' => '22 Ноя 2025', 'color' => 'teal']
                ] as $post)
                    <div class="flex gap-3 group/post cursor-pointer p-2 -mx-2 rounded-lg hover:bg-gradient-to-r hover:from-{{ $post['color'] }}-50 hover:to-blue-50 dark:hover:from-{{ $post['color'] }}-900/20 dark:hover:to-blue-900/20 transition-all duration-200">
                        <div class="w-16 h-16 bg-gradient-to-br from-{{ $post['color'] }}-100 to-blue-100 dark:from-{{ $post['color'] }}-900/30 dark:to-blue-900/30 rounded-lg flex-shrink-0 overflow-hidden relative">
                            <div class="absolute inset-0 bg-gradient-to-br from-{{ $post['color'] }}-400/20 to-blue-400/20 group-hover/post:scale-110 transition-transform duration-300"></div>
                            <div class="absolute inset-0 flex items-center justify-center text-2xl">
                                {{ ['🩺', '🥗', '🏃'][array_rand([0, 1, 2])] }}
                            </div>
                        </div>
                        <div class="flex-1 min-w-0">
                            <h4 class="text-sm font-medium text-zinc-800 dark:text-zinc-200 group-hover/post:text-{{ $post['color'] }}-600 dark:group-hover/post:text-{{ $post['color'] }}-400 transition-colors line-clamp-2 mb-1">
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
        <div class="absolute -inset-0.5 bg-gradient-to-r from-purple-500/30 to-pink-500/30 rounded-xl blur opacity-50 group-hover:opacity-70 animate-pulse transition-opacity duration-500"></div>
        <div class="relative bg-gradient-to-br from-cyan-50 via-blue-50 to-purple-50 dark:from-cyan-950/30 dark:via-blue-950/30 dark:to-purple-950/30 rounded-xl border border-cyan-200/50 dark:border-cyan-800/30 p-6 shadow-xl shadow-cyan-200/30 dark:shadow-cyan-900/20">
            <div class="flex items-center gap-2 mb-3">
                <div class="w-8 h-8 bg-gradient-to-br from-cyan-500 to-blue-500 rounded-lg flex items-center justify-center text-white shadow-lg shadow-cyan-500/30">
                    <svg xmlns="http://www.w3.org/2000/svg" fill="none" viewBox="0 0 24 24" stroke-width="2" stroke="currentColor" class="w-5 h-5">
                        <path stroke-linecap="round" stroke-linejoin="round" d="M21.75 6.75v10.5a2.25 2.25 0 0 1-2.25 2.25h-15a2.25 2.25 0 0 1-2.25-2.25V6.75m19.5 0A2.25 2.25 0 0 0 19.5 4.5h-15a2.25 2.25 0 0 0-2.25 2.25m19.5 0v.243a2.25 2.25 0 0 1-1.07 1.916l-7.5 4.615a2.25 2.25 0 0 1-2.36 0L3.32 8.91a2.25 2.25 0 0 1-1.07-1.916V6.75" />
                    </svg>
                </div>
                <h3 class="text-base font-bold bg-gradient-to-r from-cyan-700 to-blue-700 dark:from-cyan-300 dark:to-blue-300 bg-clip-text text-transparent">Подписка на новости</h3>
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
