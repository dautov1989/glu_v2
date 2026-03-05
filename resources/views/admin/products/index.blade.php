@extends('layouts.admin')

@section('title', 'Товары маркетплейса')

@section('content')
    <div class="mb-6 flex justify-between items-center">
        <p class="text-gray-600 text-sm">Управление товарами для блоков рекомендаций в категориях</p>
        <a href="{{ route('admin.products.create') }}"
            class="inline-flex items-center gap-2 px-3 py-1.5 bg-[var(--wp-admin-sidebar-active)] hover:bg-blue-700 text-white text-sm font-medium rounded-sm border border-blue-800 transition-colors shadow-sm">
            <svg class="w-4 h-4" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 4v16m8-8H4" />
            </svg>
            Добавить товар
        </a>
    </div>

    @if(session('success'))
        <div class="mb-6 bg-white border-l-4 border-green-500 shadow-sm p-3 text-sm text-gray-700">
            {{ session('success') }}
        </div>
    @endif

    <!-- Stats Row -->
    <div class="grid grid-cols-1 md:grid-cols-4 gap-4 mb-6">
        <div class="bg-white border border-gray-200 p-4 shadow-sm rounded-sm">
            <p class="text-xs text-gray-500 uppercase tracking-wider font-bold mb-1">Всего товаров</p>
            <p class="text-2xl font-normal text-gray-800">{{ $products->total() }}</p>
        </div>
        <div class="bg-white border border-gray-200 p-4 shadow-sm rounded-sm">
            <p class="text-xs text-gray-500 uppercase tracking-wider font-bold mb-1">Активных</p>
            <p class="text-2xl font-normal text-green-600">{{ $products->where('is_active', true)->count() }}</p>
        </div>
        <div class="bg-white border border-gray-200 p-4 shadow-sm rounded-sm">
            <p class="text-xs text-gray-500 uppercase tracking-wider font-bold mb-1">Маркетплейсы</p>
            <p class="text-2xl font-normal text-purple-600">{{ $products->pluck('marketplace')->unique()->count() }}</p>
        </div>
        <div class="bg-white border border-gray-200 p-4 shadow-sm rounded-sm">
            <p class="text-xs text-gray-500 uppercase tracking-wider font-bold mb-1">Ср. рейтинг</p>
            <p class="text-2xl font-normal text-amber-600">{{ $products->count() > 0 ? number_format($products->avg('rating'), 1) : '—' }}</p>
        </div>
    </div>

    <!-- Products Table -->
    <div class="bg-white border border-gray-200 shadow-sm rounded-sm overflow-hidden">
        <table class="min-w-full divide-y divide-gray-200">
            <thead class="bg-gray-50">
                <tr>
                    <th class="px-4 py-3 text-left text-xs font-bold text-gray-500 uppercase">Товар</th>
                    <th class="px-4 py-3 text-left text-xs font-bold text-gray-500 uppercase">Маркетплейс</th>
                    <th class="px-4 py-3 text-left text-xs font-bold text-gray-500 uppercase">Рейтинг</th>
                    <th class="px-4 py-3 text-left text-xs font-bold text-gray-500 uppercase">Категория</th>
                    <th class="px-4 py-3 text-left text-xs font-bold text-gray-500 uppercase">Статус</th>
                    <th class="px-4 py-3 text-right text-xs font-bold text-gray-500 uppercase">Действия</th>
                </tr>
            </thead>
            <tbody class="divide-y divide-gray-200">
                @forelse($products as $product)
                    <tr class="hover:bg-gray-50 text-sm">
                        <td class="px-4 py-3">
                            <div class="flex items-center gap-3">
                                @if($product->image_url)
                                    <img src="{{ $product->image_url }}" alt="{{ $product->title }}" class="w-10 h-10 object-contain rounded border border-gray-100 bg-white flex-shrink-0">
                                @else
                                    <div class="w-10 h-10 bg-gray-100 rounded border border-gray-200 flex items-center justify-center flex-shrink-0">
                                        <svg class="w-5 h-5 text-gray-300" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="1.5" d="M20 7l-8-4-8 4m16 0l-8 4m8-4v10l-8 4m0-10L4 7m8 4v10M4 7v10l8 4"></path></svg>
                                    </div>
                                @endif
                                <div>
                                    <div class="font-bold text-blue-600">{{ $product->title }}</div>
                                    <div class="text-[10px] text-gray-400 font-mono mt-0.5">{{ $product->slug }}</div>
                                </div>
                            </div>
                        </td>
                        <td class="px-4 py-3">
                            @php
                                $mpColors = [
                                    'Wildberries' => 'bg-purple-50 text-purple-600 border-purple-100',
                                    'Ozon' => 'bg-blue-50 text-blue-600 border-blue-100',
                                    'Яндекс Маркет' => 'bg-red-50 text-red-600 border-red-100',
                                    'ЕАПТЕКА' => 'bg-pink-50 text-pink-600 border-pink-100',
                                    'СберМегаМаркет' => 'bg-green-50 text-green-600 border-green-100',
                                    'AliExpress' => 'bg-orange-50 text-orange-600 border-orange-100',
                                ];
                            @endphp
                            <span class="px-2 py-0.5 text-[10px] font-bold rounded-sm border {{ $mpColors[$product->marketplace] ?? 'bg-gray-50 text-gray-600 border-gray-100' }}">
                                {{ $product->marketplace }}
                            </span>
                        </td>
                        <td class="px-4 py-3">
                            <span class="text-amber-600 font-bold">{{ $product->rating }}</span>
                            <span class="text-gray-400 text-xs">/ 10</span>
                        </td>
                        <td class="px-4 py-3 text-gray-500">
                            {{ $product->category?->title ?? '—' }}
                        </td>
                        <td class="px-4 py-3">
                            <form action="{{ route('admin.products.toggle', $product) }}" method="POST">
                                @csrf
                                <button type="submit"
                                    class="text-xs {{ $product->is_active ? 'text-green-600' : 'text-gray-400' }} hover:underline">
                                    {{ $product->is_active ? 'Активен' : 'Неактивен' }}
                                </button>
                            </form>
                        </td>
                        <td class="px-4 py-3 text-right space-x-2">
                            <a href="{{ route('admin.products.edit', $product) }}"
                                class="text-blue-600 hover:text-blue-800 font-medium">Изм.</a>
                            <form action="{{ route('admin.products.destroy', $product) }}" method="POST" class="inline"
                                onsubmit="return confirm('Удалить товар?')">
                                @csrf
                                @method('DELETE')
                                <button type="submit" class="text-red-600 hover:text-red-800 font-medium">Удалить</button>
                            </form>
                        </td>
                    </tr>
                @empty
                    <tr>
                        <td colspan="6" class="px-4 py-12 text-center text-gray-400 italic">Товаров не найдено. Добавьте первый товар!</td>
                    </tr>
                @endforelse
            </tbody>
        </table>
    </div>

    @if($products->hasPages())
        <div class="mt-4">
            {{ $products->links() }}
        </div>
    @endif
@endsection
