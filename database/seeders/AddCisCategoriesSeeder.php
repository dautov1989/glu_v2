<?php

namespace Database\Seeders;

use App\Models\Category;
use Illuminate\Database\Seeder;
use Illuminate\Support\Str;

class AddCisCategoriesSeeder extends Seeder
{
    /**
     * Run the database seeds.
     */
    public function run(): void
    {
        $this->command->info('Начинаем добавление категорий для СНГ...');

        // Структура новых данных. Иерархия:
        // [
        //    'parent_slug' => 'slug-roditelya' (или null если корень, но у нас все вложены),
        //    'parent_match_title' => 'Если slug может отличаться, ищем по title',
        //    'items' => [ ... ]
        // ]
        // Но так как нам нужно интегрировать в существующие, будем искать родителя по Title,
        // так как slugs могут меняться, но Title "Симптомы", "Диабет 1 типа" и т.д. скорее всего стабильны.

        $newCategories = [
            // 1. Симптомы
            'Симптомы' => [
                'items' => [
                    [
                        'target_parent' => 'Ранние признаки', // Ищем подкатегорию
                        'items' => [
                            [
                                'title' => 'Психоэмоциональные изменения',
                                'subitems' => [
                                    ['title' => 'Раздражительность и агрессия'],
                                    ['title' => 'Хроническая усталость']
                                ]
                            ],
                            [
                                'title' => 'Скрытые симптомы',
                                'subitems' => [
                                    ['title' => 'Частые инфекции (Молочница, цистит)'],
                                    ['title' => 'Ухудшение зрения (Туман в глазах)']
                                ]
                            ]
                        ]
                    ]
                ]
            ],

            // 2. Диабет 1 типа
            'Диабет 1 типа' => [
                'items' => [
                    [
                        'target_parent' => 'Особые ситуации',
                        'items' => [
                            [
                                'title' => 'Права и Социум (СНГ)',
                                'subitems' => [
                                    [
                                        'title' => 'Военкомат и Армия',
                                        'subitems' => [
                                            ['title' => 'Категория годности'],
                                            ['title' => 'Получение военного билета']
                                        ]
                                    ],
                                    [
                                        'title' => 'Учеба и Экзамены',
                                        'subitems' => [
                                            ['title' => 'Сдача ЕГЭ и ОГЭ (Особые условия)'],
                                            ['title' => 'Льготы при поступлении']
                                        ]
                                    ]
                                ]
                            ],
                            [
                                'title' => 'Образ жизни',
                                'subitems' => [
                                    [
                                        'title' => 'Вождение автомобиля',
                                        'subitems' => [
                                            ['title' => 'Медкомиссия и права'],
                                            ['title' => 'Правила при гипогликемии за рулем']
                                        ]
                                    ],
                                    [
                                        'title' => 'Путешествия',
                                        'subitems' => [
                                            ['title' => 'Провоз инсулина в самолете'],
                                            ['title' => 'Поезда РЖД (Хранение в жару)']
                                        ]
                                    ]
                                ]
                            ]
                        ]
                    ],
                    [
                        'target_parent' => 'Обучение',
                        'items' => [
                            [
                                'title' => 'Женское здоровье',
                                'subitems' => [
                                    ['title' => 'Менструальный цикл и сахара'],
                                    ['title' => 'Планирование беременности'],
                                    ['title' => 'Контрацепция при диабете']
                                ]
                            ],
                            [
                                'title' => 'Мужское здоровье',
                                'subitems' => [
                                    ['title' => 'Влияние на потенцию'],
                                    ['title' => 'Планирование отцовства']
                                ]
                            ]
                        ]
                    ]
                ]
            ],

            // 3. Диабет 2 типа
            'Диабет 2 типа' => [
                'items' => [
                    [
                        'target_parent' => 'Осложнения и Уход',
                        'items' => [
                            [
                                'title' => 'Социальная защита',
                                'subitems' => [
                                    [
                                        'title' => 'Инвалидность (МСЭ)',
                                        'subitems' => [
                                            ['title' => 'Критерии получения группы'],
                                            ['title' => 'Как обжаловать решение']
                                        ]
                                    ],
                                    [
                                        'title' => 'Санаторно-курортное лечение',
                                        'subitems' => [
                                            ['title' => 'Список бесплатных санаториев'],
                                            ['title' => 'Как получить путевку']
                                        ]
                                    ]
                                ]
                            ]
                        ]
                    ],
                    [
                        'target_parent' => 'Медикаменты',
                        'items' => [
                            [
                                'title' => 'Льготное обеспечение',
                                'subitems' => [
                                    ['title' => 'Список ЖНВЛП (Бесплатные лекарства)'],
                                    ['title' => 'Что делать, если нет лекарств в аптеке'],
                                    ['title' => 'Региональные и Федеральные льготы']
                                ]
                            ]
                        ]
                    ]
                ]
            ],

            // 4. Гаджеты и Расходники
            'Гаджеты и Расходники' => [
                'items' => [
                    [
                        'target_parent' => 'Мониторинг глюкозы',
                        'items' => [
                            [
                                'title' => 'Системы DIY (Сделай сам)',
                                'subitems' => [
                                    ['title' => 'Настройка xDrip+ и AndroidAPS'],
                                    ['title' => 'Удаленный мониторинг (Nightscout)'],
                                    ['title' => 'Продление жизни сенсоров']
                                ]
                            ],
                            [
                                'title' => 'Получение от государства',
                                'subitems' => [
                                    ['title' => 'Кому положен бесплатный НМГ'],
                                    ['title' => 'Судебная практика по сенсорам']
                                ]
                            ]
                        ]
                    ],
                    [
                        'target_parent' => 'Инсулиновые системы',
                        'items' => [
                            [
                                'title' => 'Расходные материалы',
                                'subitems' => [
                                    ['title' => 'Как получить иглы и тест-полоски бесплатно'],
                                    ['title' => 'Лайфхаки по экономии расходников']
                                ]
                            ]
                        ]
                    ]
                ]
            ],

            // 5. Питание
            'Питание' => [
                'items' => [
                    [
                        'target_parent' => 'Готовые меню',
                        'items' => [
                            [
                                'title' => 'Национальная кухня',
                                'subitems' => [
                                    [
                                        'title' => 'Русская кухня',
                                        'subitems' => [
                                            ['title' => 'Блины (Как снизить ГИ)'],
                                            ['title' => 'Пельмени и вареники (Альтернативы)'],
                                            ['title' => 'Традиционные супы (Борщ, Щи)']
                                        ]
                                    ],
                                    [
                                        'title' => 'Кавказская кухня',
                                        'subitems' => [
                                            ['title' => 'Шашлык (Правильные маринады)'],
                                            ['title' => 'Хачапури (Низкоуглеводные рецепты)']
                                        ]
                                    ],
                                    [
                                        'title' => 'Среднеазиатская кухня',
                                        'subitems' => [
                                            ['title' => 'Плов (Варианты с булгуром)'],
                                            ['title' => 'Лагман без лапши']
                                        ]
                                    ]
                                ]
                            ],
                            [
                                'title' => 'Бюджетное питание',
                                'subitems' => [
                                    ['title' => 'Сезонные ягоды (Облепиха, Клюква)'],
                                    ['title' => 'Доступные источники белка'],
                                    ['title' => 'Заготовки на зиму без сахара']
                                ]
                            ]
                        ]
                    ]
                ]
            ],

            // 6. Спорт
            'Спорт' => [
                'items' => [
                    [
                        'target_parent' => 'Виды нагрузок',
                        'items' => [
                            [
                                'title' => 'Зимние виды спорта',
                                'subitems' => [
                                    ['title' => 'Лыжи и Коньки (Сенсоры на холоде)'],
                                    ['title' => 'Защита помпы от замерзания']
                                ]
                            ],
                            [
                                'title' => 'Командные игры',
                                'subitems' => [
                                    ['title' => 'Футбол/Хоккей (Куда деть помпу)']
                                ]
                            ]
                        ]
                    ]
                ]
            ]
        ];

        foreach ($newCategories as $rootTitle => $rootData) {
            $rootCategory = Category::where('title', $rootTitle)->first();

            if (!$rootCategory) {
                $this->command->warn("Корневая категория '{$rootTitle}' не найдена! Пропускаем.");
                continue;
            }

            foreach ($rootData['items'] as $group) {
                $targetParentTitle = $group['target_parent'];

                // Ищем целевую категорию ВНУТРИ корневой (на 1 уровень ниже)
                $targetParent = Category::where('parent_id', $rootCategory->id)
                    ->where('title', $targetParentTitle)
                    ->first();

                if (!$targetParent) {
                    // Пытаемся найти глубже, если структура сложнее
                    $targetParent = Category::where('title', $targetParentTitle)->first();
                }

                if (!$targetParent) {
                    $this->command->warn("Родительская категория '{$targetParentTitle}' для '{$rootTitle}' не найдена! Пропускаем.");
                    continue;
                }

                $this->createCategories($group['items'], $targetParent->id, $targetParent->level + 1);
            }
        }

        $this->command->info('Добавление новых категорий завершено!');
    }

