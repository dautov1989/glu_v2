<header x-data="{ 
    openCategory: null, 
    mobileOpen: false, 
    toggleCategory(id) {
        if (this.openCategory === id) {
            this.openCategory = null;
        } else {
            this.openCategory = id;
        }
    },
    closeMenu() {
        this.openCategory = null;
    },
    megaMenu: [
        {
            id: 'symptoms',
            label: 'Симптомы',
            children: [
                {
                    label: 'Ранние признаки',
                    children: [
                        { label: 'Сильная жажда (Полидипсия)', children: [] },
                        { label: 'Частое мочеиспускание', children: [] },
                        { label: 'Повышенный аппетит', children: [] },
                        { label: 'Сухость во рту', children: [] },
                        { label: 'Резкая потеря веса', children: [] }
                    ]
                },
                {
                    label: 'Кожные проявления',
                    children: [
                        { label: 'Зуд и сухость кожи', children: [] },
                        { label: 'Медленное заживление ран', children: [] },
                        { label: 'Черный акантоз', children: [] },
                        { label: 'Грибковые инфекции', children: [] },
                        { label: 'Липодистрофия', children: [] }
                    ]
                },
                {
                    label: 'Неврологические',
                    children: [
                        { label: 'Онемение конечностей', children: [] },
                        { label: 'Покалывание в пальцах', children: [] },
                        { label: 'Судороги мышц', children: [] },
                        { label: 'Головокружения', children: [] }
                    ]
                },
                {
                    label: 'Острые состояния',
                    children: [
                        { label: 'Запах ацетона', children: [] },
                        { label: 'Спутанность сознания', children: [] },
                        { label: 'Глубокое дыхание', children: [] },
                        { label: 'Тошнота и рвота', children: [] }
                    ]
                }
            ]
        },
        {
            id: 'type1',
            label: 'Диабет 1 типа',
            children: [
                {
                    label: 'Инсулинотерапия',
                    children: [
                        { label: 'Ультракороткий инсулин', children: [{ label: 'Хумалог' }, { label: 'Новорапид' }, { label: 'Апидра' }, { label: 'Фиасп' }] },
                        { label: 'Короткий инсулин', children: [{ label: 'Актрапид' }, { label: 'Хумулин Р' }, { label: 'Инсуман Рапид' }] },
                        { label: 'Продленный инсулин', children: [{ label: 'Лантус' }, { label: 'Левемир' }, { label: 'Тресиба' }, { label: 'Туджео' }] },
                        { label: 'Смешанный инсулин', children: [{ label: 'Новомикс' }, { label: 'Хумалог Микс' }] }
                    ]
                },
                {
                    label: 'Гаджеты и Технологии',
                    children: [
                        { label: 'Инсулиновые помпы', children: [{ label: 'Medtronic 780G' }, { label: 'Omnipod DASH' }, { label: 'Accu-Chek Spirit' }] },
                        { label: 'Мониторинг (CGM)', children: [{ label: 'Dexcom G6/G7' }, { label: 'FreeStyle Libre 2/3' }, { label: 'Eversense' }] },
                        { label: 'Шприц-ручки', children: [{ label: 'NovoPen Echo' }, { label: 'HumaPen Savvio' }] },
                        { label: 'Порты для инъекций', children: [{ label: 'i-Port Advance' }] }
                    ]
                },
                {
                    label: 'Особые ситуации',
                    children: [
                        { label: 'Беременность', children: [{ label: 'Планирование' }, { label: '1 триместр' }, { label: 'Роды' }] },
                        { label: 'Детский диабет', children: [{ label: 'Школа' }, { label: 'Спорт секции' }, { label: 'Подростковый период' }] },
                        { label: 'Болезни и ОРВИ', children: [{ label: 'Кетоны' }, { label: 'Коррекция доз' }] }
                    ]
                },
                {
                    label: 'Обучение',
                    children: [
                        { label: 'Школа диабета', children: [{ label: 'Подсчет ХЕ' }, { label: 'Углеводный коэффициент' }, { label: 'Фактор чувствительности' }] },
                        { label: 'Психология', children: [{ label: 'Принятие диагноза' }, { label: 'Диабет-выгорание' }] }
                    ]
                }
            ]
        },
        {
            id: 'type2',
            label: 'Диабет 2 типа',
            children: [
                {
                    label: 'Медикаменты',
                    children: [
                        { label: 'Метформин', children: [{ label: 'Глюкофаж' }, { label: 'Сиофор' }, { label: 'Багомет' }] },
                        { label: 'Сульфонилмочевина', children: [{ label: 'Диабетон' }, { label: 'Амарил' }, { label: 'Манинил' }] },
                        { label: 'Ингибиторы ДПП-4', children: [{ label: 'Янувия' }, { label: 'Галвус' }, { label: 'Тражента' }] },
                        { label: 'Агонисты ГПП-1', children: [{ label: 'Оземпик' }, { label: 'Виктоза' }, { label: 'Трулисити' }] },
                        { label: 'Ингибиторы SGLT2', children: [{ label: 'Форсига' }, { label: 'Джардинс' }] }
                    ]
                },
                {
                    label: 'Осложнения',
                    children: [
                        { label: 'Зрение (Ретинопатия)', children: [{ label: 'Лазерная коагуляция' }, { label: 'Уколы в глаз' }] },
                        { label: 'Почки (Нефропатия)', children: [{ label: 'Микроальбуминурия' }, { label: 'Диализ' }] },
                        { label: 'Ноги (Нейропатия)', children: [{ label: 'Кабинет диабет-стопы' }, { label: 'Ортопедическая обувь' }] },
                        { label: 'Сердце и сосуды', children: [{ label: 'Гипертония' }, { label: 'Инфаркт/Инсульт' }] }
                    ]
                },
                {
                    label: 'Контроль веса',
                    children: [
                        { label: 'Диеты', children: [{ label: 'Стол №9' }, { label: 'Кето-диета' }, { label: 'Интервальное голодание' }] },
                        { label: 'Бариатрия', children: [{ label: 'Шунтирование' }, { label: 'Резекция желудка' }] }
                    ]
                },
                {
                    label: 'Профилактика',
                    children: [
                        { label: 'Предиабет', children: [{ label: 'Глюкозотолерантный тест' }, { label: 'Гликированный гемоглобин' }] },
                        { label: 'Образ жизни', children: [{ label: 'Отказ от курения' }, { label: 'Активность' }] }
                    ]
                }
            ]
        },
        {
            id: 'nutrition',
            label: 'Питание',
            children: [
                {
                    label: 'База знаний',
                    children: [
                        { label: 'Хлебные единицы (ХЕ)', children: [{ label: 'Таблицы ХЕ' }, { label: 'Весы и приложения' }] },
                        { label: 'Гликемический индекс', children: [{ label: 'Низкий (<55)' }, { label: 'Средний (55-69)' }, { label: 'Высокий (>70)' }] },
                        { label: 'Макронутриенты', children: [{ label: 'Белки' }, { label: 'Жиры' }, { label: 'Сложные углеводы' }] },
                        { label: 'Сахарозаменители', children: [{ label: 'Стевия' }, { label: 'Эритрит' }, { label: 'Сукралоза' }] }
                    ]
                },
                {
                    label: 'Категории продуктов',
                    children: [
                        { label: 'Овощи и Зелень', children: [{ label: 'Листовые' }, { label: 'Крестоцветные' }, { label: 'Корнеплоды' }] },
                        { label: 'Фрукты и Ягоды', children: [{ label: 'Цитрусовые' }, { label: 'Лесные ягоды' }, { label: 'Яблоки' }] },
                        { label: 'Крупы и Злаки', children: [{ label: 'Гречка' }, { label: 'Киноа' }, { label: 'Булгур' }, { label: 'Овсянка' }] },
                        { label: 'Молочные продукты', children: [{ label: 'Творог' }, { label: 'Йогурт' }, { label: 'Сыр' }] }
                    ]
                },
                {
                    label: 'Готовые меню',
                    children: [
                        { label: 'Завтраки', children: [{ label: 'Белковые' }, { label: 'Сложные углеводы' }] },
                        { label: 'Обеды', children: [{ label: 'Супы' }, { label: 'Мясные блюда' }, { label: 'Рыбные блюда' }] },
                        { label: 'Ужины', children: [{ label: 'Легкие салаты' }, { label: 'Овощные рагу' }] },
                        { label: 'Перекусы', children: [{ label: 'Орехи' }, { label: 'Протеиновые батончики' }] }
                    ]
                },
                {
                    label: 'Напитки и Жидкости',
                    children: [
                        { label: 'Вода и Чаи', children: [{ label: 'Травяные чаи' }, { label: 'Зеленый чай' }, { label: 'Минеральная вода' }] },
                        { label: 'Кофе', children: [{ label: 'Черный кофе' }, { label: 'С молоком' }] },
                        { label: 'Смузи', children: [{ label: 'Овощные' }, { label: 'Ягодные' }] },
                        { label: 'Запрещенные', children: [{ label: 'Газировка' }, { label: 'Пакетированные соки' }] }
                    ]
                }
            ]
        },
        {
            id: 'sport',
            label: 'Спорт',
            children: [
                {
                    label: 'Виды нагрузок',
                    children: [
                        { label: 'Аэробные (Кардио)', children: [{ label: 'Ходьба' }, { label: 'Бег' }, { label: 'Плавание' }, { label: 'Велоспорт' }] },
                        { label: 'Анаэробные (Силовые)', children: [{ label: 'Тренажерный зал' }, { label: 'Пауэрлифтинг' }, { label: 'Кроссфит' }] },
                        { label: 'Гибкость и Баланс', children: [{ label: 'Йога' }, { label: 'Пилатес' }, { label: 'Стретчинг' }] },
                        { label: 'Игровые виды', children: [{ label: 'Футбол' }, { label: 'Теннис' }, { label: 'Баскетбол' }] }
                    ]
                },
                {
                    label: 'Управление диабетом',
                    children: [
                        { label: 'Гипогликемия', children: [{ label: 'Симптомы' }, { label: 'Быстрые углеводы' }, { label: 'Глюкагон' }] },
                        { label: 'Коррекция инсулина', children: [{ label: 'Временный базал' }, { label: 'Уменьшение болюса' }] },
                        { label: 'Питание до/после', children: [{ label: 'Углеводная загрузка' }, { label: 'Белковое окно' }] }
                    ]
                },
                {
                    label: 'Экипировка и Гаджеты',
                    children: [
                        { label: 'Фитнес-трекеры', children: [{ label: 'Apple Watch' }, { label: 'Garmin' }, { label: 'Fitbit' }] },
                        { label: 'Спортивная одежда', children: [{ label: 'Компрессионная' }, { label: 'Влагоотводящая' }] },
                        { label: 'Обувь', children: [{ label: 'Для бега' }, { label: 'Для зала' }] },
                        { label: 'Аксессуары', children: [{ label: 'Пульсометры' }, { label: 'Повязки для CGM' }] }
                    ]
                },
                {
                    label: 'Мотивация и Планирование',
                    children: [
                        { label: 'Постановка целей', children: [{ label: 'SMART цели' }, { label: 'Трекинг прогресса' }] },
                        { label: 'Тренировочные планы', children: [{ label: 'Для начинающих' }, { label: 'Продвинутые' }] },
                        { label: 'Сообщества', children: [{ label: 'Диабет-спортсмены' }, { label: 'Онлайн группы' }] },
                        { label: 'Истории успеха', children: [{ label: 'Марафонцы' }, { label: 'Триатлонисты' }] }
                    ]
                }
            ]
        },
        {
            id: 'news',
            label: 'Новости',
            children: [
                {
                    label: 'Мировая наука',
                    children: [
                        { label: 'Клинические исследования', children: [{ label: 'Иммунотерапия' }, { label: 'Стволовые клетки' }] },
                        { label: 'Новые препараты', children: [{ label: 'Умные инсулины' }, { label: 'Таблетированный инсулин' }] },
                        { label: 'Генетика', children: [{ label: 'Скрининг' }, { label: 'Генная терапия' }] }
                    ]
                },
                {
                    label: 'Технологии',
                    children: [
                        { label: 'Искусственная поджелудочная', children: [{ label: 'Closed-loop системы' }, { label: 'DIY Loop/APS' }] },
                        { label: 'Неинвазивные глюкометры', children: [{ label: 'Часы' }, { label: 'Линзы' }, { label: 'Спектроскопия' }] }
                    ]
                },
                {
                    label: 'Сообщество',
                    children: [
                        { label: 'Личные истории', children: [{ label: 'Спортсмены' }, { label: 'Знаменитости' }] },
                        { label: 'Мероприятия', children: [{ label: 'Конференции' }, { label: 'Детские лагеря' }, { label: 'Марафоны' }] },
                        { label: 'Правовые вопросы', children: [{ label: 'Инвалидность' }, { label: 'Льготы' }, { label: 'Обеспечение' }] }
                    ]
                },
                {
                    label: 'Образование и Ресурсы',
                    children: [
                        { label: 'Онлайн-курсы', children: [{ label: 'Управление диабетом' }, { label: 'Кулинария' }] },
                        { label: 'Вебинары', children: [{ label: 'Эндокринологи' }, { label: 'Диетологи' }] },
                        { label: 'Книги и Публикации', children: [{ label: 'Научные статьи' }, { label: 'Практические руководства' }] },
                        { label: 'Подкасты и Видео', children: [{ label: 'YouTube каналы' }, { label: 'Подкасты' }] }
                    ]
                }
            ]
        }
    ]
}" 
@click.outside="closeMenu"
class="sticky top-0 z-50 w-full bg-white/90 backdrop-blur-md dark:bg-zinc-900/90 border-b border-zinc-200/50 dark:border-zinc-800/50 shadow-lg shadow-zinc-200/50 dark:shadow-zinc-900/50 transition-all duration-300">
    <div class="max-w-7xl mx-auto px-4 sm:px-6 lg:px-8">
        <div class="flex justify-between items-center h-20 gap-x-8">
            <!-- Logo -->
            <div class="flex-shrink-0 flex items-center">
                <a href="{{ route('home') }}" class="flex items-center gap-2 group">
                    <div class="bg-red-500 rounded-full p-1.5 text-white shadow-md shadow-red-500/30 group-hover:scale-110 transition-transform duration-300">
                        <svg xmlns="http://www.w3.org/2000/svg" viewBox="0 0 24 24" fill="currentColor" class="size-5">
                            <path d="M11.25 4.533A9.707 9.707 0 0 0 6 3a9.735 9.735 0 0 0-3.25.555.75.75 0 0 0-.5.516l-1.432 3.26a5.25 5.25 0 0 0 0 4.336l1.432 3.26a.75.75 0 0 0 .5.516H6c.536 0 1.064.034 1.582.1l-.012.025c-.15.312-.292.63-.426.95-.404.972-.726 2.005-.96 3.085a.75.75 0 0 0 .659.897 7.5 7.5 0 0 0 7.208-4.816A7.5 7.5 0 0 0 21.75 12a9.716 9.716 0 0 0-4.233-8.179.75.75 0 0 0-.815 1.161 8.216 8.216 0 0 1 3.548 7.018 6 6 0 0 1-11.52 1.98.75.75 0 0 0-1.5-.03 7.502 7.502 0 0 0-3.18 5.819 7.99 7.99 0 0 1-2.948-4.964 3.75 3.75 0 0 1 0-3.098 7.99 7.99 0 0 1 2.948-4.964A8.25 8.25 0 0 1 6 4.5c.693 0 1.366.09 2.007.259a.75.75 0 0 0 .848-.66c.096-.548.23-1.08.4-1.595.166-.51.382-1.003.64-1.471a.75.75 0 0 0-.645-1.133Z" />
                        </svg>
                    </div>
                    <span class="text-2xl font-bold tracking-tight text-zinc-800 dark:text-white">
                        Glucosa
                    </span>
                </a>
            </div>

            <!-- Navigation -->
            <nav class="hidden lg:flex items-center gap-6">
                <template x-for="category in megaMenu" :key="category.id">
                    <div class="relative">
                        <button @click="toggleCategory(category.id)" 
                                class="px-3 py-2 text-sm font-medium rounded-full transition-all duration-300 flex items-center gap-1"
                                :class="{ 
                                    'bg-cyan-50 text-cyan-600 dark:bg-cyan-900/30 dark:text-cyan-400': openCategory === category.id,
                                    'text-zinc-600 hover:text-cyan-600 hover:bg-zinc-50 dark:text-zinc-400 dark:hover:text-white dark:hover:bg-zinc-800': openCategory !== category.id
                                }">
                            <span x-text="category.label"></span>
                            <svg xmlns="http://www.w3.org/2000/svg" fill="none" viewBox="0 0 24 24" stroke-width="1.5" stroke="currentColor" class="w-4 h-4 transition-transform duration-200" :class="{ 'rotate-180': openCategory === category.id }">
                                <path stroke-linecap="round" stroke-linejoin="round" d="m19.5 8.25-7.5 7.5-7.5-7.5" />
                            </svg>
                        </button>

                        <!-- Mega Menu Dropdown -->
                        <div x-show="openCategory === category.id"
                             x-cloak
                             x-transition:enter="transition ease-out duration-200"
                             x-transition:enter-start="opacity-0 translate-y-1"
                             x-transition:enter-end="opacity-100 translate-y-0"
                             x-transition:leave="transition ease-in duration-150"
                             x-transition:leave-start="opacity-100 translate-y-0"
                             x-transition:leave-end="opacity-0 translate-y-1"
                             class="fixed left-0 right-0 top-[80px] mx-auto max-w-7xl px-4 sm:px-6 lg:px-8 z-50">
                            <div class="bg-white dark:bg-zinc-900 rounded-xl shadow-2xl border border-zinc-200 dark:border-zinc-800 overflow-hidden">
                            
                            <div class="p-8">
                                <h2 class="text-xl font-bold text-zinc-900 dark:text-white mb-6 flex items-center gap-2">
                                    <span x-text="category.label"></span>
                                    <span class="text-xs font-normal text-zinc-500 dark:text-zinc-400 px-2 py-0.5 bg-zinc-100 dark:bg-zinc-800 rounded-full">Категория</span>
                                </h2>
                                
                                <div class="grid grid-cols-4 gap-8">
                                    <template x-for="subSection in category.children" :key="subSection.label">
                                        <div class="space-y-4">
                                            <!-- Level 2 Header -->
                                            <h3 class="text-sm font-bold uppercase tracking-wider text-zinc-900 dark:text-zinc-200 border-b border-zinc-200 dark:border-zinc-700 pb-2" x-text="subSection.label"></h3>
                                            
                                            <!-- Level 3 & 4 List -->
                                            <ul class="space-y-3">
                                                <template x-for="type in subSection.children" :key="type.label">
                                                    <li>
                                                        <a href="#" class="text-sm font-medium text-cyan-600 dark:text-cyan-400 hover:underline block mb-1" x-text="type.label"></a>
                                                        <!-- Level 4 -->
                                                        <ul class="pl-0 space-y-1">
                                                            <template x-for="detail in type.children" :key="detail.label">
                                                                <li>
                                                                    <a href="#" class="text-xs text-zinc-500 dark:text-zinc-400 hover:text-zinc-800 dark:hover:text-zinc-200 transition-colors" x-text="detail.label"></a>
                                                                </li>
                                                            </template>
                                                        </ul>
                                                    </li>
                                                </template>
                                                <!-- If no children at level 3, just show empty state or nothing -->
                                                <template x-if="!subSection.children || subSection.children.length === 0">
                                                    <li class="text-xs text-zinc-400 italic">Нет подкатегорий</li>
                                                </template>
                                            </ul>
                                        </div>
                                    </template>
                                </div>
                            </div>
                            </div>
                        </div>
                    </div>
                </template>
            </nav>

            <!-- Mobile menu button -->
            <div class="lg:hidden flex items-center">
                <button type="button" 
                        @click="mobileOpen = !mobileOpen"
                        class="p-2 rounded-full text-zinc-500 hover:text-cyan-600 hover:bg-cyan-50 dark:hover:bg-zinc-800 transition-colors focus:outline-none focus:ring-2 focus:ring-inset focus:ring-cyan-500">
                    <span class="sr-only">Open menu</span>
                    <!-- Icon when menu is closed -->
                    <svg x-show="!mobileOpen" class="h-6 w-6" fill="none" viewBox="0 0 24 24" stroke-width="1.5" stroke="currentColor" aria-hidden="true">
                        <path stroke-linecap="round" stroke-linejoin="round" d="M3.75 6.75h16.5M3.75 12h16.5m-16.5 5.25h16.5" />
                    </svg>
                    <!-- Icon when menu is open -->
                     <svg x-show="mobileOpen" x-cloak class="h-6 w-6" fill="none" viewBox="0 0 24 24" stroke-width="1.5" stroke="currentColor" aria-hidden="true">
                        <path stroke-linecap="round" stroke-linejoin="round" d="M6 18L18 6M6 6l12 12" />
                    </svg>
                </button>
            </div>
        </div>
    </div>

    <!-- Mobile menu -->
    <div x-show="mobileOpen" 
         x-transition:enter="transition ease-out duration-200"
         x-transition:enter-start="opacity-0 -translate-y-2"
         x-transition:enter-end="opacity-100 translate-y-0"
         x-transition:leave="transition ease-in duration-150"
         x-transition:leave-start="opacity-100 translate-y-0"
         x-transition:leave-end="opacity-0 -translate-y-2"
         class="lg:hidden border-t border-zinc-200 dark:border-zinc-800 bg-white dark:bg-zinc-900" 
         id="mobile-menu">
        <div class="space-y-1 px-4 pb-3 pt-2">
            <template x-for="category in megaMenu" :key="category.id">
                <div>
                    <button @click="toggleCategory(category.id)"
                            class="w-full flex justify-between items-center px-3 py-2 text-base font-medium rounded-md transition-colors text-zinc-600 hover:text-cyan-600 hover:bg-zinc-50 dark:text-zinc-400 dark:hover:text-white dark:hover:bg-zinc-800">
                        <span x-text="category.label"></span>
                        <svg xmlns="http://www.w3.org/2000/svg" fill="none" viewBox="0 0 24 24" stroke-width="1.5" stroke="currentColor" class="w-4 h-4 transition-transform duration-200" :class="{ 'rotate-180': openCategory === category.id }">
                            <path stroke-linecap="round" stroke-linejoin="round" d="m19.5 8.25-7.5 7.5-7.5-7.5" />
                        </svg>
                    </button>
                    
                    <div x-show="openCategory === category.id" x-collapse class="pl-4 space-y-1">
                         <template x-for="subSection in category.children" :key="subSection.label">
                            <a href="#" class="block px-3 py-2 text-sm text-zinc-500 dark:text-zinc-400 hover:text-cyan-600 dark:hover:text-cyan-400" x-text="subSection.label"></a>
                         </template>
                    </div>
                </div>
            </template>
        </div>
    </div>
</header>
