<!-- Modal Window with Carbs Table -->
<div x-show="showCarbsTable" x-cloak @click.self="showCarbsTable = false"
    class="fixed inset-0 z-50 flex items-center justify-center p-4 bg-black/50 backdrop-blur-sm"
    x-transition:enter="transition ease-out duration-300" x-transition:enter-start="opacity-0"
    x-transition:enter-end="opacity-100" x-transition:leave="transition ease-in duration-200"
    x-transition:leave-start="opacity-100" x-transition:leave-end="opacity-0">

    <div @click.stop
        class="bg-white dark:bg-zinc-800 rounded-2xl shadow-2xl max-w-5xl w-[95vw] md:w-full max-h-[95vh] overflow-hidden border-2 border-cyan-300 dark:border-cyan-700"
        x-transition:enter="transition ease-out duration-300" x-transition:enter-start="opacity-0 scale-95"
        x-transition:enter-end="opacity-100 scale-100" x-transition:leave="transition ease-in duration-200"
        x-transition:leave-start="opacity-100 scale-100" x-transition:leave-end="opacity-0 scale-95">

        <!-- Header with Calculator Info -->
        <div class="bg-gradient-to-r from-cyan-500 to-blue-500 sticky top-0 z-10 shadow-md">
            <!-- Top Bar -->
            <div class="p-4 md:p-6 flex items-center justify-between border-b border-white/10">
                <div class="flex items-center gap-3 md:gap-4 text-white">
                    <div
                        class="hidden md:flex w-10 h-10 bg-white/20 rounded-lg items-center justify-center backdrop-blur-sm">
                        <svg xmlns="http://www.w3.org/2000/svg" fill="none" viewBox="0 0 24 24" stroke-width="2.5"
                            stroke="currentColor" class="w-6 h-6">
                            <path stroke-linecap="round" stroke-linejoin="round"
                                d="M15.75 10.5V6a3.75 3.75 0 10-7.5 0v4.5m11.356-1.993l1.263 12c.07.665-.45 1.243-1.119 1.243H4.25a1.125 1.125 0 01-1.12-1.243l1.264-12A1.125 1.125 0 015.513 7.5h12.974c.576 0 1.059.435 1.119 1.007z" />
                        </svg>
                    </div>
                    <div>
                        <h3 class="font-bold text-lg md:text-xl">Справочник углеводов</h3>
                        <div class="flex items-center gap-2 mt-1">
                            <span class="bg-white/20 px-2 py-0.5 rounded text-[10px] md:text-xs font-bold"
                                x-text="modalItemCount + ' шт'"></span>
                            <span class="bg-white/30 px-2 py-0.5 rounded text-[11px] md:text-sm font-bold"
                                x-text="modalTotalCarbs + ' г'"></span>
                        </div>
                    </div>
                </div>

                <div class="flex items-center gap-2">
                    <button @click="applyCarbs()" :disabled="modalTotalCarbs == 0"
                        class="bg-white text-cyan-600 hover:bg-zinc-50 font-bold py-2 px-4 rounded-xl shadow-lg transition-all active:scale-95 flex items-center gap-2 text-sm md:text-base disabled:opacity-50 disabled:translate-y-0 translate-y-0">
                        <span>Добавить</span>
                        <svg xmlns="http://www.w3.org/2000/svg" fill="none" viewBox="0 0 24 24" stroke-width="3"
                            stroke="currentColor" class="w-4 h-4">
                            <path stroke-linecap="round" stroke-linejoin="round" d="M12 4.5v15m7.5-7.5h-15" />
                        </svg>
                    </button>
                    <button @click="showCarbsTable = false"
                        class="w-10 h-10 text-white/80 hover:text-white hover:bg-white/10 rounded-lg flex items-center justify-center transition-all">
                        <svg xmlns="http://www.w3.org/2000/svg" fill="none" viewBox="0 0 24 24" stroke-width="2.5"
                            stroke="currentColor" class="w-6 h-6">
                            <path stroke-linecap="round" stroke-linejoin="round" d="M6 18L18 6M6 6l12 12" />
                        </svg>
                    </button>
                </div>
            </div>

            <!-- Selected Items List (The new row) -->
            <div x-show="selectedItems.length > 0" x-cloak x-transition
                class="bg-black/10 backdrop-blur-sm border-t border-white/10 p-2 md:p-3 flex gap-2 overflow-x-scroll scroll-smooth custom-scrollbar-horizontal">
                <template x-for="item in selectedItems" :key="item.id">
                    <div
                        class="flex-shrink-0 flex items-center gap-2 bg-white/10 hover:bg-white/20 border border-white/10 rounded-full pl-3 pr-1 py-1 transition-all group cursor-default">
                        <span class="text-xs font-medium text-white/90" x-text="item.name"></span>
                        <span class="text-[10px] font-bold bg-white/20 text-white px-1.5 rounded py-0.5"
                            x-text="item.carbs + 'г'"></span>
                        <button @click="removeItem(item.id)"
                            class="w-5 h-5 flex items-center justify-center rounded-full hover:bg-red-500/50 text-white/50 hover:text-white transition-colors">
                            <svg xmlns="http://www.w3.org/2000/svg" fill="none" viewBox="0 0 24 24" stroke-width="3"
                                stroke="currentColor" class="w-3 h-3">
                                <path stroke-linecap="round" stroke-linejoin="round" d="M6 18L18 6M6 6l12 12" />
                            </svg>
                        </button>
                    </div>
                </template>
            </div>
        </div>

        <!-- Dynamic Content -->
        <div
            class="p-4 md:p-6 overflow-y-scroll max-h-[70vh] md:max-h-[75vh] bg-zinc-50/50 dark:bg-zinc-900/50 custom-scrollbar">
            <div class="grid grid-cols-1 md:grid-cols-3 gap-6">
                <template x-for="category in foodCategories" :key="category.name">
                    <div>
                        <h4
                            class="text-lg font-bold text-zinc-800 dark:text-zinc-100 mb-3 flex items-center gap-2 bg-zinc-50/95 dark:bg-zinc-900/95 py-2 backdrop-blur-sm">
                            <span class="w-1 h-6 rounded-full" :class="category.color"></span>
                            <span x-text="category.icon + ' ' + category.name"></span>
                        </h4>
                        <div class="space-y-2">
                            <template x-for="item in category.items" :key="item.name">
                                <button @click="addCarbsToModal(item)"
                                    :class="selectedItems.some(i => i.name === item.name) 
                                        ? 'bg-rose-50 dark:bg-rose-900/20 border-rose-300 dark:border-rose-700 shadow-sm ring-1 ring-rose-500/20' 
                                        : 'bg-white dark:bg-zinc-800 border-zinc-200 dark:border-zinc-700/50 hover:border-cyan-300 dark:hover:border-cyan-600'"
                                    class="w-full flex justify-between items-center p-3 rounded-xl transition-all group text-left shadow-sm hover:shadow-md active:scale-[0.98] outline-none focus:ring-2 focus:ring-cyan-500/50 cursor-pointer border-2">

                                    <div class="flex flex-col">
                                        <span class="text-sm font-medium transition-colors"
                                            :class="selectedItems.some(i => i.name === item.name) ? 'text-rose-700 dark:text-rose-300' : 'text-zinc-700 dark:text-zinc-300 group-hover:text-cyan-800 dark:group-hover:text-cyan-200'"
                                            x-text="item.name"></span>
                                    </div>

                                    <div class="flex items-center gap-2">
                                        <!-- Checkmark for selected -->
                                        <div x-show="selectedItems.some(i => i.name === item.name)" x-transition
                                            class="w-5 h-5 bg-rose-500 rounded-full flex items-center justify-center">
                                            <svg xmlns="http://www.w3.org/2000/svg" fill="none" viewBox="0 0 24 24"
                                                stroke-width="3" stroke="currentColor" class="w-3 h-3 text-white">
                                                <path stroke-linecap="round" stroke-linejoin="round"
                                                    d="m4.5 12.75 6 6 9-13.5" />
                                            </svg>
                                        </div>
                                        <span class="text-xs font-bold transition-all transform"
                                            :class="selectedItems.some(i => i.name === item.name) ? 'text-rose-600 dark:text-rose-400 bg-rose-100 dark:bg-rose-900/40 px-2 py-0.5 rounded-md' : 'text-cyan-600 dark:text-cyan-400 bg-cyan-50 dark:bg-cyan-900/30 px-2 py-0.5 rounded-md group-hover:scale-105'"
                                            x-text="item.carbs + 'г'"></span>
                                    </div>
                                </button>
                            </template>
                        </div>
                    </div>
                </template>
            </div>

            <!-- Footer Note -->
            <div
                class="mt-8 p-4 bg-amber-50 dark:bg-amber-900/10 border border-amber-200 dark:border-amber-800/30 rounded-lg">
                <div class="text-xs text-amber-800 dark:text-amber-300 leading-relaxed flex gap-2">
                    <span class="text-lg">💡</span>
                    <span>
                        <strong>Совет:</strong> Нажимайте на продукты, чтобы добавить их углеводы в общую сумму.
                        Когда закончите, нажмите кнопку <strong>"Добавить"</strong> сверху, чтобы перенести
                        результат в калькулятор.
                    </span>
                </div>
            </div>
        </div>
    </div>
</div>