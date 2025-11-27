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
                            d="M16 7a4 4 0 1 1-8 0 4 4 0 0 1 8 0ZM12 14a7 7 0 0 0-7 7h14a7 7 0 0 0-7-7Z" />
                    </svg>
                </div>
                <h1 class="text-2xl font-bold text-zinc-900 dark:text-white mb-2">Вход в аккаунт</h1>
                <p class="text-sm text-zinc-600 dark:text-zinc-400">Введите ваш email и пароль для входа</p>
            </div>

            <!-- Session Status -->
            <x-auth-session-status class="mb-4 text-center" :status="session('status')" />

            <!-- Login Form -->
            <div class="bg-zinc-50/50 dark:bg-zinc-800/50 rounded-xl p-6 border border-zinc-200 dark:border-zinc-700">
                <form method="POST" action="{{ route('login.store') }}" class="space-y-5">
                    @csrf

                    <!-- Email Address -->
                    <flux:input name="email" :label="__('Email адрес')" :value="old('email')" type="email" required
                        autofocus autocomplete="email" placeholder="email@example.com" />

                    <!-- Password -->
                    <div class="relative">
                        <flux:input name="password" :label="__('Пароль')" type="password" required
                            autocomplete="current-password" placeholder="••••••••" viewable />

                        @if (Route::has('password.request'))
                            <flux:link class="absolute top-0 text-sm end-0" :href="route('password.request')" wire:navigate>
                                Забыли пароль?
                            </flux:link>
                        @endif
                    </div>

                    <!-- Remember Me -->
                    <flux:checkbox name="remember" :label="__('Запомнить меня')" :checked="old('remember')" />

                    <!-- Submit Button -->
                    <div class="pt-2">
                        <flux:button variant="primary" type="submit" class="w-full" data-test="login-button">
                            Войти
                        </flux:button>
                    </div>
                </form>
            </div>

            <!-- Register Link -->
            @if (Route::has('register'))
                <div class="mt-6 text-center text-sm text-zinc-600 dark:text-zinc-400">
                    <span>Нет аккаунта?</span>
                    <flux:link :href="route('register')" wire:navigate
                        class="font-medium text-cyan-600 dark:text-cyan-400 hover:text-cyan-700 dark:hover:text-cyan-300">
                        Зарегистрироваться
                    </flux:link>
                </div>
            @endif
        </div>
    </div>
</x-layouts.app>