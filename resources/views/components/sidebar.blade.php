<aside class="w-full lg:w-64 flex-shrink-0 space-y-6">

    <!-- Tools & Guides Navigation -->
    <div class="space-y-3">
        <div class="grid grid-cols-1 gap-3">
            <!-- Можно ли при диабете -->
            <a href="{{ route('tools.can-i-eat') }}" @class([
                'group relative overflow-hidden rounded-xl p-4 transition-all duration-300 hover:shadow-lg hover:-translate-y-0.5',
                'bg-white dark:bg-zinc-900 border border-zinc-200 dark:border-zinc-800 hover:border-emerald-200 dark:hover:border-emerald-800' => !request()->routeIs('tools.can-i-eat'),
                'bg-emerald-50/40 dark:bg-emerald-900/10 border border-emerald-500 dark:border-emerald-500 ring-1 ring-emerald-500/20 shadow-sm' => request()->routeIs('tools.can-i-eat')
            ])>
                <div class="absolute top-0 right-0 p-3 opacity-10 group-hover:opacity-20 transition-opacity">
                    <span class="text-4xl">🥗</span>
                </div>
                <div class="flex items-center gap-4 relative z-10">
                    <div
                        class="w-10 h-10 rounded-lg bg-emerald-100 dark:bg-emerald-900/30 flex items-center justify-center text-xl shadow-sm group-hover:scale-110 transition-transform duration-300">
                        ✅
                    </div>
                    <div>
                        <h4
                            class="font-bold text-zinc-800 dark:text-zinc-100 leading-tight group-hover:text-emerald-600 dark:group-hover:text-emerald-400 transition-colors">
                            Можно ли при диабете?
                        </h4>
                        <p class="text-xs text-zinc-500 dark:text-zinc-400 mt-0.5 font-medium">
                            Светофор продуктов
                        </p>
                    </div>
                </div>
            </a>

            <!-- Справочник углеводов -->
            <a href="{{ route('tools.carbs-table') }}" @class([
                'group relative overflow-hidden rounded-xl p-4 transition-all duration-300 hover:shadow-lg hover:-translate-y-0.5',
                'bg-white dark:bg-zinc-900 border border-zinc-200 dark:border-zinc-800 hover:border-amber-200 dark:hover:border-amber-800' => !request()->routeIs('tools.carbs-table'),
                'bg-amber-50/40 dark:bg-amber-900/10 border border-amber-500 dark:border-amber-500 ring-1 ring-amber-500/20 shadow-sm' => request()->routeIs('tools.carbs-table')
            ])>
            <div class="absolute top-0 right-0 p-3 opacity-10 group-hover:opacity-20 transition-opacity">
                    <span class="text-4xl">🍞</span>
                </div>
                <div class="flex items-center gap-4 relative z-10">
                    <div
                        class="w-10 h-10 rounded-lg bg-amber-100 dark:bg-amber-900/30 flex items-center justify-center text-xl shadow-sm group-hover:scale-110 transition-transform duration-300">
                        🥯
                    </div>
                    <div>
                        <h4
                            class="font-bold text-zinc-800 dark:text-zinc-100 leading-tight group-hover:text-amber-600 dark:group-hover:text-amber-400 transition-colors">
                            Справочник углеводов
                        </h4>
                        <p class="text-xs text-zinc-500 dark:text-zinc-400 mt-0.5 font-medium">
                            Таблица Хлебных Единиц
                        </p>
                    </div>
                </div>
            </a>

            <!-- Калькулятор инсулина -->
            <a href="{{ route('tools.insulin-calculator') }}" @class([
                'group relative overflow-hidden rounded-xl p-4 transition-all duration-300 hover:shadow-lg hover:-translate-y-0.5',
                'bg-white dark:bg-zinc-900 border border-zinc-200 dark:border-zinc-800 hover:border-cyan-200 dark:hover:border-cyan-800' => !request()->routeIs('tools.insulin-calculator'),
                'bg-cyan-50/40 dark:bg-cyan-900/10 border border-cyan-500 dark:border-cyan-500 ring-1 ring-cyan-500/20 shadow-sm' => request()->routeIs('tools.insulin-calculator')
            ])>
                <div class="absolute top-0 right-0 p-3 opacity-10 group-hover:opacity-20 transition-opacity">
                    <span class="text-4xl">💉</span>
                </div>
                <div class="flex items-center gap-4 relative z-10">
                    <div
                        class="w-10 h-10 rounded-lg bg-cyan-100 dark:bg-cyan-900/30 flex items-center justify-center text-xl shadow-sm group-hover:scale-110 transition-transform duration-300">
                        ⚡
                    </div>
                    <div>
                        <h4
                            class="font-bold text-zinc-800 dark:text-zinc-100 leading-tight group-hover:text-cyan-600 dark:group-hover:text-cyan-400 transition-colors">
                            Калькулятор инсулина
                        </h4>
                        <p class="text-xs text-zinc-500 dark:text-zinc-400 mt-0.5 font-medium">
                            Расчет дозы на еду
                        </p>
                    </div>
                </div>
            </a>

            <!-- База знаний (FAQ) -->
            <a href="{{ route('tools.faq') }}" @class([
                'group relative overflow-hidden rounded-xl p-4 transition-all duration-300 hover:shadow-lg hover:-translate-y-0.5',
                'bg-white dark:bg-zinc-900 border border-zinc-200 dark:border-zinc-800 hover:border-purple-200 dark:hover:border-purple-800' => !request()->routeIs('tools.faq'),
                'bg-purple-50/40 dark:bg-purple-900/10 border border-purple-500 dark:border-purple-500 ring-1 ring-purple-500/20 shadow-sm' => request()->routeIs('tools.faq')
            ])>
          <div class="absolute top-0 right-0 p-3 opacity-10 group-hover:opacity-20 transition-opacity">
                    <span class="text-4xl">📚</span>
                </div>
                <div class="flex items-center gap-4 relative z-10">
                    <div
                        class="w-10 h-10 rounded-lg bg-purple-100 dark:bg-purple-900/30 flex items-center justify-center text-xl shadow-sm group-hover:scale-110 transition-transform duration-300">
                        🧠
                    </div>
                    <div>
                        <h4
                            class="font-bold text-zinc-800 dark:text-zinc-100 leading-tight group-hover:text-purple-600 dark:group-hover:text-purple-400 transition-colors">
                            База знаний
                        </h4>
                        <p class="text-xs text-zinc-500 dark:text-zinc-400 mt-0.5 font-medium">
                            Ответы на вопросы
                        </p>
                    </div>
                </div>
            </a>
        </div>
    </div>

    <!-- Support Us Widget (COMMENTED OUT) -->
    {{-- <div class="relative group">
        <div
            class="absolute -inset-0.5 bg-gradient-to-r from-cyan-500/20 to-blue-500/20 rounded-xl blur opacity-0 group-hover:opacity-100 transition-opacity duration-300">
        </div>
        <div
            class="relative bg-white dark:bg-zinc-900 rounded-xl border border-cyan-200/50 dark:border-cyan-800/30 p-6 shadow-lg shadow-cyan-200/20 dark:shadow-cyan-900/10">
            <div class="flex items-center gap-2 mb-3">
                <div
                    class="w-8 h-8 bg-gradient-to-br from-cyan-500 to-blue-500 rounded-lg flex items-center justify-center text-white shadow-lg shadow-cyan-500/30">
                    <svg xmlns="http://www.w3.org/2000/svg" fill="none" viewBox="0 0 24 24" stroke-width="2"
                        stroke="currentColor" class="w-5 h-5">
                        <path stroke-linecap="round" stroke-linejoin="round"
                            d="M21 8.25c0-2.485-2.099-4.5-4.688-4.5-1.935 0-3.597 1.126-4.312 2.733-.715-1.607-2.377-2.733-4.313-2.733C5.1 3.75 3 5.765 3 8.25c0 7.22 9 12 9 12s9-4.78 9-12Z" />
                    </svg>
                </div>
                <h3
                    class="text-sm font-bold bg-gradient-to-r from-cyan-700 to-blue-700 dark:from-cyan-300 dark:to-blue-300 bg-clip-text text-transparent">
                    Поддержите нас</h3>
            </div>
            <p class="text-sm text-zinc-700 dark:text-zinc-300 mb-4">Ваша поддержка помогает нам создавать полезный
                контент и развивать проект для всех.</p>
            <style>
                @keyframes gentle-glow {

                    0%,
                    100% {
                        box-shadow: 0 10px 15px -3px rgba(6, 182, 212, 0.3), 0 4px 6px -4px rgba(6, 182, 212, 0.3);
                    }

                    50% {
                        box-shadow: 0 25px 35px -5px rgba(6, 182, 212, 0.5), 0 12px 15px -6px rgba(6, 182, 212, 0.5), 0 0 20px rgba(6, 182, 212, 0.3);
                    }
                }

                .support-button {
                    position: relative;
                    animation: gentle-glow 2s ease-in-out infinite;
                    animation-delay: 1s;
                }

                .support-button:hover {
                    animation: none;
                }
            </style>
            <a href="https://dalink.to/glucos_a" target="_blank" rel="noopener noreferrer"
                class="support-button w-full bg-gradient-to-r from-cyan-500 to-blue-500 hover:from-cyan-600 hover:to-blue-600 text-white text-sm font-bold py-2.5 rounded-lg shadow-lg shadow-cyan-500/30 hover:shadow-cyan-500/50 transition-all duration-300 hover:scale-105 active:scale-95 flex items-center justify-center gap-2">
                <span>Поддержать проект</span>
                <svg xmlns="http://www.w3.org/2000/svg" fill="none" viewBox="0 0 24 24" stroke-width="2"
                    stroke="currentColor" class="w-4 h-4">
                    <path stroke-linecap="round" stroke-linejoin="round"
                        d="M21 8.25c0-2.485-2.099-4.5-4.688-4.5-1.935 0-3.597 1.126-4.312 2.733-.715-1.607-2.377-2.733-4.313-2.733C5.1 3.75 3 5.765 3 8.25c0 7.22 9 12 9 12s9-4.78 9-12Z" />
                </svg>
            </a>
        </div>
    </div> --}}

    <!-- Tip of the Day Widget -->
    <x-tip-of-the-day />

    <!-- Popular Posts Widget -->
    <x-popular-posts :limit="5" />

</aside>