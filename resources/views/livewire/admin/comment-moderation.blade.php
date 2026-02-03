@section('title', 'Модерация комментариев')

<div>
    <!-- Flash Message -->
    @if (session()->has('message'))
        <div class="mb-4 p-3 bg-white border-l-4 border-green-500 shadow-sm text-sm text-gray-700">
            {{ session('message') }}
        </div>
    @endif

    <!-- Filters (WP Style Tabs) -->
    <div class="mb-6 flex space-x-4 border-b border-gray-300 pb-0">
        <button wire:click="setFilter('pending')"
            class="pb-2 px-1 text-sm font-medium transition-all border-b-2 {{ $filter === 'pending' ? 'border-[var(--wp-admin-sidebar-active)] text-gray-900' : 'border-transparent text-gray-500 hover:text-gray-700' }}">
            На модерации
            @if($pendingCount > 0)
                <span class="ml-1 px-1.5 py-0.5 bg-gray-200 text-gray-700 text-xs rounded-full">{{ $pendingCount }}</span>
            @endif
        </button>
        <button wire:click="setFilter('approved')"
            class="pb-2 px-1 text-sm font-medium transition-all border-b-2 {{ $filter === 'approved' ? 'border-[var(--wp-admin-sidebar-active)] text-gray-900' : 'border-transparent text-gray-500 hover:text-gray-700' }}">
            Одобренные
        </button>
        <button wire:click="setFilter('all')"
            class="pb-2 px-1 text-sm font-medium transition-all border-b-2 {{ $filter === 'all' ? 'border-[var(--wp-admin-sidebar-active)] text-gray-900' : 'border-transparent text-gray-500 hover:text-gray-700' }}">
            Все
        </button>
    </div>

    <!-- Comments List -->
    <div class="space-y-4">
        @forelse($comments as $comment)
            <div class="bg-white border border-gray-200 p-4 shadow-sm rounded-sm">
                <div class="flex justify-between items-start mb-3">
                    <div class="flex items-center gap-3">
                        <div
                            class="w-8 h-8 rounded-sm bg-gray-200 flex items-center justify-center text-gray-600 font-bold text-sm">
                            {{ substr($comment->user->name, 0, 1) }}
                        </div>
                        <div>
                            <div class="flex items-center gap-2">
                                <span class="font-bold text-gray-800">{{ $comment->user->name }}</span>
                                <span class="text-xs text-gray-500">{{ $comment->created_at->format('d.m.Y H:i') }}</span>
                            </div>
                            <p class="text-xs text-gray-500">
                                К статье:
                                <a href="{{ route('post.show', $comment->post->slug) }}" target="_blank"
                                    class="text-blue-600 hover:text-blue-800 hover:underline">
                                    {{ $comment->post->title }}
                                </a>
                            </p>
                        </div>
                    </div>
                    <div>
                        @if($comment->is_approved)
                            <span
                                class="px-2 py-0.5 bg-green-100 text-green-700 text-[10px] font-bold uppercase tracking-wider rounded-sm border border-green-200">
                                Одобрен
                            </span>
                        @else
                            <span
                                class="px-2 py-0.5 bg-orange-100 text-orange-700 text-[10px] font-bold uppercase tracking-wider rounded-sm border border-orange-200">
                                На модерации
                            </span>
                        @endif
                    </div>
                </div>

                <div class="pl-11 mb-4">
                    <p class="text-gray-700 leading-relaxed text-sm">{{ $comment->body }}</p>
                </div>

                <div class="pl-11 flex gap-3">
                    @if(!$comment->is_approved)
                        <button wire:click="approve({{ $comment->id }})"
                            class="px-3 py-1 bg-[var(--wp-admin-sidebar-active)] hover:bg-blue-700 text-white text-xs font-medium rounded-sm border border-blue-800 transition-colors shadow-sm">
                            Одобрить
                        </button>
                    @endif
                    <button wire:click="reject({{ $comment->id }})"
                        wire:confirm="Вы уверены что хотите удалить этот комментарий?"
                        class="px-3 py-1 bg-white hover:bg-red-50 text-red-600 text-xs font-medium rounded-sm border border-red-200 transition-colors">
                        Удалить
                    </button>
                </div>
            </div>
        @empty
            <div class="bg-white border border-gray-200 p-12 text-center rounded-sm">
                <p class="text-gray-500 italic">Комментариев не найдено.</p>
            </div>
        @endforelse
    </div>

    <!-- Pagination -->
    <div class="mt-6">
        {{ $comments->links() }}
    </div>
</div>