<!-- Action Buttons -->
<div class="flex flex-col sm:flex-row items-center justify-center gap-3 mb-4">
    <!-- Calculate Button -->
    <button @click="calculate()" :disabled="isLoading" :class="{'opacity-75 cursor-wait scale-95': isLoading}"
        class="w-full sm:w-auto px-8 py-4 bg-gradient-to-r from-cyan-500 to-blue-500 hover:from-cyan-600 hover:to-blue-600 text-white font-bold rounded-xl shadow-lg shadow-cyan-500/40 hover:shadow-cyan-500/60 transition-all duration-300 hover:scale-105 active:scale-95 flex items-center justify-center gap-3">

        <!-- Loading Spinner -->
        <svg x-show="isLoading" x-cloak class="animate-spin h-5 w-5 text-white" xmlns="http://www.w3.org/2000/svg"
            fill="none" viewBox="0 0 24 24">
            <circle class="opacity-25" cx="12" cy="12" r="10" stroke="currentColor" stroke-width="4"></circle>
            <path class="opacity-75" fill="currentColor"
                d="M4 12a8 8 0 018-8V0C5.373 0 0 5.373 0 12h4zm2 5.291A7.962 7.962 0 014 12H0c0 3.042 1.135 5.824 3 7.938l3-2.647z">
            </path>
        </svg>

        <!-- Default Icon -->
        <svg x-show="!isLoading" xmlns="http://www.w3.org/2000/svg" fill="none" viewBox="0 0 24 24" stroke-width="2"
            stroke="currentColor" class="w-5 h-5">
            <path stroke-linecap="round" stroke-linejoin="round"
                d="M15.75 15.75V18m-7.5-6.75h.008v.008H8.25v-.008Zm0 2.25h.008v.008H8.25V13.5Zm0 2.25h.008v.008H8.25v-.008Zm0 2.25h.008v.008H8.25V18Zm2.498-6.75h.007v.008h-.007v-.008Zm0 2.25h.007v.008h-.007V13.5Zm0 2.25h.007v.008h-.007v-.008Zm0 2.25h.007v.008h-.007V18Zm2.504-6.75h.008v.008h-.008v-.008Zm0 2.25h.008v.008h-.008V13.5Zm0 2.25h.008v.008h-.008v-.008Zm0 2.25h.008v.008h-.008V18Zm2.498-6.75h.008v.008h-.008v-.008Zm0 2.25h.008v.008h-.008V13.5ZM8.25 6h7.5v2.25h-7.5V6ZM12 2.25c-1.892 0-3.758.11-5.593.322C5.307 2.7 4.5 3.65 4.5 4.757V19.5a2.25 2.25 0 0 0 2.25 2.25h10.5a2.25 2.25 0 0 0 2.25-2.25V4.757c0-1.108-.806-2.057-1.907-2.185A48.507 48.507 0 0 0 12 2.25Z" />
        </svg>

        <span x-text="isLoading ? 'Считаем...' : 'Рассчитать дозу'"></span>
    </button>

    <!-- History Button -->
    <button @click="showHistoryModal = true" x-show="history.length > 0 && !isLoading" x-cloak
        x-transition:enter="transition ease-out duration-300" x-transition:enter-start="opacity-0 scale-95"
        x-transition:enter-end="opacity-100 scale-100"
        class="w-full sm:w-auto px-6 py-4 bg-gradient-to-r from-purple-500 to-indigo-500 hover:from-purple-600 hover:to-indigo-600 text-white font-bold rounded-xl shadow-lg shadow-purple-500/40 hover:shadow-purple-500/60 transition-all duration-300 hover:scale-105 active:scale-95 flex items-center justify-center gap-2 relative">
        <svg xmlns="http://www.w3.org/2000/svg" fill="none" viewBox="0 0 24 24" stroke-width="2" stroke="currentColor"
            class="w-5 h-5">
            <path stroke-linecap="round" stroke-linejoin="round" d="M12 6v6h4.5m4.5 0a9 9 0 1 1-18 0 9 9 0 0 1 18 0Z" />
        </svg>
        <span>История</span>
        <span x-show="history.length > 0" x-text="history.length"
            class="absolute -top-2 -right-2 bg-red-500 text-white text-xs font-bold rounded-full w-6 h-6 flex items-center justify-center shadow-lg">
        </span>
    </button>
</div>

<!-- Warning Message -->
<div id="calculator-warning" x-show="warning" x-cloak x-transition:enter="transition ease-out duration-300"
    x-transition:enter-start="opacity-0 scale-95" x-transition:enter-end="opacity-100 scale-100"
    class="bg-red-50 dark:bg-red-900/20 border-2 border-red-300 dark:border-red-700 rounded-xl p-4 mb-6 scroll-mt-24">
    <p class="text-red-800 dark:text-red-300 font-semibold text-center" x-text="warning"></p>
</div>

