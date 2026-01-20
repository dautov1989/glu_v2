<!-- History Modal -->
<div x-show="showHistoryModal" x-cloak @keydown.escape.window="showHistoryModal = false"
    class="fixed inset-0 z-50 overflow-y-auto" style="display: none;">

    <!-- Backdrop -->
    <div class="fixed inset-0 bg-black/50 backdrop-blur-sm transition-opacity" x-show="showHistoryModal"
        x-transition:enter="ease-out duration-300" x-transition:enter-start="opacity-0"
        x-transition:enter-end="opacity-100" x-transition:leave="ease-in duration-200"
        x-transition:leave-start="opacity-100" x-transition:leave-end="opacity-0" @click="showHistoryModal = false">
    </div>

    <!-- Modal Content -->
    <div class="flex min-h-screen items-center justify-center p-4">
        <div class="relative w-full max-w-4xl bg-white dark:bg-zinc-800 rounded-2xl shadow-2xl border border-cyan-200/50 dark:border-cyan-800/30"
            x-show="showHistoryModal" x-transition:enter="ease-out duration-300"
            x-transition:enter-start="opacity-0 scale-95" x-transition:enter-end="opacity-100 scale-100"
            x-transition:leave="ease-in duration-200" x-transition:leave-start="opacity-100 scale-100"
            x-transition:leave-end="opacity-0 scale-95" @click.stop>

            <!-- Header -->
            <div class="flex items-center justify-between p-6 border-b border-cyan-200/50 dark:border-cyan-800/30">
                <h2 class="text-2xl font-bold text-zinc-800 dark:text-zinc-200 flex items-center gap-3">
                    <svg xmlns="http://www.w3.org/2000/svg" fill="none" viewBox="0 0 24 24" stroke-width="2"
                        stroke="currentColor" class="w-7 h-7 text-cyan-500">
                        <path stroke-linecap="round" stroke-linejoin="round"
                            d="M12 6v6h4.5m4.5 0a9 9 0 1 1-18 0 9 9 0 0 1 18 0Z" />
                    </svg>
                    <span>История расчётов</span>
                </h2>
                <button @click="showHistoryModal = false"
                    class="text-zinc-400 hover:text-zinc-600 dark:hover:text-zinc-200 transition-colors p-2 hover:bg-zinc-100 dark:hover:bg-zinc-700 rounded-lg">
                    <svg xmlns="http://www.w3.org/2000/svg" fill="none" viewBox="0 0 24 24" stroke-width="2"
                        stroke="currentColor" class="w-6 h-6">
                        <path stroke-linecap="round" stroke-linejoin="round" d="M6 18 18 6M6 6l12 12" />
                    </svg>
                </button>
            </div>

            <!-- Content -->
            <div class="p-6">
                <!-- Actions Bar -->
                <div class="flex flex-col sm:flex-row items-center justify-between gap-4 mb-4">
                    <div class="text-sm text-zinc-600 dark:text-zinc-400">
                        Всего записей: <span class="font-bold text-cyan-600 dark:text-cyan-400"
                            x-text="history.length"></span>
                    </div>

                    <div class="flex items-center gap-2">
                        <!-- Export Button -->
                        <button @click="exportToCSV()" x-show="history.length > 0"
                            class="px-4 py-2 bg-emerald-500 hover:bg-emerald-600 text-white text-sm font-semibold rounded-lg transition-all duration-200 hover:scale-105 active:scale-95 flex items-center gap-2">
                            <svg xmlns="http://www.w3.org/2000/svg" fill="none" viewBox="0 0 24 24" stroke-width="2"
                                stroke="currentColor" class="w-4 h-4">
                                <path stroke-linecap="round" stroke-linejoin="round"
                                    d="M3 16.5v2.25A2.25 2.25 0 0 0 5.25 21h13.5A2.25 2.25 0 0 0 21 18.75V16.5M16.5 12 12 16.5m0 0L7.5 12m4.5 4.5V3" />
                            </svg>
                            Скачать Excel
                        </button>

                        <!-- Clear Button -->
                        <button @click="clearHistory()" x-show="history.length > 0"
                            class="px-4 py-2 bg-red-500 hover:bg-red-600 text-white text-sm font-semibold rounded-lg transition-all duration-200 hover:scale-105 active:scale-95 flex items-center gap-2">
                            <svg xmlns="http://www.w3.org/2000/svg" fill="none" viewBox="0 0 24 24" stroke-width="2"
                                stroke="currentColor" class="w-4 h-4">
                                <path stroke-linecap="round" stroke-linejoin="round"
                                    d="m14.74 9-.346 9m-4.788 0L9.26 9m9.968-3.21c.342.052.682.107 1.022.166m-1.022-.165L18.16 19.673a2.25 2.25 0 0 1-2.244 2.077H8.084a2.25 2.25 0 0 1-2.244-2.077L4.772 5.79m14.456 0a48.108 48.108 0 0 0-3.478-.397m-12 .562c.34-.059.68-.114 1.022-.165m0 0a48.11 48.11 0 0 1 3.478-.397m7.5 0v-.916c0-1.18-.91-2.164-2.09-2.201a51.964 51.964 0 0 0-3.32 0c-1.18.037-2.09 1.022-2.09 2.201v.916m7.5 0a48.667 48.667 0 0 0-7.5 0" />
                            </svg>
                            Очистить всё
                        </button>
                    </div>
                </div>

                <!-- History List -->
                <div class="max-h-[500px] overflow-y-auto custom-scrollbar">
                    <!-- No History Message -->
                    <div x-show="history.length === 0" class="text-center py-12">
                        <svg xmlns="http://www.w3.org/2000/svg" fill="none" viewBox="0 0 24 24" stroke-width="1.5"
                            stroke="currentColor" class="w-16 h-16 mx-auto text-zinc-300 dark:text-zinc-600 mb-4">
                            <path stroke-linecap="round" stroke-linejoin="round"
                                d="M20.25 7.5l-.625 10.632a2.25 2.25 0 01-2.247 2.118H6.622a2.25 2.25 0 01-2.247-2.118L3.75 7.5M10 11.25h4M3.375 7.5h17.25c.621 0 1.125-.504 1.125-1.125v-1.5c0-.621-.504-1.125-1.125-1.125H3.375c-.621 0-1.125.504-1.125 1.125v1.5c0 .621.504 1.125 1.125 1.125z" />
                        </svg>
                        <p class="text-zinc-500 dark:text-zinc-400 text-lg">История пуста</p>
                        <p class="text-zinc-400 dark:text-zinc-500 text-sm mt-2">Начните делать расчёты, и они появятся
                            здесь</p>
                    </div>

                    <!-- History Items -->
                    <div class="space-y-3">
                        <template x-for="entry in history" :key="entry.id">
                            <div
                                class="bg-gradient-to-br from-zinc-50 to-cyan-50/30 dark:from-zinc-900 dark:to-cyan-900/10 rounded-xl border border-cyan-200/50 dark:border-cyan-800/30 p-4 hover:shadow-md transition-shadow">
                                <div class="flex items-start justify-between gap-4">
                                    <!-- Main Info -->
                                    <div class="flex-1 grid grid-cols-1 md:grid-cols-2 gap-4">
                                        <!-- Left Column -->
                                        <div>
                                            <div class="flex items-center gap-2 mb-3">
                                                <svg xmlns="http://www.w3.org/2000/svg" fill="none" viewBox="0 0 24 24"
                                                    stroke-width="2" stroke="currentColor"
                                                    class="w-4 h-4 text-cyan-500">
                                                    <path stroke-linecap="round" stroke-linejoin="round"
                                                        d="M6.75 3v2.25M17.25 3v2.25M3 18.75V7.5a2.25 2.25 0 0 1 2.25-2.25h13.5A2.25 2.25 0 0 1 21 7.5v11.25m-18 0A2.25 2.25 0 0 0 5.25 21h13.5A2.25 2.25 0 0 0 21 18.75m-18 0v-7.5A2.25 2.25 0 0 1 5.25 9h13.5A2.25 2.25 0 0 1 21 11.25v7.5" />
                                                </svg>
                                                <span class="text-xs font-semibold text-zinc-500 dark:text-zinc-400"
                                                    x-text="new Date(entry.timestamp).toLocaleString('ru-RU', { 
                                                          day: '2-digit', 
                                                          month: '2-digit', 
                                                          year: 'numeric',
                                                          hour: '2-digit', 
                                                          minute: '2-digit' 
                                                      })">
                                                </span>
                                            </div>

                                            <div class="space-y-2">
                                                <div class="flex items-center justify-between text-sm">
                                                    <span class="text-zinc-600 dark:text-zinc-400">🍞 Углеводы:</span>
                                                    <span class="font-bold text-zinc-800 dark:text-zinc-200"
                                                        x-text="entry.carbs + ' г'"></span>
                                                </div>
                                                <div class="flex items-center justify-between text-sm">
                                                    <span class="text-zinc-600 dark:text-zinc-400">🩸 Глюкоза:</span>
                                                    <span class="font-bold" :class="{
                                                              'text-red-600 dark:text-red-400': entry.glucose > 10,
                                                              'text-orange-600 dark:text-orange-400': entry.glucose > 7 && entry.glucose <= 10,
                                                              'text-green-600 dark:text-green-400': entry.glucose >= 4 && entry.glucose <= 7,
                                                              'text-blue-600 dark:text-blue-400': entry.glucose < 4
                                                          }" x-text="entry.glucose.toFixed(1) + ' ммоль/л'">
                                                    </span>
                                                </div>
                                                <div class="flex items-center justify-between text-sm">
                                                    <span class="text-zinc-600 dark:text-zinc-400">💧 Активный:</span>
                                                    <span class="font-bold text-zinc-800 dark:text-zinc-200"
                                                        x-text="entry.activeInsulin.toFixed(1) + ' ед'"></span>
                                                </div>
                                            </div>
                                        </div>

                                        <!-- Right Column -->
                                        <div class="flex flex-col justify-between">
                                            <div
                                                class="bg-gradient-to-br from-cyan-500 to-blue-500 rounded-lg p-3 text-white mb-3">
                                                <div class="text-xs font-semibold opacity-90 mb-1">Итоговая доза</div>
                                                <div class="text-3xl font-bold" x-text="entry.total.toFixed(1) + ' ед'">
                                                </div>
                                            </div>

                                            <div class="space-y-1 text-xs">
                                                <div class="flex items-center justify-between">
                                                    <span class="text-zinc-500 dark:text-zinc-500">На еду:</span>
                                                    <span class="font-semibold text-zinc-700 dark:text-zinc-300"
                                                        x-text="entry.foodDose.toFixed(1) + ' ед'"></span>
                                                </div>
                                                <div class="flex items-center justify-between">
                                                    <span class="text-zinc-500 dark:text-zinc-500">На коррекцию:</span>
                                                    <span class="font-semibold text-zinc-700 dark:text-zinc-300"
                                                        x-text="entry.correctionDose.toFixed(1) + ' ед'"></span>
                                                </div>
                                            </div>
                                        </div>
                                    </div>

                                    <!-- Delete Button -->
                                    <button @click="deleteEntry(entry.id)"
                                        class="flex-shrink-0 text-red-400 hover:text-red-600 dark:hover:text-red-300 transition-colors p-2 hover:bg-red-50 dark:hover:bg-red-900/20 rounded-lg"
                                        title="Удалить запись">
                                        <svg xmlns="http://www.w3.org/2000/svg" fill="none" viewBox="0 0 24 24"
                                            stroke-width="2" stroke="currentColor" class="w-5 h-5">
                                            <path stroke-linecap="round" stroke-linejoin="round"
                                                d="M6 18 18 6M6 6l12 12" />
                                        </svg>
                                    </button>
                                </div>
                            </div>
                        </template>
                    </div>
                </div>
            </div>

            <!-- Footer -->
            <div
                class="p-6 border-t border-cyan-200/50 dark:border-cyan-800/30 bg-zinc-50 dark:bg-zinc-900/50 rounded-b-2xl">
                <div class="flex items-center gap-2 text-xs text-zinc-500 dark:text-zinc-400">
                    <svg xmlns="http://www.w3.org/2000/svg" fill="none" viewBox="0 0 24 24" stroke-width="2"
                        stroke="currentColor" class="w-4 h-4">
                        <path stroke-linecap="round" stroke-linejoin="round"
                            d="m11.25 11.25.041-.02a.75.75 0 0 1 1.063.852l-.708 2.836a.75.75 0 0 0 1.063.853l.041-.021M21 12a9 9 0 1 1-18 0 9 9 0 0 1 18 0Zm-9-3.75h.008v.008H12V8.25Z" />
                    </svg>
                    <span>Данные хранятся локально в вашем браузере. История ограничена 100 записями.</span>
                </div>
            </div>
        </div>
    </div>
</div>