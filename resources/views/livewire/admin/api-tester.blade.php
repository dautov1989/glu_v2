@section('title', 'API Тестер')

<div x-data="apiTester({
    apiKey: '{{ $defaultApiKey }}',
    baseUrl: '{{ $defaultBaseUrl }}'
})">
    <!-- Tabs -->
    <div class="mb-6 border-b border-gray-200 bg-white shadow-sm px-4 rounded-sm">
        <nav class="-mb-px flex space-x-6">
            <button @click="activeTab = 'general'"
                :class="{'border-blue-500 text-blue-600': activeTab === 'general', 'border-transparent text-gray-500 hover:text-gray-700 hover:border-gray-300': activeTab !== 'general'}"
                class="whitespace-nowrap py-4 px-1 border-b-2 font-bold text-sm transition-colors">
                Общие и Категории
            </button>
            <button @click="activeTab = 'content'"
                :class="{'border-blue-500 text-blue-600': activeTab === 'content', 'border-transparent text-gray-500 hover:text-gray-700 hover:border-gray-300': activeTab !== 'content'}"
                class="whitespace-nowrap py-4 px-1 border-b-2 font-bold text-sm transition-colors">
                🤖 AI Контент
            </button>
            <button @click="activeTab = 'posts'"
                :class="{'border-blue-500 text-blue-600': activeTab === 'posts', 'border-transparent text-gray-500 hover:text-gray-700 hover:border-gray-300': activeTab !== 'posts'}"
                class="whitespace-nowrap py-4 px-1 border-b-2 font-bold text-sm transition-colors">
                📝 Посты (CRUD)
            </button>
            <button @click="activeTab = 'docs'"
                :class="{'border-blue-500 text-blue-600': activeTab === 'docs', 'border-transparent text-gray-500 hover:text-gray-700 hover:border-gray-300': activeTab !== 'docs'}"
                class="whitespace-nowrap py-4 px-1 border-b-2 font-bold text-sm transition-colors">
                📚 Документация (n8n)
            </button>
        </nav>
    </div>

    <!-- Configuration (Sticky at top of content or just visible) -->
    <div class="bg-white border border-gray-200 shadow-sm p-4 mb-6 rounded-sm">
        <div class="grid grid-cols-1 md:grid-cols-2 gap-4">
            <div>
                <label class="block text-xs font-bold text-gray-700 mb-1 uppercase uppercase tracking-wider">API
                    Key</label>
                <input type="text" x-model="apiKey"
                    class="w-full px-3 py-2 border border-gray-300 rounded-sm focus:border-blue-500 focus:ring-1 focus:ring-blue-500 text-sm font-mono shadow-sm"
                    placeholder="Введите API Key">
            </div>
            <div>
                <label class="block text-xs font-bold text-gray-700 mb-1 uppercase tracking-wider">Base URL</label>
                <input type="text" x-model="baseUrl"
                    class="w-full px-3 py-2 border border-gray-300 rounded-sm focus:border-blue-500 focus:ring-1 focus:ring-blue-500 text-sm font-mono shadow-sm"
                    placeholder="https://...">
            </div>
        </div>
    </div>

    <!-- General Tab -->
    <div x-show="activeTab === 'general'" x-cloak class="grid grid-cols-1 md:grid-cols-2 gap-6">
        <div class="bg-white border border-gray-200 shadow-sm rounded-sm overflow-hidden">
            <div class="bg-gray-50 px-4 py-2 border-b border-gray-200 font-bold text-sm">🔌 Проверка соединения</div>
            <div class="p-4">
                <p class="text-gray-500 text-xs mb-4">GET /test (Без авторизации)</p>
                <button @click="makeRequest('/test', 'GET', null, false)"
                    class="bg-blue-600 text-white px-4 py-2 rounded-sm text-sm font-bold hover:bg-blue-700 transition shadow-sm border border-blue-800">Ping
                    API</button>
                <div x-show="responses['/test']"
                    class="mt-4 bg-gray-900 p-3 rounded-sm text-[11px] font-mono text-green-400 overflow-auto max-h-40 border border-gray-700">
                    <pre x-text="JSON.stringify(responses['/test'], null, 2)"></pre>
                </div>
            </div>
        </div>

        <div class="bg-white border border-gray-200 shadow-sm rounded-sm overflow-hidden">
            <div class="bg-gray-50 px-4 py-2 border-b border-gray-200 font-bold text-sm">📂 Категории</div>
            <div class="p-4">
                <p class="text-gray-500 text-xs mb-4">GET /categories</p>
                <button @click="makeRequest('/categories')"
                    class="bg-green-600 text-white px-4 py-2 rounded-sm text-sm font-bold hover:bg-green-700 transition shadow-sm border border-green-800">Список
                    категорий</button>
                <div x-show="responses['/categories']"
                    class="mt-4 bg-gray-900 p-3 rounded-sm text-[11px] font-mono text-green-400 overflow-auto max-h-60 border border-gray-700">
                    <pre x-text="JSON.stringify(responses['/categories'], null, 2)"></pre>
                </div>
            </div>
        </div>
    </div>

    <!-- Content Tab -->
    <div x-show="activeTab === 'content'" x-cloak class="space-y-6">
        <div class="bg-white border border-gray-200 shadow-sm rounded-sm overflow-hidden">
            <div
                class="bg-gray-50 px-4 py-2 border-b border-gray-200 font-bold text-sm flex justify-between items-center">
                <span>🧠 Smart Suggestion (для n8n)</span>
                <button @click="makeRequest('/content/suggest')"
                    class="bg-purple-600 text-white px-4 py-1.5 rounded-sm text-sm font-bold hover:bg-purple-700 transition shadow-sm border border-purple-800">
                    Получить рекомендацию
                </button>
            </div>
            <div class="p-6">
                <p class="text-gray-500 text-xs mb-4">GET /content/suggest - Получить готовую структуру и категорию для
                    написания статьи через AI</p>

                <div x-show="responses['/content/suggest']">
                    <div
                        class="bg-gray-900 text-green-400 p-4 rounded-sm font-mono text-xs overflow-auto max-h-[500px] border border-gray-700 shadow-inner">
                        <pre x-text="JSON.stringify(responses['/content/suggest'], null, 2)"></pre>
                    </div>
                </div>
                <div x-show="!responses['/content/suggest']" class="py-12 text-center text-gray-400 italic text-sm">
                    Нажмите кнопку выше, чтобы запросить контекст у API
                </div>
            </div>
        </div>
    </div>

    <!-- Posts Tab -->
    <div x-show="activeTab === 'posts'" x-cloak class="grid grid-cols-1 lg:grid-cols-2 gap-6">
        <div class="bg-white border border-gray-200 shadow-sm rounded-sm overflow-hidden lg:col-span-2">
            <div
                class="bg-gray-50 px-4 py-2 border-b border-gray-200 font-bold text-sm flex justify-between items-center">
                <span>📚 Список постов</span>
                <button @click="makeRequest('/posts')"
                    class="bg-blue-600 text-white px-4 py-1.5 rounded-sm text-sm font-bold hover:bg-blue-700 transition shadow-sm border border-blue-800">Обновить
                    список</button>
            </div>
            <div class="p-4">
                <div x-show="responses['/posts']"
                    class="bg-gray-900 p-3 rounded-sm text-[11px] font-mono text-green-400 overflow-auto max-h-60 border border-gray-700">
                    <pre x-text="JSON.stringify(responses['/posts'], null, 2)"></pre>
                </div>
            </div>
        </div>

        <div class="bg-white border border-gray-200 shadow-sm rounded-sm overflow-hidden">
            <div class="bg-gray-50 px-4 py-2 border-b border-gray-200 font-bold text-sm">✨ Создать пост</div>
            <div class="p-4 space-y-4">
                <div>
                    <label class="block text-[10px] font-bold text-gray-700 uppercase mb-1">Заголовок</label>
                    <input type="text" x-model="newPost.title"
                        class="w-full px-3 py-2 border border-gray-300 rounded-sm text-sm shadow-sm">
                </div>
                <div>
                    <label class="block text-[10px] font-bold text-gray-700 uppercase mb-1">ID Категории</label>
                    <input type="number" x-model="newPost.category_id"
                        class="w-full px-3 py-2 border border-gray-300 rounded-sm text-sm shadow-sm">
                </div>
                <div>
                    <label class="block text-[10px] font-bold text-gray-700 uppercase mb-1">Контент (HTML)</label>
                    <textarea x-model="newPost.content"
                        class="w-full px-3 py-2 border border-gray-300 rounded-sm h-32 text-xs shadow-sm font-mono"></textarea>
                </div>
                <label class="flex items-center space-x-2 text-sm">
                    <input type="checkbox" x-model="newPost.is_published"
                        class="rounded-sm border-gray-300 text-blue-600 focus:ring-blue-500">
                    <span class="font-medium text-gray-700">Опубликовать сразу</span>
                </label>
                <button @click="createPost()"
                    class="w-full bg-blue-600 text-white px-4 py-2 rounded-sm text-sm font-bold hover:bg-blue-700 transition shadow-sm border border-blue-800">Создать
                    пост</button>

                <div x-show="responses['create_post']"
                    class="mt-4 bg-gray-900 p-3 rounded-sm text-[11px] font-mono text-green-400 overflow-auto max-h-40 border border-gray-700">
                    <pre x-text="JSON.stringify(responses['create_post'], null, 2)"></pre>
                </div>
            </div>
        </div>

        <div class="bg-white border border-gray-200 shadow-sm rounded-sm overflow-hidden text-right">
            <div class="bg-gray-50 px-4 py-2 border-b border-gray-200 font-bold text-sm text-left">🔧 Операции с
                одиночным постом</div>
            <div class="p-4 space-y-4">
                <div class="flex gap-2 text-left">
                    <div class="flex-1">
                        <label class="block text-[10px] font-bold text-gray-700 uppercase mb-1">ID Поста</label>
                        <input type="number" x-model="targetPostId"
                            class="w-full px-3 py-2 border border-gray-300 rounded-sm text-sm shadow-sm">
                    </div>
                </div>

                <div class="grid grid-cols-3 gap-2">
                    <button @click="makeRequest(`/posts/${targetPostId}`, 'GET', null, true, 'single_post_op')"
                        class="bg-gray-600 text-white px-3 py-1.5 rounded-sm text-xs font-bold hover:bg-gray-700 border border-gray-800 shadow-sm transition">Get</button>
                    <button @click="updatePost()"
                        class="bg-yellow-600 text-white px-3 py-1.5 rounded-sm text-xs font-bold hover:bg-yellow-700 border border-yellow-800 shadow-sm transition">Update</button>
                    <button @click="makeRequest(`/posts/${targetPostId}`, 'DELETE', null, true, 'single_post_op')"
                        class="bg-red-600 text-white px-3 py-1.5 rounded-sm text-xs font-bold hover:bg-red-700 border border-red-800 shadow-sm transition">Delete</button>
                </div>

                <div class="space-y-3 border-t pt-4 text-left">
                    <label class="block text-[10px] font-bold text-gray-700 uppercase mb-1">Данные для
                        обновления:</label>
                    <input type="text" x-model="updateData.title" placeholder="Новый заголовок"
                        class="w-full px-3 py-2 border border-gray-300 rounded-sm text-xs shadow-sm">
                    <textarea x-model="updateData.content" placeholder="Новый контент"
                        class="w-full px-3 py-2 border border-gray-300 rounded-sm h-20 text-xs shadow-sm font-mono"></textarea>
                </div>

                <div x-show="responses['single_post_op']"
                    class="mt-4 bg-gray-900 p-3 rounded-sm text-[11px] font-mono text-green-400 text-left overflow-auto max-h-40 border border-gray-700">
                    <pre x-text="JSON.stringify(responses['single_post_op'], null, 2)"></pre>
                </div>
            </div>
        </div>
    </div>

    <!-- Docs Tab (Large technical view, matches the original but styled better) -->
    <div x-show="activeTab === 'docs'" x-cloak class="space-y-6">
        <div class="bg-white border border-gray-200 shadow-sm rounded-sm p-6">
            <h2 class="text-2xl font-normal text-gray-800 mb-6">📚 Документация API для n8n</h2>

            <div class="grid md:grid-cols-3 gap-6 mb-8">
                <div class="bg-red-50 border border-red-200 p-4 rounded-sm">
                    <div class="font-bold text-red-800 text-xs uppercase mb-2">ОБЯЗАТЕЛЬНЫЕ</div>
                    <ul class="text-xs text-red-700 space-y-1 font-medium">
                        <li>• category_id (integer)</li>
                        <li>• title (string)</li>
                        <li>• content (HTML string)</li>
                    </ul>
                </div>
                <div class="bg-blue-50 border border-blue-200 p-4 rounded-sm">
                    <div class="font-bold text-blue-800 text-xs uppercase mb-2">ОПЦИОНАЛЬНЫЕ</div>
                    <ul class="text-xs text-blue-700 space-y-1 font-medium">
                        <li>• meta_description</li>
                        <li>• meta_keywords</li>
                        <li>• image_url</li>
                        <li>• is_published (default: false)</li>
                    </ul>
                </div>
                <div class="bg-green-50 border border-green-200 p-4 rounded-sm">
                    <div class="font-bold text-green-800 text-xs uppercase mb-2">АВТОЗАПОЛНЕНИЕ</div>
                    <ul class="text-xs text-green-700 space-y-1 font-medium">
                        <li>• slug (из title)</li>
                        <li>• excerpt</li>
                        <li>• meta_title</li>
                    </ul>
                </div>
            </div>

            <div class="prose prose-sm max-w-none text-gray-600">
                <h4 class="text-gray-900 font-bold mb-2">Post /api/posts</h4>
                <p class="mb-4">Эндпоинт для создания статей. Требует заголовок <code>X-API-Key</code>.</p>
                <div class="bg-gray-900 text-green-400 p-4 rounded-sm font-mono text-[11px] mb-6">
                    <pre>{
  "category_id": 15,
  "title": "Как снизить уровень глюкозы...",
  "content": "&lt;h2&gt;Введение&lt;/h2&gt;&lt;p&gt;Текст...&lt;/p&gt;",
  "is_published": true
}</pre>
                </div>
            </div>
        </div>
    </div>
