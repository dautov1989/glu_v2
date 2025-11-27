<div
    class="mt-8 bg-white/80 dark:bg-zinc-900/80 backdrop-blur-sm rounded-2xl p-6 shadow-lg border border-zinc-200/50 dark:border-zinc-800/50">
    <!-- Header -->
    <div class="mb-5 pb-4 border-b border-zinc-200 dark:border-zinc-800">
        <h3 class="text-xl font-bold text-zinc-900 dark:text-white flex items-center gap-2">
            <svg xmlns="http://www.w3.org/2000/svg" fill="none" viewBox="0 0 24 24" stroke-width="2"
                stroke="currentColor" class="size-5 text-cyan-600 dark:text-cyan-400">
                <path stroke-linecap="round" stroke-linejoin="round"
                    d="M7.5 8.25h9m-9 3H12m-9.75 1.51c0 1.6 1.123 2.994 2.707 3.227 1.129.166 2.27.293 3.423.379.35.026.67.21.865.501L12 21l2.755-4.133a1.14 1.14 0 0 1 .865-.501 48.172 48.172 0 0 0 3.423-.379c1.584-.233 2.707-1.626 2.707-3.228V6.741c0-1.602-1.123-2.995-2.707-3.228A48.394 48.394 0 0 0 12 3c-2.392 0-4.744.175-7.043.513C3.373 3.746 2.25 5.14 2.25 6.741v6.018Z" />
            </svg>
            Комментарии
        </h3>
    </div>

    <!-- Pending Comment Notification -->
    @if (session()->has('comment_pending'))
        <div class="mb-5 p-4 bg-cyan-50 dark:bg-cyan-900/20 border border-cyan-200 dark:border-cyan-700 rounded-xl">
            <div class="flex items-start gap-3">
                <svg xmlns="http://www.w3.org/2000/svg" fill="none" viewBox="0 0 24 24" stroke-width="2"
                    stroke="currentColor" class="size-5 text-cyan-600 dark:text-cyan-400 flex-shrink-0 mt-0.5">
                    <path stroke-linecap="round" stroke-linejoin="round"
                        d="M9 12.75 11.25 15 15 9.75M21 12a9 9 0 1 1-18 0 9 9 0 0 1 18 0Z" />
                </svg>
                <p class="text-sm text-cyan-700 dark:text-cyan-300">
                    <strong>Комментарий отправлен!</strong> Он появится на сайте после проверки администратором.
                </p>
            </div>
        </div>
    @endif

    <!-- Comments List -->
    <div class="space-y-3 mb-6">
        @forelse($comments as $comment)
            <div class="flex gap-3 p-4 bg-zinc-50/50 dark:bg-zinc-800/30 rounded-xl border border-zinc-200/30 dark:border-zinc-700/30 hover:border-cyan-300 dark:hover:border-cyan-700 transition-all duration-200"
                wire:key="{{ $comment->id }}">
                <div class="flex-shrink-0">
                    <!-- Avatar -->
                    <div
                        class="w-9 h-9 rounded-full bg-gradient-to-br from-cyan-500 to-blue-500 flex items-center justify-center text-white font-semibold text-sm shadow-md">
                        {{ substr($comment->user->name, 0, 1) }}
                    </div>
                </div>
                <div class="flex-grow min-w-0">
                    <div class="flex items-center justify-between mb-1.5 gap-2">
                        <h4 class="font-semibold text-zinc-900 dark:text-white text-sm truncate">
                            {{ $comment->user->name }}
                        </h4>
                        <span class="text-xs text-zinc-500 dark:text-zinc-400 whitespace-nowrap">
                            {{ $comment->created_at->diffForHumans() }}
                        </span>
                    </div>
                    <div class="text-zinc-700 dark:text-zinc-300 text-sm leading-relaxed break-words">
                        {{ $comment->body }}
                    </div>
                </div>
            </div>
        @empty
            <div class="text-center py-10">
                <div
                    class="mb-3 inline-flex items-center justify-center w-12 h-12 bg-cyan-100 dark:bg-cyan-900/30 rounded-full">
                    <svg xmlns="http://www.w3.org/2000/svg" fill="none" viewBox="0 0 24 24" stroke-width="1.5"
                        stroke="currentColor" class="size-6 text-cyan-600 dark:text-cyan-400">
                        <path stroke-linecap="round" stroke-linejoin="round"
                            d="M8.625 12a.375.375 0 1 1-.75 0 .375.375 0 0 1 .75 0Zm0 0H8.25m4.125 0a.375.375 0 1 1-.75 0 .375.375 0 0 1 .75 0Zm0 0H12m4.125 0a.375.375 0 1 1-.75 0 .375.375 0 0 1 .75 0Zm0 0h-.375M21 12c0 4.556-4.03 8.25-9 8.25a9.764 9.764 0 0 1-2.555-.337A5.972 5.972 0 0 1 5.41 20.97a5.969 5.969 0 0 1-.474-.065 4.48 4.48 0 0 0 .978-2.025c.09-.457-.133-.901-.467-1.226C3.93 16.178 3 14.189 3 12c0-4.556 4.03-8.25 9-8.25s9 3.694 9 8.25Z" />
                    </svg>
                </div>
                <p class="text-zinc-500 dark:text-zinc-400 text-sm font-medium">Пока нет комментариев</p>
                <p class="text-zinc-400 dark:text-zinc-500 text-xs mt-1">Будьте первым, кто оставит комментарий!</p>
            </div>
        @endforelse
    </div>

    <!-- Comment Form -->
    @auth
        <div class="pt-4 border-t border-zinc-200 dark:border-zinc-800">
            <form wire:submit="save">
                <div class="mb-3">
                    <label for="comment" class="sr-only">Ваш комментарий</label>
                    <textarea wire:model="body" id="comment" rows="3"
                        class="w-full rounded-xl border border-zinc-300 dark:border-zinc-700 bg-white dark:bg-zinc-800 text-zinc-900 dark:text-white focus:border-cyan-500 dark:focus:border-cyan-400 focus:ring-2 focus:ring-cyan-500/20 dark:focus:ring-cyan-400/20 placeholder-zinc-400 dark:placeholder-zinc-500 resize-none transition-all duration-200 px-4 py-3 text-sm"
                        placeholder="Напишите ваш комментарий..."></textarea>
                    @error('body')
                        <div class="mt-1.5 flex items-center gap-1.5 text-red-500 text-xs">
                            <svg xmlns="http://www.w3.org/2000/svg" viewBox="0 0 20 20" fill="currentColor" class="size-3.5">
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
                        class="px-5 py-2 bg-gradient-to-r from-cyan-600 to-blue-600 hover:from-cyan-700 hover:to-blue-700 text-white font-medium rounded-lg transition-all duration-200 flex items-center gap-2 shadow-md hover:shadow-lg text-sm">
                        <span>Отправить</span>
                        <svg xmlns="http://www.w3.org/2000/svg" fill="none" viewBox="0 0 24 24" stroke-width="2"
                            stroke="currentColor" class="size-4">
                            <path stroke-linecap="round" stroke-linejoin="round"
                                d="M6 12 3.269 3.126A59.768 59.768 0 0 1 21.485 12 59.77 59.77 0 0 1 3.27 20.876L5.999 12Zm0 0h7.5" />
                        </svg>
                    </button>
                </div>
            </form>
        </div>
    @else
        <div
            class="pt-4 border-t border-zinc-200 dark:border-zinc-800 p-5 bg-cyan-50/50 dark:bg-cyan-950/20 rounded-xl text-center">
            <div
                class="mb-3 inline-flex items-center justify-center w-10 h-10 bg-cyan-100 dark:bg-cyan-900/30 rounded-full">
                <svg xmlns="http://www.w3.org/2000/svg" fill="none" viewBox="0 0 24 24" stroke-width="2"
                    stroke="currentColor" class="size-5 text-cyan-600 dark:text-cyan-400">
                    <path stroke-linecap="round" stroke-linejoin="round"
                        d="M16 7a4 4 0 1 1-8 0 4 4 0 0 1 8 0ZM12 14a7 7 0 0 0-7 7h14a7 7 0 0 0-7-7Z" />
                </svg>
            </div>
            <p class="text-zinc-700 dark:text-zinc-300 mb-3 font-medium text-sm">Войдите, чтобы оставить комментарий</p>
            <a href="{{ route('login') }}?intended={{ urlencode(url()->current()) }}"
                class="inline-flex items-center justify-center px-5 py-2 bg-white dark:bg-zinc-800 border border-cyan-300 dark:border-cyan-700 rounded-lg text-cyan-600 dark:text-cyan-400 font-medium hover:bg-cyan-50 dark:hover:bg-cyan-900/20 transition-all duration-200 text-sm">
                Войти
            </a>
        </div>
    @endauth
</div>