@section('seo-meta')
    <x-seo-meta title="Справочник углеводов и хлебных единиц (ХЕ) для диабетиков"
        description="Полная таблица содержания углеводов в продуктах питания. Удобный поиск и расчет углеводов для точной дозировки инсулина при диабете 1 и 2 типа."
        keywords="справочник углеводов, таблица хлебных единиц, сколько углеводов в продуктах, питание диабетиков, расчет инсулина, база продуктов диабет"
        type="website" />
    <x-schema-org type="website" />
    <x-schema-org type="faq" :data="[
            'questions' => [
                ['question' => 'Что такое Хлебная Единица (ХЕ)?', 'answer' => 'Хлебная единица (ХЕ) — это условная мера, используемая диабетиками для примерной оценки количества углеводов в продуктах. Одна ХЕ обычно равна 10-12 граммам усваиваемых углеводов.'],
                ['question' => 'Как рассчитать углеводы в готовом блюде?', 'answer' => 'Нужно взвесить продукт перед приготовлением или найти его в нашей таблице готовых блюд. Умножьте вес вашей порции (в граммах) на количество углеводов в 100г продукта и разделите на 100.'],
                ['question' => 'Зачем считать углеводы при диабете?', 'answer' => 'Точный подсчет углеводов необходим для расчета правильной дозировки инсулина короткого действия перед едой, что позволяет избежать резких скачков сахара в крови (гипергликемии).'],
            ]
        ]" />
@endsection

