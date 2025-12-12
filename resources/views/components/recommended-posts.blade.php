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

    <div class="flex flex-col gap-3">
        @foreach($posts as $post)
            <a href="{{ route('post.show', $post->slug) }}" 
               class="flex flex-col md:flex-row md:items-center gap-3 p-4 rounded-xl border border-zinc-200 dark:border-zinc-700 bg-white dark:bg-zinc-800 hover:border-cyan-400 dark:hover:border-cyan-500 hover:shadow-md hover:-translate-y-0.5 transition-all duration-300 group">
                
                {{-- Image Thumbnail --}}
                <div class="flex-shrink-0 relative overflow-hidden rounded-lg w-16 h-12 bg-zinc-100 dark:bg-zinc-800 border border-zinc-200 dark:border-zinc-700">
                    @if($post->image)
                        <img src="{{ $post->image }}" alt="{{ $post->title }}"
                            class="w-full h-full object-cover group-hover:scale-105 transition-transform duration-300"
                            loading="lazy">
                    @else
                         <img src="{{ asset('images/medical_placeholder.png') }}" alt="{{ $post->title }}"
                            class="w-full h-full object-cover group-hover:scale-105 transition-transform duration-300 opacity-80"
                            loading="lazy">
                    @endif
                </div>
                
                {{-- Content --}}
                <div class="flex-1 min-w-0">
                    <h3 class="text-base font-bold text-zinc-900 dark:text-zinc-100 group-hover:text-cyan-600 dark:group-hover:text-cyan-400 transition-colors truncate">
                        {{ $post->title }}
                    </h3>
                    <p class="text-xs text-zinc-500 dark:text-zinc-400 line-clamp-1">
                        {{ $post->excerpt }}
                    </p>
                </div>

                {{-- Meta & Action --}}
                <div class="hidden md:flex items-center justify-end gap-4 min-w-[fit-content]">
                    <div class="text-[11px] font-semibold text-zinc-400 uppercase tracking-wide flex items-center gap-3">
                        <span class="flex items-center gap-1 bg-zinc-50 dark:bg-zinc-700/50 px-2 py-1 rounded whitespace-nowrap">
                            {{ $post->published_at->format('d.m.Y') }}
                        </span>
                        <span class="flex items-center gap-1 bg-zinc-50 dark:bg-zinc-700/50 px-2 py-1 rounded whitespace-nowrap">
                            <svg class="w-3 h-3" fill="none" viewBox="0 0 24 24" stroke="currentColor">
                                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M15 12a3 3 0 11-6 0 3 3 0 016 0z" />
                                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M2.458 12C3.732 7.943 7.523 5 12 5c4.478 0 8.268 2.943 9.542 7-1.274 4.057-5.064 7-9.542 7-4.477 0-8.268-2.943-9.542-7z" />
                            </svg>
                            {{ $post->views }}
                        </span>
                    </div>
                     
                    <div class="w-8 h-8 rounded-full border border-zinc-200 dark:border-zinc-600 flex items-center justify-center text-zinc-400 group-hover:border-cyan-500 group-hover:text-cyan-500 group-hover:rotate-45 transition-all duration-300">
                        <svg class="w-4 h-4" fill="none" viewBox="0 0 24 24" stroke="currentColor">
                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M5 19L19 5M19 5H9m10 0v10" />
                        </svg>
                    </div>
                </div>
            </a>
        @endforeach
    </div>
</div>
@endif
