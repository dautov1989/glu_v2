<aside class="w-full lg:w-64 flex-shrink-0 space-y-6">

    <!-- Tools & Guides Navigation -->
    <div class="relative group">
        <div
            class="absolute -inset-0.5 bg-gradient-to-r from-cyan-500/20 to-blue-500/20 rounded-xl blur opacity-0 group-hover:opacity-100 transition-opacity duration-300">
        </div>
        <div
            class="relative bg-white dark:bg-zinc-900 rounded-xl border border-cyan-200/50 dark:border-cyan-800/30 p-5 shadow-lg shadow-cyan-200/20 dark:shadow-cyan-900/10">
            <div class="flex items-center gap-2 mb-4">
                <div
                    class="w-8 h-8 bg-gradient-to-br from-cyan-500 to-blue-500 rounded-lg flex items-center justify-center text-white shadow-lg shadow-cyan-500/30">
                    <svg xmlns="http://www.w3.org/2000/svg" fill="none" viewBox="0 0 24 24" stroke-width="2"
                        stroke="currentColor" class="w-5 h-5">
                        <path stroke-linecap="round" stroke-linejoin="round"
                            d="M11.423 20.407a2.25 2.25 0 0 1-2.09-1.354l-.872-2.132a2.25 2.25 0 0 0-2.09-1.354H4.5a2.25 2.25 0 0 1-2.25-2.25V6.75A2.25 2.25 0 0 1 4.5 4.5h15a2.25 2.25 0 0 1 2.25 2.25v7.5a2.25 2.25 0 0 1-2.25 2.25h-1.871a2.25 2.25 0 0 0-2.09 1.354l-.872 2.132a2.25 2.25 0 0 1-2.09 1.354H11.423Z" />
                    </svg>
                </div>
                <h3
                    class="text-sm font-bold bg-gradient-to-r from-cyan-700 to-blue-700 dark:from-cyan-300 dark:to-blue-300 bg-clip-text text-transparent uppercase tracking-wider">
                    Инструменты</h3>
            </div>

            <div class="space-y-2">
                <!-- Можно ли при диабете -->
                <a href="{{ route('tools.can-i-eat') }}"
                    class="group/link flex items-center gap-3 p-3 rounded-lg border border-transparent hover:border-cyan-200/50 dark:hover:border-cyan-800/30 hover:bg-cyan-50/50 dark:hover:bg-cyan-900/20 transition-all duration-300 @if(request()->routeIs('tools.can-i-eat')) bg-cyan-50/80 dark:bg-cyan-900/40 border-cyan-200/50 dark:border-cyan-800/30 @endif">
                    <div
                        class="w-8 h-8 rounded-full bg-emerald-100 dark:bg-emerald-900/30 flex items-center justify-center text-emerald-600 dark:text-emerald-400 group-hover/link:scale-110 transition-transform">
                        <span class="text-sm">✅</span>
                    </div>
                    <div>
                        <div class="text-xs font-bold text-zinc-800 dark:text-zinc-200">Можно ли при диабете?</div>
                        <div class="text-[10px] text-zinc-500 dark:text-zinc-400">Гид по продуктам</div>
                    </div>
                </a>

                <!-- Калькулятор инсулина -->
                <a href="{{ route('tools.insulin-calculator') }}"
                    class="group/link flex items-center gap-3 p-3 rounded-lg border border-transparent hover:border-cyan-200/50 dark:hover:border-cyan-800/30 hover:bg-cyan-50/50 dark:hover:bg-cyan-900/20 transition-all duration-300 @if(request()->routeIs('tools.insulin-calculator')) bg-cyan-50/80 dark:bg-cyan-900/40 border-cyan-200/50 dark:border-cyan-800/30 @endif">
                    <div
                        class="w-8 h-8 rounded-full bg-cyan-100 dark:bg-cyan-900/30 flex items-center justify-center text-cyan-600 dark:text-cyan-400 group-hover/link:scale-110 transition-transform">
                        <span class="text-xs">💉</span>
                    </div>
                    <div>
                        <div class="text-xs font-bold text-zinc-800 dark:text-zinc-200">Калькулятор инсулина</div>
                        <div class="text-[10px] text-zinc-500 dark:text-zinc-400">Расчет дозы на еду</div>
                    </div>
                </a>

                <!-- База знаний (FAQ) -->
                <a href="{{ route('tools.faq') }}"
                    class="group/link flex items-center gap-3 p-3 rounded-lg border border-transparent hover:border-cyan-200/50 dark:hover:border-cyan-800/30 hover:bg-cyan-50/50 dark:hover:bg-cyan-900/20 transition-all duration-300 @if(request()->routeIs('tools.faq')) bg-cyan-50/80 dark:bg-cyan-900/40 border-cyan-200/50 dark:border-cyan-800/30 @endif">
                    <div
                        class="w-8 h-8 rounded-full bg-amber-100 dark:bg-amber-900/30 flex items-center justify-center text-amber-600 dark:text-amber-400 group-hover/link:scale-110 transition-transform">
                        <span class="text-xs">📈</span>
                    </div>
                    <div>
                        <div class="text-xs font-bold text-zinc-800 dark:text-zinc-200">База знаний (FAQ)</div>
                        <div class="text-[10px] text-zinc-500 dark:text-zinc-400">Ответы на вопросы</div>
                    </div>
                </a>
            </div>
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