@section('seo-meta')
    <x-seo-meta :title="$post->meta_title ?? $post->title" :description="$post->meta_description ?? Str::limit(strip_tags($post->content), 160)" :keywords="'диабет, ' . $post->category->title . ', ' . $post->title"
        type="article" :image="$post->image" :url="route('post.show', $post->slug)"
        :publishedTime="$post->published_at->toIso8601String()" :modifiedTime="$post->updated_at->toIso8601String()" />

    {{-- Article Schema --}}
    <x-schema-org type="article" :data="[
            'title' => $post->title,
            'description' => $post->meta_description ?? Str::limit(strip_tags($post->content), 160),
            'image' => $post->image ?? asset('images/medical_placeholder.png'),
            'published_at' => $post->published_at->toIso8601String(),
            'updated_at' => $post->updated_at->toIso8601String(),
            'url' => route('post.show', $post->slug)
        ]" />

    {{-- Breadcrumb Schema --}}
    @php
        $breadcrumbItems = [
            ['name' => 'Главная', 'url' => route('home')]
        ];
        foreach ($post->category->getBreadcrumbs() as $breadcrumb) {
            $breadcrumbItems[] = [
                'name' => $breadcrumb->title,
                'url' => route('category.show', $breadcrumb->slug)
            ];
        }
        $breadcrumbItems[] = ['name' => $post->title, 'url' => route('post.show', $post->slug)];
    @endphp
    <x-schema-org type="breadcrumb" :data="['items' => $breadcrumbItems]" />
@endsection

@extends('components.layouts.app')

@section('title', $post->meta_title ?? $post->title . ' | Glucosa')
@section('meta_description', $post->meta_description ?? Str::limit(strip_tags($post->content), 160))

