@section('seo-meta')
    <x-seo-meta title="Что можно есть при сахарном диабете 1 и 2 типа — Таблица продуктов"
        description="Узнайте, какие продукты можно употреблять при сахарном диабете. Полный справочник с цветовой индикацией: можно, с осторожностью или нельзя."
        keywords="что можно есть при сахарном диабете, можно ли при диабете, запрещенные продукты при диабете, питание при диабете"
        type="website" />
    <x-schema-org type="website" />
    <x-schema-org type="faq" :data="[
            'questions' => [
                ['question' => 'Что можно есть при сахарном диабете?', 'answer' => 'При диабете рекомендуется употреблять продукты с низким гликемическим индексом: овощи (кроме картофеля), постное мясо, рыбу, цельнозерновые крупы и несладкие фрукты.'],
                ['question' => 'Можно ли мед при диабете?', 'answer' => 'Мед содержит глюкозу и фруктозу, которые быстро повышают сахар. Употреблять его можно только в очень малых количествах (до 1 ч.л. в день) при условии стабильной компенсации.'],
                ['question' => 'Можно ли арбуз при сахарном диабете?', 'answer' => 'Арбуз имеет высокий гликемический индекс (75-80), что вызывает резкий скачок сахара. Он не рекомендуется или допустим в минимальных количествах (100-150г) с учетом ХЕ.'],
            ]
        ]" />
@endsection

