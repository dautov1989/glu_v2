<div x-data="{ 
    searchQuery: '', 
    isFocused: false,
    suggestions: [
        { icon: '🩺', text: 'Симптомы диабета', category: 'Симптомы' },
        { icon: '💊', text: 'Инсулинотерапия', category: 'Лечение' },
        { icon: '🥗', text: 'Диета при диабете', category: 'Питание' },
        { icon: '🏃', text: 'Спорт и физические нагрузки', category: 'Спорт' },
        { icon: '📊', text: 'Контроль уровня глюкозы', category: 'Мониторинг' }
    ]
}"
    class="w-full bg-gradient-to-br from-cyan-50 via-blue-50 to-teal-50 dark:from-zinc-900 dark:via-cyan-950 dark:to-teal-950 border-b border-cyan-100 dark:border-cyan-900/30 shadow-lg shadow-cyan-100/50 dark:shadow-cyan-900/20">
    <div class="max-w-4xl mx-auto px-4 sm:px-6 lg:px-8 py-4">
        <!-- Search Container -->
        <div class="relative">
            <!-- Main Search Box -->
            <form action="{{ route('search') }}" method="GET" class="relative group">
                <div
                    class="absolute -inset-0.5 bg-gradient-to-r from-cyan-500 via-blue-500 to-teal-500 rounded-xl blur opacity-20 group-hover:opacity-40 transition-opacity duration-300">
                </div>

                <div class="relative bg-white dark:bg-zinc-800 rounded-xl shadow-xl shadow-cyan-200/50 dark:shadow-cyan-900/30 border border-cyan-200/50 dark:border-cyan-700/30 overflow-hidden transition-all duration-300"
                    :class="{ 'ring-2 ring-cyan-500 dark:ring-cyan-400': isFocused }">

                    <!-- Search Icon -->
                    <div class="absolute left-4 top-1/2 -translate-y-1/2 pointer-events-none">
                        <div class="relative">
                            <svg xmlns="http://www.w3.org/2000/svg" fill="none" viewBox="0 0 24 24" stroke-width="2"
                                stroke="currentColor" class="w-5 h-5 transition-colors duration-300"
                                :class="isFocused ? 'text-cyan-500 dark:text-cyan-400' : 'text-zinc-400 dark:text-zinc-500'">
                                <path stroke-linecap="round" stroke-linejoin="round"
                                    d="m21 21-5.197-5.197m0 0A7.5 7.5 0 1 0 5.196 5.196a7.5 7.5 0 0 0 10.607 10.607Z" />
                            </svg>
                            <!-- Pulse effect when focused -->
                            <div x-show="isFocused" x-transition
                                class="absolute inset-0 bg-cyan-400 rounded-full animate-ping opacity-20"></div>
                        </div>
                    </div>

                    <!-- Input Field -->
                    <input type="text" name="q" x-model="searchQuery" @focus="isFocused = true"
                        @blur="setTimeout(() => isFocused = false, 200)"
                        placeholder="Поиск информации о диабете, симптомах, лечении..."
                        class="w-full pl-12 pr-28 py-3 text-sm md:text-base bg-transparent border-0 focus:outline-none focus:ring-0 text-zinc-800 dark:text-zinc-100 placeholder-zinc-400 dark:placeholder-zinc-500">

                    <!-- Search Button -->
                    <div class="absolute right-2 top-1/2 -translate-y-1/2 flex items-center gap-1.5">
                        <!-- Clear Button -->
                        <button type="button" x-show="searchQuery.length > 0" x-transition @click="searchQuery = ''"
                            class="p-1.5 rounded-lg text-zinc-400 hover:text-zinc-600 dark:hover:text-zinc-300 hover:bg-zinc-100 dark:hover:bg-zinc-700 transition-all duration-200">
                            <svg xmlns="http://www.w3.org/2000/svg" fill="none" viewBox="0 0 24 24" stroke-width="2"
                                stroke="currentColor" class="w-4 h-4">
                                <path stroke-linecap="round" stroke-linejoin="round" d="M6 18 18 6M6 6l12 12" />
                            </svg>
                        </button>

                        <!-- Search Button -->
                        <button type="submit"
                            class="px-4 py-2 bg-gradient-to-r from-cyan-500 to-blue-500 hover:from-cyan-600 hover:to-blue-600 text-white font-medium rounded-lg shadow-md shadow-cyan-500/30 hover:shadow-cyan-500/50 transition-all duration-300 hover:scale-105 active:scale-95 flex items-center gap-1.5">
                            <span class="hidden sm:inline text-sm">Найти</span>
                            <svg xmlns="http://www.w3.org/2000/svg" fill="none" viewBox="0 0 24 24" stroke-width="2.5"
                                stroke="currentColor" class="w-4 h-4">
                                <path stroke-linecap="round" stroke-linejoin="round"
                                    d="m21 21-5.197-5.197m0 0A7.5 7.5 0 1 0 5.196 5.196a7.5 7.5 0 0 0 10.607 10.607Z" />
                            </svg>
                        </button>
                    </div>
                </div>
            </form>

            <!-- Popular Searches / Suggestions -->
            <div x-show="isFocused && searchQuery.length === 0" x-transition:enter="transition ease-out duration-200"
                x-transition:enter-start="opacity-0 translate-y-2" x-transition:enter-end="opacity-100 translate-y-0"
                x-transition:leave="transition ease-in duration-150"
                x-transition:leave-start="opacity-100 translate-y-0" x-transition:leave-end="opacity-0 translate-y-2"
                class="absolute top-full left-0 right-0 mt-3 bg-white dark:bg-zinc-900 rounded-xl shadow-2xl shadow-cyan-500/20 dark:shadow-cyan-900/40 border border-cyan-200/50 dark:border-cyan-800/50 overflow-hidden z-50">

                <div class="p-4">
                    <div class="flex items-center gap-2 mb-3 px-2">
                        <svg xmlns="http://www.w3.org/2000/svg" fill="none" viewBox="0 0 24 24" stroke-width="1.5"
                            stroke="currentColor" class="w-5 h-5 text-cyan-500">
                            <path stroke-linecap="round" stroke-linejoin="round"
                                d="M15.362 5.214A8.252 8.252 0 0 1 12 21 8.25 8.25 0 0 1 6.038 7.047 8.287 8.287 0 0 0 9 9.601a8.983 8.983 0 0 1 3.361-6.867 8.21 8.21 0 0 0 3 2.48Z" />
                            <path stroke-linecap="round" stroke-linejoin="round"
                                d="M12 18a3.75 3.75 0 0 0 .495-7.468 5.99 5.99 0 0 0-1.925 3.547 5.975 5.975 0 0 1-2.133-1.001A3.75 3.75 0 0 0 12 18Z" />
                        </svg>
                        <h3 class="text-sm font-semibold text-zinc-700 dark:text-zinc-300">Популярные запросы</h3>
                    </div>

                    <div class="space-y-1">
                        <template x-for="(suggestion, index) in suggestions" :key="index">
                            <button @click="searchQuery = suggestion.text; isFocused = false"
                                class="w-full flex items-center gap-3 px-3 py-3 rounded-lg hover:bg-gradient-to-r hover:from-cyan-50 hover:to-blue-50 dark:hover:from-cyan-900/20 dark:hover:to-blue-900/20 transition-all duration-200 group">
                                <span class="text-2xl" x-text="suggestion.icon"></span>
                                <div class="flex-1 text-left">
                                    <p class="text-sm font-medium text-zinc-700 dark:text-zinc-200 group-hover:text-cyan-600 dark:group-hover:text-cyan-400 transition-colors"
                                        x-text="suggestion.text"></p>
                                    <p class="text-xs text-zinc-500 dark:text-zinc-400" x-text="suggestion.category">
                                    </p>
                                </div>
                                <svg xmlns="http://www.w3.org/2000/svg" fill="none" viewBox="0 0 24 24" stroke-width="2"
                                    stroke="currentColor"
                                    class="w-4 h-4 text-zinc-400 group-hover:text-cyan-500 dark:group-hover:text-cyan-400 transition-colors">
                                    <path stroke-linecap="round" stroke-linejoin="round"
                                        d="m4.5 19.5 15-15m0 0H8.25m11.25 0v11.25" />
                                </svg>
                            </button>
                        </template>
                    </div>
                </div>
            </div>
        </div>
    </div>
</div>