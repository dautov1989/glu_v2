@extends('layouts.admin')

@section('title', isset($product) ? 'Редактировать товар' : 'Добавить товар')

@section('content')
<div class="max-w-4xl">
    <div class="mb-6">
        <a href="{{ route('admin.products.index') }}" class="text-blue-600 hover:text-blue-800 text-sm flex items-center gap-1">
            <svg class="w-4 h-4" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M10 19l-7-7m0 0l7-7m-7 7h18"/></svg>
            Назад к списку
        </a>
    </div>

    <form action="{{ isset($product) ? route('admin.products.update', $product) : route('admin.products.store') }}" 
          method="POST" class="bg-white border border-gray-200 shadow-sm rounded-sm overflow-hidden">
        @csrf
        @if(isset($product))
            @method('PUT')
        @endif

        <div class="p-6 space-y-6">

            {{-- Основная информация --}}
            <div class="border-b border-gray-100 pb-6">
                <h3 class="text-sm font-bold text-gray-800 uppercase tracking-wider mb-4">Основная информация</h3>

                <!-- Title -->
                <div class="mb-4">
                    <label class="block text-sm font-bold text-gray-700 mb-2">Название товара *</label>
                    <input type="text" name="title" value="{{ old('title', $product->title ?? '') }}" 
                           class="w-full px-3 py-2 border border-gray-300 rounded-sm focus:border-blue-500 focus:ring-1 focus:ring-blue-500 shadow-sm text-sm" 
                           placeholder="Например: Увлажняющий крем с мочевиной 10%" required>
                    @error('title')
                        <p class="mt-1 text-xs text-red-600">{{ $message }}</p>
                    @enderror
                </div>

                <!-- Slug -->
                <div class="mb-4">
                    <label class="block text-sm font-bold text-gray-700 mb-2">Slug (ЧПУ)</label>
                    <input type="text" name="slug" value="{{ old('slug', $product->slug ?? '') }}" 
                           class="w-full px-3 py-2 border border-gray-300 rounded-sm focus:border-blue-500 focus:ring-1 focus:ring-blue-500 shadow-sm text-sm font-mono" 
                           placeholder="Оставьте пустым для авто-генерации">
                    @error('slug')
                        <p class="mt-1 text-xs text-red-600">{{ $message }}</p>
                    @enderror
                </div>

                <!-- Description (short) -->
                <div class="mb-4">
                    <label class="block text-sm font-bold text-gray-700 mb-2">Краткое описание (для карточки)</label>
                    <textarea name="description" rows="3" 
                              class="w-full px-3 py-2 border border-gray-300 rounded-sm focus:border-blue-500 focus:ring-1 focus:ring-blue-500 shadow-sm text-sm"
                              placeholder="Краткое описание для карточки товара в категории">{{ old('description', $product->description ?? '') }}</textarea>
                    @error('description')
                        <p class="mt-1 text-xs text-red-600">{{ $message }}</p>
                    @enderror
                </div>

                <!-- Content (full) -->
                <div>
                    <label class="block text-sm font-bold text-gray-700 mb-2">Полное описание (для страницы товара)</label>
                    <textarea name="content" rows="6" 
                              class="w-full px-3 py-2 border border-gray-300 rounded-sm focus:border-blue-500 focus:ring-1 focus:ring-blue-500 shadow-sm text-sm"
                              placeholder="Подробное описание товара для отдельной страницы">{{ old('content', $product->content ?? '') }}</textarea>
                    @error('content')
                        <p class="mt-1 text-xs text-red-600">{{ $message }}</p>
                    @enderror
                </div>
            </div>

            {{-- Маркетплейс и категория --}}
            <div class="border-b border-gray-100 pb-6">
                <h3 class="text-sm font-bold text-gray-800 uppercase tracking-wider mb-4">Маркетплейс</h3>

                <div class="grid grid-cols-1 md:grid-cols-2 gap-6">
                    <!-- Marketplace -->
                    <div>
                        <label class="block text-sm font-bold text-gray-700 mb-2">Маркетплейс *</label>
                        <select name="marketplace" class="w-full px-3 py-2 border border-gray-300 rounded-sm focus:border-blue-500 focus:ring-1 focus:ring-blue-500 shadow-sm text-sm" required>
                            @foreach($marketplaces as $value => $label)
                                <option value="{{ $value }}" {{ old('marketplace', $product->marketplace ?? '') == $value ? 'selected' : '' }}>
                                    {{ $label }}
                                </option>
                            @endforeach
                        </select>
                        @error('marketplace')
                            <p class="mt-1 text-xs text-red-600">{{ $message }}</p>
                        @enderror
                    </div>

                    <!-- Category -->
                    @php
                        $formattedCategories = collect($categories)->map(function($c) {
                            return [
                                'id'    => $c['id'],
                                'title' => str_repeat('— ', $c['depth']) . $c['title'],
                                'plain' => $c['title'],
                            ];
                        })->values()->all();
                    @endphp
                    <div x-data='categorySearch({
                        selected: @json(old("category_id", $product->category_id ?? null)),
                        categories: @json($formattedCategories)
                    })' class="relative">

                        <label class="block text-sm font-bold text-gray-700 mb-2">Категория</label>

                        {{-- Hidden input that submits the real value --}}
                        <input type="hidden" name="category_id" :value="selectedId">

                        {{-- Trigger button --}}
                        <button type="button" @click="open = !open" @keydown.escape.window="open = false"
                                class="w-full flex items-center justify-between px-3 py-2 border border-gray-300 rounded-sm shadow-sm text-sm bg-white hover:border-blue-400 focus:outline-none focus:border-blue-500 focus:ring-1 focus:ring-blue-500 transition-colors">
                            <span x-text="selectedLabel" class="truncate text-gray-700"></span>
                            <svg class="w-4 h-4 text-gray-400 flex-shrink-0 ml-2 transition-transform" :class="{ 'rotate-180': open }" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M19 9l-7 7-7-7"/>
                            </svg>
                        </button>

                        {{-- Dropdown panel --}}
                        <div x-show="open" x-cloak x-transition:enter="transition ease-out duration-100"
                             x-transition:enter-start="opacity-0 scale-95" x-transition:enter-end="opacity-100 scale-100"
                             x-transition:leave="transition ease-in duration-75"
                             x-transition:leave-start="opacity-100 scale-100" x-transition:leave-end="opacity-0 scale-95"
                             @click.outside="open = false"
                             class="absolute z-50 mt-1 w-full bg-white border border-gray-200 rounded-sm shadow-lg">

                            {{-- Search input --}}
                            <div class="p-2 border-b border-gray-100">
                                <div class="relative">
                                    <svg class="absolute left-2.5 top-1/2 -translate-y-1/2 w-3.5 h-3.5 text-gray-400" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M21 21l-6-6m2-5a7 7 0 11-14 0 7 7 0 0114 0"/>
                                    </svg>
                                    <input type="text" x-model="query" x-ref="searchInput" @keydown.escape="open = false"
                                           placeholder="Поиск категории..."
                                           class="w-full pl-7 pr-3 py-1.5 text-sm border border-gray-200 rounded-sm focus:outline-none focus:border-blue-400">
                                </div>
                            </div>

                            {{-- Options list --}}
                            <ul class="max-h-56 overflow-y-auto py-1" x-ref="list">
                                {{-- Filtered categories --}}
                                <template x-for="cat in filtered" :key="cat.id">
                                    <li @click="select(cat.id, cat.title)"
                                        :class="selectedId === cat.id ? 'bg-blue-50 text-blue-700 font-medium' : 'text-gray-700 hover:bg-gray-50'"
                                        class="px-3 py-2 text-sm cursor-pointer truncate">
                                        <span x-text="cat.title"></span>
                                    </li>
                                </template>

                                {{-- Empty state --}}
                                <li x-show="filtered.length === 0" class="px-3 py-4 text-sm text-gray-400 text-center">Ничего не найдено</li>
                            </ul>
                        </div>

                        @error('category_id')
                            <p class="mt-1 text-xs text-red-600">{{ $message }}</p>
                        @enderror
                    </div>
                </div>

                <!-- Marketplace URL -->
                <div class="mt-4">
                    <label class="block text-sm font-bold text-gray-700 mb-2">Ссылка на маркетплейс</label>
                    <input type="url" name="marketplace_url" value="{{ old('marketplace_url', $product->marketplace_url ?? '') }}" 
                           class="w-full px-3 py-2 border border-gray-300 rounded-sm focus:border-blue-500 focus:ring-1 focus:ring-blue-500 shadow-sm text-sm font-mono" 
                           placeholder="https://...">
                    @error('marketplace_url')
                        <p class="mt-1 text-xs text-red-600">{{ $message }}</p>
                    @enderror
                </div>

                <!-- Image URL -->
                <div class="mt-4">
                    <label class="block text-sm font-bold text-gray-700 mb-2">URL изображения</label>
                    <input type="url" name="image_url" value="{{ old('image_url', $product->image_url ?? '') }}" 
                           class="w-full px-3 py-2 border border-gray-300 rounded-sm focus:border-blue-500 focus:ring-1 focus:ring-blue-500 shadow-sm text-sm font-mono" 
                           placeholder="https://...">
                    @error('image_url')
                        <p class="mt-1 text-xs text-red-600">{{ $message }}</p>
                    @enderror
                </div>
            </div>

            {{-- Рейтинг, бейдж, отзыв --}}
            <div class="border-b border-gray-100 pb-6">
                <h3 class="text-sm font-bold text-gray-800 uppercase tracking-wider mb-4">Рейтинг и отзыв</h3>

                <div class="grid grid-cols-1 md:grid-cols-3 gap-6">
                    <!-- Rating -->
                    <div>
                        <label class="block text-sm font-bold text-gray-700 mb-2">Рейтинг (0–10)</label>
                        <input type="number" name="rating" value="{{ old('rating', $product->rating ?? '0') }}" 
                               step="0.1" min="0" max="10"
                               class="w-full px-3 py-2 border border-gray-300 rounded-sm focus:border-blue-500 focus:ring-1 focus:ring-blue-500 shadow-sm text-sm">
                        @error('rating')
                            <p class="mt-1 text-xs text-red-600">{{ $message }}</p>
                        @enderror
                    </div>

                    <!-- Badge -->
                    <div>
                        <label class="block text-sm font-bold text-gray-700 mb-2">Бейдж</label>
                        <select name="badge" class="w-full px-3 py-2 border border-gray-300 rounded-sm focus:border-blue-500 focus:ring-1 focus:ring-blue-500 shadow-sm text-sm">
                            <option value="">Без бейджа</option>
                            @foreach($badges as $value => $label)
                                <option value="{{ $value }}" {{ old('badge', $product->badge ?? '') == $value ? 'selected' : '' }}>
                                    {{ $label }}
                                </option>
                            @endforeach
                        </select>
                        @error('badge')
                            <p class="mt-1 text-xs text-red-600">{{ $message }}</p>
                        @enderror
                    </div>

                    <!-- Sort Order -->
                    <div>
                        <label class="block text-sm font-bold text-gray-700 mb-2">Порядок сортировки</label>
                        <input type="number" name="sort_order" value="{{ old('sort_order', $product->sort_order ?? '0') }}" 
                               min="0"
                               class="w-full px-3 py-2 border border-gray-300 rounded-sm focus:border-blue-500 focus:ring-1 focus:ring-blue-500 shadow-sm text-sm">
                        @error('sort_order')
                            <p class="mt-1 text-xs text-red-600">{{ $message }}</p>
                        @enderror
                    </div>
                </div>

                <!-- Review Text -->
                <div class="mt-4">
                    <label class="block text-sm font-bold text-gray-700 mb-2">Текст отзыва</label>
                    <textarea name="review_text" rows="3" 
                              class="w-full px-3 py-2 border border-gray-300 rounded-sm focus:border-blue-500 focus:ring-1 focus:ring-blue-500 shadow-sm text-sm"
                              placeholder="Текст отзыва для карточки товара">{{ old('review_text', $product->review_text ?? '') }}</textarea>
                    @error('review_text')
                        <p class="mt-1 text-xs text-red-600">{{ $message }}</p>
                    @enderror
                </div>
            </div>

            {{-- Характеристики (динамические поля) --}}
            <div class="border-b border-gray-100 pb-6" x-data="featuresManager()">
                <h3 class="text-sm font-bold text-gray-800 uppercase tracking-wider mb-4">Характеристики</h3>
                <p class="text-xs text-gray-500 mb-3">Добавьте ключевые преимущества товара (отображаются на карточке)</p>

                <div class="space-y-2" id="features-container">
                    <template x-for="(feature, index) in features" :key="index">
                        <div class="flex items-center gap-2">
                            <span class="flex-shrink-0 w-6 h-6 rounded-full bg-green-50 border border-green-200 flex items-center justify-center">
                                <svg class="w-3 h-3 text-green-500" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2.5" d="M5 13l4 4L19 7"/></svg>
                            </span>
                            <input type="text" :name="'features[' + index + ']'" x-model="features[index]"
                                   class="flex-1 px-3 py-2 border border-gray-300 rounded-sm focus:border-blue-500 focus:ring-1 focus:ring-blue-500 shadow-sm text-sm"
                                   placeholder="Характеристика товара">
                            <button type="button" @click="removeFeature(index)"
                                    class="flex-shrink-0 w-8 h-8 rounded-sm border border-red-200 bg-red-50 hover:bg-red-100 flex items-center justify-center transition-colors">
                                <svg class="w-4 h-4 text-red-500" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M6 18L18 6M6 6l12 12"/></svg>
                            </button>
                        </div>
                    </template>
                </div>

                <button type="button" @click="addFeature()"
                        class="mt-3 inline-flex items-center gap-1.5 px-3 py-1.5 text-sm font-medium text-blue-600 hover:text-blue-800 border border-blue-200 hover:border-blue-300 rounded-sm bg-blue-50 hover:bg-blue-100 transition-colors">
                    <svg class="w-4 h-4" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 4v16m8-8H4"/></svg>
                    Добавить характеристику
                </button>
            </div>

            {{-- SEO --}}
            <div class="border-b border-gray-100 pb-6">
                <h3 class="text-sm font-bold text-gray-800 uppercase tracking-wider mb-4">SEO</h3>

                <div class="space-y-4">
                    <div>
                        <label class="block text-sm font-bold text-gray-700 mb-2">Meta Title</label>
                        <input type="text" name="meta_title" value="{{ old('meta_title', $product->meta_title ?? '') }}" 
                               class="w-full px-3 py-2 border border-gray-300 rounded-sm focus:border-blue-500 focus:ring-1 focus:ring-blue-500 shadow-sm text-sm"
                               placeholder="SEO заголовок (если пусто — используется название товара)">
                        @error('meta_title')
                            <p class="mt-1 text-xs text-red-600">{{ $message }}</p>
                        @enderror
                    </div>

                    <div>
                        <label class="block text-sm font-bold text-gray-700 mb-2">Meta Description</label>
                        <textarea name="meta_description" rows="2" 
                                  class="w-full px-3 py-2 border border-gray-300 rounded-sm focus:border-blue-500 focus:ring-1 focus:ring-blue-500 shadow-sm text-sm"
                                  placeholder="SEO описание для поисковых систем">{{ old('meta_description', $product->meta_description ?? '') }}</textarea>
                        @error('meta_description')
                            <p class="mt-1 text-xs text-red-600">{{ $message }}</p>
                        @enderror
                    </div>

                    <div>
                        <label class="block text-sm font-bold text-gray-700 mb-2">Meta Keywords</label>
                        <input type="text" name="meta_keywords" value="{{ old('meta_keywords', $product->meta_keywords ?? '') }}" 
                               class="w-full px-3 py-2 border border-gray-300 rounded-sm focus:border-blue-500 focus:ring-1 focus:ring-blue-500 shadow-sm text-sm"
                               placeholder="Ключевые слова через запятую">
                        @error('meta_keywords')
                            <p class="mt-1 text-xs text-red-600">{{ $message }}</p>
                        @enderror
                    </div>
                </div>
            </div>

            {{-- Активность --}}
            <div class="flex items-center gap-2 pt-2">
                <input type="checkbox" name="is_active" value="1" id="is_active"
                       {{ old('is_active', isset($product) ? $product->is_active : true) ? 'checked' : '' }}
                       class="rounded-sm border-gray-300 text-blue-600 focus:ring-blue-500">
                <label for="is_active" class="text-sm text-gray-700 font-medium cursor-pointer">Товар активен и отображается на сайте</label>
            </div>
        </div>

        <div class="bg-gray-50 px-6 py-4 flex justify-end gap-3 border-t border-gray-200">
            <a href="{{ route('admin.products.index') }}" class="px-4 py-2 text-sm font-medium text-gray-700 hover:text-gray-900 border border-gray-300 rounded-sm hover:bg-white transition-colors">
                Отмена
            </a>
            <button type="submit" class="px-4 py-2 bg-[var(--wp-admin-sidebar-active)] hover:bg-blue-700 text-white text-sm font-bold rounded-sm border border-blue-800 shadow-sm transition-colors">
                {{ isset($product) ? 'Сохранить изменения' : 'Добавить товар' }}
            </button>
        </div>
    </form>
