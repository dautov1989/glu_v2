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

        <!-- Header Section -->
        <div class="bg-gradient-to-r from-cyan-500 to-blue-500 sticky top-0 z-10 shadow-md">
            <!-- Top Bar -->
            <div class="p-3 md:p-5 border-b border-white/10">
                <div class="flex flex-wrap items-center justify-between gap-3 md:gap-4">

                    <!-- Info Badges (Styled like buttons for symmetry) -->
                    <div class="flex flex-1 items-center gap-2 md:gap-3">
                        <!-- Items Count Badge -->
                        <div
                            class="flex-1 md:flex-none h-[48px] md:h-[52px] inline-flex items-center bg-white/10 rounded-2xl px-4 md:px-6 border border-white/20 backdrop-blur-md shadow-lg">
                            <div
                                class="flex flex-col items-center md:flex-row md:items-center w-full justify-center md:justify-start">
                                <span
                                    class="text-[9px] font-black text-white uppercase tracking-widest md:mr-3">Кол-во</span>
                                <span class="flex items-center gap-1">
                                    <span class="text-sm md:text-lg font-black text-white tracking-tight"
                                        x-text="modalItemCount"></span>
                                    <span class="text-[10px] font-black text-white">шт</span>
                                </span>
                            </div>
                        </div>

                        <!-- Total Carbs Badge -->
                        <div
                            class="flex-1 md:flex-none h-[48px] md:h-[52px] inline-flex items-center bg-white/20 rounded-2xl px-4 md:px-6 border border-white/30 backdrop-blur-md shadow-xl ring-1 ring-white/10">
                            <div
                                class="flex flex-col items-center md:flex-row md:items-center w-full justify-center md:justify-start">
                                <span
                                    class="text-[9px] font-black text-white uppercase tracking-widest md:mr-3">Углеводы</span>
                                <span class="flex items-center gap-1">
                                    <span class="text-sm md:text-xl font-black text-white tracking-tight"
                                        x-text="modalTotalCarbs"></span>
                                    <span class="text-[10px] font-black text-white">г</span>
                                </span>
                            </div>
                        </div>
                    </div>

                    <!-- Action Buttons Section -->
                    <div
                        class="flex items-center gap-2 w-full md:w-auto bg-black/10 md:bg-transparent p-2 md:p-0 rounded-2xl">
                        <!-- Add Button -->
                        <button @click="applyCarbs()" :disabled="modalTotalCarbs == 0"
                            class="flex-1 md:flex-none h-[48px] md:h-[52px] bg-blue-600 text-white font-extrabold px-8 md:px-12 rounded-2xl shadow-[0_20px_40px_-10px_rgba(37,99,235,0.6)] hover:shadow-[0_20px_50px_-10px_rgba(37,99,235,0.8)] transition-all active:scale-95 flex items-center justify-center gap-3 disabled:bg-blue-400/50 disabled:text-white/50 disabled:shadow-none hover:bg-blue-700 border-2 border-white/40 group relative overflow-hidden">
                            <span class="uppercase tracking-widest text-[11px] md:text-xs relative z-10">Добавить</span>
                            <div
                                class="hidden md:flex bg-white/20 text-white p-1 rounded-lg group-hover:rotate-90 transition-transform duration-300 relative z-10">
                                <svg xmlns="http://www.w3.org/2000/svg" fill="none" viewBox="0 0 24 24" stroke-width="4"
                                    stroke="currentColor" class="w-3.5 h-3.5">
                                    <path stroke-linecap="round" stroke-linejoin="round" d="M12 4.5v15m7.5-7.5h-15" />
                                </svg>
                            </div>
                        </button>

                        <!-- Help Button with Tooltip (Fixed position and Mobile support) -->
                        <div class="relative" x-data="{ showHelp: false }" @click.away="showHelp = false">
                            <!-- Tooltip (Appears below the button to avoid being cut off) -->
                            <div class="absolute top-full right-0 mt-3 w-64 p-4 bg-zinc-900 text-white rounded-2xl shadow-2xl transition-all duration-300 transform z-50 text-left"
                                x-show="showHelp" x-cloak x-transition:enter="transition ease-out duration-200"
                                x-transition:enter-start="opacity-0 translate-y-[-10px]"
                                x-transition:enter-end="opacity-100 translate-y-0"
                                x-transition:leave="transition ease-in duration-150"
                                x-transition:leave-start="opacity-100 translate-y-0"
                                x-transition:leave-end="opacity-0 translate-y-[-10px]" @mouseenter="showHelp = true"
                                @mouseleave="showHelp = false">
                                <p class="text-[10px] font-black uppercase tracking-widest mb-1 text-cyan-400">Не нашли
                                    продукт?</p>
                                <p class="text-[12px] leading-relaxed font-medium text-white">
                                    Напишите нам, и мы добавим его в справочник!
                                </p>
                                <div class="mt-2 pt-2 border-t border-white/10">
                                    <a href="mailto:glucosa45@gmail.com"
                                        class="text-white font-black text-sm hover:text-cyan-400 flex items-center gap-1 transition-colors">
                                        glucosa45@gmail.com
                                    </a>
                                </div>
                                <!-- Tooltip Arrow (Pointing UP) -->
                                <div
                                    class="absolute bottom-full right-5 w-3 h-3 bg-zinc-900 transform rotate-45 translate-y-1.5">
                                </div>
                            </div>

                            <button @click="showHelp = !showHelp" @mouseenter="showHelp = true"
                                @mouseleave="showHelp = false"
                                class="w-[48px] h-[48px] md:w-[52px] md:h-[52px] flex items-center justify-center bg-white/10 hover:bg-white/20 text-white rounded-2xl border-2 border-white/10 transition-all active:scale-90"
                                :class="{ 'bg-white/30 border-white/40': showHelp }">
                                <svg class="w-6 h-6 md:w-7 md:h-7 text-white" fill="none" stroke="currentColor"
                                    viewBox="0 0 24 24">
                                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="3"
                                        d="M8.228 9c.549-1.165 2.03-2 3.772-2 2.21 0 4 1.343 4 3 0 1.4-1.278 2.575-3.006 2.907-.542.104-.994.54-.994 1.093m0 3h.01M21 12a9 9 0 11-18 0 9 9 0 0118 0z" />
                                </svg>
                            </button>
                        </div>

                        <!-- Close Button (Perfectly squared/matched height) -->
                        <button @click="showCarbsTable = false"
                            class="w-[48px] h-[48px] md:w-[52px] md:h-[52px] flex shrink-0 items-center justify-center bg-white/10 hover:bg-white/20 text-white rounded-2xl border-2 border-white/10 transition-all hover:border-white/30 active:scale-90">
                            <svg xmlns="http://www.w3.org/2000/svg" fill="none" viewBox="0 0 24 24" stroke-width="3.5"
                                stroke="currentColor" class="w-6 h-6 md:w-7 md:h-7 text-white">
                                <path stroke-linecap="round" stroke-linejoin="round" d="M6 18L18 6M6 6l12 12" />
                            </svg>
                        </button>
                    </div>
                </div>
            </div>

            <!-- Selected Items List -->
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

            <!-- Search Bar Section -->
            <div class="px-4 py-5 bg-black/10 backdrop-blur-md border-t border-white/20">
                <div class="max-w-2xl mx-auto relative group">
                    <div class="absolute inset-y-0 left-0 pl-4 flex items-center pointer-events-none">
                        <svg class="h-5 w-5 text-cyan-500 transition-colors group-focus-within:text-cyan-400"
                            xmlns="http://www.w3.org/2000/svg" fill="none" viewBox="0 0 24 24" stroke="currentColor">
                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="3"
                                d="M21 21l-6-6m2-5a7 7 0 11-14 0 7 7 0 0114 0z" />
                        </svg>
                    </div>
                    <input x-model="searchQuery" type="text"
                        class="block w-full pl-12 pr-12 py-3.5 bg-white border-none rounded-2xl text-base font-medium placeholder-zinc-400 shadow-[0_15px_30px_-10px_rgba(0,0,0,0.3)] text-zinc-900 focus:ring-4 focus:ring-cyan-500/20 transition-all outline-none border-2 border-transparent focus:border-cyan-200"
                        placeholder="Какой продукт ищем?..." @keydown.escape="searchQuery = ''">
                    <div x-show="searchQuery.length > 0" class="absolute inset-y-0 right-0 pr-4 flex items-center"
                        x-cloak>
                        <button @click="searchQuery = ''"
                            class="text-zinc-400 hover:text-rose-500 transition-all bg-zinc-100 hover:bg-rose-50 p-1.5 rounded-xl shadow-sm">
                            <svg class="h-4 w-4" xmlns="http://www.w3.org/2000/svg" fill="none" viewBox="0 0 24 24"
                                stroke="currentColor">
                                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="3"
                                    d="M6 18L18 6M6 6l12 12" />
                            </svg>
                        </button>
                    </div>
                </div>
            </div>
        </div>

        <div
            class="p-4 md:p-6 overflow-y-scroll max-h-[70vh] md:max-h-[75vh] bg-zinc-50/50 dark:bg-zinc-900/50 custom-scrollbar">

            <!-- Empty Search Results -->
            <div x-show="filteredCategories.length === 0 && searchQuery.length > 0" x-cloak
                class="flex flex-col items-center justify-center py-12 text-zinc-400 dark:text-zinc-600">
                <div class="w-16 h-16 mb-4 rounded-full bg-zinc-100 dark:bg-zinc-800 flex items-center justify-center">
                    <svg class="w-8 h-8" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
                            d="M21 21l-6-6m2-5a7 7 0 11-14 0 7 7 0 0114 0z" />
                    </svg>
                </div>
                <p class="text-lg font-bold text-zinc-600 dark:text-zinc-400">Ничего не найдено</p>
                <p class="text-sm">Попробуйте поискать что-нибудь другое</p>
                <button @click="searchQuery = ''" class="mt-4 text-cyan-600 font-bold hover:underline">Очистить
                    поиск</button>
            </div>

            <div class="grid grid-cols-1 md:grid-cols-3 gap-6" x-show="filteredCategories.length > 0">
                <template x-for="category in filteredCategories" :key="category.name">
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