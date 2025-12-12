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
    <div class="bg-white dark:bg-zinc-800 rounded-2xl p-8 border border-zinc-200 dark:border-zinc-700 shadow-sm">
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
        <header class="mb-8">
            <h1 class="text-3xl md:text-4xl font-bold text-zinc-900 dark:text-zinc-100 mb-4">
                {{ $post->title }}
            </h1>

            <div class="flex items-center text-sm text-zinc-500 dark:text-zinc-400 space-x-4">
                <span class="flex items-center">
                    <svg class="w-4 h-4 mr-1" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
                            d="M8 7V3m8 4V3m-9 8h10M5 21h14a2 2 0 002-2V7a2 2 0 00-2-2H5a2 2 0 00-2 2v12a2 2 0 002 2z">
                        </path>
                    </svg>
                    {{ $post->published_at->format('d.m.Y') }}
                </span>
                <span class="flex items-center">
                    <svg class="w-4 h-4 mr-1" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
                            d="M15 12a3 3 0 11-6 0 3 3 0 016 0z"></path>
                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
                            d="M2.458 12C3.732 7.943 7.523 5 12 5c4.478 0 8.268 2.943 9.542 7-1.274 4.057-5.064 7-9.542 7-4.477 0-8.268-2.943-9.542-7z">
                        </path>
                    </svg>
                    {{ $post->views }} просмотров
                </span>
            </div>
        </header>



        <!-- Content -->
        @inject('linker', 'App\Services\Seo\InternalLinker')
        <div class="prose prose-zinc dark:prose-invert max-w-none" x-data x-init="
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

        <!-- Recommended Posts -->
        <x-recommended-posts :posts="$recommendedPosts" />
    </div>

    <!-- Comments Section -->
    <livewire:post-comments :post="$post" />
@endsection