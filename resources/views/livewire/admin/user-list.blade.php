@section('title', 'Пользователи')

<div>
    <div class="mb-6 flex flex-col md:flex-row md:items-center justify-between gap-4">
        <!-- Filters -->
        <div class="flex items-center gap-4 text-sm">
            <button wire:click="$set('filter', 'all')"
                class="{{ $filter === 'all' ? 'text-gray-900 font-bold' : 'text-blue-600 hover:text-blue-800' }}">
                Все
            </button>
            <span class="text-gray-300">|</span>
            <button wire:click="$set('filter', 'admin')"
                class="{{ $filter === 'admin' ? 'text-gray-900 font-bold' : 'text-blue-600 hover:text-blue-800' }}">
                Администраторы
            </button>
            <span class="text-gray-300">|</span>
            <button wire:click="$set('filter', 'user')"
                class="{{ $filter === 'user' ? 'text-gray-900 font-bold' : 'text-blue-600 hover:text-blue-800' }}">
                Пользователи
            </button>
        </div>

        <!-- Search -->
        <div class="flex items-center gap-2">
            <input type="text" wire:model.live.debounce.300ms="search" placeholder="Поиск пользователей..."
                class="px-3 py-1 border border-gray-300 rounded-sm text-sm focus:border-blue-500 focus:ring-1 focus:ring-blue-500 shadow-sm w-64">
        </div>
    </div>

    @if (session()->has('message'))
        <div class="mb-4 p-3 bg-green-100 border-l-4 border-green-500 text-green-700 text-sm">
            {{ session('message') }}
        </div>
    @endif

    @if (session()->has('error'))
        <div class="mb-4 p-3 bg-red-100 border-l-4 border-red-500 text-red-700 text-sm">
            {{ session('error') }}
        </div>
    @endif

    <div class="bg-white border border-gray-200 shadow-sm">
        <table class="w-full text-left border-collapse">
            <thead>
                <tr class="border-b border-gray-200 bg-gray-50 text-xs font-bold text-gray-700 uppercase">
                    <th class="px-4 py-3">Пользователь</th>
                    <th class="px-4 py-3">Email</th>
                    <th class="px-4 py-3">Роль</th>
                    <th class="px-4 py-3">Дата регистрации</th>
                    <th class="px-4 py-3 text-right">Действия</th>
                </tr>
            </thead>
            <tbody class="divide-y divide-gray-100">
                @forelse($users as $user)
                    <tr class="hover:bg-gray-50 transition-colors">
                        <td class="px-4 py-3">
                            <div class="flex items-center gap-3">
                                <div
                                    class="w-8 h-8 rounded-full bg-blue-100 flex items-center justify-center text-blue-700 font-bold text-xs">
                                    {{ $user->initials() }}
                                </div>
                                <span class="text-sm font-medium text-gray-900">{{ $user->name }}</span>
                            </div>
                        </td>
                        <td class="px-4 py-3 text-sm text-gray-600">
                            {{ $user->email }}
                        </td>
                        <td class="px-4 py-3">
                            @if($user->is_admin)
                                <span
                                    class="px-2 py-0.5 rounded-full bg-blue-100 text-blue-700 text-[10px] font-bold uppercase">
                                    Админ
                                </span>
                            @else
                                <span
                                    class="px-2 py-0.5 rounded-full bg-gray-100 text-gray-600 text-[10px] font-bold uppercase">
                                    Участник
                                </span>
                            @endif
                        </td>
                        <td class="px-4 py-3 text-sm text-gray-500 italic">
                            {{ $user->created_at->format('d.m.Y H:i') }}
                        </td>
                        <td class="px-4 py-3 text-right">
                            <button wire:click="toggleAdmin({{ $user->id }})"
                                wire:confirm="Вы уверены, что хотите изменить права доступа для этого пользователя?"
                                class="text-xs {{ $user->is_admin ? 'text-red-600 hover:text-red-800' : 'text-blue-600 hover:text-blue-800' }} font-medium">
                                {{ $user->is_admin ? 'Снять админа' : 'Сделать админом' }}
                            </button>
                        </td>
                    </tr>
                @empty
                    <tr>
                        <td colspan="5" class="px-4 py-8 text-center text-gray-500 text-sm">
                            Пользователи не найдены
                        </td>
                    </tr>
                @endforelse
            </tbody>
        </table>
    </div>

    <div class="mt-4">
        {{ $users->links() }}
    </div>
</div>