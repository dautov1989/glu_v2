<x-layouts.app>
    <div class="bg-white dark:bg-zinc-900 p-8">
        <div class="max-w-md mx-auto">
            <!-- Header -->
            <div class="text-center mb-8">
                <div
                    class="mb-4 inline-flex items-center justify-center w-16 h-16 bg-gradient-to-br from-cyan-500 to-blue-500 rounded-2xl shadow-lg">
                    <svg xmlns="http://www.w3.org/2000/svg" fill="none" viewBox="0 0 24 24" stroke-width="2"
                        stroke="currentColor" class="size-8 text-white">
                        <path stroke-linecap="round" stroke-linejoin="round"
                            d="M18 7.5v3m0 0v3m0-3h3m-3 0h-3m-2.25-4.125a3.375 3.375 0 1 1-6.75 0 3.375 3.375 0 0 1 6.75 0ZM3 19.235v-.11a6.375 6.375 0 0 1 12.75 0v.109A12.318 12.318 0 0 1 9.374 21c-2.331 0-4.512-.645-6.374-1.766Z" />
                    </svg>
                </div>
                <h1 class="text-2xl font-bold text-zinc-900 dark:text-white mb-2">Создать аккаунт</h1>
                <p class="text-sm text-zinc-600 dark:text-zinc-400">Введите ваши данные для регистрации</p>
            </div>

            <!-- Session Status -->
            <x-auth-session-status class="mb-4 text-center" :status="session('status')" />

            <!-- Register Form -->
            <div class="bg-zinc-50/50 dark:bg-zinc-800/50 rounded-xl p-6 border border-zinc-200 dark:border-zinc-700">
                <form method="POST" action="{{ route('register.store') }}" class="space-y-5">
                    @csrf

                    <!-- Name -->
                    <flux:input name="name" :label="__('Имя')" :value="old('name')" type="text" required autofocus
                        autocomplete="name" placeholder="Ваше полное имя" />

                    <!-- Email Address -->
                    <flux:input name="email" :label="__('Email адрес')" :value="old('email')" type="email" required
                        autocomplete="email" placeholder="email@example.com" />

                    <!-- Password -->
                    <flux:input name="password" :label="__('Пароль')" type="password" required
                        autocomplete="new-password" placeholder="••••••••" viewable />

                    <!-- Confirm Password -->
                    <flux:input name="password_confirmation" :label="__('Подтвердите пароль')" type="password" required
                        autocomplete="new-password" placeholder="••••••••" viewable />

                    <!-- Submit Button -->
                    <div class="pt-2">
                        <flux:button type="submit" variant="primary" class="w-full">
                            Создать аккаунт
                        </flux:button>
                    </div>
                </form>
            </div>

            <!-- Login Link -->
            <div class="mt-6 text-center text-sm text-zinc-600 dark:text-zinc-400">
                <span>Уже есть аккаунт?</span>
                <flux:link :href="route('login')" wire:navigate
                    class="font-medium text-cyan-600 dark:text-cyan-400 hover:text-cyan-700 dark:hover:text-cyan-300">
                    Войти
                </flux:link>
            </div>
        </div>
    </div>
</x-layouts.app>