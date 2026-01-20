{{-- Screen reader description --}}
<p class="sr-only">
    Используйте данный калькулятор для расчета дозы инсулина. Введите количество углеводов в граммах и текущий
    уровень сахара в крови. Калькулятор автоматически рассчитает необходимую дозу с учетом коррекции. Не
    забудьте указать активный инсулин, если с прошлого укола прошло менее 4 часов.
</p>

<div class="grid grid-cols-1 md:grid-cols-3 gap-4 mb-4">
    <!-- Углеводы -->
    <div class="bg-white dark:bg-zinc-800 rounded-xl p-4 border border-cyan-200/50 dark:border-cyan-800/30 shadow-sm">
        <label for="carbs-input" class="block text-sm font-bold text-zinc-700 dark:text-zinc-300 mb-2">
            🍞 Углеводы (г)
        </label>
        <input id="carbs-input" type="number" x-model="carbs" step="0.5" min="0" placeholder="0.0"
            class="w-full px-4 py-3 bg-zinc-50 dark:bg-zinc-900 border border-cyan-200/50 dark:border-cyan-800/30 rounded-lg text-zinc-800 dark:text-zinc-200 font-semibold text-lg focus:outline-none focus:ring-2 focus:ring-cyan-500 dark:focus:ring-cyan-400 transition-all">
        <div class="text-xs text-zinc-500 dark:text-zinc-400 mt-2 leading-relaxed">
            💡 Количество углеводов в приёме пищи. Смотрите на упаковке продуктов или используйте
            <button @click="openCarbsTable()"
                class="text-cyan-600 dark:text-cyan-400 hover:text-cyan-700 dark:hover:text-cyan-300 underline decoration-dashed underline-offset-4 cursor-pointer font-semibold transition-colors">таблицы</button>.
        </div>
    </div>

    <!-- Сахар крови -->
    <div class="bg-white dark:bg-zinc-800 rounded-xl p-4 border border-cyan-200/50 dark:border-cyan-800/30 shadow-sm">
        <label for="glucose-input" class="block text-sm font-bold text-zinc-700 dark:text-zinc-300 mb-2">
            🩸 Сахар крови (ммоль/л)
        </label>
        <input id="glucose-input" type="number" x-model="glucose" step="0.1" min="0" placeholder="0.0"
            class="w-full px-4 py-3 bg-zinc-50 dark:bg-zinc-900 border border-cyan-200/50 dark:border-cyan-800/30 rounded-lg text-zinc-800 dark:text-zinc-200 font-semibold text-lg focus:outline-none focus:ring-2 focus:ring-cyan-500 dark:focus:ring-cyan-400 transition-all">
        <p class="text-xs text-zinc-500 dark:text-zinc-400 mt-2 leading-relaxed">
            💡 Текущий уровень глюкозы по глюкометру. Норма: 4.0-7.0 ммоль/л перед едой.
        </p>
    </div>

    <!-- Активный инсулин (опционально) -->
    <div class="bg-white dark:bg-zinc-800 rounded-xl p-4 border border-cyan-200/50 dark:border-cyan-800/30 shadow-sm">
        <label for="active-insulin-input" class="block text-sm font-bold text-zinc-700 dark:text-zinc-300 mb-2">
            💧 Активный инсулин (ед)
        </label>
        <input id="active-insulin-input" type="number" x-model="activeInsulin" step="0.1" min="0" placeholder="0.0"
            class="w-full px-4 py-3 bg-zinc-50 dark:bg-zinc-900 border border-cyan-200/50 dark:border-cyan-800/30 rounded-lg text-zinc-800 dark:text-zinc-200 font-semibold text-lg focus:outline-none focus:ring-2 focus:ring-cyan-500 dark:focus:ring-cyan-400 transition-all">
        <p class="text-xs text-zinc-500 dark:text-zinc-400 mt-2 leading-relaxed">
            💡 Это инсулин от прошлого укола, который всё ещё работает в организме. Если прошло меньше 4 часов —
            укажите дозу, иначе 0.
        </p>
    </div>
</div>