@section('content')
    <div x-data x-init="
                                                    if (window.innerWidth < 768) {
                                                        setTimeout(() => {
                                                            $el.scrollIntoView({ behavior: 'smooth', block: 'start' });
                                                        }, 100);
                                                    }
                                                "
        class="bg-white dark:bg-zinc-800 rounded-2xl p-8 border border-zinc-200 dark:border-zinc-700 shadow-sm scroll-mt-24">
        <!-- Breadcrumbs -->
        <nav class="mb-8">
            <ol class="flex flex-wrap items-center gap-2 text-sm">
                <li>
                    <a href="{{ route('home') }}"
                        class="text-cyan-600 hover:text-cyan-700 dark:text-cyan-400 dark:hover:text-cyan-300">
                        Главная
                    </a>
                </li>
                @foreach($post->category->getBreadcrumbs() as $breadcrumb)
                    <li class="flex items-center">
                        <svg class="w-4 h-4 mx-1 text-zinc-400" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M9 5l7 7-7 7"></path>
                        </svg>
                        <a href="{{ route('category.show', $breadcrumb->slug) }}"
                            class="text-cyan-600 hover:text-cyan-700 dark:text-cyan-400 dark:hover:text-cyan-300">
                            {{ $breadcrumb->title }}
                        </a>
                    </li>
                @endforeach
                <li class="flex items-center">
                    <svg class="w-4 h-4 mx-2 text-zinc-400" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M9 5l7 7-7 7"></path>
                    </svg>
                    <span class="text-zinc-500 dark:text-zinc-400 truncate max-w-[200px]">{{ $post->title }}</span>
                </li>
            </ol>
        </nav>

        <!-- Article Header -->
        <header class="mb-10 relative">
            <!-- Decorative accent line -->
            <div
                class="absolute -left-8 top-0 bottom-0 w-1 bg-gradient-to-b from-cyan-500 via-blue-500 to-cyan-500 rounded-full hidden md:block">
            </div>

            <!-- Category Badge -->
            <div class="mb-4">
                <a href="{{ route('category.show', $post->category->slug) }}"
                    class="inline-flex items-center gap-2 px-4 py-2 bg-gradient-to-r from-cyan-50 to-blue-50 dark:from-cyan-950/30 dark:to-blue-950/30 text-cyan-700 dark:text-cyan-300 rounded-full text-sm font-semibold border border-cyan-200 dark:border-cyan-800/50 hover:border-cyan-400 dark:hover:border-cyan-600 transition-all duration-300 hover:shadow-md hover:shadow-cyan-500/20">
                    <svg class="w-4 h-4" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
                            d="M7 7h.01M7 3h5c.512 0 1.024.195 1.414.586l7 7a2 2 0 010 2.828l-7 7a2 2 0 01-2.828 0l-7-7A1.994 1.994 0 013 12V7a4 4 0 014-4z">
                        </path>
                    </svg>
                    {{ $post->category->title }}
                </a>
            </div>

            <!-- Title with gradient -->
            <h1 class="text-xl sm:text-2xl md:text-3xl font-bold mb-5 leading-tight">
                <span
                    class="bg-gradient-to-r from-zinc-900 via-zinc-800 to-zinc-900 dark:from-zinc-50 dark:via-cyan-100 dark:to-zinc-50 bg-clip-text text-transparent">
                    {{ $post->title }}
                </span>
            </h1>

            <!-- Meta information with icons -->
            <div class="flex flex-wrap items-center gap-4 text-sm text-zinc-600 dark:text-zinc-400">
                <div
                    class="flex items-center gap-2 px-3 py-1.5 bg-zinc-50 dark:bg-zinc-800/50 rounded-lg border border-zinc-200 dark:border-zinc-700">
                    <svg class="w-4 h-4 text-cyan-500" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
                            d="M8 7V3m8 4V3m-9 8h10M5 21h14a2 2 0 002-2V7a2 2 0 00-2-2H5a2 2 0 00-2 2v12a2 2 0 002 2z">
                        </path>
                    </svg>
                    <span class="font-medium">{{ $post->published_at->format('d.m.Y') }}</span>
                </div>

                <div
                    class="flex items-center gap-2 px-3 py-1.5 bg-zinc-50 dark:bg-zinc-800/50 rounded-lg border border-zinc-200 dark:border-zinc-700">
                    <svg class="w-4 h-4 text-cyan-500" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
                            d="M15 12a3 3 0 11-6 0 3 3 0 016 0z"></path>
                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
                            d="M2.458 12C3.732 7.943 7.523 5 12 5c4.478 0 8.268 2.943 9.542 7-1.274 4.057-5.064 7-9.542 7-4.477 0-8.268-2.943-9.542-7z">
                        </path>
                    </svg>
                    <span class="font-medium">{{ $post->views }} просмотров</span>
                </div>
            </div>

            <!-- Decorative bottom line -->
            <div class="mt-6 h-1 w-24 bg-gradient-to-r from-cyan-500 to-blue-500 rounded-full"></div>
        </header>



        <!-- Content -->
        @inject('linker', 'App\Services\Seo\InternalLinker')
        <div class="article-content prose prose-zinc dark:prose-invert max-w-none prose-headings:leading-tight prose-h1:text-xl prose-h2:text-lg prose-h3:text-base md:prose-h1:text-2xl md:prose-h2:text-xl md:prose-h3:text-lg"
            x-data x-init="
                                        // Wrap tables for responsiveness
                                        $el.querySelectorAll('table').forEach(table => {
                                            if (table.parentElement.classList.contains('overflow-x-auto')) return;
                                            const wrapper = document.createElement('div');
                                            wrapper.className = 'overflow-x-auto my-6 rounded-lg border border-zinc-200 dark:border-zinc-700 shadow-sm';
                                            table.parentNode.insertBefore(wrapper, table);
                                            wrapper.appendChild(table);
                                        });
                                     ">
            {!! $linker->link($post->content) !!}
        </div>

        <style>
            /* Beautiful List Styles */
            .article-content ul {
                list-style: none;
                padding-left: 0;
                margin: 1.5rem 0;
            }

            .article-content ul li {
                position: relative;
                padding-left: 2rem;
                margin-bottom: 0.75rem;
                line-height: 1.75;
            }

            .article-content ul li::before {
                content: "●";
                position: absolute;
                left: 0.5rem;
                color: #06b6d4;
                /* cyan-500 */
                font-size: 1.2em;
                font-weight: bold;
                transition: transform 0.2s ease;
            }

            .article-content ul li:hover::before {
                transform: scale(1.3);
                color: #0891b2;
                /* cyan-600 */
            }

            .article-content ol {
                list-style: none;
                counter-reset: custom-counter;
                padding-left: 0;
                margin: 1.5rem 0;
            }

            .article-content ol li {
                position: relative;
                padding-left: 2.5rem;
                margin-bottom: 0.75rem;
                counter-increment: custom-counter;
                line-height: 1.75;
            }

            .article-content ol li::before {
                content: counter(custom-counter);
                position: absolute;
                left: 0;
                top: 0;
                width: 1.75rem;
                height: 1.75rem;
                background: linear-gradient(135deg, #06b6d4 0%, #0891b2 100%);
                color: white;
                border-radius: 50%;
                display: flex;
                align-items: center;
                justify-content: center;
                font-size: 0.875rem;
                font-weight: bold;
                box-shadow: 0 2px 4px rgba(6, 182, 212, 0.3);
                transition: all 0.2s ease;
            }

            .article-content ol li:hover::before {
                transform: scale(1.1);
                box-shadow: 0 4px 8px rgba(6, 182, 212, 0.4);
            }

            /* Nested lists */
            .article-content ul ul,
            .article-content ol ol,
            .article-content ul ol,
            .article-content ol ul {
                margin: 0.5rem 0;
            }

            .article-content ul ul li::before {
                content: "○";
                color: #22d3ee;
                /* cyan-400 */
            }

            /* Dark mode */
            @media (prefers-color-scheme: dark) {
                .article-content ul li::before {
                    color: #22d3ee;
                    /* cyan-400 */
                }

                .article-content ul li:hover::before {
                    color: #06b6d4;
                    /* cyan-500 */
                }

                .article-content ol li::before {
                    background: linear-gradient(135deg, #22d3ee 0%, #06b6d4 100%);
                }
            }

            /* Compact heading styles */
            .article-content h1,
            .article-content h2,
            .article-content h3,
            .article-content h4,
            .article-content h5,
            .article-content h6 {
                font-weight: 600 !important;
                /* Semi-bold instead of bold */
            }

            .article-content h1 {
                font-size: 1.5rem !important;
                line-height: 2rem !important;
            }

            .article-content h2 {
                font-size: 1.25rem !important;
                line-height: 1.75rem !important;
            }

            .article-content h3 {
                font-size: 1.125rem !important;
                line-height: 1.5rem !important;
            }

            .article-content h4 {
                font-size: 1rem !important;
                line-height: 1.5rem !important;
            }

            /* Mobile responsive headings */
            @media (max-width: 767px) {
                .article-content h1 {
                    font-size: 1.5rem !important;
                    line-height: 2rem !important;
                }

                .article-content h2 {
                    font-size: 1.25rem !important;
                    line-height: 1.75rem !important;
                }

                .article-content h3 {
                    font-size: 1.125rem !important;
                    line-height: 1.75rem !important;
                }

                .article-content h4 {
                    font-size: 1rem !important;
                    line-height: 1.5rem !important;
                }

                .article-content h5 {
                    font-size: 0.875rem !important;
                    line-height: 1.25rem !important;
                }

                .article-content h6 {
                    font-size: 0.75rem !important;
                    line-height: 1rem !important;
                }

                /* Mobile list adjustments */
                .article-content ul li,
                .article-content ol li {
                    padding-left: 1.75rem;
                    font-size: 0.9375rem;
                }

                .article-content ol li::before {
                    width: 1.5rem;
                    height: 1.5rem;
                    font-size: 0.75rem;
                }
            }
        </style>

        <!-- Recommended Posts -->
        <x-recommended-posts :posts="$recommendedPosts" />
    </div>

    <!-- Comments Section -->
    <livewire:post-comments :post="$post" />
@endsection