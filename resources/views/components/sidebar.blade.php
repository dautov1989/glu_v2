<aside class="w-full lg:w-64 flex-shrink-0 space-y-6">

    <!-- Support Us Widget -->
    <div class="relative group">
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
    </div>

    <!-- Tip of the Day Widget -->
    <x-tip-of-the-day />

    <!-- Quick HE Calculator Widget -->
    <div class="relative group" x-data="{ grams: 50, result: 4.2 }"
        x-init="$watch('grams', value => result = (value / 12).toFixed(1))">
        <div
            class="absolute -inset-0.5 bg-gradient-to-r from-cyan-500/20 to-blue-500/20 rounded-xl blur opacity-0 group-hover:opacity-100 transition-opacity duration-300">
        </div>
        <div
            class="relative bg-white dark:bg-zinc-900 rounded-xl border border-cyan-200/50 dark:border-cyan-800/30 p-6 shadow-lg shadow-cyan-200/20 dark:shadow-cyan-900/10">
            <div class="flex items-center gap-2 mb-5">
                <div
                    class="w-8 h-8 bg-gradient-to-br from-cyan-500 to-blue-500 rounded-lg flex items-center justify-center text-white shadow-lg shadow-cyan-500/30">
                    <svg xmlns="http://www.w3.org/2000/svg" fill="none" viewBox="0 0 24 24" stroke-width="2"
                        stroke="currentColor" class="w-5 h-5">
                        <path stroke-linecap="round" stroke-linejoin="round"
                            d="M15.75 15.75V18m-7.5-6.75h.008v.008H8.25v-.008Zm0 2.25h.008v.008H8.25V13.5Zm0 2.25h.008v.008H8.25v-.008Zm0 2.25h.008v.008H8.25V18Zm2.498-6.75h.007v.008h-.007v-.008Zm0 2.25h.007v.008h-.007V13.5Zm0 2.25h.007v.008h-.007v-.008Zm0 2.25h.007v.008h-.007V18Zm2.504-6.75h.008v.008h-.008v-.008Zm0 2.25h.008v.008h-.008V13.5Zm0 2.25h.008v.008h-.008v-.008Zm0 2.25h.008v.008h-.008V18Zm2.498-6.75h.008v.008h-.008v-.008Zm0 2.25h.008v.008h-.008V13.5ZM8.25 6h7.5v2.25h-7.5V6ZM12 2.25c-1.892 0-3.758.11-5.593.322C5.307 2.7 4.5 3.65 4.5 4.757V19.5a2.25 2.25 0 0 0 2.25 2.25h10.5a2.25 2.25 0 0 0 2.25-2.25V4.757c0-1.108-.806-2.057-1.907-2.185A48.507 48.507 0 0 0 12 2.25Z" />
                    </svg>
                </div>
                <h3
                    class="text-sm font-bold bg-gradient-to-r from-cyan-700 to-blue-700 dark:from-cyan-300 dark:to-blue-300 bg-clip-text text-transparent">
                    Калькулятор ХЕ</h3>
            </div>

            <div class="space-y-4">
                <div>
                    <label class="text-xs text-zinc-600 dark:text-zinc-400 mb-2 block">Граммы углеводов:</label>
                    <input type="range" x-model="grams" min="0" max="200" step="5"
                        class="w-full h-2 bg-gradient-to-r from-cyan-200 to-blue-200 dark:from-cyan-900/30 dark:to-blue-900/30 rounded-lg appearance-none cursor-pointer accent-cyan-500">
                    <div class="flex justify-between text-xs text-zinc-500 mt-1">
                        <span>0г</span>
                        <span class="font-semibold text-cyan-600 dark:text-cyan-400" x-text="grams + 'г'"></span>
                        <span>200г</span>
                    </div>
                </div>

                <div
                    class="bg-gradient-to-br from-cyan-50 to-blue-50 dark:from-cyan-950/30 dark:to-blue-950/30 rounded-lg p-4 border border-cyan-200/50 dark:border-cyan-800/30">
                    <div class="text-center">
                        <div class="text-xs text-cyan-700 dark:text-cyan-400 mb-1">Хлебные единицы:</div>
                        <div class="text-3xl font-bold bg-gradient-to-r from-cyan-600 to-blue-600 dark:from-cyan-400 dark:to-blue-400 bg-clip-text text-transparent"
                            x-text="result"></div>
                        <div class="text-xs text-zinc-500 mt-1">ХЕ</div>
                    </div>
                </div>
            </div>
        </div>
    </div>



    <!-- Newsletter Widget (Закомментировано) -->
    <!--
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
    -->

</aside>