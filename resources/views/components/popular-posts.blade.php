{{-- Popular Posts Widget --}}
@props([
    'limit' => 5
])

@php
    // Получаем популярные статьи по просмотрам
    $popularPosts = \App\Models\Post::where('is_published', true)
        ->orderBy('views', 'desc')
        ->limit($limit)
        ->get();
@endphp

@if($popularPosts->count() > 0)
<div class="relative group">
    <div class="absolute -inset-0.5 bg-gradient-to-r from-cyan-500/20 to-blue-500/20 rounded-xl blur opacity-0 group-hover:opacity-100 transition-opacity duration-300"></div>
    <div class="relative bg-white dark:bg-zinc-900 rounded-xl border border-cyan-200/50 dark:border-cyan-800/30 p-6 shadow-lg shadow-cyan-200/20 dark:shadow-cyan-900/10">
        
        {{-- Header --}}
        <div class="flex items-center gap-2 mb-5">
            <div class="w-8 h-8 bg-gradient-to-br from-cyan-500 to-blue-500 rounded-lg flex items-center justify-center text-white shadow-lg shadow-cyan-500/30">
                <svg xmlns="http://www.w3.org/2000/svg" fill="none" viewBox="0 0 24 24" stroke-width="2" stroke="currentColor" class="w-5 h-5">
                    <path stroke-linecap="round" stroke-linejoin="round" d="M2.25 18 9 11.25l4.306 4.306a11.95 11.95 0 0 1 5.814-5.518l2.74-1.22m0 0-5.94-2.281m5.94 2.28-2.28 5.941" />
                </svg>
            </div>
            <h3 class="text-sm font-bold bg-gradient-to-r from-cyan-700 to-blue-700 dark:from-cyan-300 dark:to-blue-300 bg-clip-text text-transparent">
                Популярные статьи
            </h3>
        </div>

        {{-- Posts List --}}
        <div class="space-y-4">
            @foreach($popularPosts as $index => $post)
                <a href="{{ route('post.show', $post->slug) }}" 
                   class="group/item flex gap-3 hover:bg-cyan-50 dark:hover:bg-cyan-950/20 rounded-lg p-2 -m-2 transition-all duration-200">
                    
                    {{-- Number Badge --}}
                    <div class="flex-shrink-0">
                        <div class="w-8 h-8 rounded-lg flex items-center justify-center font-bold text-sm
                            {{ $index === 0 ? 'bg-gradient-to-br from-amber-400 to-orange-500 text-white shadow-lg shadow-amber-500/30' : '' }}
                            {{ $index === 1 ? 'bg-gradient-to-br from-zinc-300 to-zinc-400 text-zinc-700 shadow-md' : '' }}
                            {{ $index === 2 ? 'bg-gradient-to-br from-amber-600 to-amber-700 text-white shadow-md' : '' }}
                            {{ $index > 2 ? 'bg-zinc-100 dark:bg-zinc-800 text-zinc-500 dark:text-zinc-400' : '' }}">
                            {{ $index + 1 }}
                        </div>
                    </div>

                    {{-- Post Info --}}
                    <div class="flex-1 min-w-0">
                        <h4 class="text-sm font-semibold text-zinc-800 dark:text-zinc-200 line-clamp-2 mb-1 group-hover/item:text-cyan-600 dark:group-hover/item:text-cyan-400 transition-colors">
                            {{ $post->title }}
                        </h4>
                        <div class="flex items-center gap-2 text-xs text-zinc-400">
                            <svg class="w-3 h-3" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M15 12a3 3 0 11-6 0 3 3 0 016 0z"></path>
                                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M2.458 12C3.732 7.943 7.523 5 12 5c4.478 0 8.268 2.943 9.542 7-1.274 4.057-5.064 7-9.542 7-4.477 0-8.268-2.943-9.542-7z"></path>
                            </svg>
                            <span>{{ number_format($post->views) }}</span>
                        </div>
                    </div>

                    {{-- Arrow Icon --}}
                    <div class="flex-shrink-0 self-center opacity-0 group-hover/item:opacity-100 transition-opacity">
                        <svg class="w-4 h-4 text-cyan-500" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M9 5l7 7-7 7"></path>
                        </svg>
                    </div>
                </a>

                @if(!$loop->last)
                    <div class="border-t border-zinc-100 dark:border-zinc-800"></div>
                @endif
            @endforeach
        </div>

        {{-- View All Link --}}
        <div class="mt-5 pt-4 border-t border-cyan-200/50 dark:border-cyan-800/30">
            <a href="{{ route('articles.index') }}" 
               class="text-xs font-semibold text-cyan-600 dark:text-cyan-400 hover:text-cyan-700 dark:hover:text-cyan-300 flex items-center justify-center gap-1 transition-colors">
                <span>Смотреть все статьи</span>
                <svg class="w-3 h-3" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M13.5 4.5 21 12m0 0-7.5 7.5M21 12H3"></path>
                </svg>
            </a>
        </div>
    </div>
</div>
@endif
