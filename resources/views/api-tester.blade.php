<!DOCTYPE html>
<html lang="ru">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>API Тестер - Создание статей</title>
    <script src="https://cdn.tailwindcss.com"></script>
    <style>
        body {
            background: linear-gradient(135deg, #667eea 0%, #764ba2 100%);
            min-height: 100vh;
        }

        .glass {
            background: rgba(255, 255, 255, 0.95);
            backdrop-filter: blur(10px);
            border: 1px solid rgba(255, 255, 255, 0.3);
        }

        .code-block {
            background: #1e293b;
            color: #e2e8f0;
            border-radius: 8px;
            padding: 1rem;
            overflow-x: auto;
            font-family: 'Courier New', monospace;
            font-size: 0.875rem;
        }

        .field-card {
            transition: all 0.3s ease;
        }

        .field-card:hover {
            transform: translateY(-2px);
            box-shadow: 0 8px 16px rgba(0, 0, 0, 0.1);
        }

        .badge {
            display: inline-block;
            padding: 0.25rem 0.75rem;
            border-radius: 9999px;
            font-size: 0.75rem;
            font-weight: 600;
        }

        .badge-required {
            background: #fee2e2;
            color: #991b1b;
        }

        .badge-optional {
            background: #dbeafe;
            color: #1e40af;
        }

        .badge-auto {
            background: #d1fae5;
            color: #065f46;
        }
    </style>
</head>

<body class="p-6">
    <div class="max-w-7xl mx-auto">
        <!-- Header -->
        <div class="glass rounded-2xl shadow-2xl p-8 mb-6">
            <div class="flex items-center justify-between mb-4">
                <div>
                    <h1 class="text-4xl font-bold text-gray-800 mb-2">🚀 API Тестер для n8n</h1>
                    <p class="text-gray-600">Полная документация по созданию статей через API</p>
                </div>
                <div class="text-right">
                    <div class="text-sm text-gray-500">Endpoint:</div>
                    <div class="font-mono text-sm bg-purple-100 px-3 py-1 rounded">POST /api/posts</div>
                </div>
            </div>
        </div>

        <!-- Quick Start -->
        <div class="glass rounded-2xl shadow-2xl p-8 mb-6">
            <h2 class="text-2xl font-bold text-gray-800 mb-4">⚡ Быстрый старт</h2>
            <div class="grid md:grid-cols-2 gap-6">
                <div>
                    <h3 class="font-semibold text-gray-700 mb-2">1️⃣ Получить предложение категории</h3>
                    <div class="code-block">
                        GET {{ url('/api/content/suggest') }}
                        Headers:
                        X-API-Key: ваш_api_ключ
                    </div>
                </div>
                <div>
                    <h3 class="font-semibold text-gray-700 mb-2">2️⃣ Создать статью</h3>
                    <div class="code-block">
                        POST {{ url('/api/posts') }}
                        Headers:
                        X-API-Key: ваш_api_ключ
                        Content-Type: application/json
                    </div>
                </div>
            </div>
        </div>

        <!-- Fields Documentation -->
        <div class="glass rounded-2xl shadow-2xl p-8 mb-6">
            <h2 class="text-2xl font-bold text-gray-800 mb-6">📋 Поля для создания статьи</h2>

            <div class="space-y-4">
                <!-- category_id -->
                <div class="field-card bg-white rounded-lg p-6 border-l-4 border-red-500">
                    <div class="flex items-start justify-between mb-3">
                        <div>
                            <h3 class="text-lg font-bold text-gray-800">category_id</h3>
                            <p class="text-sm text-gray-600 mt-1">ID категории для статьи</p>
                        </div>
                        <span class="badge badge-required">ОБЯЗАТЕЛЬНО</span>
                    </div>
                    <div class="bg-gray-50 rounded p-4 space-y-2">
                        <div><strong>Тип:</strong> <code class="bg-gray-200 px-2 py-1 rounded">integer</code></div>
                        <div><strong>Валидация:</strong> Должен существовать в таблице categories</div>
                        <div><strong>Откуда взять:</strong> Из ответа <code
                                class="bg-purple-100 px-2 py-1 rounded">/api/content/suggest</code> →
                            <code>context.category_id</code></div>
                        <div class="code-block mt-2">
                            "category_id": 15
                        </div>
                    </div>
                </div>

                <!-- title -->
                <div class="field-card bg-white rounded-lg p-6 border-l-4 border-red-500">
                    <div class="flex items-start justify-between mb-3">
                        <div>
                            <h3 class="text-lg font-bold text-gray-800">title</h3>
                            <p class="text-sm text-gray-600 mt-1">Заголовок статьи (H1)</p>
                        </div>
                        <span class="badge badge-required">ОБЯЗАТЕЛЬНО</span>
                    </div>
                    <div class="bg-gray-50 rounded p-4 space-y-2">
                        <div><strong>Тип:</strong> <code class="bg-gray-200 px-2 py-1 rounded">string</code></div>
                        <div><strong>Валидация:</strong> От 3 до 255 символов</div>
                        <div><strong>Что происходит:</strong> Автоматически генерируется slug из заголовка</div>
                        <div><strong>Требования:</strong> Должен быть уникальным, цепляющим и информативным</div>
                        <div class="code-block mt-2">
                            "title": "Как снизить уровень глюкозы в крови: 10 эффективных методов"
                        </div>
                    </div>
                </div>

                <!-- content -->
                <div class="field-card bg-white rounded-lg p-6 border-l-4 border-red-500">
                    <div class="flex items-start justify-between mb-3">
                        <div>
                            <h3 class="text-lg font-bold text-gray-800">content</h3>
                            <p class="text-sm text-gray-600 mt-1">HTML контент статьи</p>
                        </div>
                        <span class="badge badge-required">ОБЯЗАТЕЛЬНО</span>
                    </div>
                    <div class="bg-gray-50 rounded p-4 space-y-2">
                        <div><strong>Тип:</strong> <code class="bg-gray-200 px-2 py-1 rounded">string (HTML)</code>
                        </div>
                        <div><strong>Валидация:</strong> Минимум 100 символов</div>
                        <div><strong>Формат:</strong> HTML с Tailwind CSS классами</div>
                        <div><strong>⚠️ Важно:</strong> НЕ использовать тег H1 (он будет из title)</div>
                        <div class="bg-yellow-50 border-l-4 border-yellow-400 p-3 mt-2">
                            <p class="text-sm font-semibold text-yellow-800 mb-2">📝 Требования к контенту:</p>
                            <ul class="text-sm text-yellow-700 space-y-1 ml-4 list-disc">
                                <li>Минимум 1500+ слов для медицинских тем</li>
                                <li>Использовать H2 → H3 → H4 для структуры</li>
                                <li>Включать списки (ul/ol) для лучшей читаемости</li>
                                <li>Выделять важное через &lt;strong&gt; или &lt;em&gt;</li>
                                <li>Короткие абзацы (3-4 предложения)</li>
                                <li>Без переносов строк (\n), только HTML теги</li>
                            </ul>
                        </div>
                        <div class="code-block mt-2">
                            "content": "&lt;h2 class='text-2xl font-bold mb-4'&gt;Введение&lt;/h2&gt;&lt;p
                            class='mb-4'&gt;Текст...&lt;/p&gt;"
                        </div>
                    </div>
                </div>

                <!-- meta_description -->
                <div class="field-card bg-white rounded-lg p-6 border-l-4 border-blue-500">
                    <div class="flex items-start justify-between mb-3">
                        <div>
                            <h3 class="text-lg font-bold text-gray-800">meta_description</h3>
                            <p class="text-sm text-gray-600 mt-1">SEO описание для поисковиков</p>
                        </div>
                        <span class="badge badge-optional">ОПЦИОНАЛЬНО</span>
                    </div>
                    <div class="bg-gray-50 rounded p-4 space-y-2">
                        <div><strong>Тип:</strong> <code class="bg-gray-200 px-2 py-1 rounded">string</code></div>
                        <div><strong>Валидация:</strong> Максимум 500 символов</div>
                        <div><strong>Рекомендация:</strong> 150-160 символов для оптимального отображения</div>
                        <div><strong>Если не указано:</strong> Автоматически создается из первых 160 символов content
                        </div>
                        <div><strong>Требования:</strong> Должно содержать призыв к действию</div>
                        <div class="code-block mt-2">
                            "meta_description": "Узнайте 10 проверенных способов снизить уровень глюкозы. Практические
                            советы от врачей. Читайте сейчас!"
                        </div>
                    </div>
                </div>

                <!-- meta_keywords -->
                <div class="field-card bg-white rounded-lg p-6 border-l-4 border-blue-500">
                    <div class="flex items-start justify-between mb-3">
                        <div>
                            <h3 class="text-lg font-bold text-gray-800">meta_keywords</h3>
                            <p class="text-sm text-gray-600 mt-1">Ключевые слова для SEO</p>
                        </div>
                        <span class="badge badge-optional">ОПЦИОНАЛЬНО</span>
                    </div>
                    <div class="bg-gray-50 rounded p-4 space-y-2">
                        <div><strong>Тип:</strong> <code class="bg-gray-200 px-2 py-1 rounded">string</code></div>
                        <div><strong>Формат:</strong> Слова через запятую</div>
                        <div><strong>Рекомендация:</strong> 5-7 релевантных ключевых слов</div>
                        <div><strong>Требования:</strong> Только релевантные термины, без спама</div>
                        <div class="code-block mt-2">
                            "meta_keywords": "глюкоза, диабет, сахар в крови, снижение глюкозы, здоровье"
                        </div>
                    </div>
                </div>

                <!-- excerpt -->
                <div class="field-card bg-white rounded-lg p-6 border-l-4 border-green-500">
                    <div class="flex items-start justify-between mb-3">
                        <div>
                            <h3 class="text-lg font-bold text-gray-800">excerpt</h3>
                            <p class="text-sm text-gray-600 mt-1">Краткое описание для карточек статей</p>
                        </div>
                        <span class="badge badge-auto">АВТО-ГЕНЕРАЦИЯ</span>
                    </div>
                    <div class="bg-gray-50 rounded p-4 space-y-2">
                        <div><strong>Тип:</strong> <code class="bg-gray-200 px-2 py-1 rounded">string</code></div>
                        <div><strong>Валидация:</strong> Максимум 500 символов</div>
                        <div><strong>Если не указано:</strong> Автоматически создается из первых 200 символов content
                            (без HTML тегов)</div>
                        <div><strong>Где используется:</strong> В списках статей, карточках, превью</div>
                        <div class="code-block mt-2">
                            "excerpt": "В этой статье мы рассмотрим 10 эффективных методов снижения уровня глюкозы в
                            крови..."
                        </div>
                    </div>
                </div>

                <!-- meta_title -->
                <div class="field-card bg-white rounded-lg p-6 border-l-4 border-green-500">
                    <div class="flex items-start justify-between mb-3">
                        <div>
                            <h3 class="text-lg font-bold text-gray-800">meta_title</h3>
                            <p class="text-sm text-gray-600 mt-1">SEO заголовок для поисковиков</p>
                        </div>
                        <span class="badge badge-auto">АВТО-ГЕНЕРАЦИЯ</span>
                    </div>
                    <div class="bg-gray-50 rounded p-4 space-y-2">
                        <div><strong>Тип:</strong> <code class="bg-gray-200 px-2 py-1 rounded">string</code></div>
                        <div><strong>Валидация:</strong> Максимум 255 символов</div>
                        <div><strong>Рекомендация:</strong> До 60 символов для оптимального отображения</div>
                        <div><strong>Если не указано:</strong> Используется обрезанный title (первые 60 символов)</div>
                        <div class="code-block mt-2">
                            "meta_title": "Как снизить глюкозу в крови: 10 методов | Здоровая Глюкоза"
                        </div>
                    </div>
                </div>

                <!-- image_url -->
                <div class="field-card bg-white rounded-lg p-6 border-l-4 border-blue-500">
                    <div class="flex items-start justify-between mb-3">
                        <div>
                            <h3 class="text-lg font-bold text-gray-800">image_url</h3>
                            <p class="text-sm text-gray-600 mt-1">URL изображения для статьи</p>
                        </div>
                        <span class="badge badge-optional">ОПЦИОНАЛЬНО</span>
                    </div>
                    <div class="bg-gray-50 rounded p-4 space-y-2">
                        <div><strong>Тип:</strong> <code class="bg-gray-200 px-2 py-1 rounded">string (URL)</code></div>
                        <div><strong>Валидация:</strong> Должен быть валидным URL</div>
                        <div><strong>Что происходит:</strong> Изображение автоматически скачивается и сохраняется в
                            storage/posts/</div>
                        <div><strong>Форматы:</strong> jpg, png, webp и другие</div>
                        <div><strong>⚠️ Важно:</strong> Если не указано, будет использоваться placeholder</div>
                        <div class="code-block mt-2">
                            "image_url": "https://example.com/images/glucose-levels.jpg"
                        </div>
                    </div>
                </div>

                <!-- is_published -->
                <div class="field-card bg-white rounded-lg p-6 border-l-4 border-green-500">
                    <div class="flex items-start justify-between mb-3">
                        <div>
                            <h3 class="text-lg font-bold text-gray-800">is_published</h3>
                            <p class="text-sm text-gray-600 mt-1">Статус публикации</p>
                        </div>
                        <span class="badge badge-auto">АВТО: false</span>
                    </div>
                    <div class="bg-gray-50 rounded p-4 space-y-2">
                        <div><strong>Тип:</strong> <code class="bg-gray-200 px-2 py-1 rounded">boolean</code></div>
                        <div><strong>По умолчанию:</strong> <code class="bg-red-100 px-2 py-1 rounded">false</code>
                            (черновик)</div>
                        <div><strong>Значения:</strong> true = опубликовано, false = черновик</div>
                        <div><strong>Что происходит при true:</strong> Автоматически устанавливается published_at =
                            текущее время</div>
                        <div class="bg-blue-50 border-l-4 border-blue-400 p-3 mt-2">
                            <p class="text-sm text-blue-800">💡 <strong>Совет:</strong> Для автоматической публикации
                                через n8n установите <code>true</code></p>
                        </div>
                        <div class="code-block mt-2">
                            "is_published": true
                        </div>
                    </div>
                </div>
            </div>
        </div>

        <!-- Example Request -->
        <div class="glass rounded-2xl shadow-2xl p-8 mb-6">
            <h2 class="text-2xl font-bold text-gray-800 mb-4">📤 Пример полного запроса</h2>
            <div class="code-block">
                {
                "category_id": 15,
                "title": "Как снизить уровень глюкозы в крови: 10 эффективных методов",
                "content": "&lt;h2 class='text-2xl font-bold text-gray-800 mb-4'&gt;Введение&lt;/h2&gt;&lt;p class='mb-4
                text-gray-700 leading-relaxed'&gt;Повышенный уровень глюкозы в крови - серьезная проблема, требующая
                внимания. В этой статье мы рассмотрим 10 проверенных методов снижения глюкозы.&lt;/p&gt;&lt;h2
                class='text-2xl font-bold text-gray-800 mb-4 mt-8'&gt;1. Регулярная физическая
                активность&lt;/h2&gt;&lt;p class='mb-4 text-gray-700 leading-relaxed'&gt;Физические упражнения помогают
                клеткам использовать инсулин более эффективно...&lt;/p&gt;",
                "meta_description": "Узнайте 10 проверенных способов снизить уровень глюкозы в крови. Практические
                советы от врачей и научно обоснованные методы. Читайте сейчас!",
                "meta_keywords": "глюкоза, диабет, сахар в крови, снижение глюкозы, здоровье, инсулин",
                "excerpt": "В этой статье мы рассмотрим 10 эффективных и научно обоснованных методов снижения уровня
                глюкозы в крови.",
                "meta_title": "Как снизить глюкозу в крови: 10 методов | Здоровая Глюкоза",
                "image_url": "https://images.unsplash.com/photo-1505751172876-fa1923c5c528",
                "is_published": true
                }
            </div>
        </div>

        <!-- Response Example -->
        <div class="glass rounded-2xl shadow-2xl p-8 mb-6">
            <h2 class="text-2xl font-bold text-gray-800 mb-4">📥 Пример успешного ответа</h2>
            <div class="code-block">
                {
                "success": true,
                "message": "Post created successfully",
                "data": {
                "id": 123,
                "category_id": 15,
                "title": "Как снизить уровень глюкозы в крови: 10 эффективных методов",
                "slug": "kak-snizit-uroven-glyukozy-v-krovi-10-effektivnyh-metodov",
                "excerpt": "В этой статье мы рассмотрим 10 эффективных...",
                "content": "...",
                "image": "posts/abc123def456.jpg",
                "is_published": true,
                "published_at": "2025-12-09T12:00:00.000000Z",
                "views": 0,
                "meta_title": "Как снизить глюкозу в крови: 10 методов | Здоровая Глюкоза",
                "meta_description": "Узнайте 10 проверенных способов...",
                "meta_keywords": "глюкоза, диабет, сахар в крови...",
                "created_at": "2025-12-09T12:00:00.000000Z",
                "updated_at": "2025-12-09T12:00:00.000000Z",
                "category": {
                "id": 15,
                "title": "Профилактика диабета",
                "slug": "profilaktika-diabeta"
                }
                }
                }
            </div>
        </div>

        <!-- Workflow for n8n -->
        <div class="glass rounded-2xl shadow-2xl p-8 mb-6">
            <h2 class="text-2xl font-bold text-gray-800 mb-6">🔄 Рекомендуемый workflow для n8n</h2>
            <div class="space-y-4">
                <div class="flex items-start space-x-4">
                    <div
                        class="flex-shrink-0 w-10 h-10 bg-purple-500 text-white rounded-full flex items-center justify-center font-bold">
                        1</div>
                    <div class="flex-1">
                        <h3 class="font-bold text-gray-800 mb-1">HTTP Request: GET /api/content/suggest</h3>
                        <p class="text-sm text-gray-600">Получить рекомендацию категории и контекст для AI</p>
                    </div>
                </div>
                <div class="flex items-start space-x-4">
                    <div
                        class="flex-shrink-0 w-10 h-10 bg-purple-500 text-white rounded-full flex items-center justify-center font-bold">
                        2</div>
                    <div class="flex-1">
                        <h3 class="font-bold text-gray-800 mb-1">OpenAI/Claude: Генерация контента</h3>
                        <p class="text-sm text-gray-600">Отправить контекст в AI с требованиями из suggest</p>
                    </div>
                </div>
                <div class="flex items-start space-x-4">
                    <div
                        class="flex-shrink-0 w-10 h-10 bg-purple-500 text-white rounded-full flex items-center justify-center font-bold">
                        3</div>
                    <div class="flex-1">
                        <h3 class="font-bold text-gray-800 mb-1">Code: Парсинг JSON от AI</h3>
                        <p class="text-sm text-gray-600">Извлечь title, content, meta_description, meta_keywords</p>
                    </div>
                </div>
                <div class="flex items-start space-x-4">
                    <div
                        class="flex-shrink-0 w-10 h-10 bg-purple-500 text-white rounded-full flex items-center justify-center font-bold">
                        4</div>
                    <div class="flex-1">
                        <h3 class="font-bold text-gray-800 mb-1">HTTP Request: POST /api/posts</h3>
                        <p class="text-sm text-gray-600">Создать статью с данными от AI + category_id из шага 1</p>
                    </div>
                </div>
                <div class="flex items-start space-x-4">
                    <div
                        class="flex-shrink-0 w-10 h-10 bg-green-500 text-white rounded-full flex items-center justify-center font-bold">
                        ✓</div>
                    <div class="flex-1">
                        <h3 class="font-bold text-gray-800 mb-1">Готово!</h3>
                        <p class="text-sm text-gray-600">Статья создана и опубликована на сайте</p>
                    </div>
                </div>
            </div>
        </div>

        <!-- Important Notes -->
        <div class="glass rounded-2xl shadow-2xl p-8">
            <h2 class="text-2xl font-bold text-gray-800 mb-4">⚠️ Важные замечания</h2>
            <div class="space-y-3">
                <div class="bg-red-50 border-l-4 border-red-500 p-4">
                    <h3 class="font-bold text-red-800 mb-2">🔐 Аутентификация</h3>
                    <p class="text-sm text-red-700">Все запросы должны содержать заголовок <code
                            class="bg-red-200 px-2 py-1 rounded">X-API-Key: ваш_ключ</code></p>
                </div>
                <div class="bg-yellow-50 border-l-4 border-yellow-500 p-4">
                    <h3 class="font-bold text-yellow-800 mb-2">⏱️ Rate Limiting</h3>
                    <p class="text-sm text-yellow-700">Ограничение: 60 запросов в минуту</p>
                </div>
                <div class="bg-blue-50 border-l-4 border-blue-500 p-4">
                    <h3 class="font-bold text-blue-800 mb-2">📝 Минимальные требования</h3>
                    <p class="text-sm text-blue-700">Обязательные поля: <code
                            class="bg-blue-200 px-2 py-1 rounded">category_id</code>, <code
                            class="bg-blue-200 px-2 py-1 rounded">title</code>, <code
                            class="bg-blue-200 px-2 py-1 rounded">content</code></p>
                </div>
                <div class="bg-green-50 border-l-4 border-green-500 p-4">
                    <h3 class="font-bold text-green-800 mb-2">✨ Автоматизация</h3>
                    <p class="text-sm text-green-700">Slug, excerpt, meta_title генерируются автоматически, если не
                        указаны</p>
                </div>
            </div>
        </div>

        <!-- Footer -->
        <div class="text-center mt-8 text-white">
            <p class="text-sm opacity-75">API Тестер для автоматизации через n8n | Версия 1.0</p>
        </div>
    </div>
</body>

</html>