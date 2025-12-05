<x-layouts.app :title="isset($affiliateLink) ? 'Редактировать ссылку' : 'Создать ссылку'">
    <div class="min-h-screen bg-gradient-to-br from-gray-50 to-gray-100 dark:from-gray-900 dark:to-gray-800 py-8">
        <div class="max-w-3xl mx-auto px-4 sm:px-6 lg:px-8">
            <!-- Header -->
            <div class="mb-8">
                <a href="{{ route('admin.affiliate-links.index') }}" 
                   class="inline-flex items-center text-gray-600 dark:text-gray-400 hover:text-gray-900 dark:hover:text-white mb-4 transition-colors group">
                    <svg class="w-5 h-5 mr-2 transform group-hover:-translate-x-1 transition-transform" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M10 19l-7-7m0 0l7-7m-7 7h18"/>
                    </svg>
                    Назад к списку
                </a>
                <h1 class="text-3xl font-bold text-gray-900 dark:text-white flex items-center gap-3">
                    <span class="text-4xl">{{ isset($affiliateLink) ? '✏️' : '➕' }}</span>
                    {{ isset($affiliateLink) ? 'Редактировать партнерскую ссылку' : 'Создать партнерскую ссылку' }}
                </h1>
            </div>

            <form action="{{ isset($affiliateLink) ? route('admin.affiliate-links.update', $affiliateLink) : route('admin.affiliate-links.store') }}" 
                  method="POST" class="bg-white dark:bg-gray-800 rounded-2xl shadow-lg border border-gray-100 dark:border-gray-700 overflow-hidden">
                @csrf
                @if(isset($affiliateLink))
                    @method('PUT')
                @endif

                <div class="p-8 space-y-8">
                    <!-- Category -->
                    <div class="relative">
                        <label class="block text-sm font-semibold text-gray-700 dark:text-gray-300 mb-3 flex items-center gap-2">
                            <div class="p-2 bg-blue-100 dark:bg-blue-900/30 rounded-lg">
                                <svg class="w-4 h-4 text-blue-600 dark:text-blue-400" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M7 7h.01M7 3h5c.512 0 1.024.195 1.414.586l7 7a2 2 0 010 2.828l-7 7a2 2 0 01-2.828 0l-7-7A1.994 1.994 0 013 12V7a4 4 0 014-4z"/>
                                </svg>
                            </div>
                            <span>Категория</span>
                        </label>
                        <select name="category_id" class="w-full pl-4 pr-10 py-3.5 rounded-xl border-2 border-gray-200 dark:border-gray-600 dark:bg-gray-700 dark:text-white shadow-sm focus:border-blue-500 focus:ring-4 focus:ring-blue-500/20 transition-all text-sm appearance-none bg-white dark:bg-gray-700 cursor-pointer hover:border-gray-300 dark:hover:border-gray-500">
                            <option value="">📂 Без категории (для всех)</option>
                            @foreach($categories as $category)
                                <option value="{{ $category['id'] }}" 
                                        {{ (isset($affiliateLink) && $affiliateLink->category_id == $category['id']) ? 'selected' : '' }}
                                        {{ $category['has_children'] ? 'disabled' : '' }}
                                        style="padding-left: {{ 8 + ($category['depth'] * 20) }}px;">
                                    @for($i = 0; $i < $category['depth']; $i++)
                                        {{ $i == $category['depth'] - 1 ? '└─' : '│ ' }}
                                    @endfor
                                    @if($category['has_children'])
                                        📂 {{ $category['title'] }} (содержит подкатегории)
                                    @else
                                        {{ $category['depth'] > 0 ? '📄 ' : '📁 ' }}{{ $category['title'] }}
                                    @endif
                                </option>
                            @endforeach
                        </select>
                        <div class="absolute right-4 top-[52px] pointer-events-none">
                            <svg class="w-5 h-5 text-gray-400" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M19 9l-7 7-7-7"/>
                            </svg>
                        </div>
                        <div class="mt-3 p-3 bg-blue-50 dark:bg-blue-900/20 rounded-xl border border-blue-200 dark:border-blue-800">
                            <p class="text-xs text-blue-800 dark:text-blue-200 flex items-start gap-2">
                                <svg class="w-4 h-4 mt-0.5 flex-shrink-0" fill="currentColor" viewBox="0 0 20 20">
                                    <path fill-rule="evenodd" d="M18 10a8 8 0 11-16 0 8 8 0 0116 0zm-7-4a1 1 0 11-2 0 1 1 0 012 0zM9 9a1 1 0 000 2v3a1 1 0 001 1h1a1 1 0 100-2v-3a1 1 0 00-1-1H9z" clip-rule="evenodd"/>
                                </svg>
                                <span><strong>Важно:</strong> Можно выбрать только конечные категории (📄)</span>
                            </p>
                        </div>
                        @error('category_id')
                            <p class="mt-2 text-sm text-red-600 dark:text-red-400 flex items-center gap-1">
                                <svg class="w-4 h-4" fill="currentColor" viewBox="0 0 20 20">
                                    <path fill-rule="evenodd" d="M18 10a8 8 0 11-16 0 8 8 0 0116 0zm-7 4a1 1 0 11-2 0 1 1 0 012 0zm-1-9a1 1 0 00-1 1v4a1 1 0 102 0V6a1 1 0 00-1-1z" clip-rule="evenodd"/>
                                </svg>
                                {{ $message }}
                            </p>
                        @enderror
                    </div>

                    <!-- Platform -->
                    <div>
                        <label class="block text-sm font-semibold text-gray-700 dark:text-gray-300 mb-3 flex items-center gap-2">
                            <div class="p-2 bg-purple-100 dark:bg-purple-900/30 rounded-lg">
                                <svg class="w-4 h-4 text-purple-600 dark:text-purple-400" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M19 11H5m14 0a2 2 0 012 2v6a2 2 0 01-2 2H5a2 2 0 01-2-2v-6a2 2 0 012-2m14 0V9a2 2 0 00-2-2M5 11V9a2 2 0 012-2m0 0V5a2 2 0 012-2h6a2 2 0 012 2v2M7 7h10"/>
                                </svg>
                            </div>
                            <span>Платформа *</span>
                        </label>
                        <div class="grid grid-cols-3 gap-4">
                            @foreach($platforms as $value => $label)
                                <label class="relative flex items-center justify-center p-5 border-2 rounded-xl cursor-pointer transition-all hover:border-blue-300 dark:hover:border-blue-700 hover:shadow-md
                                    {{ (isset($affiliateLink) && $affiliateLink->platform == $value) ? 'border-blue-500 bg-blue-50 dark:bg-blue-900/20 shadow-md' : 'border-gray-200 dark:border-gray-600' }}">
                                    <input type="radio" name="platform" value="{{ $value }}" 
                                           {{ (isset($affiliateLink) && $affiliateLink->platform == $value) || (!isset($affiliateLink) && $loop->first) ? 'checked' : '' }}
                                           class="absolute opacity-0" 
                                           onchange="this.closest('label').parentElement.querySelectorAll('label').forEach(l => l.classList.remove('border-blue-500', 'bg-blue-50', 'dark:bg-blue-900/20', 'shadow-md')); this.closest('label').classList.add('border-blue-500', 'bg-blue-50', 'dark:bg-blue-900/20', 'shadow-md');"
                                           required>
                                    <div class="text-center pointer-events-none">
                                        <div class="text-3xl mb-2">
                                            @if($value === 'ozon') 🔵
                                            @elseif($value === 'wildberries') 🟣
                                            @else 🟠
                                            @endif
                                        </div>
                                        <span class="text-sm font-semibold text-gray-700 dark:text-gray-300">{{ $label }}</span>
                                    </div>
                                </label>
                            @endforeach
                        </div>
                        @error('platform')
                            <p class="mt-2 text-sm text-red-600 dark:text-red-400">{{ $message }}</p>
                        @enderror
                    </div>

                    <!-- Product Name -->
                    <div class="relative">
                        <label class="block text-sm font-semibold text-gray-700 dark:text-gray-300 mb-3 flex items-center gap-2">
                            <div class="p-2 bg-green-100 dark:bg-green-900/30 rounded-lg">
                                <svg class="w-4 h-4 text-green-600 dark:text-green-400" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M16 11V7a4 4 0 00-8 0v4M5 9h14l1 12H4L5 9z"/>
                                </svg>
                            </div>
                            <span>Название товара *</span>
                        </label>
                        <div class="relative">
                            <input type="text" name="product_name" value="{{ old('product_name', $affiliateLink->product_name ?? '') }}" 
                                   class="w-full pl-12 pr-4 py-3.5 rounded-xl border-2 border-gray-200 dark:border-gray-600 dark:bg-gray-700 dark:text-white shadow-sm focus:border-blue-500 focus:ring-4 focus:ring-blue-500/20 transition-all placeholder-gray-400" 
                                   placeholder="Глюкометр Accu-Chek Active" required>
                            <div class="absolute left-4 top-1/2 -translate-y-1/2 text-gray-400">
                                <svg class="w-5 h-5" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M20 7l-8-4-8 4m16 0l-8 4m8-4v10l-8 4m0-10L4 7m8 4v10M4 7v10l8 4"/>
                                </svg>
                            </div>
                        </div>
                        @error('product_name')
                            <p class="mt-2 text-sm text-red-600 dark:text-red-400">{{ $message }}</p>
                        @enderror
                    </div>

                    <!-- Product Description -->
                    <div>
                        <label class="block text-sm font-semibold text-gray-700 dark:text-gray-300 mb-3 flex items-center gap-2">
                            <div class="p-2 bg-indigo-100 dark:bg-indigo-900/30 rounded-lg">
                                <svg class="w-4 h-4 text-indigo-600 dark:text-indigo-400" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M4 6h16M4 12h16M4 18h7"/>
                                </svg>
                            </div>
                            <span>Описание товара</span>
                        </label>
                        <textarea name="product_description" rows="3" 
                                  class="w-full px-4 py-3.5 rounded-xl border-2 border-gray-200 dark:border-gray-600 dark:bg-gray-700 dark:text-white shadow-sm focus:border-blue-500 focus:ring-4 focus:ring-blue-500/20 transition-all placeholder-gray-400 resize-none"
                                  placeholder="Точный и надежный глюкометр для ежедневного контроля">{{ old('product_description', $affiliateLink->product_description ?? '') }}</textarea>
                        @error('product_description')
                            <p class="mt-2 text-sm text-red-600 dark:text-red-400">{{ $message }}</p>
                        @enderror
                    </div>

                    <!-- Affiliate URL -->
                    <div>
                        <label class="block text-sm font-semibold text-gray-700 dark:text-gray-300 mb-3 flex items-center gap-2">
                            <div class="p-2 bg-orange-100 dark:bg-orange-900/30 rounded-lg">
                                <svg class="w-4 h-4 text-orange-600 dark:text-orange-400" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M13.828 10.172a4 4 0 00-5.656 0l-4 4a4 4 0 105.656 5.656l1.102-1.101m-.758-4.899a4 4 0 005.656 0l4-4a4 4 0 00-5.656-5.656l-1.1 1.1"/>
                                </svg>
                            </div>
                            <span>Партнерская ссылка *</span>
                        </label>
                        <div class="relative">
                            <input type="url" name="affiliate_url" value="{{ old('affiliate_url', $affiliateLink->affiliate_url ?? '') }}" 
                                   class="w-full pl-12 pr-4 py-3.5 rounded-xl border-2 border-gray-200 dark:border-gray-600 dark:bg-gray-700 dark:text-white shadow-sm focus:border-blue-500 focus:ring-4 focus:ring-blue-500/20 transition-all font-mono text-sm placeholder-gray-400" 
                                   placeholder="https://ozon.ru/t/..." required>
                            <div class="absolute left-4 top-1/2 -translate-y-1/2 text-gray-400">
                                <svg class="w-5 h-5" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M21 12a9 9 0 01-9 9m9-9a9 9 0 00-9-9m9 9H3m9 9a9 9 0 01-9-9m9 9c1.657 0 3-4.03 3-9s-1.343-9-3-9m0 18c-1.657 0-3-4.03-3-9s1.343-9 3-9m-9 9a9 9 0 019-9"/>
                                </svg>
                            </div>
                        </div>
                        @error('affiliate_url')
                            <p class="mt-2 text-sm text-red-600 dark:text-red-400">{{ $message }}</p>
                        @enderror
                    </div>

                    <!-- Anchor Text -->
                    <div>
                        <label class="block text-sm font-semibold text-gray-700 dark:text-gray-300 mb-3 flex items-center gap-2">
                            <div class="p-2 bg-pink-100 dark:bg-pink-900/30 rounded-lg">
                                <svg class="w-4 h-4 text-pink-600 dark:text-pink-400" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M7 8h10M7 12h4m1 8l-4-4H5a2 2 0 01-2-2V6a2 2 0 012-2h14a2 2 0 012 2v8a2 2 0 01-2 2h-3l-4 4z"/>
                                </svg>
                            </div>
                            <span>Текст ссылки (anchor text) *</span>
                        </label>
                        <div class="relative">
                            <input type="text" name="anchor_text" value="{{ old('anchor_text', $affiliateLink->anchor_text ?? '') }}" 
                                   class="w-full pl-12 pr-4 py-3.5 rounded-xl border-2 border-gray-200 dark:border-gray-600 dark:bg-gray-700 dark:text-white shadow-sm focus:border-blue-500 focus:ring-4 focus:ring-blue-500/20 transition-all placeholder-gray-400" 
                                   placeholder="современный глюкометр" required>
                            <div class="absolute left-4 top-1/2 -translate-y-1/2 text-gray-400">
                                <svg class="w-5 h-5" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M7 8h10M7 12h4m1 8l-4-4H5a2 2 0 01-2-2V6a2 2 0 012-2h14a2 2 0 012 2v8a2 2 0 01-2 2h-3l-4 4z"/>
                                </svg>
                            </div>
                        </div>
                        <p class="mt-2 text-xs text-gray-500 dark:text-gray-400 ml-1">Этот текст будет использован как анкор для ссылки в статье</p>
                        @error('anchor_text')
                            <p class="mt-2 text-sm text-red-600 dark:text-red-400">{{ $message }}</p>
                        @enderror
                    </div>

                    <!-- Placement Hint -->
                    <div>
                        <label class="block text-sm font-semibold text-gray-700 dark:text-gray-300 mb-3 flex items-center gap-2">
                            <div class="p-2 bg-yellow-100 dark:bg-yellow-900/30 rounded-lg">
                                <svg class="w-4 h-4 text-yellow-600 dark:text-yellow-400" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M13 16h-1v-4h-1m1-4h.01M21 12a9 9 0 11-18 0 9 9 0 0118 0z"/>
                                </svg>
                            </div>
                            <span>Подсказка для размещения</span>
                        </label>
                        <textarea name="placement_hint" rows="2" 
                                  class="w-full px-4 py-3.5 rounded-xl border-2 border-gray-200 dark:border-gray-600 dark:bg-gray-700 dark:text-white shadow-sm focus:border-blue-500 focus:ring-4 focus:ring-blue-500/20 transition-all placeholder-gray-400 resize-none" 
                                  placeholder="Вставить в раздел о мониторинге глюкозы">{{ old('placement_hint', $affiliateLink->placement_hint ?? '') }}</textarea>
                        <p class="mt-2 text-xs text-gray-500 dark:text-gray-400 ml-1">Подсказка для ИИ, где лучше разместить ссылку в статье</p>
                        @error('placement_hint')
                            <p class="mt-2 text-sm text-red-600 dark:text-red-400">{{ $message }}</p>
                        @enderror
                    </div>

                    <!-- Is Active -->
                    <div class="bg-gradient-to-r from-gray-50 to-gray-100 dark:from-gray-700/50 dark:to-gray-600/50 rounded-xl p-5 border-2 border-gray-200 dark:border-gray-600">
                        <label class="inline-flex items-center cursor-pointer group">
                            <input type="checkbox" name="is_active" value="1" 
                                   {{ (isset($affiliateLink) && $affiliateLink->is_active) || !isset($affiliateLink) ? 'checked' : '' }}
                                   class="w-5 h-5 rounded-lg border-2 border-gray-300 text-blue-600 focus:ring-4 focus:ring-blue-500/20 transition-all cursor-pointer">
                            <span class="ml-3 text-sm font-semibold text-gray-700 dark:text-gray-300 group-hover:text-blue-600 dark:group-hover:text-blue-400 transition-colors">
                                ✓ Активна (ссылка будет использоваться в статьях)
                            </span>
                        </label>
                    </div>
                </div>

                <!-- Footer -->
                <div class="bg-gradient-to-r from-gray-50 to-gray-100 dark:from-gray-700/50 dark:to-gray-600/50 px-8 py-6 flex justify-end gap-3 border-t-2 border-gray-200 dark:border-gray-600">
                    <a href="{{ route('admin.affiliate-links.index') }}" 
                       class="px-6 py-3 border-2 border-gray-300 dark:border-gray-600 rounded-xl text-gray-700 dark:text-gray-300 font-semibold hover:bg-white dark:hover:bg-gray-700 hover:shadow-md transition-all">
                        Отмена
                    </a>
                    <button type="submit" class="px-6 py-3 bg-gradient-to-r from-blue-600 to-blue-700 hover:from-blue-700 hover:to-blue-800 text-white font-semibold rounded-xl shadow-lg hover:shadow-xl transform hover:-translate-y-0.5 transition-all">
                        {{ isset($affiliateLink) ? '💾 Обновить' : '✨ Создать' }}
                    </button>
                </div>
            </form>
        </div>
    </div>
</x-layouts.app>