<x-layouts.app title="Можно ли при сахарном диабете?">
    <div class="bg-white dark:bg-zinc-900 rounded-2xl border border-cyan-200/50 dark:border-cyan-800/30 shadow-sm overflow-hidden"
        x-data="{
            search: '',
            activeCategory: 'all',
            items: [
                // Сладости
                { name: 'Сахар', status: 'danger', category: 'sweets', note: 'Вызывает резкий скачок глюкозы. Замените на качественные сахарозаменители.' },
                { name: 'Мед', status: 'warning', category: 'sweets', note: 'В небольших количествах (1 ч.л.), если сахар в норме.' },
                { name: 'Горький шоколад (75%+)', status: 'success', category: 'sweets', note: 'Допустимо 20-30г в день. Полезен для сосудов.' },
                { name: 'Шоколад молочный', status: 'danger', category: 'sweets', note: 'Высокое содержание сахара и жира.' },
                { name: 'Зефир / Пастила', status: 'danger', category: 'sweets', note: 'Высокий гликемический индекс. Не рекомендуется.' },
                { name: 'Стевия / Эритрит', status: 'success', category: 'sweets', note: 'Натуральные заменители сахара с нулевым ГИ.' },
                { name: 'Варенье на сахаре', status: 'danger', category: 'sweets', note: 'Концентрат сахара. Избегайте.' },
                { name: 'Халва', status: 'danger', category: 'sweets', note: 'Очень калорийна и сильно поднимает сахар.' },
                { name: 'Сушки / Сухари', status: 'danger', category: 'sweets', note: 'Высокий ГИ, быстрые углеводы из белой муки.' },
                
                // Фрукты и ягоды
                { name: 'Яблоки (зеленые)', status: 'success', category: 'fruits', note: 'Богаты клетчаткой, низкий ГИ. Идеально на перекус.' },
                { name: 'Арбуз', status: 'danger', category: 'fruits', note: 'Очень высокий ГИ. Быстрый подъем сахара.' },
                { name: 'Виноград', status: 'danger', category: 'fruits', note: 'Много фруктозы и глюкозы. Избегайте.' },
                { name: 'Грейпфрут', status: 'success', category: 'fruits', note: 'Помогает снижать инсулинорезистентность.' },
                { name: 'Банан (спелый)', status: 'danger', category: 'fruits', note: 'Много крахмала и сахара. С осторожностью.' },
                { name: 'Груша', status: 'success', category: 'fruits', note: 'Хороший источник клетчатки. Выбирайте твердые сорта.' },
                { name: 'Клубника / Малина', status: 'success', category: 'fruits', note: 'Низкий ГИ. Допустимо 1-2 стакана в день.' },
                { name: 'Вишня / Черешня', status: 'success', category: 'fruits', note: 'Низкий ГИ, содержат антоцианы.' },
                { name: 'Черника', status: 'success', category: 'fruits', note: 'Очень полезна для зрения при диабете.' },
                { name: 'Дыня', status: 'danger', category: 'fruits', note: 'Высокий ГИ. Сильно влияет на гликемию.' },
                { name: 'Персики / Абрикосы', status: 'success', category: 'fruits', note: 'В умеренных количествах (1-2 шт).' },
                
                // Напитки
                { name: 'Чистая вода', status: 'success', category: 'drinks', note: 'Основа рациона. Без ограничений.' },
                { name: 'Фруктовые соки (пакет)', status: 'danger', category: 'drinks', note: 'Избегайте! Нет клетчатки, только сахар.' },
                { name: 'Сладкая газировка', status: 'danger', category: 'drinks', note: 'Худший продукт для диабетика.' },
                { name: 'Пиво', status: 'danger', category: 'drinks', note: 'Высокий ГИ, риск тяжелой гипогликемии позже.' },
                { name: 'Квас (магазинный)', status: 'danger', category: 'drinks', note: 'В промышленном квасе очень много сахара.' },
                { name: 'Чай / Кофе (без сахара)', status: 'success', category: 'drinks', note: 'Можно, но следите за давлением.' },
                { name: 'Вино сухое', status: 'warning', category: 'drinks', note: 'Допустимо редко (1 бокал) строго во время еды.' },
                { name: 'Компот без сахара', status: 'success', category: 'drinks', note: 'Отличная альтернатива сокам.' },
                
                // Овощи
                { name: 'Огурцы / Помидоры', status: 'success', category: 'veggies', note: 'Почти не содержат углеводов. Можно много.' },
                { name: 'Капуста любая', status: 'success', category: 'veggies', note: 'Брокколи, цветная, белокочанная — лучшие друзья.' },
                { name: 'Квашеная капуста', status: 'success', category: 'veggies', note: 'Суперфуд! Пробиотики и витамин С, 0 сахара.' },
                { name: 'Картофель вареный / Пюре', status: 'danger', category: 'veggies', note: 'Высокий крахмал. Сильно поднимает сахар.' },
                { name: 'Картофель запеченный', status: 'warning', category: 'veggies', note: 'Лучше, чем пюре, но порция должна быть малой.' },
                { name: 'Морковь сырая', status: 'success', category: 'veggies', note: 'Низкий ГИ, много витаминов.' },
                { name: 'Свекла вареная', status: 'warning', category: 'veggies', note: 'Содержит много сахаров. Контролируйте порцию.' },
                { name: 'Кабачки / Баклажаны', status: 'success', category: 'veggies', note: 'Низкий ГИ. Полезны в тушеном виде.' },
                { name: 'Зелень / Салаты', status: 'success', category: 'veggies', note: 'Основа любого приема пищи.' },
                { name: 'Тыква', status: 'warning', category: 'veggies', note: 'Средний ГИ, содержит полезную клетчатку.' },

                // Белки (Мясо/Рыба)
                { name: 'Куриная грудка', status: 'success', category: 'protein', note: 'Постный белок. Основа питания.' },
                { name: 'Индейка', status: 'success', category: 'protein', note: 'Отличный диетический выбор.' },
                { name: 'Рыба белая / жирная', status: 'success', category: 'protein', note: 'Омега-3 крайне важна при диабете.' },
                { name: 'Яйца куриные', status: 'success', category: 'protein', note: 'До 2-х шт в день. Почти не влияют на сахар.' },
                { name: 'Сало (без добавок)', status: 'success', category: 'protein', note: 'Чистые жиры, 0 ГИ. В умеренных количествах полезно.' },
                { name: 'Колбаса вареная', status: 'warning', category: 'protein', note: 'Скрытый крахмал и много жира. Не лучший выбор.' },
                { name: 'Свинина жирная', status: 'warning', category: 'protein', note: 'Много лишнего жира. Выбирайте постные части.' },
                { name: 'Пельмени / Вареники', status: 'danger', category: 'protein', note: 'Сочетание теста и жира — удар по сахару.' },
                { name: 'Морепродукты', status: 'success', category: 'protein', note: 'Белок и микроэлементы. Очень полезно.' },

                // Крупы и Хлеб
                { name: 'Гречка', status: 'success', category: 'grains', note: 'Медленные углеводы. Лучшая крупа для диабетика.' },
                { name: 'Овсянка (цельная)', status: 'success', category: 'grains', note: 'Хороший завтрак, но не варите в кашу.' },
                { name: 'Перловка', status: 'success', category: 'grains', note: 'Один из самых низких ГИ среди круп.' },
                { name: 'Белый рис', status: 'danger', category: 'grains', note: 'Шлифованный рис — это почти чистый сахар.' },
                { name: 'Бурый / Дикий рис', status: 'success', category: 'grains', note: 'Отличная замена белому рису.' },
                { name: 'Манная каша', status: 'danger', category: 'grains', note: 'Бесполезная крупа с высоким ГИ. Избегайте.' },
                { name: 'Макароны твердых сортов', status: 'warning', category: 'grains', note: 'Только аль денте и в умеренных количествах.' },
                { name: 'Белый хлеб / Булки', status: 'danger', category: 'grains', note: 'Резкий подъем глюкозы. Избегайте.' },
                { name: 'Ржаной хлеб (Бородинский)', status: 'warning', category: 'grains', note: 'Лучше белого, но содержит углеводы. Следите за порцией.' },
                { name: 'Цельнозерновой хлеб', status: 'success', category: 'grains', note: 'Больше клетчатки — медленнее подъем сахара.' },

                // Молочное
                { name: 'Кефир / Натуральный йогурт', status: 'success', category: 'dairy', note: 'Полезно для ЖКТ. Без сахара.' },
                { name: 'Молоко', status: 'warning', category: 'dairy', note: 'Содержит лактозу (молочный сахар). Следите за порцией.' },
                { name: 'Творог (до 5%)', status: 'success', category: 'dairy', note: 'Источник кальция и белка.' },
                { name: 'Сыр твердый', status: 'success', category: 'dairy', note: 'Белок и жиры. Но не переедайте из-за соли.' },
                { name: 'Сметана (10-15%)', status: 'success', category: 'dairy', note: 'В умеренных количествах допустима.' },
                { name: 'Сладкие творожки', status: 'danger', category: 'dairy', note: 'Концентрат сахара и жира.' },

                // Орехи и семечки
                { name: 'Грецкие орехи', status: 'success', category: 'nuts', note: 'Источник Омега-3. Очень полезны для мозга.' },
                { name: 'Миндаль', status: 'success', category: 'nuts', note: 'Снижает уровень плохого холестерина.' },
                { name: 'Семечки подсолнуха', status: 'success', category: 'nuts', note: 'Богаты витамином Е, но очень калорийны.' },
                { name: 'Тыквенные семечки', status: 'success', category: 'nuts', note: 'Источник цинка и магния.' },
                { name: 'Фундук', status: 'success', category: 'nuts', note: 'Полезен для сердца и сосудов.' },
                { name: 'Кешью', status: 'warning', category: 'nuts', note: 'Содержат больше углеводов, чем другие орехи.' },
                { name: 'Арахис', status: 'success', category: 'nuts', note: 'Низкий ГИ, но сильный аллерген.' },
                { name: 'Кедровые орешки', status: 'success', category: 'nuts', note: 'Полезны для иммунитета.' },

                // Чай и Травы
                { name: 'Иван-чай', status: 'success', category: 'herbs', note: 'Не содержит кофеина, успокаивает и укрепляет иммунитет.' },
                { name: 'Шиповник (отвар)', status: 'success', category: 'herbs', note: 'Кладезь витамина С. Варите без сахара.' },
                { name: 'Ромашка', status: 'success', category: 'herbs', note: 'Снимает воспаление и улучшает пищеварение.' },
                { name: 'Цикорий', status: 'success', category: 'herbs', note: 'Содержит инулин, который полезен для микрофлоры.' },
                { name: 'Черный / Зеленый чай', status: 'success', category: 'herbs', note: 'Без сахара можно пить свободно. Бодрит.' },
                { name: 'Мята / Мелисса', status: 'success', category: 'herbs', note: 'Отлично успокаивает нервную систему.' },
                { name: 'Листья черники', status: 'success', category: 'herbs', note: 'Традиционное средство для мягкого снижения сахара.' },
                { name: 'Каркаде', status: 'success', category: 'herbs', note: 'Богат антиоксидантами. В холодном виде освежает.' },
            ],
            categories: [
                { id: 'all', name: 'Все', icon: '📋' },
                { id: 'sweets', name: 'Сладости', icon: '🍫' },
                { id: 'fruits', name: 'Фрукты/Ягоды', icon: '🍎' },
                { id: 'veggies', name: 'Овощи', icon: '🥕' },
                { id: 'grains', name: 'Крупы/Хлеб', icon: '🌾' },
                { id: 'protein', name: 'Мясо/Рыба', icon: '🥩' },
                { id: 'dairy', name: 'Молочное', icon: '🥛' },
                { id: 'nuts', name: 'Орехи/Семечки', icon: '🌻' },
                { id: 'herbs', name: 'Чай/Травы', icon: '🌿' },
                { id: 'drinks', name: 'Напитки', icon: '☕' },
            ],
            get filteredItems() {
                return this.items.filter(item => {
                    const matchesSearch = item.name.toLowerCase().includes(this.search.toLowerCase());
                    const matchesCategory = this.activeCategory === 'all' || item.category === this.activeCategory;
                    return matchesSearch && matchesCategory;
                });
            }
        }">

        <!-- Header Section -->
        <div
            class="p-6 md:p-8 bg-gradient-to-br from-cyan-50 to-blue-50 dark:from-cyan-950/10 dark:to-blue-900/10 border-b border-cyan-100 dark:border-cyan-800/30">
            <h1 class="text-2xl md:text-3xl font-extrabold text-zinc-900 dark:text-zinc-100 mb-4 tracking-tight">
                🥗 Можно ли <span
                    class="bg-gradient-to-r from-cyan-600 to-blue-600 dark:from-cyan-400 dark:to-blue-400 bg-clip-text text-transparent">при
                    сахарном диабете</span>?
            </h1>
            <p class="text-zinc-600 dark:text-zinc-400 max-w-2xl leading-relaxed font-medium">
                Интерактивный справочник продуктов с цветовой индикацией. Мы поможем вам составить правильный рацион и
                понять, как те или иные продукты влияют на ваш уровень сахара.
            </p>
        </div>

        <!-- Search and Filters -->
        <div class="p-4 md:p-6 space-y-4">
            <!-- Search bar -->
            <div class="relative group">
                <div
                    class="absolute inset-y-0 left-0 pl-4 flex items-center pointer-events-none text-zinc-400 group-focus-within:text-cyan-500 transition-colors">
                    <svg class="h-5 w-5" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
                            d="M21 21l-6-6m2-5a7 7 0 11-14 0 7 7 0 0114 0z" />
                    </svg>
                </div>
                <input type="text" x-model="search" placeholder="Введите название продукта (например: мед, арбуз)..."
                    class="block w-full pl-11 pr-4 py-4 bg-zinc-50 dark:bg-zinc-800 border-2 border-zinc-100 dark:border-zinc-700 rounded-2xl focus:ring-0 focus:border-cyan-500 dark:focus:border-cyan-500 text-zinc-900 dark:text-zinc-100 placeholder-zinc-400 font-bold transition-all shadow-sm">
            </div>

            <!-- Categories Grid -->
            <div class="grid grid-cols-2 lg:flex lg:flex-wrap gap-2">
                <template x-for="cat in categories" :key="cat.id">
                    <button @click="activeCategory = cat.id"
                        :class="activeCategory === cat.id 
                            ? 'bg-gradient-to-r from-cyan-500 to-blue-500 text-white shadow-lg shadow-cyan-500/30 ring-2 ring-cyan-500 ring-offset-2 dark:ring-offset-zinc-900 border-transparent' 
                            : 'bg-white dark:bg-zinc-800 text-zinc-700 dark:text-zinc-300 border border-zinc-200 dark:border-zinc-700 hover:border-cyan-300 dark:hover:border-cyan-700'"
                        class="px-3 py-3 rounded-2xl text-xs md:text-sm font-bold transition-all flex items-center justify-center gap-2 border-2 text-center">
                        <span x-text="cat.icon" class="text-base"></span>
                        <span x-text="cat.name"></span>
                    </button>
                </template>
            </div>
        </div>

        <!-- Legend -->
        <div class="px-6 py-3 bg-zinc-50 dark:bg-zinc-800/50 flex flex-wrap gap-4 text-[11px] md:text-xs">
            <div class="flex items-center gap-1.5 font-bold text-emerald-600 dark:text-emerald-400">
                <div class="w-2.5 h-2.5 bg-emerald-500 rounded-full"></div> ПОЛЕЗНО / МОЖНО
            </div>
            <div class="flex items-center gap-1.5 font-bold text-amber-600 dark:text-amber-400">
                <div class="w-2.5 h-2.5 bg-amber-500 rounded-full"></div> УМЕРЕННО / С ОСТОРОЖНОСТЬЮ
            </div>
            <div class="flex items-center gap-1.5 font-bold text-rose-600 dark:text-rose-400">
                <div class="w-2.5 h-2.5 bg-rose-500 rounded-full"></div> НЕ РЕКОМЕНДУЕТСЯ / НЕЛЬЗЯ
            </div>
        </div>

        <!-- Results Grid -->
        <div class="p-4 md:p-8 min-h-[400px]">
            <div x-show="filteredItems.length === 0"
                class="flex flex-col items-center justify-center py-20 text-center opacity-50">
                <div class="text-5xl mb-4">🔍</div>
                <div class="font-bold text-zinc-500">Продукт не найден</div>
                <div class="text-xs">Попробуйте ввести другое название</div>
            </div>

            <div class="grid grid-cols-1 md:grid-cols-2 lg:grid-cols-3 gap-4" x-show="filteredItems.length > 0">
                <template x-for="item in filteredItems" :key="item.name">
                    <div :class="{
                            'border-emerald-200 dark:border-emerald-900/40 bg-emerald-50/30 dark:bg-emerald-950/20': item.status === 'success',
                            'border-amber-200 dark:border-amber-900/40 bg-amber-50/30 dark:bg-amber-950/20': item.status === 'warning',
                            'border-rose-200 dark:border-rose-900/40 bg-rose-50/30 dark:bg-rose-950/20': item.status === 'danger'
                        }"
                        class="p-5 rounded-2xl border-2 transition-all duration-300 hover:scale-[1.03] flex flex-col group">

                        <div class="flex items-center justify-between mb-3">
                            <h3 class="font-extrabold text-zinc-800 dark:text-zinc-100" x-text="item.name"></h3>
                            <!-- Badge -->
                            <div :class="{
                                    'bg-emerald-500': item.status === 'success',
                                    'bg-amber-500': item.status === 'warning',
                                    'bg-rose-500': item.status === 'danger'
                                }" class="w-3 h-3 rounded-full shadow-lg group-hover:animate-ping"></div>
                        </div>

                        <p class="text-sm text-zinc-600 dark:text-zinc-400 leading-relaxed italic" x-text="item.note">
                        </p>
                    </div>
                </template>
            </div>
        </div>

        <!-- SEO Content Block -->
        <article class="p-6 md:p-8 bg-zinc-50 dark:bg-zinc-800/30 border-t border-zinc-100 dark:border-zinc-800">
            <h2 class="text-xl font-bold text-zinc-800 dark:text-zinc-100 mb-4">Основные принципы питания при диабете
            </h2>
            <div
                class="prose prose-zinc dark:prose-invert max-w-none text-sm leading-relaxed text-zinc-600 dark:text-zinc-400">
                <p>
                    При диабете 1 и 2 типа питание играет ключевую роль в поддержании целевого уровня глюкозы в крови.
                    Важно обращать внимание не только на калорийность, но и на <strong>Гликемический индекс
                        (ГИ)</strong> продуктов.
                    ГИ — это показатель того, как быстро углеводы из продукта превращаются в сахар.
                </p>
                <ul>
                    <li><strong>Низкий ГИ (до 55):</strong> Углеводы усваиваются медленно, сахар растет плавно.</li>
                    <li><strong>Средний ГИ (56-69):</strong> Требуют осторожности и контроля порции.</li>
                    <li><strong>Высокий ГИ (от 70):</strong> Вызывают резкие скачки сахара. Употреблять не
                        рекомендуется.</li>
                </ul>
                <p class="mt-4">
                    Наш справочник регулярно обновляется. Помните, что реакция организма на продукты индивидуальна.
                    Всегда консультируйтесь со своим лечащим врачом.
                </p>
            </div>
        </article>
    </div>
</x-layouts.app>