</div>

<script>
    function apiTester(config) {
        return {
            activeTab: 'general',
            apiKey: config.apiKey || '',
            baseUrl: config.baseUrl || '',
            responses: {},
            newPost: {
                title: '',
                category_id: 1,
                content: '',
                is_published: true
            },
            targetPostId: '',
            updateData: {
                title: '',
                content: ''
            },
            targetSlug: '',

            async makeRequest(endpoint, method = 'GET', body = null, requireAuth = true, responseKey = null) {
                const key = responseKey || endpoint;
                this.responses[key] = { status: 'Загрузка...' };

                const headers = {
                    'Accept': 'application/json',
                    'Content-Type': 'application/json'
                };

                if (requireAuth) {
                    headers['X-API-Key'] = this.apiKey;
                }

                try {
                    const url = `${this.baseUrl}${endpoint}`;
                    const res = await fetch(url, {
                        method,
                        headers,
                        body: body ? JSON.stringify(body) : null
                    });

                    if (!res.ok) {
                        const errorData = await res.json().catch(() => ({}));
                        this.responses[key] = {
                            status: res.status,
                            statusText: res.statusText,
                            error: errorData
                        };
                        return;
                    }

                    const data = await res.json();
                    this.responses[key] = data;

                    // Auto-fill update fields if getting a post
                    if (method === 'GET' && endpoint.includes('/posts/') && data.data) {
                        this.updateData.title = data.data.title;
                        this.updateData.content = data.data.content;
                    }

                } catch (error) {
                    this.responses[key] = {
                        error: 'Network Error / Failed to fetch',
                        message: error.message,
                        hint: 'Проверьте, что Base URL доступен и не блокируется CORS/Mixed Content (HTTP vs HTTPS)'
                    };
                }
            },

            async createPost() {
                if (!this.newPost.title || !this.newPost.content) {
                    alert('Пожалуйста, заполните заголовок и контент');
                    return;
                }
                await this.makeRequest('/posts', 'POST', this.newPost, true, 'create_post');
            },

            async updatePost() {
                if (!this.targetPostId) {
                    alert('Введите ID поста');
                    return;
                }
                const body = {};
                if (this.updateData.title) body.title = this.updateData.title;
                if (this.updateData.content) body.content = this.updateData.content;

                await this.makeRequest(`/posts/${this.targetPostId}`, 'PUT', body, true, 'single_post_op');
            },

            async deleteBySlug() {
                if (!this.targetSlug) {
                    alert('Введите Slug поста');
                    return;
                }
                if (!confirm('Вы уверены, что хотите удалить этот пост?')) {
                    return;
                }
                await this.makeRequest(`/posts/${this.targetSlug}`, 'DELETE', null, true, 'delete_slug');
            }
        }
    }
</script>