<x-layouts.app title="Справочник углеводов">
    <script>
        window.carbsTableConfig = @json(config('carbs'));

        window.initCarbsTable = function () {
            return {
                search: '',
                activeCategory: 'Хлеб и выпечка',
                categories: window.carbsTableConfig || [],

                get allItems() {
                    let items = [];
                    this.categories.forEach(cat => {
                        cat.items.forEach(item => {
                            items.push({
                                ...item,
                                categoryName: cat.name,
                                categoryIcon: cat.icon,
                                color: cat.color
                            });
                        });
                    });
                    return items;
                },

                get filteredItems() {
                    if (this.activeCategory === 'all') {
                        if (this.search === '') return this.allItems;
                        return this.allItems.filter(item =>
                            item.name.toLowerCase().includes(this.search.toLowerCase())
                        );
                    }

                    // Filter by specific category
                    const category = this.categories.find(c => c.name === this.activeCategory);
                    if (!category) return [];

                    let items = category.items.map(item => ({
                        ...item,
                        categoryName: category.name,
                        categoryIcon: category.icon,
                        color: category.color
                    }));

                    if (this.search !== '') {
                        items = items.filter(item =>
                            item.name.toLowerCase().includes(this.search.toLowerCase())
                        );
                    }

                    return items;
                }
            }
        }
    </script>

    <div class="bg-white dark:bg-zinc-900 rounded-xl border border-zinc-200 dark:border-zinc-800 shadow-sm overflow-hidden"
        x-data="window.initCarbsTable()">

        <!-- Header & Controls -->
        <div class="border-b border-zinc-100 dark:border-zinc-800 bg-white dark:bg-zinc-900 p-6 space-y-6">
            <!-- Title & Search Row -->
            <div class="flex flex-col md:flex-row gap-4 justify-between items-start md:items-center">
                <div class="flex items-center gap-3">
                    <div
                        class="w-12 h-12 rounded-xl bg-cyan-100 dark:bg-cyan-900/30 flex items-center justify-center text-2xl shrink-0 text-cyan-600 dark:text-cyan-400">
                        🍞
                    </div>
                    <div>
                        <h1 class="text-xl font-bold text-zinc-900 dark:text-zinc-100">
                            Справочник углеводов
                        </h1>
                        <p class="text-sm text-zinc-500 dark:text-zinc-400">
                            База знаний для расчета ХЕ
                        </p>
                    </div>
                </div>

                <!-- Search -->
                <div class="relative w-full md:w-96">
                    <input type="text" x-model="search" placeholder="Поиск продукта (рис, яблоко, хлеб)..."
                        class="w-full pl-10 pr-10 py-2.5 bg-zinc-50 dark:bg-zinc-800/50 border border-zinc-200 dark:border-zinc-700 rounded-lg focus:ring-2 focus:ring-cyan-500/20 focus:border-cyan-500 transition-all text-sm font-medium">
                    <div class="absolute left-3 top-2.5 text-zinc-400">
                        <svg class="w-5 h-5" fill="none" viewBox="0 0 24 24" stroke="currentColor">
                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
                                d="M21 21l-6-6m2-5a7 7 0 11-14 0 7 7 0 0114 0z" />
                        </svg>
                    </div>
                    <button x-show="search.length > 0" @click="search = ''"
                        class="absolute right-3 top-2.5 text-zinc-400 hover:text-zinc-600 cursor-pointer">
                        <svg class="w-5 h-5" fill="none" viewBox="0 0 24 24" stroke="currentColor">
                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
                                d="M6 18L18 6M6 6l12 12" />
                        </svg>
                    </button>
                </div>
            </div>

            <!-- Categories Grid (Full View) -->
            <div class="flex flex-wrap gap-2">
                <template x-for="cat in categories" :key="cat.name">
                    <button @click="activeCategory = cat.name"
                        :class="activeCategory === cat.name 
                            ? 'bg-cyan-500 text-white border-cyan-500 shadow-md shadow-cyan-500/20' 
                            : 'bg-white dark:bg-zinc-800 text-zinc-600 dark:text-zinc-400 border-zinc-200 dark:border-zinc-700 hover:border-cyan-400 dark:hover:border-cyan-600 hover:bg-cyan-50 dark:hover:bg-cyan-900/10'"
                        class="px-3 py-1.5 rounded-lg text-xs font-bold border transition-all flex items-center gap-1.5 hover:shadow-sm">
                        <span x-text="cat.icon"></span>
                        <span x-text="cat.name"></span>
                    </button>
                </template>
            </div>
        </div>

        <!-- Table Grid View (No Header, 2 Cols) -->
        <div class="bg-white dark:bg-zinc-900 flex flex-col pt-2">
            <!-- Content Grid 2-Cols -->
            <div
                class="grid grid-cols-1 lg:grid-cols-2 lg:gap-x-12 divide-y lg:divide-y-0 divide-zinc-100 dark:divide-zinc-800/50 px-4 md:px-6">
                <template x-for="(item, index) in filteredItems" :key="item.name">
                    <div
                        class="flex items-center justify-between py-4 hover:bg-zinc-50 dark:hover:bg-zinc-800/50 transition-colors border-b border-zinc-100 dark:border-zinc-800/50 lg:border-dashed lg:border-zinc-200 dark:lg:border-zinc-800 group rounded-lg px-2 -mx-2">
                        <div class="flex items-center gap-4 overflow-hidden">
                            <div class="w-10 h-10 rounded-xl bg-zinc-50 dark:bg-zinc-800 border border-zinc-100 dark:border-zinc-700 flex items-center justify-center text-lg shrink-0 transition-transform group-hover:scale-105 shadow-sm"
                                x-text="item.categoryIcon"></div>
                            <div class="font-bold text-zinc-700 dark:text-zinc-200 text-sm md:text-base leading-tight truncate pr-2"
                                x-text="item.name"></div>
                        </div>
                        <div class="text-right whitespace-nowrap pl-2 flex flex-col items-end">
                            <div>
                                <span
                                    class="font-black text-lg text-cyan-600 dark:text-cyan-400 font-mono tracking-tight"
                                    x-text="item.carbs"></span>
                                <span class="text-xs font-bold text-zinc-400 ml-0.5">г</span>
                            </div>
                        </div>
                    </div>
                </template>
            </div>

            <!-- Empty State -->
            <div x-show="filteredItems.length === 0"
                class="flex flex-col items-center justify-center py-16 text-center">
                <div class="text-zinc-300 dark:text-zinc-700 text-5xl mb-3 grayscale opacity-50">🍽️</div>
                <p class="text-zinc-500 dark:text-zinc-400 font-medium">В этой категории пока пусто</p>
                <button @click="activeCategory = 'all'" class="text-cyan-600 text-sm mt-2 hover:underline">Сбросить
                    фильтры</button>
            </div>
        </div>

        <!-- SEO Content Block -->
        <article class="p-6 md:p-8 bg-white dark:bg-zinc-900 border-t border-zinc-100 dark:border-zinc-800">
            <h2 class="text-xl font-bold text-zinc-800 dark:text-zinc-100 mb-4">Как считать углеводы?</h2>
            <div
                class="prose prose-zinc dark:prose-invert max-w-none text-sm leading-relaxed text-zinc-600 dark:text-zinc-400">
                <p>
                    Для точного расчета дозы инсулина важно знать количество углеводов в порции еды.
                    Обычно 10-12 г углеводов принимают за <strong>1 Хлебную Единицу (ХЕ)</strong>.
                </p>
                <p>
                    <strong>Пример расчета:</strong><br>
                    Если в 100г вареного риса содержится 26г углеводов, а вы съели 150г риса:<br>
                    <code>(26г / 100) * 150 = 39г углеводов</code>.
                    Это примерно 3-4 ХЕ.
                </p>
                <div
                    class="mt-4 p-4 bg-amber-50 dark:bg-amber-900/10 rounded-xl border border-amber-100 dark:border-amber-800/30 text-amber-800 dark:text-amber-200 text-xs">
                    ⚠️ Данные в таблице являются усредненными. Всегда проверяйте информацию на упаковке конкретного
                    продукта, так как рецептура может отличаться.
                </div>
            </div>
        </article>
    </div>

    <!-- Static Content for SEO Bots -->
    <noscript>
        <div class="p-8 bg-white border-t border-zinc-200 mt-8 container mx-auto">
            <h3 class="text-xl font-bold mb-4">Полный список продуктов и содержание углеводов</h3>
            @foreach(config('carbs') as $category)
                <div class="mb-8">
                    <h4 class="font-bold text-lg mb-2 text-zinc-800">{{ $category['name'] }}</h4>
                    <ul class="grid grid-cols-1 md:grid-cols-2 gap-2 text-sm text-zinc-600">
                        @foreach($category['items'] as $item)
                            <li>
                                <strong>{{ $item['name'] }}</strong> — {{ $item['carbs'] }}г углеводов
                            </li>
                        @endforeach
                    </ul>
                </div>
            @endforeach
        </div>
    </noscript>

</x-layouts.app>