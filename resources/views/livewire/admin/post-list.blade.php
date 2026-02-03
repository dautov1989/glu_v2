@section('title', 'Статьи')

<div>
    <div class="mb-6 flex flex-col md:flex-row md:items-center justify-between gap-4">
        <div class="flex items-center gap-4">
            <a href="{{ route('admin.posts.create') }}"
                class="bg-blue-600 text-white px-4 py-2 rounded-sm text-sm font-bold hover:bg-blue-700 transition shadow-sm border border-blue-800">
                Добавить статью
            </a>

            <div class="flex items-center gap-2 text-sm ml-4">
                <button wire:click="$set('status', '')"
                    class="{{ $status === '' ? 'text-gray-900 font-bold' : 'text-blue-600 hover:text-blue-800' }}">Все</button>
                <span class="text-gray-300">|</span>
                <button wire:click="$set('status', 'published')"
                    class="{{ $status === 'published' ? 'text-gray-900 font-bold' : 'text-blue-600 hover:text-blue-800' }}">Опубликованные</button>
                <span class="text-gray-300">|</span>
                <button wire:click="$set('status', 'draft')"
                    class="{{ $status === 'draft' ? 'text-gray-900 font-bold' : 'text-blue-600 hover:text-blue-800' }}">Черновики</button>
            </div>
        </div>

        <div class="flex items-center gap-2">
            <select wire:model.live="categoryId"
                class="px-3 py-1.5 border border-gray-300 rounded-sm text-sm focus:border-blue-500 focus:ring-1 focus:ring-blue-500 shadow-sm bg-white">
                <option value="">Все категории</option>
                @foreach($categories as $category)
                    <option value="{{ $category->id }}">{{ $category->title }}</option>
                @endforeach
            </select>

            <input type="text" wire:model.live.debounce.300ms="search" placeholder="Поиск по статьям..."
                class="px-3 py-1.5 border border-gray-300 rounded-sm text-sm focus:border-blue-500 focus:ring-1 focus:ring-blue-500 shadow-sm w-64">
        </div>
    </div>

    @if (session()->has('message'))
        <div class="mb-4 p-3 bg-green-100 border-l-4 border-green-500 text-green-700 text-sm shadow-sm">
            {{ session('message') }}
        </div>
    @endif

    <div class="bg-white border border-gray-200 shadow-sm rounded-sm overflow-hidden relative">
        <!-- Loading Overlay -->
        <div wire:loading wire:target="search, categoryId, status, gotoPage, previousPage, nextPage"
            class="absolute inset-0 bg-white/50 backdrop-blur-[1px] z-10 flex items-center justify-center">
            <div class="flex flex-col items-center">
                <svg class="animate-spin h-8 w-8 text-blue-600 mb-2" xmlns="http://www.w3.org/2000/svg" fill="none"
                    viewBox="0 0 24 24">
                    <circle class="opacity-25" cx="12" cy="12" r="10" stroke="currentColor" stroke-width="4"></circle>
                    <path class="opacity-75" fill="currentColor"
                        d="M4 12a8 8 0 018-8V0C5.373 0 0 5.373 0 12h4zm2 5.291A7.962 7.962 0 014 12H0c0 3.042 1.135 5.824 3 7.938l3-2.647z">
                    </path>
                </svg>
                <span class="text-xs font-bold text-gray-600 uppercase tracking-wider">Загрузка...</span>
            </div>
        </div>

        <table class="w-full text-left border-collapse" wire:loading.class="opacity-50">
            <thead>
                <tr class="border-b border-gray-200 bg-gray-50 text-xs font-bold text-gray-700 uppercase">
                    <th class="px-4 py-3 w-12 text-center">Изобр.</th>
                    <th class="px-4 py-3">Заголовок</th>
                    <th class="px-4 py-3">Категория</th>
                    <th class="px-4 py-3">Статус</th>
                    <th class="px-4 py-3">Просмотры</th>
                    <th class="px-4 py-3">Дата</th>
                    <th class="px-4 py-3 text-right">Действия</th>
                </tr>
            </thead>
            <tbody class="divide-y divide-gray-100">
                @forelse($posts as $post)
                    <tr class="hover:bg-gray-50 transition-colors group">
                        <td class="px-4 py-3">
                            <img src="{{ $post->image }}" alt=""
                                class="w-10 h-10 object-cover rounded-sm border border-gray-200 shadow-sm">
                        </td>
                        <td class="px-4 py-3">
                            <div class="flex flex-col">
                                <a href="{{ route('admin.posts.edit', $post) }}"
                                    class="text-sm font-bold text-blue-600 hover:text-blue-800">
                                    {{ $post->title }}
                                </a>
                                <div
                                    class="flex items-center gap-2 mt-1 opacity-0 group-hover:opacity-100 transition-opacity text-[10px]">
                                    <a href="{{ route('admin.posts.edit', $post) }}"
                                        class="text-blue-600 hover:underline">Изменить</a>
                                    <span class="text-gray-300">|</span>
                                    <button wire:click="deletePost({{ $post->id }})"
                                        wire:confirm="Вы уверены, что хотите удалить эту статью?"
                                        class="text-red-600 hover:underline">Удалить</button>
                                    <span class="text-gray-300">|</span>
                                    <a href="{{ route('post.show', $post->slug) }}" target="_blank"
                                        class="text-gray-600 hover:underline">Просмотреть</a>
                                </div>
                            </div>
                        </td>
                        <td class="px-4 py-3 text-sm text-gray-600">
                            {{ $post->category?->title ?? 'Без категории' }}
                        </td>
                        <td class="px-4 py-3">
                            @if($post->is_published)
                                <span
                                    class="px-2 py-0.5 rounded-full bg-green-100 text-green-700 text-[10px] font-bold uppercase">Опубликовано</span>
                            @else
                                <span
                                    class="px-2 py-0.5 rounded-full bg-yellow-100 text-yellow-700 text-[10px] font-bold uppercase">Черновик</span>
                            @endif
                        </td>
                        <td class="px-4 py-3 text-sm text-gray-500 text-center">
                            {{ number_format($post->views) }}
                        </td>
                        <td class="px-4 py-3 text-xs text-gray-500 italic">
                            {{ $post->created_at->format('d.m.Y') }}<br>
                            <span class="text-[9px] uppercase">{{ $post->is_published ? 'Опубликовано' : 'Создано' }}</span>
                        </td>
                        <td class="px-4 py-3 text-right">
                            <a href="{{ route('admin.posts.edit', $post) }}" class="text-gray-400 hover:text-blue-600">
                                <svg class="w-5 h-5 inline" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
                                        d="M11 5H6a2 2 0 00-2 2v11a2 2 0 002 2h11a2 2 0 002-2v-5m-1.414-9.414a2 2 0 112.828 2.828L11.828 15H9v-2.828l8.586-8.586z" />
                                </svg>
                            </a>
                        </td>
                    </tr>
                @empty
                    <tr>
                        <td colspan="7" class="px-4 py-12 text-center text-gray-500 text-sm">
                            Статьи не найдены
                        </td>
                    </tr>
                @endforelse
            </tbody>
        </table>
    </div>

    <div class="mt-4">
        {{ $posts->links() }}
    </div>
</div>