@extends('layouts.admin')

@section('title', isset($affiliateLink) ? 'Редактировать ссылку' : 'Добавить ссылку')

@section('content')
<div class="max-w-4xl">
    <div class="mb-6">
        <a href="{{ route('admin.affiliate-links.index') }}" class="text-blue-600 hover:text-blue-800 text-sm flex items-center gap-1">
            <svg class="w-4 h-4" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M10 19l-7-7m0 0l7-7m-7 7h18"/></svg>
            Назад к списку
        </a>
    </div>

    <form action="{{ isset($affiliateLink) ? route('admin.affiliate-links.update', $affiliateLink) : route('admin.affiliate-links.store') }}" 
          method="POST" class="bg-white border border-gray-200 shadow-sm rounded-sm overflow-hidden">
        @csrf
        @if(isset($affiliateLink))
            @method('PUT')
        @endif

        <div class="p-6 space-y-6">
            <!-- Product Name -->
            <div>
                <label class="block text-sm font-bold text-gray-700 mb-2">Название товара / продукта *</label>
                <input type="text" name="product_name" value="{{ old('product_name', $affiliateLink->product_name ?? '') }}" 
                       class="w-full px-3 py-2 border border-gray-300 rounded-sm focus:border-blue-500 focus:ring-1 focus:ring-blue-500 shadow-sm text-sm" 
                       placeholder="Например: Глюкометр Accu-Chek Active" required>
                @error('product_name')
                    <p class="mt-1 text-xs text-red-600">{{ $message }}</p>
                @enderror
            </div>

            <div class="grid grid-cols-1 md:grid-cols-2 gap-6">
                <!-- Platform -->
                <div>
                    <label class="block text-sm font-bold text-gray-700 mb-2">Платформа *</label>
                    <select name="platform" class="w-full px-3 py-2 border border-gray-300 rounded-sm focus:border-blue-500 focus:ring-1 focus:ring-blue-500 shadow-sm text-sm" required>
                        @foreach($platforms as $value => $label)
                            <option value="{{ $value }}" {{ (isset($affiliateLink) && $affiliateLink->platform == $value) ? 'selected' : '' }}>
                                {{ $label }}
                            </option>
                        @endforeach
                    </select>
                    @error('platform')
                        <p class="mt-1 text-xs text-red-600">{{ $message }}</p>
                    @enderror
                </div>

                <!-- Category -->
                <div>
                    <label class="block text-sm font-bold text-gray-700 mb-2">Категория (влияет на показ в статьях)</label>
                    <select name="category_id" class="w-full px-3 py-2 border border-gray-300 rounded-sm focus:border-blue-500 focus:ring-1 focus:ring-blue-500 shadow-sm text-sm">
                        <option value="">Без категории (для всех)</option>
                        @foreach($categories as $category)
                            <option value="{{ $category['id'] }}" 
                                    {{ (isset($affiliateLink) && $affiliateLink->category_id == $category['id']) ? 'selected' : '' }}
                                    {{ $category['has_children'] ? 'disabled' : '' }}>
                                {{ str_repeat('— ', $category['depth']) }}{{ $category['title'] }} {{ $category['has_children'] ? '(раздел)' : '' }}
                            </option>
                        @endforeach
                    </select>
                    @error('category_id')
                        <p class="mt-1 text-xs text-red-600">{{ $message }}</p>
                    @enderror
                </div>
            </div>

            <!-- Affiliate URL -->
            <div>
                <label class="block text-sm font-bold text-gray-700 mb-2">Партнерская ссылка (URL) *</label>
                <input type="url" name="affiliate_url" value="{{ old('affiliate_url', $affiliateLink->affiliate_url ?? '') }}" 
                       class="w-full px-3 py-2 border border-gray-300 rounded-sm focus:border-blue-500 focus:ring-1 focus:ring-blue-500 shadow-sm text-sm font-mono" 
                       placeholder="https://..." required>
                @error('affiliate_url')
                    <p class="mt-1 text-xs text-red-600">{{ $message }}</p>
                @enderror
            </div>

            <!-- Anchor Text -->
            <div>
                <label class="block text-sm font-bold text-gray-700 mb-2">Текст ссылки (Anchor Text) *</label>
                <input type="text" name="anchor_text" value="{{ old('anchor_text', $affiliateLink->anchor_text ?? '') }}" 
                       class="w-full px-3 py-2 border border-gray-300 rounded-sm focus:border-blue-500 focus:ring-1 focus:ring-blue-500 shadow-sm text-sm" 
                       placeholder="То, на что пользователь кликнет в тексте" required>
                @error('anchor_text')
                    <p class="mt-1 text-xs text-red-600">{{ $message }}</p>
                @enderror
            </div>

            <!-- Description -->
            <div>
                <label class="block text-sm font-bold text-gray-700 mb-2">Описание (для справки)</label>
                <textarea name="product_description" rows="3" 
                          class="w-full px-3 py-2 border border-gray-300 rounded-sm focus:border-blue-500 focus:ring-1 focus:ring-blue-500 shadow-sm text-sm">{{ old('product_description', $affiliateLink->product_description ?? '') }}</textarea>
            </div>

            <!-- Placement Hint -->
            <div>
                <label class="block text-sm font-bold text-gray-700 mb-2">Подсказка по размещению (для ИИ)</label>
                <input type="text" name="placement_hint" value="{{ old('placement_hint', $affiliateLink->placement_hint ?? '') }}" 
                       class="w-full px-3 py-2 border border-gray-300 rounded-sm focus:border-blue-500 focus:ring-1 focus:ring-blue-500 shadow-sm text-sm" 
                       placeholder="Например: разместить в начале раздела про инсулины">
            </div>

            <!-- Is Active -->
            <div class="flex items-center gap-2 pt-2">
                <input type="checkbox" name="is_active" value="1" id="is_active"
                       {{ (isset($affiliateLink) && $affiliateLink->is_active) || !isset($affiliateLink) ? 'checked' : '' }}
                       class="rounded-sm border-gray-300 text-blue-600 focus:ring-blue-500">
                <label for="is_active" class="text-sm text-gray-700 font-medium cursor-pointer">Ссылка активна и готова к использованию</label>
            </div>
        </div>

        <div class="bg-gray-50 px-6 py-4 flex justify-end gap-3 border-t border-gray-200">
            <a href="{{ route('admin.affiliate-links.index') }}" class="px-4 py-2 text-sm font-medium text-gray-700 hover:text-gray-900 border border-gray-300 rounded-sm hover:bg-white transition-colors">
                Отмена
            </a>
            <button type="submit" class="px-4 py-2 bg-[var(--wp-admin-sidebar-active)] hover:bg-blue-700 text-white text-sm font-bold rounded-sm border border-blue-800 shadow-sm transition-colors">
                {{ isset($affiliateLink) ? 'Сохранить изменения' : 'Добавить ссылку' }}
            </button>
        </div>
    </form>
</div>
@endsection
