{{-- Recommended Posts Component --}}
@props([
    'posts'
])

@if($posts->count() > 0)
<div class="mt-12 pt-8 border-t border-zinc-200 dark:border-zinc-700">
    <div class="mb-6">
        <h2 class="text-2xl font-bold text-zinc-900 dark:text-zinc-100 flex items-center">
            <span class="w-1 h-8 bg-gradient-to-b from-cyan-500 to-blue-500 rounded-full mr-3"></span>
            Рекомендовано для вас
        </h2>
        <p class="text-sm text-zinc-500 dark:text-zinc-400 mt-2 ml-4">
            Подобранные статьи на основе ваших интересов
        </p>
    </div>

    <div class="grid grid-cols-1 md:grid-cols-2 lg:grid-cols-3 xl:grid-cols-4 gap-6">
        @foreach($posts as $post)
            <article class="bg-white dark:bg-zinc-800 rounded-xl overflow-hidden border border-zinc-200 dark:border-zinc-700 shadow-sm hover:shadow-md transition-all duration-200 group flex flex-col h-full">
                <a href="{{ route('post.show', $post->slug) }}" class="block relative aspect-[16/9] overflow-hidden">
                    @if($post->image)
                        <img src="{{ $post->image }}" alt="{{ $post->title }}"
                            class="w-full h-full object-cover group-hover:scale-105 transition-transform duration-500"
                            loading="lazy">
                    @else
                        <img src="{{ asset('images/medical_placeholder.png') }}" alt="{{ $post->title }}"
                            class="w-full h-full object-cover group-hover:scale-105 transition-transform duration-500 opacity-80"
                            loading="lazy">
                    @endif
                    
                    {{-- Category Badge --}}
                    @if($post->category)
                        <span class="absolute top-2 left-2 bg-black/50 backdrop-blur-sm text-white text-[10px] px-2 py-1 rounded-full">
                            {{ $post->category->title }}
                        </span>
                    @endif
                </a>

                <div class="p-4 flex flex-col flex-1">
                    <div class="flex items-center text-[11px] text-zinc-400 mb-2 gap-2 whitespace-nowrap overflow-hidden text-ellipsis">
                        <span>{{ $post->published_at->format('d.m.Y') }}</span>
                        <span class="w-1 h-1 bg-zinc-300 rounded-full flex-shrink-0"></span>
                        <span>{{ $post->views }} просмотров</span>
                    </div>

                    <h3 class="text-base font-bold text-zinc-800 dark:text-zinc-100 mb-2 line-clamp-2 group-hover:text-cyan-600 dark:group-hover:text-cyan-400 transition-colors">
                        <a href="{{ route('post.show', $post->slug) }}">
                            {{ $post->title }}
                        </a>
                    </h3>

                    <p class="text-sm text-zinc-500 dark:text-zinc-400 line-clamp-3 mb-4 flex-1 leading-relaxed">
                        {{ $post->excerpt }}
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
</div>
@endif