    private function createCategories(array $items, int $parentId, int $level): void
    {
        foreach ($items as $item) {
            $title = $item['title'];
            $slug = Str::slug($title);

            // Проверяем существование, чтобы не дублировать
            $category = Category::firstOrCreate(
                [
                    'parent_id' => $parentId,
                    'slug' => $slug,
                ],
                [
                    'title' => $title,
                    'level' => $level,
                    'order' => Category::where('parent_id', $parentId)->max('order') + 1,
                    'is_active' => true,
                    // Генерируем SEO поля "на лету", чтобы не оставлять пустыми
                    'meta_title' => $this->generateMetaTitle($title, $level),
                    'meta_description' => $this->generateMetaDescription($title),
                    'description' => "Полезная информация о '{$title}' для людей с диабетом.",
                ]
            );

            // Если категория уже существовала, мы её просто получили. 
            // Если была создана - отлично.

            if ($category->wasRecentlyCreated) {
                $this->command->info("Создана: {$title}");
            }

            if (isset($item['subitems']) && is_array($item['subitems'])) {
                $this->createCategories($item['subitems'], $category->id, $level + 1);
            }
        }
    }

    private function generateMetaTitle(string $title, int $level): string
    {
        return "{$title} | Glucosa - Все о диабете";
    }

    private function generateMetaDescription(string $title): string
    {
        return "Узнайте все о {$title}. Подробные руководства, советы экспертов и полезная информация для диабетиков на сайте Glucosa.";
    }
}
