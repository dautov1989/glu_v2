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
    </div>
    @if(request()->routeIs('tools.insulin-calculator'))
        <p class="text-xs md:text-sm text-zinc-500 dark:text-zinc-400 font-medium">
            Точный расчет дозировки прямо в вашем браузере. Данные не отправляются на сервер.
        </p>
    @endif
</div>