</div>

<script>
    function featuresManager() {
        return {
            features: @json(old('features', isset($product) && $product->features ? $product->features : [''])),
            addFeature() {
                this.features.push('');
            },
            removeFeature(index) {
                if (this.features.length > 1) {
                    this.features.splice(index, 1);
                } else {
                    this.features = [''];
                }
            }
        }
    }

    function categorySearch(config) {
        return {
            open: false,
            query: '',
            categories: config.categories || [],
            selectedId: config.selected,

            get filtered() {
                if (this.query === '') {
                    return this.categories;
                }
                const q = this.query.toLowerCase();
                return this.categories.filter(c => c.plain.toLowerCase().includes(q));
            },

            get selectedLabel() {
                if (!this.selectedId) {
                    return 'Выберите категорию...';
                }
                const found = this.categories.find(c => c.id == this.selectedId);
                return found ? found.title : 'Выберите категорию...';
            },

            select(id, label) {
                this.selectedId = id;
                this.open = false;
                this.query = '';
            },

            init() {
                this.$watch('open', value => {
                    if (value) {
                        this.$nextTick(() => {
                            this.$refs.searchInput.focus();
                            // прокрутка к выбранному элементу
                            if (this.selectedId) {
                                const list = this.$refs.list;
                                const activeItem = list.querySelector('.bg-blue-50');
                                if (activeItem) {
                                    list.scrollTop = activeItem.offsetTop - list.offsetTop;
                                }
                            }
                        });
                    } else {
                        this.query = '';
                    }
                });
            }
        }
    }
</script>
@endsection
