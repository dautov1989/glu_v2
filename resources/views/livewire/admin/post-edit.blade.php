@section('title', $post && $post->exists ? 'Редактировать статью' : 'Добавить статью')

<div class="max-w-5xl">
    <form wire:submit="save">
        <div class="grid grid-cols-1 lg:grid-cols-3 gap-6">
            <!-- Main Content Area -->
            <div class="lg:col-span-2 space-y-6">
                <!-- Title & Content -->
                <div class="bg-white border border-gray-200 shadow-sm p-6 rounded-sm">
                    <div class="space-y-4">
                        <div>
                            <label class="block text-xs font-bold text-gray-700 uppercase mb-1">Заголовок</label>
                            <input type="text" wire:model.live.debounce.500ms="title"
                                class="w-full px-3 py-2 border border-gray-300 rounded-sm focus:border-blue-500 focus:ring-1 focus:ring-blue-500 text-lg font-bold shadow-sm">
                            @error('title') <span class="text-red-600 text-xs">{{ $message }}</span> @enderror
                        </div>

                        <div>
                            <div class="flex items-center gap-2 mb-1">
                                <label class="block text-[10px] font-bold text-gray-500 uppercase">Постоянная
                                    ссылка:</label>
                                <span class="text-[10px] text-gray-400 font-mono">{{ config('app.url') }}/posts/</span>
                                <input type="text" wire:model="slug"
                                    class="text-[10px] border-b border-gray-200 focus:border-blue-500 outline-none font-mono text-blue-600 w-full">
                            </div>
                            @error('slug') <span class="text-red-600 text-xs">{{ $message }}</span> @enderror
                        </div>

                        <div>
                            <label class="block text-xs font-bold text-gray-700 uppercase mb-1">Текст статьи
                                (HTML)</label>
                            <textarea wire:model="content" rows="15"
                                class="w-full px-3 py-2 border border-gray-300 rounded-sm focus:border-blue-500 focus:ring-1 focus:ring-blue-500 text-sm font-mono shadow-sm"></textarea>
                            @error('content') <span class="text-red-600 text-xs">{{ $message }}</span> @enderror
                        </div>
                    </div>
                </div>

                <!-- Excerpt -->
                <div class="bg-white border border-gray-200 shadow-sm p-6 rounded-sm">
                    <label class="block text-xs font-bold text-gray-700 uppercase mb-3">Краткое описание
                        (Excerpt)</label>
                    <textarea wire:model="excerpt" rows="3"
                        class="w-full px-3 py-2 border border-gray-300 rounded-sm focus:border-blue-500 focus:ring-1 focus:ring-blue-500 text-sm shadow-sm"></textarea>
                    <p class="mt-1 text-[10px] text-gray-400">Краткое описание — это необязательная выжимка из вашей
                        записи.</p>
                </div>

                <!-- SEO Settings -->
                <div class="bg-white border border-gray-200 shadow-sm p-6 rounded-sm">
                    <h3 class="text-sm font-bold text-gray-800 mb-4 border-b border-gray-100 pb-2">Настройки SEO</h3>
                    <div class="space-y-4">
                        <div>
                            <label class="block text-[10px] font-bold text-gray-700 uppercase mb-1">Meta Title</label>
                            <input type="text" wire:model="meta_title"
                                class="w-full px-3 py-2 border border-gray-300 rounded-sm focus:border-blue-500 focus:ring-1 focus:ring-blue-500 text-sm shadow-sm">
                        </div>
                        <div>
                            <label class="block text-[10px] font-bold text-gray-700 uppercase mb-1">Meta
                                Description</label>
                            <textarea wire:model="meta_description" rows="2"
                                class="w-full px-3 py-2 border border-gray-300 rounded-sm focus:border-blue-500 focus:ring-1 focus:ring-blue-500 text-sm shadow-sm"></textarea>
                        </div>
                        <div>
                            <label class="block text-[10px] font-bold text-gray-700 uppercase mb-1">Meta
                                Keywords</label>
                            <input type="text" wire:model="meta_keywords"
                                class="w-full px-3 py-2 border border-gray-300 rounded-sm focus:border-blue-500 focus:ring-1 focus:ring-blue-500 text-sm shadow-sm"
                                placeholder="слово1, слово2, слово3">
                        </div>
                    </div>
                </div>
            </div>

            <!-- Sidebar Sidebar Area -->
            <div class="space-y-6">
                <!-- Publish Box -->
                <div class="bg-white border border-gray-200 shadow-sm rounded-sm">
                    <div
                        class="px-4 py-2 border-b border-gray-200 bg-gray-50 font-bold text-xs uppercase tracking-wider">
                        Опубликовать</div>
                    <div class="p-4 space-y-4">
                        <div class="flex items-center justify-between text-xs">
                            <span class="text-gray-500">Статус:</span>
                            <span class="font-bold {{ $is_published ? 'text-green-600' : 'text-yellow-600' }}">
                                {{ $is_published ? 'Опубликован' : 'Черновик' }}
                            </span>
                        </div>

                        <div class="flex items-center gap-2">
                            <input type="checkbox" wire:model="is_published" id="is_published"
                                class="rounded-sm border-gray-300 text-blue-600">
                            <label for="is_published" class="text-sm cursor-pointer select-none">Опубликовать</label>
                        </div>

                        @if($post && $post->exists)
                            <div class="text-[10px] text-gray-400">
                                Создано: {{ $post->created_at->format('d.m.Y H:i') }}
                            </div>
                        @endif

                        @if (session()->has('message'))
                            <div class="text-[10px] text-green-600 font-bold italic">{{ session('message') }}</div>
                        @endif
                    </div>
                    <div class="px-4 py-3 bg-gray-50 border-t border-gray-200 flex justify-between items-center">
                        <div>
                            @if($post && $post->exists)
                                <button type="button" wire:click="deletePost" wire:confirm="Вы уверены?"
                                    class="text-red-600 hover:text-red-800 text-[11px] underline">Удалить</button>
                            @endif
                        </div>
                        <button type="submit"
                            class="bg-blue-600 text-white px-4 py-1.5 rounded-sm text-xs font-bold hover:bg-blue-700 shadow-sm border border-blue-800 transition">
                            {{ $post && $post->exists ? 'Обновить' : 'Опубликовать' }}
                        </button>
                    </div>
                </div>

                <!-- Categories Box -->
                <div class="bg-white border border-gray-200 shadow-sm rounded-sm">
                    <div
                        class="px-4 py-2 border-b border-gray-200 bg-gray-50 font-bold text-xs uppercase tracking-wider">
                        Категория</div>
                    <div class="p-4 max-h-48 overflow-y-auto">
                        <select wire:model="category_id"
                            class="w-full px-2 py-1.5 border border-gray-300 rounded-sm text-sm shadow-sm">
                            <option value="">Выберите категорию...</option>
                            @foreach($categories as $category)
                                <option value="{{ $category->id }}">{{ $category->title }}</option>
                            @endforeach
                        </select>
                        @error('category_id') <span class="text-red-600 text-xs mt-1 block">{{ $message }}</span>
                        @enderror
                    </div>
                </div>

                <!-- Featured Image Box -->
                <div class="bg-white border border-gray-200 shadow-sm rounded-sm">
                    <div
                        class="px-4 py-2 border-b border-gray-200 bg-gray-50 font-bold text-xs uppercase tracking-wider">
                        Изображение записи</div>
                    <div class="p-4">
                        @if($image)
                            <div class="mb-3">
                                <img src="{{ $image }}"
                                    class="w-full aspect-video object-cover border border-gray-200 rounded-sm shadow-inner">
                            </div>
                        @endif
                        <input type="text" wire:model.live="image" placeholder="URL изображения..."
                            class="w-full px-2 py-1.5 border border-gray-300 rounded-sm text-xs shadow-sm font-mono">
                        <p class="mt-2 text-[10px] text-gray-400 italic font-mono">Введите прямой URL до картинки.</p>
                    </div>
                </div>
            </div>
        </div>
    </form>
</div>