<!-- Result Section Wrapper -->
<div id="result-section" class="scroll-mt-24">
    <!-- Thinking/Loading State -->
    <div x-show="isLoading" x-cloak x-transition:enter="transition ease-out duration-300"
        x-transition:enter-start="opacity-0 scale-95" x-transition:enter-end="opacity-100 scale-100"
        class="bg-white dark:bg-zinc-800 rounded-xl border-2 border-dashed border-cyan-300 dark:border-cyan-700 p-8 shadow-xl flex flex-col items-center justify-center space-y-4 mb-6">
        <div class="relative">
            <div
                class="w-16 h-16 border-4 border-cyan-100 dark:border-cyan-900 border-t-cyan-500 rounded-full animate-spin">
            </div>
            <div class="absolute inset-0 flex items-center justify-center">
                <svg class="w-6 h-6 text-cyan-500 animate-pulse" fill="none" stroke="currentColor" viewBox="0 0 24 24"
                    xmlns="http://www.w3.org/2000/svg">
                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
                        d="M13 10V3L4 14h7v7l9-11h-7z">
                    </path>
                </svg>
            </div>
        </div>
        <div class="text-center">
            <h3 class="text-lg font-bold text-zinc-800 dark:text-zinc-200">Анализируем данные...</h3>
            <p class="text-sm text-zinc-500 dark:text-zinc-400">Система рассчитывает вашу дозировку</p>
        </div>
    </div>

    <!-- Result Display -->
    <div x-show="result && !isLoading" x-cloak x-transition:enter="transition ease-out duration-500"
        x-transition:enter-start="opacity-0 translate-y-4" x-transition:enter-end="opacity-100 translate-y-0"
        class="bg-white dark:bg-zinc-800 rounded-xl border-2 border-cyan-300 dark:border-cyan-700 p-6 shadow-xl mb-6">

        <div class="grid grid-cols-1 lg:grid-cols-2 gap-6 mb-6">
            <div class="text-sm font-bold text-zinc-700 dark:text-zinc-300 uppercase tracking-wide">
                📊 Итоговая доза:
            </div>
            <div class="text-sm font-bold text-zinc-700 dark:text-zinc-300 uppercase tracking-wide hidden lg:block">
                📊 Расшифровка:
            </div>
        </div>

        <div class="grid grid-cols-1 lg:grid-cols-2 gap-6 mb-6">
            <!-- Main Result -->
            <div
                class="flex flex-col justify-center items-center border-b lg:border-b-0 lg:border-r border-cyan-200/50 dark:border-cyan-800/30 pb-6 lg:pb-0 lg:pr-6">
                <div
                    class="text-6xl md:text-7xl font-bold bg-gradient-to-r from-cyan-600 to-blue-600 dark:from-cyan-400 dark:to-blue-400 bg-clip-text text-transparent mb-3">
                    <span x-text="result ? result.total : '0'"></span> <span class="text-4xl">ед</span>
                </div>

                <div x-show="result && result.total == 0"
                    class="bg-blue-50 dark:bg-blue-900/20 border border-blue-200 dark:border-blue-800/30 rounded-lg p-3 w-full">
                    <p class="text-sm text-blue-800 dark:text-blue-300 text-center">
                        ℹ️ Инсулин не требуется. Текущие показатели в норме.
                    </p>
                </div>
            </div>

            <!-- Breakdown -->
            <div class="space-y-3">
                <div class="flex items-center justify-between bg-zinc-50 dark:bg-zinc-900 rounded-lg p-3">
                    <span class="text-sm text-zinc-600 dark:text-zinc-400">🍞 На еду:</span>
                    <span class="text-sm font-bold text-zinc-800 dark:text-zinc-200">
                        <span x-text="result ? result.foodDose : '0.0'"></span> ед
                    </span>
                </div>

                <div class="flex items-center justify-between bg-zinc-50 dark:bg-zinc-900 rounded-lg p-3">
                    <span class="text-sm text-zinc-600 dark:text-zinc-400">📈 На коррекцию:</span>
                    <span class="text-sm font-bold text-zinc-800 dark:text-zinc-200">
                        <span x-text="result ? result.correctionDose : '0.0'"></span> ед
                    </span>
                </div>
            </div>
        </div>

        <!-- Disclaimer -->
        <div class="bg-amber-50 dark:bg-amber-900/10 border border-amber-200 dark:border-amber-800/30 rounded-lg p-4">
            <div class="flex items-start gap-2">
                <svg xmlns="http://www.w3.org/2000/svg" fill="none" viewBox="0 0 24 24" stroke-width="2"
                    stroke="currentColor" class="w-5 h-5 text-amber-600 dark:text-amber-400 flex-shrink-0 mt-0.5">
                    <path stroke-linecap="round" stroke-linejoin="round"
                        d="M12 9v3.75m-9.303 3.376c-.866 1.5.217 3.374 1.948 3.374h14.71c1.73 0 2.813-1.874 1.948-3.374L13.949 3.378c-.866-1.5-3.032-1.5-3.898 0L2.697 16.126ZM12 15.75h.007v.008H12v-.008Z" />
                </svg>
                <p class="text-xs text-amber-800 dark:text-amber-300 leading-relaxed">
                    <strong>Важно:</strong> Расчёт является ориентировочным и не заменяет рекомендации врача.
                    Используйте только в ознакомительных целях. Всегда консультируйтесь с вашим эндокринологом
                    перед изменением дозировки инсулина.
                </p>
            </div>
        </div>
    </div>
</div>