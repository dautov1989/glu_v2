@extends('components.layouts.app')

@section('title', 'Страница не найдена | Glucosa')
@section('meta_description', 'К сожалению, запрашиваемая страница не найдена. Воспользуйтесь поиском или перейдите на главную страницу.')

@section('content')
    <div
        class="min-h-[70vh] flex items-center justify-center bg-gradient-to-br from-white via-cyan-50/30 to-white dark:from-zinc-900 dark:via-cyan-950/20 dark:to-zinc-900 py-12">
        <div class="max-w-4xl mx-auto px-4 sm:px-6 lg:px-8 text-center">

            {{-- 404 Illustration/Number --}}
            <div class="relative mb-8 inline-block">
                <h1
                    class="text-9xl font-black text-transparent bg-clip-text bg-gradient-to-r from-cyan-400 to-blue-600 dark:from-cyan-500 dark:to-blue-500 opacity-20 select-none">
                    404
                </h1>
                <div class="absolute inset-0 flex items-center justify-center">
                    <div
                        class="bg-white dark:bg-zinc-800 p-4 rounded-full shadow-xl border border-cyan-100 dark:border-cyan-900/50 animate-bounce-slow">
                        <svg class="w-16 h-16 text-cyan-500" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="1.5"
                                d="M12 9v2m0 4h.01m-6.938 4h13.856c1.54 0 2.502-1.667 1.732-3L13.732 4c-.77-1.333-2.694-1.333-3.464 0L3.34 16c-.77 1.333.192 3 1.732 3z">
                            </path>
                        </svg>
                    </div>
                </div>
            </div>

            {{-- Message --}}
            <h2 class="text-3xl md:text-4xl font-bold text-zinc-800 dark:text-zinc-100 mb-4">
                Страница не найдена
            </h2>
            <p class="text-lg text-zinc-500 dark:text-zinc-400 mb-8 max-w-lg mx-auto">
                Похоже, мы не можем найти то, что вы ищете. Возможно, страница была удалена или перемещена по новому адресу.
            </p>

            {{-- Action Buttons --}}
            <div class="flex flex-col sm:flex-row items-center justify-center gap-4 mb-16">
                <a href="{{ route('home') }}"
                    class="w-full sm:w-auto px-8 py-3 bg-gradient-to-r from-cyan-500 to-blue-500 hover:from-cyan-600 hover:to-blue-600 text-white font-semibold rounded-xl shadow-lg shadow-cyan-500/30 hover:shadow-cyan-500/40 transition-all duration-300 hover:scale-105 flex items-center justify-center gap-2">
                    <svg class="w-5 h-5" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
                            d="M3 12l2-2m0 0l7-7 7 7M5 10v10a1 1 0 001 1h3m10-11l2 2m-2-2v10a1 1 0 01-1 1h-3m-6 0a1 1 0 001-1v-4a1 1 0 011-1h2a1 1 0 011 1v4a1 1 0 001 1m-6 0h6">
                        </path>
                    </svg>
                    На главную
                </a>

                <a href="{{ route('articles.index') }}"
                    class="w-full sm:w-auto px-8 py-3 bg-white dark:bg-zinc-800 text-zinc-700 dark:text-zinc-200 font-semibold rounded-xl border border-zinc-200 dark:border-zinc-700 hover:border-cyan-400 dark:hover:border-cyan-600 hover:text-cyan-600 dark:hover:text-cyan-400 shadow-sm hover:shadow-md transition-all duration-300 flex items-center justify-center gap-2">
                    <svg class="w-5 h-5" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
                            d="M19 20H5a2 2 0 01-2-2V6a2 2 0 012-2h10a2 2 0 012 2v1m2 13a2 2 0 01-2-2V7m2 13a2 2 0 002-2V9a2 2 0 00-2-2h-2m-4-3H9M7 16h6M7 8h6v4H7V8z">
                        </path>
                    </svg>
                    Все статьи
                </a>
            </div>

            {{-- Helpful Links / Popular --}}
            <div class="border-t border-zinc-200 dark:border-zinc-800 pt-12">
                <h3 class="text-xl font-semibold text-zinc-800 dark:text-zinc-200 mb-8">
                    Возможно, вам будет интересно:
                </h3>

                {{-- Reusing the logic from popular posts but displaying differently --}}
                @php
                    $popularPosts = \App\Models\Post::where('is_published', true)
                        ->orderBy('views', 'desc')
                        ->limit(3)
                        ->get();
                @endphp

                <div class="grid grid-cols-1 md:grid-cols-3 gap-6 text-left">
                    @foreach($popularPosts as $post)
                        <a href="{{ route('post.show', $post->slug) }}"
                            class="group block bg-white dark:bg-zinc-800 rounded-xl p-4 border border-zinc-200 dark:border-zinc-700 hover:border-cyan-300 dark:hover:border-cyan-700 shadow-sm hover:shadow-md transition-all duration-200">
                            <div class="flex items-start gap-3">
                                <div
                                    class="flex-shrink-0 w-10 h-10 rounded-lg bg-cyan-50 dark:bg-cyan-900/30 flex items-center justify-center text-cyan-600 dark:text-cyan-400 group-hover:scale-110 transition-transform">
                                    <svg class="w-5 h-5" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
                                            d="M13 10V3L4 14h7v7l9-11h-7z"></path>
                                    </svg>
                                </div>
                                <div>
                                    <h4
                                        class="font-medium text-zinc-800 dark:text-zinc-200 group-hover:text-cyan-600 dark:group-hover:text-cyan-400 transition-colors line-clamp-2">
                                        {{ $post->title }}
                                    </h4>
                                    <p class="text-xs text-zinc-500 mt-1">
                                        {{ $post->views }} просмотров
                                    </p>
                                </div>
                            </div>
                        </a>
                    @endforeach
                </div>
            </div>

        </div>
    </div>

    <style>
        @keyframes bounce-slow {

            0%,
            100% {
                transform: translateY(0);
            }

            50% {
                transform: translateY(-10px);
            }
        }

        .animate-bounce-slow {
            animation: bounce-slow 3s infinite ease-in-out;
        }
    </style>
@endsection