@props(['bentoData'])

@php
    $large = $bentoData['large'] ?? null;
    $medium = $bentoData['medium'] ?? collect([]);
    $small = $bentoData['small'] ?? collect([]);
@endphp

<div class="bento-grid-container">
    {{-- Desktop: Asymmetric Bento Grid --}}
    <div class="hidden md:grid bento-grid gap-6 bento-desktop-container" x-ref="desktopGrid">
        {{-- Large Block (Top-1 Article) --}}
        @if($large)
            <x-bento-card :post="$large" size="large" :badge="$large->bentoBadge" :gradient="$large->bentoGradient"
                :icon="$large->bentoIcon" />
        @endif

        {{-- Medium Blocks (Top 2-4) --}}
        @foreach($medium as $post)
            <x-bento-card :post="$post" size="medium" :badge="$post->bentoBadge" :gradient="$post->bentoGradient"
                :icon="$post->bentoIcon" />
        @endforeach

        {{-- Small Blocks (Remaining) --}}
        @foreach($small as $post)
            <x-bento-card :post="$post" size="small" :badge="$post->bentoBadge" :gradient="$post->bentoGradient"
                :icon="$post->bentoIcon" />
        @endforeach
    </div>

    {{-- Mobile: Single Column --}}
    <div class="md:hidden flex flex-col gap-4 bento-mobile-container" x-ref="mobileGrid">
        @foreach($bentoData['all'] ?? [] as $post)
            <x-bento-card :post="$post" size="mobile" :badge="$post->bentoBadge" :gradient="$post->bentoGradient"
                :icon="$post->bentoIcon" />
        @endforeach
    </div>
</div>

<style>
    .bento-grid {
        /* display: grid; - Убрано, так как управляется через md:grid tailwind */
        grid-template-columns: repeat(4, 1fr);
        grid-auto-flow: dense;
    }

    /* Размеры блоков */
    .col-span-2 {
        grid-column: span 2;
    }

    .col-span-1 {
        grid-column: span 1;
    }

    .row-span-2 {
        grid-row: span 2;
    }

    .row-span-1 {
        grid-row: span 1;
    }

    /* Tablet адаптация */
    @media (min-width: 768px) and (max-width: 1023px) {
        .bento-grid {
            grid-template-columns: repeat(2, 1fr);
        }
    }

    /* Desktop адаптация */
    @media (min-width: 1024px) {
        .bento-grid {
            grid-template-columns: repeat(4, 1fr);
        }
    }

    /* Fade-in анимация при первой загрузке */
    @keyframes bentoFadeInUp {
        from {
            opacity: 0;
            transform: translateY(20px);
        }

        to {
            opacity: 1;
            transform: translateY(0);
        }
    }

    .bento-card {
        animation: bentoFadeInUp 0.6s ease-out forwards;
    }

    /* Задержка для каждой карточки */
    .bento-card:nth-child(1) {
        animation-delay: 0.1s;
        opacity: 0;
    }

    .bento-card:nth-child(2) {
        animation-delay: 0.2s;
        opacity: 0;
    }

    .bento-card:nth-child(3) {
        animation-delay: 0.3s;
        opacity: 0;
    }

    .bento-card:nth-child(4) {
        animation-delay: 0.4s;
        opacity: 0;
    }

    .bento-card:nth-child(5) {
        animation-delay: 0.5s;
        opacity: 0;
    }

    .bento-card:nth-child(6) {
        animation-delay: 0.6s;
        opacity: 0;
    }

    .bento-card:nth-child(n+7) {
        animation-delay: 0.7s;
        opacity: 0;
    }
</style>