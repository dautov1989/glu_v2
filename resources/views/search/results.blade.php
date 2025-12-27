<x-layouts.app title="Результаты поиска: {{ $query }}">
    <div class="py-12">
        <div class="max-w-7xl mx-auto sm:px-6 lg:px-8">
            <div class="mb-8">
                <h1 class="text-3xl font-bold text-zinc-900 dark:text-zinc-100">
                    Результаты поиска: <span class="text-cyan-600 dark:text-cyan-400">"{{ $query }}"</span>
                </h1>
                <p class="mt-2 text-zinc-600 dark:text-zinc-400">
                    Найдено {{ $posts->total() }} {{ trans_choice('статья|статьи|статей', $posts->total()) }}
                </p>
            </div>

            @if($posts->count() > 0)
                <div class="grid grid-cols-1 md:grid-cols-2 lg:grid-cols-3 xl:grid-cols-4 gap-6">
                    @foreach($posts as $post)
                        <a href="{{ route('post.show', $post->slug) }}"
                            class="group block bg-white dark:bg-zinc-900 rounded-xl border border-cyan-200/30 dark:border-cyan-800/20 overflow-hidden shadow-md hover:shadow-xl hover:border-cyan-400/50 dark:hover:border-cyan-600/50 transition-all duration-300 hover:scale-105 flex flex-col h-full relative">
                            <!-- Category Header (Top Center) -->
                            <div
                                class="px-3 py-1.5 border-b border-zinc-100 dark:border-zinc-800 bg-zinc-50/50 dark:bg-zinc-800/30">
                                <div
                                    class="text-[10px] font-bold uppercase tracking-wider text-center text-cyan-600 dark:text-cyan-400 truncate">
                                    {{ $post->category->title }}
                                </div>
                            </div>

                            <!-- Post Image -->
                            <div class="relative w-full overflow-hidden bg-white dark:bg-zinc-800/50"
                                style="aspect-ratio: 16/9;">
                                @if($post->image)
                                    <img src="{{ $post->image }}" alt="{{ $post->title }}"
                                        class="w-full h-full object-contain group-hover:scale-110 transition-transform duration-300">
                                @else
                                    <img src="{{ asset('images/medical_placeholder.png') }}" alt="{{ $post->title }}"
                                        class="w-full h-full object-contain group-hover:scale-110 transition-transform duration-300 opacity-80">
                                @endif
                            </div>

                            <!-- Post Content -->
                            <div class="p-4 pb-14 flex-1">
                                <h3
                                    class="text-sm font-bold text-zinc-800 dark:text-zinc-200 mb-0 leading-tight line-clamp-4 group-hover:text-cyan-600 dark:group-hover:text-cyan-400 transition-colors">
                                    {{ $post->title }}
                                </h3>

                                <div
                                    class="absolute bottom-4 left-4 right-4 flex items-center justify-between text-[11px] text-zinc-400 border-t border-zinc-100 dark:border-zinc-800 pt-3">
                                    <div class="flex items-center gap-1.5">
                                        <span>{{ $post->published_at->format('d.m.Y') }}</span>
                                    </div>
                                    <div class="flex items-center gap-1">
                                        <svg xmlns="http://www.w3.org/2000/svg" fill="none" viewBox="0 0 24 24" stroke-width="2"
                                            stroke="currentColor" class="w-3.5 h-3.5">
                                            <path stroke-linecap="round" stroke-linejoin="round"
                                                d="M2.036 12.322a1.012 1.012 0 0 1 0-.639C3.423 7.51 7.36 4.5 12 4.5c4.638 0 8.573 3.007 9.963 7.178.07.207.07.431 0 .639C20.577 16.49 16.64 19.5 12 19.5c-4.638 0-8.573-3.007-9.963-7.178Z" />
                                            <path stroke-linecap="round" stroke-linejoin="round"
                                                d="M15 12a3 3 0 1 1-6 0 3 3 0 0 1 6 0Z" />
                                        </svg>
                                        <span>{{ $post->views }}</span>
                                    </div>
                                </div>
                            </div>
                        </a>
                    @endforeach
                </div>

                <div class="mt-8">
                    {{ $posts->links() }}
                </div>
            @else
                <div
                    class="text-center py-16 bg-white dark:bg-zinc-800 rounded-2xl border border-dashed border-zinc-300 dark:border-zinc-700">
                    <div
                        class="inline-flex items-center justify-center w-16 h-16 rounded-full bg-zinc-100 dark:bg-zinc-700/50 mb-4">
                        <svg xmlns="http://www.w3.org/2000/svg" fill="none" viewBox="0 0 24 24" stroke-width="1.5"
                            stroke="currentColor" class="w-8 h-8 text-zinc-400">
                            <path stroke-linecap="round" stroke-linejoin="round"
                                d="m21 21-5.197-5.197m0 0A7.5 7.5 0 1 0 5.196 5.196a7.5 7.5 0 0 0 10.607 10.607Z" />
                        </svg>
                    </div>
                    <h3 class="text-lg font-medium text-zinc-900 dark:text-zinc-100">Ничего не найдено</h3>
                    <p class="mt-2 text-zinc-500 dark:text-zinc-400 max-w-sm mx-auto">
                        К сожалению, по вашему запросу ничего не найдено. Попробуйте изменить поисковый запрос или
                        используйте навигацию по категориям.
                    </p>
                    <a href="{{ route('home') }}"
                        class="inline-flex items-center gap-2 mt-6 px-4 py-2 bg-cyan-600 hover:bg-cyan-700 text-white rounded-lg transition-colors">
                        <svg xmlns="http://www.w3.org/2000/svg" fill="none" viewBox="0 0 24 24" stroke-width="2"
                            stroke="currentColor" class="w-4 h-4">
                            <path stroke-linecap="round" stroke-linejoin="round"
                                d="m2.25 12 8.954-8.955c.44-.439 1.152-.439 1.591 0L21.75 12M4.5 9.75v10.125c0 .621.504 1.125 1.125 1.125H9.75v-4.875c0-.621.504-1.125 1.125-1.125h2.25c.621 0 1.125.504 1.125 1.125V21h4.125c.621 0 1.125-.504 1.125-1.125V9.75M8.25 21h8.25" />
                        </svg>
                        На главную
                    </a>
                </div>
            @endif
        </div>
    </div>
</x-layouts.app>