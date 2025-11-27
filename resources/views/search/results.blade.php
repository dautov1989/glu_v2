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
                        <article
                            class="bg-white dark:bg-zinc-800 rounded-xl overflow-hidden border border-zinc-200 dark:border-zinc-700 shadow-sm hover:shadow-md transition-all duration-200 group flex flex-col h-full">
                            @if($post->image)
                                <div class="aspect-[16/9] w-full overflow-hidden">
                                    <img src="{{ Storage::url($post->image) }}" alt="{{ $post->title }}"
                                        class="w-full h-full object-cover group-hover:scale-105 transition-transform duration-500">
                                </div>
                            @else
                                <div class="aspect-[16/9] w-full overflow-hidden">
                                    <img src="{{ asset('images/medical_placeholder.png') }}" alt="{{ $post->title }}"
                                        class="w-full h-full object-cover group-hover:scale-105 transition-transform duration-500 opacity-80">
                                </div>
                            @endif

                            <div class="p-4 flex flex-col flex-1">
                                <div class="flex items-center text-[11px] text-zinc-400 mb-2 space-x-2">
                                    <span>{{ $post->published_at->format('d.m.Y') }}</span>
                                    <span class="w-1 h-1 bg-zinc-300 rounded-full"></span>
                                    <span>{{ $post->views }} просмотров</span>
                                </div>

                                <h3
                                    class="text-base font-bold text-zinc-800 dark:text-zinc-100 mb-2 line-clamp-2 group-hover:text-cyan-600 dark:group-hover:text-cyan-400 transition-colors">
                                    <a href="{{ route('post.show', $post->slug) }}">
                                        {{ $post->title }}
                                    </a>
                                </h3>

                                <p class="text-sm text-zinc-500 dark:text-zinc-400 line-clamp-3 mb-4 flex-1 leading-relaxed">
                                    {{ $post->excerpt ?? Str::limit(strip_tags($post->content), 120) }}
                                </p>

                                <div class="mt-auto pt-3 border-t border-zinc-100 dark:border-zinc-700">
                                    <a href="{{ route('post.show', $post->slug) }}"
                                        class="text-cyan-600 dark:text-cyan-400 text-xs font-semibold hover:text-cyan-700 dark:hover:text-cyan-300 flex items-center uppercase tracking-wide">
                                        Читать статью
                                        <svg class="w-3 h-3 ml-1 transform group-hover:translate-x-1 transition-transform"
                                            fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
                                                d="M17 8l4 4m0 0l-4 4m4-4H3"></path>
                                        </svg>
                                    </a>
                                </div>
                            </div>
                        </article>
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