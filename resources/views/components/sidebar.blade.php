<aside class="w-full lg:w-64 flex-shrink-0">
    <div class="bg-white dark:bg-zinc-900 rounded-lg border border-zinc-200 dark:border-zinc-800 p-6 space-y-8">
        
        <!-- Categories Widget -->
        <div>
            <h3 class="text-lg font-semibold text-zinc-900 dark:text-white mb-4">Категории</h3>
            <ul class="space-y-3">
                @foreach(['Диабет 1 типа', 'Диабет 2 типа', 'Питание', 'Спорт', 'Лекарства', 'Истории успеха'] as $category)
                    <li>
                        <a href="#" class="text-zinc-600 dark:text-zinc-400 hover:text-cyan-500 dark:hover:text-cyan-400 transition-colors flex items-center justify-between group">
                            <span>{{ $category }}</span>
                            <span class="text-xs bg-zinc-100 dark:bg-zinc-800 text-zinc-500 px-2 py-1 rounded-full group-hover:bg-cyan-50 dark:group-hover:bg-cyan-900/20 group-hover:text-cyan-600 transition-colors">
                                {{ rand(5, 50) }}
                            </span>
                        </a>
                    </li>
                @endforeach
            </ul>
        </div>

        <!-- Recent Posts Widget -->
        <div>
            <h3 class="text-lg font-semibold text-zinc-900 dark:text-white mb-4">Популярное</h3>
            <div class="space-y-4">
                @foreach(range(1, 3) as $i)
                    <div class="flex gap-3 group cursor-pointer">
                        <div class="w-16 h-16 bg-zinc-200 dark:bg-zinc-800 rounded-md flex-shrink-0 overflow-hidden">
                            <!-- Placeholder image -->
                            <div class="w-full h-full bg-gradient-to-br from-zinc-200 to-zinc-300 dark:from-zinc-800 dark:to-zinc-700 group-hover:scale-110 transition-transform duration-300"></div>
                        </div>
                        <div>
                            <h4 class="text-sm font-medium text-zinc-800 dark:text-zinc-200 group-hover:text-cyan-500 transition-colors line-clamp-2">
                                Как контролировать сахар в крови без стресса
                            </h4>
                            <span class="text-xs text-zinc-500 mt-1 block">24 Ноя 2025</span>
                        </div>
                    </div>
                @endforeach
            </div>
        </div>

        <!-- Newsletter Widget -->
        <div class="bg-cyan-50 dark:bg-cyan-900/10 rounded-lg p-4 -mx-2">
            <h3 class="text-sm font-semibold text-cyan-900 dark:text-cyan-100 mb-2">Подписка</h3>
            <p class="text-xs text-cyan-700 dark:text-cyan-300 mb-3">Получайте полезные советы каждую неделю.</p>
            <input type="email" placeholder="Ваш Email" class="w-full text-sm px-3 py-2 rounded border border-cyan-200 dark:border-cyan-800 bg-white dark:bg-zinc-900 focus:outline-none focus:ring-2 focus:ring-cyan-400 mb-2">
            <button class="w-full bg-cyan-500 hover:bg-cyan-600 text-white text-xs font-bold py-2 rounded transition-colors">
                Подписаться
            </button>
        </div>

    </div>
</aside>
