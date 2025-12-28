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
                                                                                            const yOffset = -100;
                                                                                            const y = $el.getBoundingClientRect().top + window.pageYOffset + yOffset;
                                                                                            window.scrollTo({top: y, behavior: 'smooth'});
                                                                                        }, 300);
                                                                                    }
                                                                                "
        class="bg-white dark:bg-zinc-800 rounded-2xl p-4 md:p-8 border border-cyan-200/50 dark:border-cyan-800/30 shadow-sm scroll-mt-24">
        <!-- Article Header -->
        <header class="mb-6 md:mb-8">
            {{-- Smart Breadcrumbs with Arrow Navigation --}}
            <div x-data="{ 
                                        canScrollLeft: false, 
                                        canScrollRight: false,
                                        updateScrollState() {
                                            const el = this.$refs.scrollContainer;
                                            if (!el) return;
                                            // Добавляем микро-задержку для точности отрисовки
                                            this.canScrollLeft = el.scrollLeft > 2;
                                            this.canScrollRight = el.scrollWidth > (el.clientWidth + el.scrollLeft + 2);
                                        },
                                        scroll(direction) {
                                            const el = this.$refs.scrollContainer;
                                            const scrollAmount = Math.min(el.clientWidth * 0.8, 300);
                                            el.scrollBy({ left: direction === 'left' ? -scrollAmount : scrollAmount, behavior: 'smooth' });
                                        }
                                    }" x-init="
                                        $nextTick(() => updateScrollState());
                                        // Следим за изменением размера для пересчета стрелок
                                        new ResizeObserver(() => updateScrollState()).observe($refs.scrollContainer);
                                    " @resize.window.debounce.100ms="updateScrollState()" class="relative group mb-6">

                {{-- Left Arrow --}}
                <button x-show="canScrollLeft" x-cloak x-transition.opacity @click="scroll('left')"
                    class="absolute left-0 top-1/2 -translate-y-1/2 z-20 p-2 bg-white dark:bg-zinc-800 shadow-xl rounded-full border-2 border-cyan-500 text-cyan-600 dark:text-cyan-400 hover:bg-cyan-50 dark:hover:bg-cyan-900/30 transition-all duration-200 sm:-ml-[23px] sm:-mt-[2px]">
                    <svg class="w-4 h-4" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M15 19l-7-7 7-7" />
                    </svg>
                </button>

                {{-- Scrollable Container --}}
                <nav x-ref="scrollContainer" @scroll.debounce.50ms="updateScrollState()"
                    class="overflow-x-auto scroll-smooth" style="scrollbar-width: none; -ms-overflow-style: none;">
                    <style>
                        [x-ref='scrollContainer']::-webkit-scrollbar {
                            display: none;
                        }
                    </style>
                    <ol class="flex items-center gap-2 min-w-max pb-1 px-1">
                        <li>
                            <a href="{{ route('home') }}"
                                class="flex items-center h-9 px-4 rounded-xl bg-white dark:bg-zinc-800 border border-cyan-200/50 dark:border-cyan-800/30 shadow-sm text-zinc-600 dark:text-zinc-400 hover:border-cyan-500 hover:text-cyan-600 dark:hover:text-cyan-400 transition-all duration-300 group">
                                <svg class="w-3.5 h-3.5 mr-2 text-zinc-400 group-hover:text-cyan-500 transition-colors"
                                    fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
                                        d="M3 12l2-2m0 0l7-7 7 7M5 10v10a1 1 0 001 1h3m10-11l2 2m-2-2v10a1 1 0 01-1 1h-3m-6 0a1 1 0 001-1v-4a1 1 0 011-1h2a1 1 0 011 1v4a1 1 0 001 1m-6 0h6" />
                                </svg>
                                <span class="text-sm font-semibold">Главная</span>
                            </a>
                        </li>

                        @foreach($post->category->getBreadcrumbs() as $breadcrumb)
                            <li class="flex items-center">
                                <svg class="w-3.5 h-3.5 text-zinc-300 dark:text-zinc-600" fill="none" stroke="currentColor"
                                    viewBox="0 0 24 24">
                                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M9 5l7 7-7 7">
                                    </path>
                                </svg>
                            </li>
                            <li>
                                <a href="{{ route('category.show', $breadcrumb->slug) }}"
                                    class="flex items-center h-9 px-4 rounded-xl bg-white dark:bg-zinc-800 border border-cyan-200/50 dark:border-cyan-800/30 shadow-sm text-zinc-600 dark:text-zinc-400 hover:border-cyan-500 hover:text-cyan-600 dark:hover:text-cyan-400 transition-all duration-300 group">
                                    <span class="text-sm font-semibold">{{ $breadcrumb->title }}</span>
                                </a>
                            </li>
                        @endforeach

                        <li class="flex items-center">
                            <svg class="w-3.5 h-3.5 text-zinc-300 dark:text-zinc-600" fill="none" stroke="currentColor"
                                viewBox="0 0 24 24">
                                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M9 5l7 7-7 7">
                                </path>
                            </svg>
                        </li>
                        <li>
                            <div
                                class="flex items-center h-9 px-4 rounded-xl bg-cyan-50 dark:bg-cyan-950/30 border border-cyan-200/50 dark:border-cyan-800/30 text-cyan-600 dark:text-cyan-400 shadow-sm">
                                <svg class="w-3.5 h-3.5 mr-2 text-cyan-500" fill="none" stroke="currentColor"
                                    viewBox="0 0 24 24">
                                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
                                        d="M11 5H6a2 2 0 00-2 2v11a2 2 0 002 2h11a2 2 0 002-2v-5m-1.414-9.414a2 2 0 112.828 2.828L11.828 15H9v-2.828l8.586-8.586z" />
                                </svg>
                                <span class="text-sm font-bold tracking-tight">Статья</span>
                            </div>
                        </li>
                    </ol>
                </nav>

                {{-- Right Arrow --}}
                <button x-show="canScrollRight" x-cloak x-transition.opacity @click="scroll('right')"
                    class="absolute right-0 top-1/2 -translate-y-1/2 z-20 p-2 bg-white dark:bg-zinc-800 shadow-xl rounded-full border-2 border-cyan-500 text-cyan-600 dark:text-cyan-400 hover:bg-cyan-50 dark:hover:bg-cyan-900/30 transition-all duration-200 sm:-mr-[23px] sm:-mt-[2px]">
                    <svg class="w-4 h-4" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M9 5l7 7-7 7" />
                    </svg>
                </button>
            </div>

            <!-- Title -->
            <h1
                class="text-xl sm:text-2xl md:text-3xl font-bold mb-4 leading-tight text-zinc-900 dark:text-white tracking-tight">
                {{ $post->title }}
            </h1>

            <!-- Meta information (Date, Views) -->
            <div
                class="flex items-center gap-6 text-sm text-zinc-500 dark:text-zinc-400 pb-6 border-b border-zinc-100 dark:border-zinc-800">
                <div class="flex items-center gap-2">
                    <svg class="w-4 h-4 text-zinc-400" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
                            d="M8 7V3m8 4V3m-9 8h10M5 21h14a2 2 0 002-2V7a2 2 0 00-2-2H5a2 2 0 00-2 2v12a2 2 0 002 2z">
                        </path>
                    </svg>
                    <span>{{ $post->published_at->format('d.m.Y') }}</span>
                </div>

                <div class="flex items-center gap-2">
                    <svg class="w-4 h-4 text-zinc-400" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
                            d="M15 12a3 3 0 11-6 0 3 3 0 016 0z"></path>
                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
                            d="M2.458 12C3.732 7.943 7.523 5 12 5c4.478 0 8.268 2.943 9.542 7-1.274 4.057-5.064 7-9.542 7-4.477 0-8.268-2.943-9.542-7z">
                        </path>
                    </svg>
                    <span>{{ $post->views }}</span>
                </div>
            </div>
        </header>



        <!-- Content -->
        @inject('linker', 'App\Services\Seo\InternalLinker')
        <div class="article-content max-w-none prose prose-zinc dark:prose-invert prose-headings:leading-tight prose-h1:text-xl prose-h2:text-lg prose-h3:text-base md:prose-h1:text-2xl md:prose-h2:text-xl md:prose-h3:text-lg"
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
            /* Remove top margin from the first element and its first child to avoid double spacing */
            .article-content> :first-child,
            .article-content> :first-child> :first-child {
                margin-top: 0 !important;
                padding-top: 0 !important;
            }

            /* Neutralize inner wrapper constraints (fixes indents and width issues) */
            .article-content>div {
                max-width: none !important;
                margin: 0 !important;
                padding: 0 !important;
            }

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