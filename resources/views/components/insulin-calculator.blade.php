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
      "description": "Калькулятор для расчета дозы инсулина. Работает без интернета. Расчет на основе углеводов (ХЕ), сахара крови и активного инсулина.",
      "featureList": "Работа offline, Расчет дозы на еду, Коррекция высокого сахара, Учет активного инсулина",
      "screenshot": "{{ asset('images/calculator-preview.png') }}"
    }
    </script>





    <!-- Header -->
    <div class="text-center mb-6">
        <div class="flex flex-col md:flex-row items-center justify-center gap-3 mb-2">
            <h2 class="text-xl md:text-3xl font-extrabold text-zinc-800 dark:text-zinc-100 leading-tight">
                Калькулятор <span class="text-cyan-600 dark:text-cyan-400">инсулина</span>
            </h2>

            @if(request()->routeIs('tools.insulin-calculator'))
                <!-- Offline Badge -->
                <div
                    class="inline-flex items-center gap-1.5 px-3 py-1 bg-emerald-50 dark:bg-emerald-900/20 text-emerald-600 dark:text-emerald-400 border border-emerald-200 dark:border-emerald-800/30 rounded-full text-[10px] font-black uppercase tracking-wider shadow-sm">
                    <span class="relative flex h-2 w-2">
                        <span
                            class="animate-ping absolute inline-flex h-full w-full rounded-full bg-emerald-400 opacity-75"></span>
                        <span class="relative inline-flex rounded-full h-2 w-2 bg-emerald-500"></span>
                    </span>
                    Работает без интернета
                </div>
            @endif

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

    <!-- Input Form Wrapper with Shared State -->
    <div x-data="{ 
        showCarbsTable: false,
        modalTotalCarbs: 0,
        modalItemCount: 0,
        selectedItems: [],
        foodCategories: [
            {
                name: 'Хлеб и выпечка',
                icon: '🍞',
                color: 'bg-amber-500',
                items: [
                    { name: 'Хлеб белый (1 ломтик, 30г)', carbs: 15 },
                    { name: 'Хлеб чёрный (1 ломтик, 30г)', carbs: 13 },
                    { name: 'Хлеб Бородинский (1 ломтик, 35г)', carbs: 15 },
                    { name: 'Батон (1 ломтик, 25г)', carbs: 12 },
                    { name: 'Булочка (1 шт, 50г)', carbs: 25 },
                    { name: 'Блин (1 шт, 50г)', carbs: 15 },
                    { name: 'Лаваш (50г)', carbs: 24 },
                    { name: 'Сырник (1 шт, 50г)', carbs: 10 },
                    { name: 'Печенье (1 шт, 10г)', carbs: 7 },
                    { name: 'Сушка/Баранка (1 шт, 15г)', carbs: 10 }
                ]
            },
            {
                name: 'Крупы и гарниры (готовые)',
                icon: '🍚',
                color: 'bg-emerald-500',
                items: [
                    { name: 'Рис отварной (100г)', carbs: 26 },
                    { name: 'Гречка отварная (100г)', carbs: 18 },
                    { name: 'Макароны отварные (100г)', carbs: 25 },
                    { name: 'Пюре картофельное (100г)', carbs: 15 },
                    { name: 'Плов с мясом (100г)', carbs: 28 },
                    { name: 'Овсяная каша (100г)', carbs: 15 },
                    { name: 'Булгур отварной (100г)', carbs: 19 },
                    { name: 'Перловка отварная (100г)', carbs: 22 },
                    { name: 'Чечевица отварная (100г)', carbs: 20 },
                    { name: 'Картофель жареный (100г)', carbs: 25 }
                ]
            },
            {
                name: 'Основные блюда',
                icon: '🍲',
                color: 'bg-rose-500',
                items: [
                    { name: 'Пельмени (100г ~6 шт)', carbs: 28 },
                    { name: 'Вареники с картофелем (100г)', carbs: 30 },
                    { name: 'Котлета мясная (1 шт, хлеб внутри)', carbs: 5 },
                    { name: 'Голубцы (100г)', carbs: 10 },
                    { name: 'Борщ (250мл, средняя тарелка)', carbs: 12 },
                    { name: 'Сосиска (1 шт)', carbs: 2 },
                    { name: 'Блинчик с творогом (1 шт)', carbs: 18 },
                    { name: 'Омлет (из 2 яиц с молоком)', carbs: 3 }
                ]
            },
            {
                name: 'Фастфуд и перекусы',
                icon: '🍔',
                color: 'bg-yellow-500',
                items: [
                    { name: 'Шаурма/Донер (1 шт, ~350г)', carbs: 55 },
                    { name: 'Бургер классический (1 шт)', carbs: 40 },
                    { name: 'Картофель фри (средний, 100г)', carbs: 35 },
                    { name: 'Пирожок с картошкой (1 шт)', carbs: 25 },
                    { name: 'Пирожок с мясом (1 шт)', carbs: 20 },
                    { name: 'Чебурек (1 шт, ~100г)', carbs: 25 },
                    { name: 'Сосиска в тесте (1 шт)', carbs: 28 },
                    { name: 'Наггетсы (6 шт)', carbs: 15 },
                    { name: 'Хот-дог классический (1 шт)', carbs: 30 },
                    { name: 'Сэндвич с ветчиной (1 шт)', carbs: 25 }
                ]
            },
            {
                name: 'Фрукты и ягоды',
                icon: '🍎',
                color: 'bg-red-500',
                items: [
                    { name: 'Яблоко (1 среднее, 150г)', carbs: 18 },
                    { name: 'Банан (1 средний, 120г)', carbs: 25 },
                    { name: 'Апельсин (1 средний, 150г)', carbs: 15 },
                    { name: 'Груша (1 средняя, 150г)', carbs: 16 },
                    { name: 'Мандарин (1 шт, 80г)', carbs: 8 },
                    { name: 'Виноград (100г)', carbs: 18 },
                    { name: 'Арбуз (200г мякоти)', carbs: 12 },
                    { name: 'Дыня (200г мякоти)', carbs: 15 },
                    { name: 'Клубника (100г)', carbs: 7 },
                    { name: 'Сок фруктовый (200мл)', carbs: 24 }
                ]
            },
            {
                name: 'Овощи и салаты',
                icon: '🥕',
                color: 'bg-orange-500',
                items: [
                    { name: 'Картофель варёный (100г)', carbs: 17 },
                    { name: 'Винегрет (100г)', carbs: 10 },
                    { name: 'Салат Оливье (100г)', carbs: 8 },
                    { name: 'Морковь сырая (100г)', carbs: 7 },
                    { name: 'Свёкла варёная (100г)', carbs: 10 },
                    { name: 'Огурцы/Помидоры (100г)', carbs: 3.5 },
                    { name: 'Капуста свежая (100г)', carbs: 5 },
                    { name: 'Перец сладкий (100г)', carbs: 6 }
                ]
            },
            {
                name: 'Молочные продукты',
                icon: '🥛',
                color: 'bg-blue-500',
                items: [
                    { name: 'Молоко (200мл)', carbs: 10 },
                    { name: 'Кефир/Ряженка (200мл)', carbs: 8 },
                    { name: 'Йогурт сладкий (150г)', carbs: 18 },
                    { name: 'Йогурт натуральный (150г)', carbs: 7 },
                    { name: 'Сырок глазированный (1 шт)', carbs: 16 },
                    { name: 'Творожная масса (100г)', carbs: 15 }
                ]
            },
            {
                name: 'Сладости',
                icon: '🍫',
                color: 'bg-pink-500',
                items: [
                    { name: 'Сахар (1 ч.л., 5г)', carbs: 5 },
                    { name: 'Мед (1 ч.л., 10г)', carbs: 8 },
                    { name: 'Шоколад молочный (30г)', carbs: 17 },
                    { name: 'Конфета шоколадная (1 шт)', carbs: 8 },
                    { name: 'Зефир (1 шт, 35г)', carbs: 28 },
                    { name: 'Мороженое пломбир (100г)', carbs: 22 },
                    { name: 'Торт (100г)', carbs: 55 },
                    { name: 'Халва (30г)', carbs: 15 },
                    { name: 'Сгущенное молоко (1 ст.л.)', carbs: 10 },
                    { name: 'Квас (200мл)', carbs: 12 }
                ]
            }
        ],
        
        addCarbsToModal(item) {
            this.modalTotalCarbs += item.carbs;
            this.modalItemCount++;
            this.selectedItems.push({
                id: Date.now() + Math.random(),
                name: item.name,
                carbs: item.carbs
            });
        },

        removeItem(id) {
            const index = this.selectedItems.findIndex(i => i.id === id);
            if (index > -1) {
                this.modalTotalCarbs -= this.selectedItems[index].carbs;
                this.modalItemCount--;
                this.selectedItems.splice(index, 1);
            }
        },
        
        applyCarbs() {
            this.carbs = this.modalTotalCarbs;
            this.showCarbsTable = false;
        },
        
        openCarbsTable() {
            this.modalTotalCarbs = 0;
            this.modalItemCount = 0;
            this.selectedItems = [];
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
                                <svg xmlns="http://www.w3.org/2000/svg" fill="none" viewBox="0 0 24 24"
                                    stroke-width="2.5" stroke="currentColor" class="w-6 h-6">
                                    <path stroke-linecap="round" stroke-linejoin="round"
                                        d="M15.75 10.5V6a3.75 3.75 0 10-7.5 0v4.5m11.356-1.993l1.263 12c.07.665-.45 1.243-1.119 1.243H4.25a1.125 1.125 0 01-1.12-1.243l1.264-12A1.125 1.125 0 015.513 7.5h12.974c.576 0 1.059.435 1.119 1.007z" />
                                </svg>
                            </div>
                            <div>
                                <h3 class="font-bold text-lg md:text-xl">Калькулятор еды</h3>
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
                                <svg xmlns="http://www.w3.org/2000/svg" fill="none" viewBox="0 0 24 24"
                                    stroke-width="2.5" stroke="currentColor" class="w-6 h-6">
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
                                    <svg xmlns="http://www.w3.org/2000/svg" fill="none" viewBox="0 0 24 24"
                                        stroke-width="3" stroke="currentColor" class="w-3 h-3">
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
                                        <button @click="addCarbsToModal(item)"
                                            :class="selectedItems.some(i => i.name === item.name) 
                                                ? 'bg-rose-50 dark:bg-rose-900/20 border-rose-300 dark:border-rose-700 shadow-sm ring-1 ring-rose-500/20' 
                                                : 'bg-white dark:bg-zinc-800 border-zinc-200 dark:border-zinc-700/50 hover:border-cyan-300 dark:hover:border-cyan-600'"
                                            class="flex justify-between items-center p-3 rounded-xl transition-all group text-left shadow-sm hover:shadow-md active:scale-[0.98] outline-none focus:ring-2 focus:ring-cyan-500/50 cursor-pointer border-2">

                                            <div class="flex flex-col">
                                                <span class="text-sm font-medium transition-colors"
                                                    :class="selectedItems.some(i => i.name === item.name) ? 'text-rose-700 dark:text-rose-300' : 'text-zinc-700 dark:text-zinc-300 group-hover:text-cyan-800 dark:group-hover:text-cyan-200'"
                                                    x-text="item.name"></span>
                                            </div>

                                            <div class="flex items-center gap-2">
                                                <!-- Checkmark for selected -->
                                                <div x-show="selectedItems.some(i => i.name === item.name)" x-transition
                                                    class="w-5 h-5 bg-rose-500 rounded-full flex items-center justify-center">
                                                    <svg xmlns="http://www.w3.org/2000/svg" fill="none"
                                                        viewBox="0 0 24 24" stroke-width="3" stroke="currentColor"
                                                        class="w-3 h-3 text-white">
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
    <div x-show="warning" x-cloak x-transition:enter="transition ease-out duration-300"
        x-transition:enter-start="opacity-0 scale-95" x-transition:enter-end="opacity-100 scale-100"
        class="bg-red-50 dark:bg-red-900/20 border-2 border-red-300 dark:border-red-700 rounded-xl p-4 mb-6">
        <p class="text-red-800 dark:text-red-300 font-semibold text-center" x-text="warning"></p>
    </div>

    <!-- Result Display -->
    <div x-show="result" x-cloak x-transition:enter="transition ease-out duration-300"
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
    <!-- Custom Scrollbar Styles -->
    <style>
        .custom-scrollbar::-webkit-scrollbar {
            width: 8px;
        }

        .custom-scrollbar::-webkit-scrollbar-track {
            background: rgba(0, 0, 0, 0.05);
            border-radius: 10px;
        }

        .custom-scrollbar::-webkit-scrollbar-thumb {
            background: #06b6d4;
            /* cyan-500 */
            border-radius: 10px;
            border: 2px solid transparent;
            background-clip: content-box;
        }

        .custom-scrollbar::-webkit-scrollbar-thumb:hover {
            background: #0891b2;
            /* cyan-600 */
        }

        /* Horizontal Scrollbar specifically for the selected items list */
        .custom-scrollbar-horizontal::-webkit-scrollbar {
            height: 6px;
        }

        .custom-scrollbar-horizontal::-webkit-scrollbar-track {
            background: rgba(255, 255, 255, 0.1);
            border-radius: 10px;
            margin: 0 10px;
        }

        .custom-scrollbar-horizontal::-webkit-scrollbar-thumb {
            background: rgba(255, 255, 255, 0.4);
            border-radius: 10px;
        }

        .custom-scrollbar-horizontal::-webkit-scrollbar-thumb:hover {
            background: rgba(255, 255, 255, 0.6);
        }

        /* For Firefox */
        .custom-scrollbar {
            scrollbar-width: thin;
            scrollbar-color: #06b6d4 rgba(0, 0, 0, 0.05);
        }

        .custom-scrollbar-horizontal {
            scrollbar-width: thin;
            scrollbar-color: rgba(255, 255, 255, 0.4) rgba(255, 255, 255, 0.1);
        }
    </style>
</div>