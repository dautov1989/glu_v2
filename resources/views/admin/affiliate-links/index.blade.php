@extends('layouts.admin')

@section('title', 'Партнерские ссылки')

@section('content')
    <div class="mb-6 flex justify-between items-center">
        <p class="text-gray-600 text-sm">Управление реферальными ссылками для монетизации контента</p>
        <a href="{{ route('admin.affiliate-links.create') }}"
            class="inline-flex items-center gap-2 px-3 py-1.5 bg-[var(--wp-admin-sidebar-active)] hover:bg-blue-700 text-white text-sm font-medium rounded-sm border border-blue-800 transition-colors shadow-sm">
            <svg class="w-4 h-4" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 4v16m8-8H4" />
            </svg>
            Добавить ссылку
        </a>
    </div>

    @if(session('success'))
        <div class="mb-6 bg-white border-l-4 border-green-500 shadow-sm p-3 text-sm text-gray-700">
            {{ session('success') }}
        </div>
    @endif

    <!-- Stats Row -->
    <div class="grid grid-cols-1 md:grid-cols-3 gap-4 mb-6">
        <div class="bg-white border border-gray-200 p-4 shadow-sm rounded-sm">
            <p class="text-xs text-gray-500 uppercase tracking-wider font-bold mb-1">Всего ссылок</p>
            <p class="text-2xl font-normal text-gray-800">{{ $links->total() }}</p>
        </div>
        <div class="bg-white border border-gray-200 p-4 shadow-sm rounded-sm">
            <p class="text-xs text-gray-500 uppercase tracking-wider font-bold mb-1">Активных</p>
            <p class="text-2xl font-normal text-green-600">{{ $links->where('is_active', true)->count() }}</p>
        </div>
        <div class="bg-white border border-gray-200 p-4 shadow-sm rounded-sm">
            <p class="text-xs text-gray-500 uppercase tracking-wider font-bold mb-1">Платформы</p>
            <p class="text-2xl font-normal text-purple-600">3</p>
        </div>
    </div>

    <!-- Links Table (WP style) -->
    <div class="bg-white border border-gray-200 shadow-sm rounded-sm overflow-hidden">
        <table class="min-w-full divide-y divide-gray-200">
            <thead class="bg-gray-50">
                <tr>
                    <th class="px-4 py-3 text-left text-xs font-bold text-gray-500 uppercase">Название / Продукт</th>
                    <th class="px-4 py-3 text-left text-xs font-bold text-gray-500 uppercase">Платформа</th>
                    <th class="px-4 py-3 text-left text-xs font-bold text-gray-500 uppercase">Статус</th>
                    <th class="px-4 py-3 text-left text-xs font-bold text-gray-500 uppercase">Категория</th>
                    <th class="px-4 py-3 text-right text-xs font-bold text-gray-500 uppercase">Действия</th>
                </tr>
            </thead>
            <tbody class="divide-y divide-gray-200">
                @forelse($links as $link)
                    <tr class="hover:bg-gray-50 text-sm">
                        <td class="px-4 py-3">
                            <div class="font-bold text-blue-600">{{ $link->product_name }}</div>
                            <div class="text-[10px] text-gray-400 font-mono mt-0.5 truncate max-w-xs">{{ $link->url }}</div>
                        </td>
                        <td class="px-4 py-3">
                            <span class="px-2 py-0.5 text-[10px] font-bold rounded-sm border 
                                    @if($link->platform === 'ozon') bg-blue-50 text-blue-600 border-blue-100
                                    @elseif($link->platform === 'wildberries') bg-purple-50 text-purple-600 border-purple-100
                                    @else bg-orange-50 text-orange-600 border-orange-100
                                    @endif">
                                {{ strtoupper($link->platform) }}
                            </span>
                        </td>
                        <td class="px-4 py-3">
                            <form action="{{ route('admin.affiliate-links.toggle', $link) }}" method="POST">
                                @csrf
                                <button type="submit"
                                    class="text-xs {{ $link->is_active ? 'text-green-600' : 'text-gray-400' }} hover:underline">
                                    {{ $link->is_active ? 'Активна' : 'Неактивна' }}
                                </button>
                            </form>
                        </td>
                        <td class="px-4 py-3 text-gray-500">
                            {{ $link->category?->title ?? '—' }}
                        </td>
                        <td class="px-4 py-3 text-right space-x-2">
                            <a href="{{ route('admin.affiliate-links.edit', $link) }}"
                                class="text-blue-600 hover:text-blue-800 font-medium">Изм.</a>
                            <form action="{{ route('admin.affiliate-links.destroy', $link) }}" method="POST" class="inline"
                                onsubmit="return confirm('Удалить?')">
                                @csrf
                                @method('DELETE')
                                <button type="submit" class="text-red-600 hover:text-red-800 font-medium">Удалить</button>
                            </form>
                        </td>
                    </tr>
                @empty
                    <tr>
                        <td colspan="5" class="px-4 py-12 text-center text-gray-400 italic">Ссылок не найдено.</td>
                    </tr>
                @endforelse
            </tbody>
        </table>
    </div>

    @if($links->hasPages())
        <div class="mt-4">
            {{ $links->links() }}
        </div>
    @endif
@endsection