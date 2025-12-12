<footer
    class="relative bg-gradient-to-br from-white via-cyan-50/30 to-blue-50/30 dark:from-zinc-900 dark:via-cyan-950/20 dark:to-blue-950/20 border-t border-cyan-200/50 dark:border-cyan-800/30 mt-auto overflow-hidden">
    <!-- Decorative gradient background -->
    <div class="absolute inset-0 bg-gradient-to-r from-cyan-500/5 via-blue-500/5 to-purple-500/5 pointer-events-none">
    </div>

    <div class="relative max-w-7xl mx-auto px-4 sm:px-6 lg:px-8 py-12">
        <div class="grid grid-cols-1 md:grid-cols-4 gap-8 mb-8">

            <!-- Brand & About -->
            <div class="col-span-1 md:col-span-1">
                <a href="{{ route('home') }}" class="flex items-center gap-3 group mb-4">
                    <!-- Logo Icon -->
                    <div class="relative">
                        <div
                            class="absolute -inset-1 bg-gradient-to-r from-cyan-500 to-blue-500 rounded-full blur opacity-30 group-hover:opacity-50 transition-opacity duration-300">
                        </div>
                        <div
                            class="relative bg-gradient-to-br from-cyan-500 to-blue-600 rounded-full p-1.5 text-white shadow-lg shadow-cyan-500/40">
                            <svg xmlns="http://www.w3.org/2000/svg" viewBox="0 0 24 24" fill="currentColor"
                                class="w-5 h-5">
                                <path
                                    d="M11.25 4.533A9.707 9.707 0 0 0 6 3a9.735 9.735 0 0 0-3.25.555.75.75 0 0 0-.5.516l-1.432 3.26a5.25 5.25 0 0 0 0 4.336l1.432 3.26a.75.75 0 0 0 .5.516H6c.536 0 1.064.034 1.582.1l-.012.025c-.15.312-.292.63-.426.95-.404.972-.726 2.005-.96 3.085a.75.75 0 0 0 .659.897 7.5 7.5 0 0 0 7.208-4.816A7.5 7.5 0 0 0 21.75 12a9.716 9.716 0 0 0-4.233-8.179.75.75 0 0 0-.815 1.161 8.216 8.216 0 0 1 3.548 7.018 6 6 0 0 1-11.52 1.98.75.75 0 0 0-1.5-.03 7.502 7.502 0 0 0-3.18 5.819 7.99 7.99 0 0 1-2.948-4.964 3.75 3.75 0 0 1 0-3.098 7.99 7.99 0 0 1 2.948-4.964A8.25 8.25 0 0 1 6 4.5c.693 0 1.366.09 2.007.259a.75.75 0 0 0 .848-.66c.096-.548.23-1.08.4-1.595.166-.51.382-1.003.64-1.471a.75.75 0 0 0-.645-1.133Z" />
                            </svg>
                        </div>
                    </div>
                    <span
                        class="text-xl font-bold bg-gradient-to-r from-cyan-600 to-blue-600 dark:from-cyan-400 dark:to-blue-400 bg-clip-text text-transparent">
                        Glucosa
                    </span>
                </a>
                <p class="text-sm text-zinc-600 dark:text-zinc-400 leading-relaxed mb-6">
                    Ваш надежный помощник в управлении диабетом. База данных, советы экспертов и поддержка сообщества.
                </p>

                <!-- Support Project Widget -->
                <div class="relative group">
                    <div
                        class="absolute -inset-0.5 bg-gradient-to-r from-cyan-500/20 to-blue-500/20 rounded-xl blur opacity-0 group-hover:opacity-100 transition-opacity duration-300">
                    </div>
                    <div
                        class="relative bg-white/50 dark:bg-zinc-800/50 rounded-xl border border-cyan-200/50 dark:border-cyan-800/30 p-4 shadow-sm hover:shadow-md transition-all duration-300">
                        <div class="flex items-center gap-2 mb-2">
                            <div
                                class="w-6 h-6 bg-gradient-to-br from-pink-500 to-rose-500 rounded-md flex items-center justify-center text-white shadow-md shadow-pink-500/20">
                                <svg xmlns="http://www.w3.org/2000/svg" fill="none" viewBox="0 0 24 24" stroke-width="2"
                                    stroke="currentColor" class="w-3.5 h-3.5">
                                    <path stroke-linecap="round" stroke-linejoin="round"
                                        d="M21 8.25c0-2.485-2.099-4.5-4.688-4.5-1.935 0-3.597 1.126-4.312 2.733-.715-1.607-2.377-2.733-4.313-2.733C5.1 3.75 3 5.765 3 8.25c0 7.22 9 12 9 12s9-4.78 9-12Z" />
                                </svg>
                            </div>
                            <h3 class="text-xs font-bold uppercase tracking-wider text-zinc-800 dark:text-zinc-200">
                                Поддержите нас</h3>
                        </div>

                        <style>
                            @keyframes footer-glow {

                                0%,
                                100% {
                                    box-shadow: 0 0 5px rgba(6, 182, 212, 0.2);
                                }

                                50% {
                                    box-shadow: 0 0 15px rgba(6, 182, 212, 0.4);
                                }
                            }

                            .footer-support-btn {
                                animation: footer-glow 3s ease-in-out infinite;
                            }

                            .footer-support-btn:hover {
                                animation: none;
                            }
                        </style>

                        <a href="https://dalink.to/glucos_a" target="_blank" rel="noopener noreferrer"
                            class="footer-support-btn w-full bg-gradient-to-r from-cyan-500 to-blue-500 hover:from-cyan-600 hover:to-blue-600 text-white text-xs font-bold py-2 rounded-lg shadow-md hover:shadow-lg transition-all duration-300 flex items-center justify-center gap-2 group/btn">
                            <span>Поддержать проект</span>
                            <svg xmlns="http://www.w3.org/2000/svg" fill="none" viewBox="0 0 24 24" stroke-width="2"
                                stroke="currentColor"
                                class="w-3 h-3 transform group-hover/btn:scale-110 transition-transform">
                                <path stroke-linecap="round" stroke-linejoin="round"
                                    d="M21 8.25c0-2.485-2.099-4.5-4.688-4.5-1.935 0-3.597 1.126-4.312 2.733-.715-1.607-2.377-2.733-4.313-2.733C5.1 3.75 3 5.765 3 8.25c0 7.22 9 12 9 12s9-4.78 9-12Z" />
                            </svg>
                        </a>
                    </div>
                </div>
            </div>

            <!-- Quick Links -->
            <div>
                <div class="flex items-center gap-2 mb-4">
                    <div class="w-1 h-5 bg-gradient-to-b from-cyan-500 to-blue-500 rounded-full"></div>
                    <h3 class="text-sm font-bold uppercase tracking-wider text-cyan-700 dark:text-cyan-300">Навигация
                    </h3>
                </div>
                <ul class="space-y-2.5">
                    <li>
                        <a href="{{ route('home') }}"
                            class="text-sm text-zinc-600 dark:text-zinc-400 hover:text-cyan-600 dark:hover:text-cyan-400 transition-colors inline-block">
                            Главная
                        </a>
                    </li>
                    <li>
                        <a href="{{ route('articles.index') }}"
                            class="text-sm text-zinc-600 dark:text-zinc-400 hover:text-cyan-600 dark:hover:text-cyan-400 transition-colors inline-block">
                            Статьи
                        </a>
                    </li>
                    <li>
                        <a href="{{ route('search') }}"
                            class="text-sm text-zinc-600 dark:text-zinc-400 hover:text-cyan-600 dark:hover:text-cyan-400 transition-colors inline-block">
                            Поиск
                        </a>
                    </li>
                    @auth
                        <li>
                            <a href="{{ route('dashboard') }}"
                                class="text-sm text-zinc-600 dark:text-zinc-400 hover:text-cyan-600 dark:hover:text-cyan-400 transition-colors inline-block">
                                Личный кабинет
                            </a>
                        </li>
                    @endauth
                </ul>
            </div>

            <!-- Categories -->
            <div>
                <div class="flex items-center gap-2 mb-4">
                    <div class="w-1 h-5 bg-gradient-to-b from-blue-500 to-purple-500 rounded-full"></div>
                    <h3 class="text-sm font-bold uppercase tracking-wider text-blue-700 dark:text-blue-300">Категории
                    </h3>
                </div>
                <ul class="space-y-2.5">
                    @if(isset($megaMenuCategories) && count($megaMenuCategories) > 0)
                        @foreach(array_slice($megaMenuCategories, 0, 5) as $category)
                            <li>
                                <a href="{{ route('category.show', $category['slug']) }}"
                                    class="text-sm text-zinc-600 dark:text-zinc-400 hover:text-blue-600 dark:hover:text-blue-400 transition-colors inline-block">
                                    {{ $category['label'] }}
                                </a>
                            </li>
                        @endforeach
                    @else
                        <li>
                            <a href="{{ route('articles.index') }}"
                                class="text-sm text-zinc-600 dark:text-zinc-400 hover:text-blue-600 dark:hover:text-blue-400 transition-colors inline-block">
                                Все категории
                            </a>
                        </li>
                    @endif
                </ul>
            </div>

            <!-- Contact -->
            <div>
                <div class="flex items-center gap-2 mb-4">
                    <div class="w-1 h-5 bg-gradient-to-b from-purple-500 to-pink-500 rounded-full"></div>
                    <h3 class="text-sm font-bold uppercase tracking-wider text-purple-700 dark:text-purple-300">Контакты
                    </h3>
                </div>
                <ul class="space-y-3">
                    <li class="flex items-center gap-2 group">
                        <div
                            class="w-5 h-5 rounded bg-gradient-to-br from-purple-100 to-pink-100 dark:from-purple-900/30 dark:to-pink-900/30 flex items-center justify-center flex-shrink-0 group-hover:from-purple-500 group-hover:to-pink-500 transition-all duration-300">
                            <svg class="w-3 h-3 text-purple-600 dark:text-purple-400 group-hover:text-white transition-colors"
                                fill="none" viewBox="0 0 24 24" stroke-width="2" stroke="currentColor">
                                <path stroke-linecap="round" stroke-linejoin="round"
                                    d="M21.75 6.75v10.5a2.25 2.25 0 0 1-2.25 2.25h-15a2.25 2.25 0 0 1-2.25-2.25V6.75m19.5 0A2.25 2.25 0 0 0 19.5 4.5h-15a2.25 2.25 0 0 0-2.25 2.25m19.5 0v.243a2.25 2.25 0 0 1-1.07 1.916l-7.5 4.615a2.25 2.25 0 0 1-2.36 0L3.32 8.91a2.25 2.25 0 0 1-1.07-1.916V6.75" />
                            </svg>
                        </div>
                        <a href="mailto:glucosa45@gmail.com"
                            class="text-sm text-zinc-600 dark:text-zinc-400 hover:text-purple-600 dark:hover:text-purple-400 transition-colors">
                            glucosa45@gmail.com
                        </a>
                    </li>
                </ul>
            </div>
        </div>

        <!-- Disclaimer -->
        <div
            class="mb-8 p-5 rounded-2xl bg-white/40 dark:bg-zinc-800/40 border border-cyan-100 dark:border-cyan-800/30 backdrop-blur-sm shadow-sm flex flex-col md:flex-row gap-4 items-start md:items-center">
            <div class="flex-shrink-0 p-2 bg-cyan-50 dark:bg-cyan-900/20 rounded-lg text-cyan-600 dark:text-cyan-400">
                <svg xmlns="http://www.w3.org/2000/svg" viewBox="0 0 24 24" fill="none" stroke="currentColor"
                    stroke-width="2" stroke-linecap="round" stroke-linejoin="round" class="w-5 h-5">
                    <circle cx="12" cy="12" r="10"></circle>
                    <line x1="12" y1="8" x2="12" y2="12"></line>
                    <line x1="12" y1="16" x2="12.01" y2="16"></line>
                </svg>
            </div>
            <div class="text-xs text-zinc-500 dark:text-zinc-400 leading-relaxed font-medium">
                <span class="font-bold text-zinc-700 dark:text-zinc-300 block mb-1 text-sm">Отказ от
                    ответственности</span>
                Информация на сайте предоставлена исключительно в ознакомительных целях. Она не является медицинской
                консультацией и не может заменить визит к врачу. Не занимайтесь самолечением — это может быть опасно.
                При
                любых подозрениях на проблемы со здоровьем обращайтесь к квалифицированным специалистам.
            </div>
        </div>

        <!-- Bottom Bar -->
        <div
            class="pt-8 border-t border-cyan-200/50 dark:border-cyan-700/50 flex flex-col md:flex-row justify-between items-center gap-4">
            <p class="text-sm text-zinc-500 dark:text-zinc-400">
                &copy; {{ date('Y') }} <span
                    class="font-semibold bg-gradient-to-r from-cyan-600 to-blue-600 dark:from-cyan-400 dark:to-blue-400 bg-clip-text text-transparent">Glucosa</span>.
                Все права защищены.
            </p>
            <div class="flex items-center gap-4 text-xs text-zinc-500 dark:text-zinc-400">
                @auth
                    <form method="POST" action="{{ route('logout') }}" class="inline">
                        @csrf
                        <button type="submit"
                            class="hover:text-red-600 dark:hover:text-red-400 transition-colors font-medium">
                            Выйти
                        </button>
                    </form>
                @endauth
            </div>
        </div>
    </div>
</footer>