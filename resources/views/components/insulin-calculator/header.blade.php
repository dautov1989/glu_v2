<div class="text-center mb-6">
    <div class="flex flex-col md:flex-row items-center justify-center gap-3 mb-2">
        <h2 class="text-xl md:text-3xl font-extrabold text-zinc-800 dark:text-zinc-100 leading-tight">
            Калькулятор <span class="text-cyan-600 dark:text-cyan-400">инсулина</span>
        </h2>



        @if(!request()->routeIs('tools.insulin-calculator'))
            <a href="{{ route('tools.insulin-calculator') }}"
                class="inline-flex items-center gap-1.5 px-3 py-1.5 bg-cyan-50 dark:bg-cyan-900/20 text-cyan-600 dark:text-cyan-400 border border-cyan-200 dark:border-cyan-800/30 rounded-full text-xs font-bold hover:bg-cyan-100 dark:hover:bg-cyan-900/40 transition-all hover:scale-105 md:ml-2">
                <span>Подробнее</span>
                <svg xmlns="http://www.w3.org/2000/svg" fill="none" viewBox="0 0 24 24" stroke-width="2"
                    stroke="currentColor" class="w-3 h-3">
                    <path stroke-linecap="round" stroke-linejoin="round" d="M13.5 4.5 21 12m0 0-7.5 7.5M21 12H3" />
                </svg>
            </a>
        @endif

        <!-- Feature Request Help Icon -->
        <div class="relative inline-block" x-data="{ showCalculatorHelp: false }"
            @click.away="showCalculatorHelp = false">
            <div class="absolute bottom-full left-1/2 -translate-x-1/2 mb-3 w-64 p-4 bg-zinc-900 text-white rounded-2xl shadow-2xl transition-all duration-300 transform z-50 text-left"
                x-show="showCalculatorHelp" x-cloak x-transition:enter="transition ease-out duration-200"
                x-transition:enter-start="opacity-0 translate-y-2" x-transition:enter-end="opacity-100 translate-y-0"
                x-transition:leave="transition ease-in duration-150"
                x-transition:leave-start="opacity-100 translate-y-0" x-transition:leave-end="opacity-0 translate-y-2"
                @mouseenter="showCalculatorHelp = true" @mouseleave="showCalculatorHelp = false">
                <p class="text-[10px] font-black uppercase tracking-widest mb-1 text-cyan-400">Нужна новая функция?</p>
                <p class="text-[12px] leading-relaxed font-medium text-white">
                    Есть идеи по улучшению калькулятора? Напишите нам, и мы добавим нужный вам функционал!
                </p>
                <div class="mt-2 pt-2 border-t border-white/10">
                    <a href="mailto:glucosa45@gmail.com"
                        class="text-white font-black text-sm hover:text-cyan-400 flex items-center gap-1 transition-colors">
                        glucosa45@gmail.com
                    </a>
                </div>
                <!-- Arrow -->
                <div
                    class="absolute top-full left-1/2 -translate-x-1/2 -mt-1.5 transform rotate-45 w-3 h-3 bg-zinc-900">
                </div>
            </div>

            <button @click="showCalculatorHelp = !showCalculatorHelp" @mouseenter="showCalculatorHelp = true"
                @mouseleave="showCalculatorHelp = false"
                class="w-8 h-8 flex items-center justify-center bg-cyan-100/50 dark:bg-cyan-900/30 text-cyan-600 dark:text-cyan-400 rounded-full border border-cyan-200 dark:border-cyan-800/30 transition-all hover:bg-cyan-200 dark:hover:bg-cyan-800/50 active:scale-90"
                :class="{ 'ring-2 ring-cyan-500/50': showCalculatorHelp }">
                <svg class="w-5 h-5" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2.5"
                        d="M8.228 9c.549-1.165 2.03-2 3.772-2 2.21 0 4 1.343 4 3 0 1.4-1.278 2.575-3.006 2.907-.542.104-.994.54-.994 1.093m0 3h.01M21 12a9 9 0 11-18 0 9 9 0 0118 0z" />
                </svg>
            </button>
        </div>
    </div>
    @if(request()->routeIs('tools.insulin-calculator'))
        <p class="text-xs md:text-sm text-zinc-500 dark:text-zinc-400 font-medium">
            Точный расчет дозировки прямо в вашем браузере. Данные не отправляются на сервер.
        </p>
    @endif
</div>