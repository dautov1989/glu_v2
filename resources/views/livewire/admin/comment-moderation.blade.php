<div>
    <div class="bg-white dark:bg-zinc-900 p-8">
        <div class="max-w-6xl mx-auto">
            <!-- Header -->
            <div class="mb-8">
                <h1 class="text-3xl font-bold text-zinc-900 dark:text-white mb-2">Модерация комментариев</h1>
                <p class="text-zinc-600 dark:text-zinc-400">Управление комментариями пользователей</p>
            </div>

            <!-- Flash Message -->
            @if (session()->has('message'))
                <div
                    class="mb-6 p-4 bg-green-50 dark:bg-green-900/20 border border-green-200 dark:border-green-700 rounded-xl">
                    <p class="text-sm text-green-700 dark:text-green-300">{{ session('message') }}</p>
                </div>
            @endif

            <!-- Filters -->
            <div class="mb-6 flex gap-2">
                <button wire:click="setFilter('pending')"
                    class="px-4 py-2 rounded-lg font-medium transition-colors {{ $filter === 'pending' ? 'bg-cyan-600 text-white' : 'bg-zinc-100 dark:bg-zinc-800 text-zinc-700 dark:text-zinc-300 hover:bg-zinc-200 dark:hover:bg-zinc-700' }}">
                    На модерации
                    @if($pendingCount > 0)
                        <span class="ml-1 px-2 py-0.5 bg-red-500 text-white text-xs rounded-full">{{ $pendingCount }}</span>
                    @endif
                </button>
                <button wire:click="setFilter('approved')"
                    class="px-4 py-2 rounded-lg font-medium transition-colors {{ $filter === 'approved' ? 'bg-cyan-600 text-white' : 'bg-zinc-100 dark:bg-zinc-800 text-zinc-700 dark:text-zinc-300 hover:bg-zinc-200 dark:hover:bg-zinc-700' }}">
                    Одобренные
                </button>
                <button wire:click="setFilter('all')"
                    class="px-4 py-2 rounded-lg font-medium transition-colors {{ $filter === 'all' ? 'bg-cyan-600 text-white' : 'bg-zinc-100 dark:bg-zinc-800 text-zinc-700 dark:text-zinc-300 hover:bg-zinc-200 dark:hover:bg-zinc-700' }}">
                    Все
                </button>
            </div>

            <!-- Comments List -->
            <div class="space-y-4">
                @forelse($comments as $comment)
                    <div class="bg-zinc-50 dark:bg-zinc-800 rounded-xl p-5 border border-zinc-200 dark:border-zinc-700">
                        <div class="flex justify-between items-start mb-3">
                            <div class="flex items-center gap-3">
                                <div
                                    class="w-10 h-10 rounded-full bg-gradient-to-br from-cyan-500 to-blue-500 flex items-center justify-center text-white font-semibold">
                                    {{ substr($comment->user->name, 0, 1) }}
                                </div>
                                <div>
                                    <h4 class="font-semibold text-zinc-900 dark:text-white">{{ $comment->user->name }}</h4>
                                    <p class="text-xs text-zinc-500 dark:text-zinc-400">
                                        {{ $comment->created_at->diffForHumans() }}</p>
                                </div>
                            </div>
                            <div class="flex items-center gap-2">
                                @if($comment->is_approved)
                                    <span
                                        class="px-3 py-1 bg-green-100 dark:bg-green-900/30 text-green-700 dark:text-green-300 text-xs font-medium rounded-full">
                                        Одобрен
                                    </span>
                                @else
                                    <span
                                        class="px-3 py-1 bg-yellow-100 dark:bg-yellow-900/30 text-yellow-700 dark:text-yellow-300 text-xs font-medium rounded-full">
                                        На модерации
                                    </span>
                                @endif
                            </div>
                        </div>

                        <div class="mb-3">
                            <p class="text-sm text-zinc-600 dark:text-zinc-400 mb-2">
                                <strong>Статья:</strong>
                                <a href="{{ route('post.show', $comment->post->slug) }}"
                                    class="text-cyan-600 dark:text-cyan-400 hover:underline">
                                    {{ $comment->post->title }}
                                </a>
                            </p>
                            <p class="text-zinc-700 dark:text-zinc-300">{{ $comment->body }}</p>
                        </div>

                        @if(!$comment->is_approved)
                            <div class="flex gap-2">
                                <button wire:click="approve({{ $comment->id }})"
                                    class="px-4 py-2 bg-green-600 hover:bg-green-700 text-white text-sm font-medium rounded-lg transition-colors">
                                    ✓ Одобрить
                                </button>
                                <button wire:click="reject({{ $comment->id }})"
                                    wire:confirm="Вы уверены что хотите удалить этот комментарий?"
                                    class="px-4 py-2 bg-red-600 hover:bg-red-700 text-white text-sm font-medium rounded-lg transition-colors">
                                    ✕ Удалить
                                </button>
                            </div>
                        @endif
                    </div>
                @empty
                    <div class="text-center py-12">
                        <p class="text-zinc-500 dark:text-zinc-400">Нет комментариев для отображения</p>
                    </div>
                @endforelse
            </div>

            <!-- Pagination -->
            <div class="mt-6">
                {{ $comments->links() }}
            </div>
        </div>
    </div>
</div>