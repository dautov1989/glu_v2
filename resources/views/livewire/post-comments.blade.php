<div
    class="mt-12 bg-gradient-to-br from-white via-cyan-50/30 to-blue-50/20 dark:from-zinc-900 dark:via-cyan-950/20 dark:to-blue-950/10 rounded-3xl p-8 shadow-xl shadow-cyan-200/20 dark:shadow-cyan-900/10 border border-cyan-200/50 dark:border-cyan-800/50">
    <!-- Header with gradient -->
    <div
        class="mb-8 pb-6 border-b border-gradient-to-r from-cyan-200 via-blue-200 to-cyan-200 dark:from-cyan-800 dark:via-blue-800 dark:to-cyan-800">
        <h3
            class="text-2xl font-bold bg-gradient-to-r from-cyan-600 via-blue-600 to-cyan-600 dark:from-cyan-400 dark:via-blue-400 dark:to-cyan-400 bg-clip-text text-transparent flex items-center gap-3">
            <div class="relative">
                <div
                    class="absolute -inset-1 bg-gradient-to-r from-cyan-500 to-blue-500 rounded-full blur opacity-30 animate-pulse">
                </div>
                <svg xmlns="http://www.w3.org/2000/svg" fill="none" viewBox="0 0 24 24" stroke-width="2"
                    stroke="currentColor" class="relative size-7 text-cyan-600 dark:text-cyan-400">
                    <path stroke-linecap="round" stroke-linejoin="round"
                        d="M7.5 8.25h9m-9 3H12m-9.75 1.51c0 1.6 1.123 2.994 2.707 3.227 1.129.166 2.27.293 3.423.379.35.026.67.21.865.501L12 21l2.755-4.133a1.14 1.14 0 0 1 .865-.501 48.172 48.172 0 0 0 3.423-.379c1.584-.233 2.707-1.626 2.707-3.228V6.741c0-1.602-1.123-2.995-2.707-3.228A48.394 48.394 0 0 0 12 3c-2.392 0-4.744.175-7.043.513C3.373 3.746 2.25 5.14 2.25 6.741v6.018Z" />
                </svg>
            </div>
            Комментарии
        </h3>
    </div>

    @auth
        <form wire:submit="save" class="mb-10">
            <div class="mb-4 relative group">
                <label for="comment" class="sr-only">Ваш комментарий</label>
                <div class="relative">
                    <!-- Glowing border effect on focus -->
                    <div
                        class="absolute -inset-0.5 bg-gradient-to-r from-cyan-500 to-blue-500 rounded-2xl opacity-0 group-focus-within:opacity-20 blur transition duration-300">
                    </div>
                    <textarea wire:model="body" id="comment" rows="4"
                        class="relative w-full rounded-2xl border-2 border-zinc-200 dark:border-zinc-700 bg-white/80 dark:bg-zinc-800/80 backdrop-blur-sm text-zinc-900 dark:text-white focus:border-cyan-500 dark:focus:border-cyan-400 focus:ring-4 focus:ring-cyan-500/20 dark:focus:ring-cyan-400/20 placeholder-zinc-400 dark:placeholder-zinc-500 resize-none transition-all duration-300 px-5 py-4 text-base shadow-sm hover:shadow-md"
                        placeholder="Напишите ваш комментарий..."></textarea>
                </div>
                @error('body')
                    <div class="mt-2 flex items-center gap-2 text-red-500 text-sm">
                        <svg xmlns="http://www.w3.org/2000/svg" viewBox="0 0 20 20" fill="currentColor" class="size-4">
                            <path fill-rule="evenodd"
                                d="M18 10a8 8 0 1 1-16 0 8 8 0 0 1 16 0Zm-8-5a.75.75 0 0 1 .75.75v4.5a.75.75 0 0 1-1.5 0v-4.5A.75.75 0 0 1 10 5Zm0 10a1 1 0 1 0 0-2 1 1 0 0 0 0 2Z"
                                clip-rule="evenodd" />
                        </svg>
                        {{ $message }}
                    </div>
                @enderror
            </div>
            <div class="flex justify-end">
                <button type="submit"
                    class="group relative px-6 py-3 bg-gradient-to-r from-cyan-600 to-blue-600 hover:from-cyan-700 hover:to-blue-700 text-white font-semibold rounded-xl transition-all duration-300 flex items-center gap-2 shadow-lg shadow-cyan-500/25 hover:shadow-xl hover:shadow-cyan-500/40 hover:scale-105 active:scale-95">
                    <div
                        class="absolute -inset-1 bg-gradient-to-r from-cyan-400 to-blue-400 rounded-xl opacity-0 group-hover:opacity-30 blur transition duration-300">
                    </div>
                    <span class="relative">Отправить</span>
                    <svg xmlns="http://www.w3.org/2000/svg" fill="none" viewBox="0 0 24 24" stroke-width="2"
                        stroke="currentColor" class="relative size-5 group-hover:translate-x-0.5 transition-transform">
                        <path stroke-linecap="round" stroke-linejoin="round"
                            d="M6 12 3.269 3.126A59.768 59.768 0 0 1 21.485 12 59.77 59.77 0 0 1 3.27 20.876L5.999 12Zm0 0h7.5" />
                    </svg>
                </button>
            </div>
        </form>
    @else
        <div
            class="mb-10 p-6 bg-gradient-to-br from-cyan-50 to-blue-50 dark:from-cyan-950/20 dark:to-blue-950/10 rounded-2xl border border-cyan-200/50 dark:border-cyan-700/50 text-center backdrop-blur-sm">
            <div
                class="mb-4 inline-flex items-center justify-center w-12 h-12 bg-cyan-100 dark:bg-cyan-900/30 rounded-full">
                <svg xmlns="http://www.w3.org/2000/svg" fill="none" viewBox="0 0 24 24" stroke-width="2"
                    stroke="currentColor" class="size-6 text-cyan-600 dark:text-cyan-400">
                    <path stroke-linecap="round" stroke-linejoin="round"
                        d="M16 7a4 4 0 1 1-8 0 4 4 0 0 1 8 0ZM12 14a7 7 0 0 0-7 7h14a7 7 0 0 0-7-7Z" />
                </svg>
            </div>
            <p class="text-zinc-700 dark:text-zinc-300 mb-4 font-medium">Войдите, чтобы оставить комментарий</p>
            <a href="{{ route('login') }}"
                class="inline-flex items-center justify-center px-6 py-2.5 bg-white dark:bg-zinc-800 border-2 border-cyan-200 dark:border-cyan-700 rounded-xl text-cyan-600 dark:text-cyan-400 font-semibold hover:bg-cyan-50 dark:hover:bg-cyan-900/20 hover:border-cyan-300 dark:hover:border-cyan-600 transition-all duration-300 shadow-sm hover:shadow-md">
                Войти
            </a>
        </div>
    @endauth

    <div class="space-y-5">
        @forelse($comments as $comment)
            <div class="group flex gap-4 p-5 bg-white/60 dark:bg-zinc-800/40 backdrop-blur-sm rounded-2xl border border-zinc-200/50 dark:border-zinc-700/50 hover:border-cyan-200 dark:hover:border-cyan-700 transition-all duration-300 hover:shadow-lg hover:shadow-cyan-200/20 dark:hover:shadow-cyan-900/10"
                wire:key="{{ $comment->id }}">
                <div class="flex-shrink-0">
                    <!-- Avatar with gradient border -->
                    <div class="relative">
                        <div
                            class="absolute -inset-1 bg-gradient-to-br from-cyan-400 via-blue-400 to-cyan-400 rounded-full opacity-60 group-hover:opacity-100 blur-sm transition duration-300">
                        </div>
                        <div
                            class="relative w-12 h-12 rounded-full bg-gradient-to-br from-cyan-500 via-blue-500 to-cyan-600 flex items-center justify-center text-white font-bold text-lg shadow-lg">
                            {{ substr($comment->user->name, 0, 1) }}
                        </div>
                    </div>
                </div>
                <div class="flex-grow min-w-0">
                    <div class="flex items-center justify-between mb-2 gap-3">
                        <h4 class="font-bold text-zinc-900 dark:text-white text-base truncate">{{ $comment->user->name }}
                        </h4>
                        <span class="text-xs text-zinc-500 dark:text-zinc-400 whitespace-nowrap flex items-center gap-1">
                            <svg xmlns="http://www.w3.org/2000/svg" viewBox="0 0 20 20" fill="currentColor"
                                class="size-3.5">
                                <path fill-rule="evenodd"
                                    d="M10 18a8 8 0 1 0 0-16 8 8 0 0 0 0 16Zm.75-13a.75.75 0 0 0-1.5 0v5c0 .414.336.75.75.75h4a.75.75 0 0 0 0-1.5h-3.25V5Z"
                                    clip-rule="evenodd" />
                            </svg>
                            {{ $comment->created_at->diffForHumans() }}
                        </span>
                    </div>
                    <div class="text-zinc-700 dark:text-zinc-300 text-sm leading-relaxed break-words">
                        {{ $comment->body }}
                    </div>
                </div>
            </div>
        @empty
            <div class="text-center py-16">
                <div
                    class="mb-4 inline-flex items-center justify-center w-16 h-16 bg-cyan-100 dark:bg-cyan-900/30 rounded-full">
                    <svg xmlns="http://www.w3.org/2000/svg" fill="none" viewBox="0 0 24 24" stroke-width="1.5"
                        stroke="currentColor" class="size-8 text-cyan-600 dark:text-cyan-400">
                        <path stroke-linecap="round" stroke-linejoin="round"
                            d="M8.625 12a.375.375 0 1 1-.75 0 .375.375 0 0 1 .75 0Zm0 0H8.25m4.125 0a.375.375 0 1 1-.75 0 .375.375 0 0 1 .75 0Zm0 0H12m4.125 0a.375.375 0 1 1-.75 0 .375.375 0 0 1 .75 0Zm0 0h-.375M21 12c0 4.556-4.03 8.25-9 8.25a9.764 9.764 0 0 1-2.555-.337A5.972 5.972 0 0 1 5.41 20.97a5.969 5.969 0 0 1-.474-.065 4.48 4.48 0 0 0 .978-2.025c.09-.457-.133-.901-.467-1.226C3.93 16.178 3 14.189 3 12c0-4.556 4.03-8.25 9-8.25s9 3.694 9 8.25Z" />
                    </svg>
                </div>
                <p class="text-zinc-500 dark:text-zinc-400 text-base font-medium">Пока нет комментариев</p>
                <p class="text-zinc-400 dark:text-zinc-500 text-sm mt-1">Будьте первым, кто оставит комментарий!</p>
            </div>
        @endforelse
    </div>
</div>