<!-- MODAL CONTAINER -->
<div x-cloak x-show="modalOpen" class="fixed inset-0 z-50 flex items-center justify-center p-4 sm:p-6 pb-20 sm:pb-6"
    aria-labelledby="modal-title" role="dialog" aria-modal="true">

    <!-- Backdrop -->
    <div x-show="modalOpen" x-transition.opacity.duration.300ms class="fixed inset-0 bg-zinc-900/60 backdrop-blur-sm"
        @click="closeModal"></div>

    <!-- Modal Panel -->
    <div x-show="modalOpen" x-transition:enter="ease-out duration-300"
        x-transition:enter-start="opacity-0 translate-y-8 sm:translate-y-0 sm:scale-95"
        x-transition:enter-end="opacity-100 translate-y-0 sm:scale-100" x-transition:leave="ease-in duration-200"
        x-transition:leave-start="opacity-100 translate-y-0 sm:scale-100"
        x-transition:leave-end="opacity-0 translate-y-8 sm:translate-y-0 sm:scale-95"
        class="relative bg-white dark:bg-zinc-900 rounded-[28px] shadow-2xl w-full max-w-[850px] max-h-[95vh] flex flex-col overflow-hidden border border-zinc-200/50 dark:border-zinc-800 ring-1 ring-zinc-900/5 dark:ring-white/10">

        <!-- Header -->
        <div
            class="relative flex items-center justify-center px-6 py-4 bg-gradient-to-r from-cyan-500 to-blue-600 shadow-sm border-b border-white/10 shrink-0">
            <div class="flex items-center gap-3 text-white">
                <div class="w-6 h-6 rounded-full bg-white/20 backdrop-blur-sm flex items-center justify-center">
                    <svg class="w-3.5 h-3.5 text-white" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2.5"
                            d="M9 12l2 2 4-4m6 2a9 9 0 11-18 0 9 9 0 0118 0z" />
                    </svg>
                </div>
                <span class="text-[10px] sm:text-xs font-black uppercase tracking-[0.2em]">Glucosa рекомендует</span>
                <div class="w-6 h-6 rounded-full bg-white/20 backdrop-blur-sm flex items-center justify-center">
                    <svg class="w-3.5 h-3.5 text-white" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2.5"
                            d="M9 12l2 2 4-4m6 2a9 9 0 11-18 0 9 9 0 0118 0z" />
                    </svg>
                </div>
            </div>

            <!-- Close cross -->
            <button @click="closeModal"
                class="absolute right-4 p-2 text-white/70 hover:text-white hover:bg-white/10 rounded-full transition-all">
                <svg class="w-5 h-5" fill="none" viewBox="0 0 24 24" stroke="currentColor">
                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M6 18L18 6M6 6l12 12" />
                </svg>
            </button>
        </div>

        <!-- Scrollable Content -->
        <div class="flex-1 overflow-y-auto min-h-0 bg-white dark:bg-zinc-900"
            style="scrollbar-width: thin; scrollbar-color: #cbd5e1 transparent;">
            <template x-if="activeProduct">
                <div class="pb-6">
                    <!-- Title & Short Description -->
                    <div class="px-6 pt-8 pb-6 text-center border-b border-zinc-50 dark:border-zinc-800/50">
                        <h2 class="text-xl sm:text-3xl font-black text-zinc-900 dark:text-zinc-50 leading-tight mb-3"
                            x-text="activeProduct.title"></h2>
                        <div class="w-full">
                            <p class="text-[13px] sm:text-[16px] text-zinc-600 dark:text-zinc-300 leading-relaxed"
                                x-text="activeProduct.description"></p>
                        </div>
                    </div>

                    <div class="p-6">
                        <!-- Main Info Grid (40/60 Split) -->
                        <div class="grid grid-cols-1 md:grid-cols-[4fr_6fr] gap-8 items-start">
                            <!-- Left: Image (40%) -->
                            <div class="flex flex-col items-center">
                                <div class="w-full flex items-center justify-center p-2">
                                    <img :src="activeProduct.image_url" :alt="activeProduct.title"
                                        class="w-full h-auto object-contain mix-blend-multiply dark:mix-blend-normal transform hover:scale-105 transition-transform duration-500">
                                </div>
                            </div>

                            <!-- Right: Rating & Characteristics (60%) -->
                            <div class="space-y-6">
                                <!-- Small Rating -->
                                <div class="flex flex-col gap-2" x-show="activeProduct.rating">
                                    <span
                                        class="text-[10px] font-black text-zinc-400 uppercase tracking-widest">Рейтинг</span>
                                    <div
                                        class="flex items-center gap-1 bg-zinc-50 dark:bg-zinc-800/80 px-2.5 py-1.5 rounded-lg border border-zinc-100 dark:border-zinc-700/50 w-fit">
                                        <template x-for="i in 10">
                                            <svg class="w-3 h-3"
                                                :class="i <= activeProduct.rating ? 'text-amber-400' : 'text-zinc-200 dark:text-zinc-700'"
                                                fill="currentColor" viewBox="0 0 20 20">
                                                <path
                                                    d="M9.049 2.927c.3-.921 1.603-.921 1.902 0l1.07 3.292a1 1 0 00.95.69h3.462c.969 0 1.371 1.24.588 1.81l-2.8 2.034a1 1 0 00-.364 1.118l1.07 3.292c.3.921-.755 1.688-1.54 1.118l-2.8-2.034a1 1 0 00-1.175 0l-2.8 2.034c-.784.57-1.838-.197-1.539-1.118l1.07-3.292a1 1 0 00-.364-1.118L2.98 8.72c-.783-.57-.38-1.81.588-1.81h3.461a1 1 0 00.951-.69l1.07-3.292z" />
                                            </svg>
                                        </template>
                                        <span class="ml-1.5 text-xs font-bold text-zinc-500"
                                            x-text="activeProduct.rating"></span>
                                    </div>
                                </div>

                                <!-- Characteristics (Two-Column Grid) -->
                                <div class="space-y-4">
                                    <h3
                                        class="text-[10px] font-black text-zinc-400 uppercase tracking-widest border-b border-zinc-100 dark:border-zinc-800 pb-2">
                                        Характеристики</h3>
                                    <div class="grid grid-cols-1 sm:grid-cols-2 gap-2">
                                        <!-- Features Loop -->
                                        <template x-for="feature in activeProduct.characteristics">
                                            <div
                                                class="px-3 py-2 bg-cyan-50/50 dark:bg-cyan-900/10 border border-cyan-100/50 dark:border-cyan-800/30 rounded-lg shadow-sm flex items-center justify-center text-center">
                                                <span
                                                    class="text-[10px] sm:text-[11px] font-bold text-cyan-600 dark:text-cyan-400 uppercase tracking-tight"
                                                    x-text="feature"></span>
                                            </div>
                                        </template>



                                        <!-- Marketplace Badge -->
                                        <template x-if="activeProduct.marketplace">
                                            <div
                                                class="px-3 py-2 bg-cyan-50/50 dark:bg-cyan-900/10 border border-cyan-100/50 dark:border-cyan-800/30 rounded-lg shadow-sm flex items-center justify-center text-center">
                                                <span
                                                    class="text-[10px] sm:text-[11px] font-bold text-cyan-600 dark:text-cyan-400 uppercase tracking-tight"
                                                    x-text="activeProduct.marketplace"></span>
                                            </div>
                                        </template>

                                    </div>
                                    <!-- Expert Review (Moved into 60% column) -->
                                    <div class="pt-4 border-t border-zinc-100 dark:border-zinc-800"
                                        x-show="activeProduct.expert_review">
                                        <h3
                                            class="text-[10px] font-black text-zinc-400 uppercase tracking-widest mb-4 flex items-center gap-2">
                                            Отзывы
                                        </h3>
                                        <div class="">
                                            <p class="text-[11px] sm:text-xs text-zinc-600 dark:text-zinc-300 leading-relaxed italic"
                                                x-text="activeProduct.expert_review"></p>
                                        </div>
                                    </div>
                                </div>
                            </div>
                        </div>
            </template>
        </div>

        <!-- Fixed CTA Footer (Badge Style) -->
        <div x-show="activeProduct" class="z-20 sticky sm:relative bottom-0 left-0 w-full shrink-0">
            <a :href="activeProduct.marketplace_url" target="_blank" rel="noopener nofollow"
                class="group w-full flex items-center justify-center gap-3 py-4 sm:py-5 px-6 font-black uppercase tracking-[0.15em] text-[10px] sm:text-xs transition-all duration-300"
                :class="activeProduct.btn_bg + ' ' + activeProduct.btn_hover + ' ' + activeProduct.btn_text">
                Посмотреть на <span x-text="activeProduct.marketplace"></span>
                <svg class="w-4 h-4 transform group-hover:translate-x-1.5 transition-transform" fill="none"
                    stroke="currentColor" viewBox="0 0 24 24">
                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
                        d="M17 8l4 4m0 0l-4 4m4-4H3" />
                </svg>
            </a>
        </div>
    </div>
</div>