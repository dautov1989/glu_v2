<div class="bg-gradient-to-br from-cyan-50 to-blue-50 dark:from-cyan-900/10 dark:to-blue-900/10 rounded-xl border border-cyan-200/50 dark:border-cyan-800/30 p-4 md:p-6 shadow-lg"
    x-data="{
         carbs: '',
         glucose: '',
         activeInsulin: 0.0,
         result: null,
         warning: '',
         
         /**
          * Расчёт дозы инсулина
          * Логика:
          * - 1 ед. инсулина = 10 г углеводов
          * - Коррекция при glucose > 7.0: (glucose - 7.0) * 0.5
          * - Итоговая доза = foodDose + correctionDose - activeInsulin
          * - Округление до 1 знака после запятой
          */
         calculate() {
             // Сброс предыдущих результатов
             this.result = null;
             this.warning = '';
             
             // Преобразование в float
             const carbsValue = parseFloat(this.carbs);
             const glucoseValue = parseFloat(this.glucose);
             const activeInsulinValue = parseFloat(this.activeInsulin) || 0.0;
             
             // Валидация входных данных
             if (isNaN(carbsValue) || carbsValue < 0) {
                 this.warning = '⚠️ Пожалуйста, введите корректное значение углеводов';
                 return;
             }
             
             if (isNaN(glucoseValue) || glucoseValue < 0) {
                 this.warning = '⚠️ Пожалуйста, введите корректное значение сахара крови';
                 return;
             }
             
             // Проверка на гипогликемию
             if (glucoseValue < 4.0) {
                 this.warning = '🚨 ВНИМАНИЕ: Низкий уровень сахара (гипогликемия)! Примите быстрые углеводы и не вводите инсулин. Обратитесь к врачу.';
                 return;
             }
             
             // Расчёт дозы на еду
             const foodDose = carbsValue / 10.0;
             
             // Расчёт коррекции (только если glucose > 7.0)
             let correctionDose = 0.0;
             if (glucoseValue > 7.0) {
                 correctionDose = (glucoseValue - 7.0) * 0.5;
             }
             
             // Итоговая доза с учётом активного инсулина
             const totalDoseRaw = foodDose + correctionDose - activeInsulinValue;
             
             // Округление до 1 знака после запятой
             const totalDose = Math.max(0, totalDoseRaw).toFixed(1);
             
             // Формирование результата
             this.result = {
                 total: totalDose,
                 foodDose: foodDose.toFixed(1),
                 correctionDose: correctionDose.toFixed(1),
                 activeInsulin: activeInsulinValue.toFixed(1),
                 wasRounded: totalDose !== totalDoseRaw
             };
         }
     }">

    {{-- Schema.org JSON-LD --}}
    <script type="application/ld+json">
    {
      "@@context": "https://schema.org",
      "@@type": "SoftwareApplication",
      "name": "Калькулятор инсулина Glucosa",
      "applicationCategory": "HealthApplication",
      "operatingSystem": "Web",
      "offers": {
        "@@type": "Offer",
        "price": "0",
        "priceCurrency": "RUB"
      },
      "description": "Онлайн калькулятор для расчета дозы инсулина короткого действия на основе количества углеводов (ХЕ) и текущего уровня сахара крови с учетом активного инсулина.",
      "featureList": "Расчет дозы на еду, Коррекция высокого сахара, Учет активного инсулина",
      "screenshot": "{{ asset('images/calculator-preview.png') }}"
    }
    </script>





    <!-- Header -->
    <div class="text-center mb-6">
        <div class="flex flex-col md:flex-row items-center justify-center gap-3 mb-4">
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
    </div>

    <!-- Input Form Wrapper with Shared State -->
    <div x-data="{ 
        showCarbsTable: false,
        modalTotalCarbs: 0,
        modalItemCount: 0,
        foodCategories: [
            {
                name: 'Хлеб и выпечка',
                icon: '🍞',
                color: 'bg-amber-500',
                items: [
                    { name: 'Хлеб белый (1 ломтик, 30г)', carbs: 15 },
                    { name: 'Хлеб чёрный (1 ломтик, 30г)', carbs: 13 },
                    { name: 'Булочка (1 шт, 50г)', carbs: 25 },
                    { name: 'Печенье (1 шт, 10г)', carbs: 7 },
                    { name: 'Блин (1 шт, 50г)', carbs: 15 },
                    { name: 'Лаваш (50г)', carbs: 24 },
                    { name: 'Пицца (1 кусок, 100г)', carbs: 30 }
                ]
            },
            {
                name: 'Крупы и гарниры',
                icon: '🍚',
                color: 'bg-emerald-500',
                items: [
                    { name: 'Рис (100г)', carbs: 28 },
                    { name: 'Гречка (100г)', carbs: 20 },
                    { name: 'Макароны (100г)', carbs: 25 },
                    { name: 'Овсянка (100г)', carbs: 12 },
                    { name: 'Пюре картофельное (100г)', carbs: 15 },
                    { name: 'Чечевица (100г)', carbs: 20 }
                ]
            },
            {
                name: 'Фрукты и ягоды',
                icon: '🍎',
                color: 'bg-red-500',
                items: [
                    { name: 'Яблоко (1 среднее, 150г)', carbs: 20 },
                    { name: 'Банан (1 средний, 120г)', carbs: 27 },
                    { name: 'Апельсин (1 средний, 150г)', carbs: 18 },
                    { name: 'Виноград (100г)', carbs: 17 },
                    { name: 'Груша (1 средняя, 150г)', carbs: 16 },
                    { name: 'Мандарин (1 шт, 80г)', carbs: 8 },
                    { name: 'Сок фруктовый (200мл)', carbs: 24 }
                ]
            },
            {
                name: 'Овощи',
                icon: '🥕',
                color: 'bg-orange-500',
                items: [
                    { name: 'Картофель варёный (100г)', carbs: 17 },
                    { name: 'Морковь (100г)', carbs: 7 },
                    { name: 'Огурец (100г)', carbs: 3 },
                    { name: 'Помидор (100г)', carbs: 4 },
                    { name: 'Капуста белокочанная (100г)', carbs: 5 },
                    { name: 'Перец сладкий (100г)', carbs: 5 }
                ]
            },
            {
                name: 'Молочные продукты',
                icon: '🥛',
                color: 'bg-blue-500',
                items: [
                    { name: 'Молоко (200мл)', carbs: 10 },
                    { name: 'Йогурт натуральный (150г)', carbs: 7 },
                    { name: 'Кефир (200мл)', carbs: 8 },
                    { name: 'Творог (100г)', carbs: 3 }
                ]
            },
            {
                name: 'Сладости',
                icon: '🍫',
                color: 'bg-pink-500',
                items: [
                    { name: 'Шоколад молочный (30г)', carbs: 17 },
                    { name: 'Мёд (1 ст.л., 20г)', carbs: 16 },
                    { name: 'Сахар (1 ч.л., 5г)', carbs: 5 },
                    { name: 'Мороженое (100г)', carbs: 24 },
                    { name: 'Зефир (1 шт, 30г)', carbs: 24 },
                    { name: 'Торт (100г)', carbs: 50 }
                ]
            }
        ],
        
        addCarbsToModal(amount) {
            this.modalTotalCarbs += amount;
            this.modalItemCount++;
        },
        
        applyCarbs() {
            this.carbs = this.modalTotalCarbs;
            this.showCarbsTable = false;
        },
        
        openCarbsTable() {
            this.modalTotalCarbs = 0;
            this.modalItemCount = 0;
            this.showCarbsTable = true;
        }
    }">
        {{-- Screen reader description --}}
        <p class="sr-only">
            Используйте данный калькулятор для расчета дозы инсулина. Введите количество углеводов в граммах и текущий
            уровень сахара в крови. Калькулятор автоматически рассчитает необходимую дозу с учетом коррекции. Не
            забудьте указать активный инсулин, если с прошлого укола прошло менее 4 часов.
        </p>

        <div class="grid grid-cols-1 md:grid-cols-3 gap-4 mb-4">
            <!-- Углеводы -->
            <div
                class="bg-white dark:bg-zinc-800 rounded-xl p-4 border border-cyan-200/50 dark:border-cyan-800/30 shadow-sm">
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
            <div
                class="bg-white dark:bg-zinc-800 rounded-xl p-4 border border-cyan-200/50 dark:border-cyan-800/30 shadow-sm">
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
            <div
                class="bg-white dark:bg-zinc-800 rounded-xl p-4 border border-cyan-200/50 dark:border-cyan-800/30 shadow-sm">
                <label for="active-insulin-input" class="block text-sm font-bold text-zinc-700 dark:text-zinc-300 mb-2">
                    💧 Активный инсулин (ед)
                </label>
                <input id="active-insulin-input" type="number" x-model="activeInsulin" step="0.1" min="0"
                    placeholder="0.0"
                    class="w-full px-4 py-3 bg-zinc-50 dark:bg-zinc-900 border border-cyan-200/50 dark:border-cyan-800/30 rounded-lg text-zinc-800 dark:text-zinc-200 font-semibold text-lg focus:outline-none focus:ring-2 focus:ring-cyan-500 dark:focus:ring-cyan-400 transition-all">
                <p class="text-xs text-zinc-500 dark:text-zinc-400 mt-2 leading-relaxed">
                    💡 Это инсулин от прошлого укола, который всё ещё работает в организме. Если прошло меньше 4 часов —
                    укажите дозу, иначе 0.
                </p>
            </div>
        </div>

        <!-- Modal Window with Carbs Table -->
        <div x-show="showCarbsTable" x-cloak @click.self="showCarbsTable = false"
            class="fixed inset-0 z-50 flex items-center justify-center p-4 bg-black/50 backdrop-blur-sm"
            x-transition:enter="transition ease-out duration-300" x-transition:enter-start="opacity-0"
            x-transition:enter-end="opacity-100" x-transition:leave="transition ease-in duration-200"
            x-transition:leave-start="opacity-100" x-transition:leave-end="opacity-0">

            <div @click.stop
                class="bg-white dark:bg-zinc-800 rounded-2xl shadow-2xl max-w-4xl w-full max-h-[90vh] overflow-hidden border-2 border-cyan-300 dark:border-cyan-700"
                x-transition:enter="transition ease-out duration-300" x-transition:enter-start="opacity-0 scale-95"
                x-transition:enter-end="opacity-100 scale-100" x-transition:leave="transition ease-in duration-200"
                x-transition:leave-start="opacity-100 scale-100" x-transition:leave-end="opacity-0 scale-95">

                <!-- Header with Calculator Info -->
                <div class="bg-gradient-to-r from-cyan-500 to-blue-500 sticky top-0 z-10 shadow-md">
                    <!-- Desktop Header -->
                    <div class="hidden md:flex p-6 items-center justify-between">
                        <div class="flex items-center gap-4">
                            <div
                                class="w-12 h-12 bg-white/20 rounded-xl flex items-center justify-center backdrop-blur-sm">
                                <svg xmlns="http://www.w3.org/2000/svg" fill="none" viewBox="0 0 24 24" stroke-width="2"
                                    stroke="currentColor" class="w-7 h-7 text-white">
                                    <path stroke-linecap="round" stroke-linejoin="round"
                                        d="M15.75 10.5V6a3.75 3.75 0 10-7.5 0v4.5m11.356-1.993l1.263 12c.07.665-.45 1.243-1.119 1.243H4.25a1.125 1.125 0 01-1.12-1.243l1.264-12A1.125 1.125 0 015.513 7.5h12.974c.576 0 1.059.435 1.119 1.007zM8.625 10.5a.375.375 0 11-.75 0 .375.375 0 01.75 0zm7.5 0a.375.375 0 11-.75 0 .375.375 0 01.75 0z" />
                                </svg>
                            </div>
                            <div>
                                <h3 class="text-2xl font-bold text-white">Калькулятор еды</h3>
                                <div class="flex items-center gap-2 mt-1">
                                    <span class="text-white/90 font-medium text-sm">Выбрано:</span>
                                    <span x-show="modalItemCount > 0"
                                        class="bg-white/20 px-2 py-0.5 rounded-lg text-white font-bold text-sm backdrop-blur-sm"
                                        x-text="modalItemCount + ' шт'"></span>
                                    <span
                                        class="bg-white/20 px-3 py-0.5 rounded-lg text-white font-bold backdrop-blur-sm"
                                        :class="{'bg-white/30': modalTotalCarbs > 0}"
                                        x-text="modalTotalCarbs + 'г'"></span>
                                </div>
                            </div>
                        </div>

                        <div class="flex items-center gap-3">
                            <button x-show="modalTotalCarbs > 0" @click="applyCarbs()"
                                class="bg-white text-cyan-600 hover:bg-zinc-50 font-bold py-2 px-4 rounded-xl shadow-lg transition-all active:scale-95 flex items-center gap-2">
                                <span>Добавить</span>
                                <svg xmlns="http://www.w3.org/2000/svg" fill="none" viewBox="0 0 24 24"
                                    stroke-width="2.5" stroke="currentColor" class="w-5 h-5">
                                    <path stroke-linecap="round" stroke-linejoin="round" d="M12 4.5v15m7.5-7.5h-15" />
                                </svg>
                            </button>
                            <button @click="showCarbsTable = false"
                                class="w-10 h-10 bg-white/20 hover:bg-white/30 rounded-lg flex items-center justify-center transition-colors backdrop-blur-sm">
                                <svg xmlns="http://www.w3.org/2000/svg" fill="none" viewBox="0 0 24 24"
                                    stroke-width="2.5" stroke="currentColor" class="w-6 h-6 text-white">
                                    <path stroke-linecap="round" stroke-linejoin="round" d="M6 18L18 6M6 6l12 12" />
                                </svg>
                            </button>
                        </div>
                    </div>

                    <!-- Mobile Header -->
                    <div class="md:hidden p-4 flex flex-col gap-4">
                        <div class="flex items-center justify-between">
                            <h3 class="text-xl font-bold text-white leading-none">Калькулятор еды</h3>
                            <button @click="showCarbsTable = false"
                                class="text-white/80 p-1 hover:bg-white/10 rounded-lg ml-auto">
                                <svg xmlns="http://www.w3.org/2000/svg" fill="none" viewBox="0 0 24 24"
                                    stroke-width="2.5" stroke="currentColor" class="w-7 h-7">
                                    <path stroke-linecap="round" stroke-linejoin="round" d="M6 18L18 6M6 6l12 12" />
                                </svg>
                            </button>
                        </div>

                        <div
                            class="flex items-center justify-between bg-white/10 rounded-xl p-2 pl-3 border border-white/10 backdrop-blur-md">
                            <div class="flex items-center gap-3">
                                <span x-show="modalItemCount > 0"
                                    class="flex flex-col items-center justify-center leading-none">
                                    <span
                                        class="text-[10px] text-cyan-100 font-medium uppercase tracking-wider">Штук</span>
                                    <span class="text-white font-bold text-lg" x-text="modalItemCount"></span>
                                </span>
                                <span x-show="modalItemCount > 0" class="h-8 w-px bg-white/20"></span>
                                <div class="flex flex-col justify-center leading-none">
                                    <span
                                        class="text-[10px] text-cyan-100 font-medium uppercase tracking-wider">Углеводы</span>
                                    <div class="flex items-baseline gap-0.5">
                                        <span class="text-white font-bold text-2xl" x-text="modalTotalCarbs"></span>
                                        <span class="text-sm font-bold text-cyan-100">г</span>
                                    </div>
                                </div>
                            </div>

                            <button @click="applyCarbs()" :disabled="modalTotalCarbs == 0"
                                class="px-5 py-2.5 bg-white text-cyan-600 rounded-lg font-bold text-sm shadow-sm active:scale-95 transition-all flex items-center gap-2 disabled:opacity-50 disabled:cursor-not-allowed">
                                <span>Добавить</span>
                                <svg xmlns="http://www.w3.org/2000/svg" fill="none" viewBox="0 0 24 24" stroke-width="3"
                                    stroke="currentColor" class="w-4 h-4">
                                    <path stroke-linecap="round" stroke-linejoin="round" d="M12 4.5v15m7.5-7.5h-15" />
                                </svg>
                            </button>
                        </div>
                    </div>
                </div>

                <!-- Dynamic Content -->
                <div class="p-6 overflow-y-auto max-h-[calc(90vh-120px)] bg-zinc-50/50 dark:bg-zinc-900/50">
                    <div class="space-y-6">
                        <template x-for="category in foodCategories" :key="category.name">
                            <div>
                                <h4
                                    class="text-lg font-bold text-zinc-800 dark:text-zinc-100 mb-3 flex items-center gap-2 sticky top-0 bg-zinc-50/95 dark:bg-zinc-900/95 py-2 z-0 backdrop-blur-sm">
                                    <span class="w-1 h-6 rounded-full" :class="category.color"></span>
                                    <span x-text="category.icon + ' ' + category.name"></span>
                                </h4>
                                <div class="grid grid-cols-1 sm:grid-cols-2 gap-2">
                                    <template x-for="item in category.items" :key="item.name">
                                        <button @click="addCarbsToModal(item.carbs)"
                                            class="flex justify-between items-center p-3 bg-white dark:bg-zinc-800 hover:bg-cyan-50 dark:hover:bg-cyan-900/20 border border-zinc-200 dark:border-zinc-700/50 hover:border-cyan-300 dark:hover:border-cyan-600 rounded-xl transition-all group text-left shadow-sm hover:shadow-md active:scale-[0.98] outline-none focus:ring-2 focus:ring-cyan-500/50 cursor-pointer">
                                            <span
                                                class="text-sm text-zinc-700 dark:text-zinc-300 group-hover:text-cyan-800 dark:group-hover:text-cyan-200 transition-colors font-medium"
                                                x-text="item.name"></span>
                                            <div class="flex items-center gap-2">
                                                <span
                                                    class="text-xs font-bold text-cyan-500 dark:text-cyan-400 opacity-0 group-hover:opacity-100 transition-all transform translate-x-2 group-hover:translate-x-0">+</span>
                                                <span
                                                    class="text-sm font-bold text-cyan-600 dark:text-cyan-400 bg-cyan-50 dark:bg-cyan-900/30 px-2 py-0.5 rounded-md"
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
    </div>

    <!-- Calculate Button -->
    <div class="text-center mb-4">
        <button @click="calculate()"
            class="px-8 py-4 bg-gradient-to-r from-cyan-500 to-blue-500 hover:from-cyan-600 hover:to-blue-600 text-white font-bold rounded-xl shadow-lg shadow-cyan-500/40 hover:shadow-cyan-500/60 transition-all duration-300 hover:scale-105 active:scale-95 flex items-center justify-center gap-2 mx-auto">
            <svg xmlns="http://www.w3.org/2000/svg" fill="none" viewBox="0 0 24 24" stroke-width="2"
                stroke="currentColor" class="w-5 h-5">
                <path stroke-linecap="round" stroke-linejoin="round"
                    d="M15.75 15.75V18m-7.5-6.75h.008v.008H8.25v-.008Zm0 2.25h.008v.008H8.25V13.5Zm0 2.25h.008v.008H8.25v-.008Zm0 2.25h.008v.008H8.25V18Zm2.498-6.75h.007v.008h-.007v-.008Zm0 2.25h.007v.008h-.007V13.5Zm0 2.25h.007v.008h-.007v-.008Zm0 2.25h.007v.008h-.007V18Zm2.504-6.75h.008v.008h-.008v-.008Zm0 2.25h.008v.008h-.008V13.5Zm0 2.25h.008v.008h-.008v-.008Zm0 2.25h.008v.008h-.008V18Zm2.498-6.75h.008v.008h-.008v-.008Zm0 2.25h.008v.008h-.008V13.5ZM8.25 6h7.5v2.25h-7.5V6ZM12 2.25c-1.892 0-3.758.11-5.593.322C5.307 2.7 4.5 3.65 4.5 4.757V19.5a2.25 2.25 0 0 0 2.25 2.25h10.5a2.25 2.25 0 0 0 2.25-2.25V4.757c0-1.108-.806-2.057-1.907-2.185A48.507 48.507 0 0 0 12 2.25Z" />
            </svg>
            <span>Рассчитать дозу</span>
        </button>
    </div>

    <!-- Warning Message -->
    <div x-show="warning" x-transition:enter="transition ease-out duration-300"
        x-transition:enter-start="opacity-0 scale-95" x-transition:enter-end="opacity-100 scale-100"
        class="bg-red-50 dark:bg-red-900/20 border-2 border-red-300 dark:border-red-700 rounded-xl p-4 mb-6">
        <p class="text-red-800 dark:text-red-300 font-semibold text-center" x-text="warning"></p>
    </div>

    <!-- Result Display -->
    <div x-show="result" x-transition:enter="transition ease-out duration-300"
        x-transition:enter-start="opacity-0 scale-95" x-transition:enter-end="opacity-100 scale-100"
        class="bg-white dark:bg-zinc-800 rounded-xl border-2 border-cyan-300 dark:border-cyan-700 p-6 shadow-xl">

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
                        ℹ️ Инсулин не требуется. Активный инсулин уже покрывает необходимую дозу.
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

                <div class="flex items-center justify-between bg-zinc-50 dark:bg-zinc-900 rounded-lg p-3">
                    <span class="text-sm text-zinc-600 dark:text-zinc-400">💧 Активный инсулин:</span>
                    <span class="text-sm font-bold text-zinc-800 dark:text-zinc-200">
                        <span x-text="result ? result.activeInsulin : '0.0'"></span> ед
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