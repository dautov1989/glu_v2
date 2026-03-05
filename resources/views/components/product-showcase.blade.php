{{-- Product Showcase Component for Categories --}}
@props(['category', 'products'])

@php
    // ──────────────────────────────────────────────
    // Автоматическая генерация цветов (как в BentoService)
    // ──────────────────────────────────────────────
    $gradientPalette = [
        ['from' => 'from-[#8042D8]', 'to' => 'to-[#6029B1]', 'badge' => 'bg-[#FF7A00]'],   // фиолетовый
        ['from' => 'from-[#0BB5CE]', 'to' => 'to-[#0188A2]', 'badge' => 'bg-[#FF7A00]'],   // бирюзовый
        ['from' => 'from-[#414E5D]', 'to' => 'to-[#2B3542]', 'badge' => 'bg-[#FF7A00]'],   // стальной
        ['from' => 'from-[#D84282]', 'to' => 'to-[#B12960]', 'badge' => 'bg-[#FF7A00]'],   // розовый
    ];

    // Автоматический цвет бренда маркетплейса
    $marketplaceConfig = [
        'Wildberries'   => ['color' => 'text-[#CB11AB]'],
        'Ozon'          => ['color' => 'text-[#005BFF]'],
        'Яндекс Маркет' => ['color' => 'text-[#FF0000]'],
        'ЕАПТЕКА'       => ['color' => 'text-[#D84282]'],
        'СберМегаМаркет'=> ['color' => 'text-[#21A038]'],
        'AliExpress'    => ['color' => 'text-[#FF4000]'],
    ];

    // Преобразуем коллекцию в массив и обогащаем авто-цветами
    $items = $products->map(function ($p, $i) use ($gradientPalette, $marketplaceConfig) {
        $palette = $gradientPalette[$i % count($gradientPalette)];
        $mpConfig = $marketplaceConfig[$p->marketplace] ?? ['color' => 'text-zinc-700'];

        return [
            'slug'             => $p->slug,
            'title'            => $p->title,
            'description'      => $p->description,
            'image_url'        => $p->image_url,
            'marketplace'      => $p->marketplace,
            'marketplace_url'  => $p->marketplace_url,
            'rating'           => $p->rating,
            'badge'            => $p->badge,
            'features'         => $p->features ?? [],
            'review'           => $p->review_text ? ['text' => $p->review_text] : null,
            'grad_from'        => $palette['from'],
            'grad_to'          => $palette['to'],
            'badge_bg'         => $palette['badge'],
            'marketplace_color'=> $mpConfig['color'],
        ];
    })->toArray();

    $products = $items;
    $count = count($products);
@endphp

@if($count > 0)
<div class="mb-14">

    @if($count === 1)
        {{-- Single Card Horizontal Layout --}}
        @php $product = $products[0]; @endphp
        <div class="group relative flex flex-col sm:flex-row bg-gradient-to-br {{ $product['grad_from'] }} {{ $product['grad_to'] }} rounded-[20px] p-4 lg:p-5 overflow-hidden transition-all duration-300 hover:-translate-y-1 shadow-md w-full gap-5 lg:gap-6">
            {{-- Watermark SVG --}}
            <svg class="absolute -bottom-10 -right-10 w-[200px] h-[200px] text-white/5 -rotate-12 pointer-events-none transition-transform duration-500 group-hover:scale-110 group-hover:rotate-0" fill="currentColor" viewBox="0 0 24 24">
                <path d="M12 21.35l-1.45-1.32C5.4 15.36 2 12.28 2 8.5 2 5.42 4.42 3 7.5 3c1.74 0 3.41.81 4.5 2.09C13.09 3.81 14.76 3 16.5 3 19.58 3 22 5.42 22 8.5c0 3.78-3.4 6.86-8.55 11.54L12 21.35z"/>
            </svg>

            {{-- LEFT SIDE: Image + Pills --}}
            <div class="w-full sm:w-[35%] lg:w-[30%] flex-shrink-0 flex flex-col relative z-10 sm:justify-center">
                {{-- Top pills --}}
                <div class="flex items-start mb-3">
                    <span class="px-2.5 py-1 {{ $product['badge_bg'] }} text-white text-[10px] sm:text-xs font-bold uppercase tracking-wide rounded-md shadow-sm">
                        {{ $product['badge'] }}
                    </span>
                </div>

                {{-- Image --}}
                <a href="{{ $product['marketplace_url'] }}" target="_blank" rel="noopener nofollow" class="block cursor-pointer w-full aspect-video sm:aspect-auto sm:h-[180px] lg:h-[200px] bg-white rounded-[14px] shadow-inner flex items-center justify-center overflow-hidden shrink-0 group-hover:shadow-[inset_0_0_20px_rgba(0,0,0,0.03)] transition-shadow relative mb-3 sm:mb-0">
                    @if(!empty($product['image_url']))
                        <img src="{{ $product['image_url'] }}" alt="{{ $product['title'] }}"
                             class="w-full h-full object-contain p-[5px] group-hover:scale-105 transition-transform duration-500">
                    @else
                        <svg class="w-12 h-12 text-zinc-300" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="1.5" d="M20 7l-8-4-8 4m16 0l-8 4m8-4v10l-8 4m0-10L4 7m8 4v10M4 7v10l8 4"></path>
                        </svg>
                    @endif
                    <div class="absolute bottom-1.5 left-1.5 px-2 py-1 bg-white/90 backdrop-blur-sm rounded-md border border-zinc-100 shadow-sm">
                        <span class="text-[10px] font-extrabold {{ $product['marketplace_color'] }}">{{ $product['marketplace'] }}</span>
                    </div>
                </a>

                {{-- Rating (Moved to bottom) --}}
                <div class="pt-2 sm:pt-4 flex items-center justify-start">
                    <div class="flex items-center gap-1.5">
                        <div class="flex items-center">
                            @for($s = 1; $s <= 10; $s++)
                                <svg class="w-3.5 h-3.5 {{ $s <= round($product['rating']) ? 'text-amber-400' : 'text-white/20' }}" fill="currentColor" viewBox="0 0 20 20">
                                    <path d="M9.049 2.927c.3-.921 1.603-.921 1.902 0l1.07 3.292a1 1 0 00.95.69h3.462c.969 0 1.371 1.24.588 1.81l-2.8 2.034a1 1 0 00-.364 1.118l1.07 3.292c.3.921-.755 1.688-1.54 1.118l-2.8-2.034a1 1 0 00-1.175 0l-2.8 2.034c-.784.57-1.838-.197-1.539-1.118l1.07-3.292a1 1 0 00-.364-1.118L2.98 8.72c-.783-.57-.38-1.81.588-1.81h3.461a1 1 0 00.951-.69l1.07-3.292z"/>
                                </svg>
                            @endfor
                        </div>
                        <span class="text-white/90 text-[13px] font-bold leading-none pl-1">{{ $product['rating'] }}</span>
                    </div>
                </div>
            </div>

            {{-- RIGHT SIDE: Content --}}
            <div class="w-full sm:w-[65%] lg:w-[70%] flex flex-col relative z-10 sm:justify-center">
                <h3 class="text-lg sm:text-xl lg:text-2xl font-bold text-white mb-2 leading-tight group-hover:opacity-90 transition-opacity">
                    {{ $product['title'] }}
                </h3>
                <p class="text-white/80 text-xs sm:text-sm leading-relaxed mb-4">
                    {{ $product['description'] }}
                </p>

                {{-- Features --}}
                @if(!empty($product['features']))
                <ul class="flex flex-col gap-2 mb-4">
                    @foreach($product['features'] as $feature)
                    <li class="flex items-center gap-2 text-white/90 text-xs sm:text-sm">
                        <span class="flex-shrink-0 w-5 h-5 rounded-full bg-white/20 border border-white/30 flex items-center justify-center">
                            <svg class="w-3 h-3 text-white" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2.5" d="M5 13l4 4L19 7"/>
                            </svg>
                        </span>
                        <span>{{ $feature }}</span>
                    </li>
                    @endforeach
                </ul>
                @endif

                {{-- Footer Buttons --}}
                <div class="mt-auto pt-4 border-t border-white/10 w-full sm:w-2/3 lg:w-1/2">
                    <div class="flex items-center gap-2">
                        <a href="/products/{{ $product['slug'] ?? '#' }}" class="w-1/2 inline-flex items-center justify-center py-2 bg-white/10 hover:bg-white/20 border border-white/20 text-white rounded-full text-[10px] sm:text-xs font-semibold transition-all duration-300 hover:-translate-y-0.5">
                            Подробнее
                        </a>
                        <a href="{{ $product['marketplace_url'] }}" target="_blank" rel="noopener nofollow" class="w-1/2 inline-flex items-center justify-center py-2 bg-white text-zinc-900 rounded-full text-[10px] sm:text-xs font-bold transition-all duration-300 shadow-md hover:shadow-[0_6px_20px_rgba(255,255,255,0.25)] hover:-translate-y-0.5">
                            Узнать цену
                        </a>
                    </div>
                </div>
            </div>
        </div>

    @elseif($count === 2)
        {{-- Symmetrical Layout: 2 cards render as identical large vertical cards --}}
        <div class="grid grid-cols-1 sm:grid-cols-2 gap-4">
            @foreach($products as $product)
            <div class="group relative flex flex-col bg-gradient-to-br {{ $product['grad_from'] }} {{ $product['grad_to'] }} rounded-[20px] p-4 overflow-hidden transition-all duration-300 hover:-translate-y-1 shadow-md">
                {{-- Watermark SVG --}}
                <svg class="absolute -bottom-4 -right-4 w-[160px] h-[160px] text-white/5 -rotate-12 pointer-events-none transition-transform duration-500 group-hover:scale-110 group-hover:rotate-0" fill="currentColor" viewBox="0 0 24 24">
                    <path d="M12 21.35l-1.45-1.32C5.4 15.36 2 12.28 2 8.5 2 5.42 4.42 3 7.5 3c1.74 0 3.41.81 4.5 2.09C13.09 3.81 14.76 3 16.5 3 19.58 3 22 5.42 22 8.5c0 3.78-3.4 6.86-8.55 11.54L12 21.35z"/>
                </svg>

                {{-- Top pills --}}
                <div class="flex justify-between items-start mb-3 relative z-10">
                    <span class="px-2.5 py-1 {{ $product['badge_bg'] }} text-white text-[10px] sm:text-xs font-bold uppercase tracking-wide rounded-md shadow-sm">
                        {{ $product['badge'] }}
                    </span>
                    <div class="px-2.5 py-1 bg-black/25 rounded-full backdrop-blur-sm border border-white/10 flex items-center gap-1.5 shadow-sm">
                        <div class="flex items-center">
                            @for($s = 1; $s <= 10; $s++)
                                <svg class="w-3 h-3 {{ $s <= round($product['rating']) ? 'text-amber-400' : 'text-white/20' }}" fill="currentColor" viewBox="0 0 20 20">
                                    <path d="M9.049 2.927c.3-.921 1.603-.921 1.902 0l1.07 3.292a1 1 0 00.95.69h3.462c.969 0 1.371 1.24.588 1.81l-2.8 2.034a1 1 0 00-.364 1.118l1.07 3.292c.3.921-.755 1.688-1.54 1.118l-2.8-2.034a1 1 0 00-1.175 0l-2.8 2.034c-.784.57-1.838-.197-1.539-1.118l1.07-3.292a1 1 0 00-.364-1.118L2.98 8.72c-.783-.57-.38-1.81.588-1.81h3.461a1 1 0 00.951-.69l1.07-3.292z"/>
                                </svg>
                            @endfor
                        </div>
                        <span class="text-white/90 text-[11px] sm:text-xs font-bold leading-none pt-px">{{ $product['rating'] }}</span>
                    </div>
                </div>

                {{-- Image --}}
                <a href="{{ $product['marketplace_url'] }}" target="_blank" rel="noopener nofollow" class="block cursor-pointer relative z-10 w-full aspect-video bg-white rounded-[14px] mb-4 shadow-inner flex items-center justify-center overflow-hidden shrink-0 group-hover:shadow-[inset_0_0_20px_rgba(0,0,0,0.03)] transition-shadow">
                    @if(!empty($product['image_url']))
                        <img src="{{ $product['image_url'] }}" alt="{{ $product['title'] }}"
                             class="w-full h-full object-contain p-[5px] group-hover:scale-105 transition-transform duration-500">
                    @else
                        <svg class="w-16 h-16 text-zinc-300" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="1.5" d="M20 7l-8-4-8 4m16 0l-8 4m8-4v10l-8 4m0-10L4 7m8 4v10M4 7v10l8 4"></path>
                        </svg>
                    @endif
                    <div class="absolute bottom-2 left-2 px-2 py-1 bg-white/90 backdrop-blur-sm rounded-md border border-zinc-100 shadow-sm">
                        <span class="text-[10px] font-extrabold {{ $product['marketplace_color'] }}">{{ $product['marketplace'] }}</span>
                    </div>
                </a>

                {{-- Content --}}
                <div class="relative z-10 flex-1 flex flex-col">
                    <h3 class="text-lg sm:text-xl font-bold text-white mb-2 leading-tight group-hover:opacity-90 transition-opacity">
                        {{ $product['title'] }}
                    </h3>
                    <p class="text-white/80 text-xs sm:text-sm leading-relaxed mb-4 line-clamp-3">
                        {{ $product['description'] }}
                    </p>

                    {{-- Features --}}
                    @if(!empty($product['features']))
                    <ul class="flex flex-col gap-2 mb-4">
                        @foreach($product['features'] as $feature)
                        <li class="flex items-center gap-2 text-white/90 text-xs sm:text-sm">
                            <span class="flex-shrink-0 w-5 h-5 rounded-full bg-white/20 border border-white/30 flex items-center justify-center">
                                <svg class="w-3 h-3 text-white" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2.5" d="M5 13l4 4L19 7"/>
                                </svg>
                            </span>
                            <span>{{ $feature }}</span>
                        </li>
                        @endforeach
                    </ul>
                    @endif

                    {{-- Footer --}}
                    <div class="mt-auto pt-4 border-t border-white/10">
                        <div class="flex items-center gap-2">
                            <a href="/products/{{ $product['slug'] ?? '#' }}" class="w-1/2 inline-flex items-center justify-center py-2 bg-white/10 hover:bg-white/20 border border-white/20 text-white rounded-full text-[10px] sm:text-xs font-semibold transition-all duration-300 hover:-translate-y-0.5">
                                Подробнее
                            </a>
                            <a href="{{ $product['marketplace_url'] }}" target="_blank" rel="noopener nofollow" class="w-1/2 inline-flex items-center justify-center py-2 bg-white text-zinc-900 rounded-full text-[10px] sm:text-xs font-bold transition-all duration-300 shadow-md hover:shadow-[0_6px_20px_rgba(255,255,255,0.25)] hover:-translate-y-0.5">
                                Узнать цену
                            </a>
                        </div>
                    </div>
                </div>
            </div>
            @endforeach
        </div>
    @else
        {{-- Asymmetric Flexbox Layout: 1 large card left, 2+ stacked cards right --}}
        <div class="flex flex-col lg:flex-row gap-4">

            @php $largeProduct = $products[0]; @endphp

            {{-- LEFT: Large vertical card --}}
            <div class="lg:w-[42%] flex-shrink-0 group relative flex flex-col bg-gradient-to-br {{ $largeProduct['grad_from'] }} {{ $largeProduct['grad_to'] }} rounded-[20px] p-4 overflow-hidden transition-all duration-300 hover:-translate-y-1 shadow-md">
                {{-- Watermark SVG --}}
                <svg class="absolute -bottom-4 -right-4 w-[160px] h-[160px] text-white/5 -rotate-12 pointer-events-none transition-transform duration-500 group-hover:scale-110 group-hover:rotate-0" fill="currentColor" viewBox="0 0 24 24">
                    <path d="M12 21.35l-1.45-1.32C5.4 15.36 2 12.28 2 8.5 2 5.42 4.42 3 7.5 3c1.74 0 3.41.81 4.5 2.09C13.09 3.81 14.76 3 16.5 3 19.58 3 22 5.42 22 8.5c0 3.78-3.4 6.86-8.55 11.54L12 21.35z"/>
                </svg>

                {{-- Top pills --}}
                <div class="flex justify-between items-start mb-3 relative z-10">
                    <span class="px-2.5 py-1 {{ $largeProduct['badge_bg'] }} text-white text-[10px] sm:text-xs font-bold uppercase tracking-wide rounded-md shadow-sm">
                        {{ $largeProduct['badge'] }}
                    </span>
                    <div class="px-2.5 py-1 bg-black/25 rounded-full backdrop-blur-sm border border-white/10 flex items-center gap-1.5 shadow-sm">
                        <div class="flex items-center">
                            @for($s = 1; $s <= 10; $s++)
                                <svg class="w-3 h-3 {{ $s <= round($largeProduct['rating']) ? 'text-amber-400' : 'text-white/20' }}" fill="currentColor" viewBox="0 0 20 20">
                                    <path d="M9.049 2.927c.3-.921 1.603-.921 1.902 0l1.07 3.292a1 1 0 00.95.69h3.462c.969 0 1.371 1.24.588 1.81l-2.8 2.034a1 1 0 00-.364 1.118l1.07 3.292c.3.921-.755 1.688-1.54 1.118l-2.8-2.034a1 1 0 00-1.175 0l-2.8 2.034c-.784.57-1.838-.197-1.539-1.118l1.07-3.292a1 1 0 00-.364-1.118L2.98 8.72c-.783-.57-.38-1.81.588-1.81h3.461a1 1 0 00.951-.69l1.07-3.292z"/>
                                </svg>
                            @endfor
                        </div>
                        <span class="text-white/90 text-[11px] sm:text-xs font-bold leading-none pt-px">{{ $largeProduct['rating'] }}</span>
                    </div>
                </div>

                {{-- Image --}}
                <a href="{{ $largeProduct['marketplace_url'] }}" target="_blank" rel="noopener nofollow" class="block cursor-pointer relative z-10 w-full aspect-video bg-white rounded-[14px] mb-4 shadow-inner flex items-center justify-center overflow-hidden shrink-0 group-hover:shadow-[inset_0_0_20px_rgba(0,0,0,0.03)] transition-shadow">
                    @if(!empty($largeProduct['image_url']))
                        <img src="{{ $largeProduct['image_url'] }}" alt="{{ $largeProduct['title'] }}"
                             class="w-full h-full object-contain p-[5px] group-hover:scale-105 transition-transform duration-500">
                    @else
                        <svg class="w-16 h-16 text-zinc-300" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="1.5" d="M20 7l-8-4-8 4m16 0l-8 4m8-4v10l-8 4m0-10L4 7m8 4v10M4 7v10l8 4"></path>
                        </svg>
                    @endif
                    <div class="absolute bottom-2 left-2 px-2 py-1 bg-white/90 backdrop-blur-sm rounded-md border border-zinc-100 shadow-sm">
                        <span class="text-[10px] font-extrabold {{ $largeProduct['marketplace_color'] }}">{{ $largeProduct['marketplace'] }}</span>
                    </div>
                </a>

                {{-- Content --}}
                <div class="relative z-10 flex-1 flex flex-col">
                    <h3 class="text-lg sm:text-xl font-bold text-white mb-2 leading-tight group-hover:opacity-90 transition-opacity">
                        {{ $largeProduct['title'] }}
                    </h3>
                    <p class="text-white/80 text-xs sm:text-sm leading-relaxed mb-4 line-clamp-3">
                        {{ $largeProduct['description'] }}
                    </p>

                    {{-- Features --}}
                    @if(!empty($largeProduct['features']))
                    <ul class="flex flex-col gap-2 mb-4">
                        @foreach($largeProduct['features'] as $feature)
                        <li class="flex items-center gap-2 text-white/90 text-xs sm:text-sm">
                            <span class="flex-shrink-0 w-5 h-5 rounded-full bg-white/20 border border-white/30 flex items-center justify-center">
                                <svg class="w-3 h-3 text-white" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2.5" d="M5 13l4 4L19 7"/>
                                </svg>
                            </span>
                            <span>{{ $feature }}</span>
                        </li>
                        @endforeach
                    </ul>
                    @endif

                    {{-- Review Block (Only if more than 3 products) --}}
                    @if($count >= 4 && !empty($largeProduct['review']))
                    <div class="mb-4 mt-6 bg-white/10 rounded-xl p-4 pt-5 border border-white/20 relative backdrop-blur-sm">
                        <div class="absolute -top-2.5 left-4 px-2.5 py-0.5 bg-amber-500/90 text-white text-[10px] font-bold uppercase tracking-wider rounded-md border border-amber-400/50 shadow-sm z-10 backdrop-blur-md">
                            Отзывы
                        </div>
                        <p class="text-white/90 text-[11px] sm:text-xs italic leading-relaxed relative z-10 pt-1">
                            {{ $largeProduct['review']['text'] }}
                        </p>
                    </div>
                    @endif

                    {{-- Footer --}}
                    <div class="mt-auto pt-4 border-t border-white/10">
                        <div class="flex items-center gap-2">
                            <a href="/products/{{ $largeProduct['slug'] ?? '#' }}" class="w-1/2 inline-flex items-center justify-center py-2 bg-white/10 hover:bg-white/20 border border-white/20 text-white rounded-full text-[10px] sm:text-xs font-semibold transition-all duration-300 hover:-translate-y-0.5">
                                Подробнее
                            </a>
                            <a href="{{ $largeProduct['marketplace_url'] }}" target="_blank" rel="noopener nofollow" class="w-1/2 inline-flex items-center justify-center py-2 bg-white text-zinc-900 rounded-full text-[10px] sm:text-xs font-bold transition-all duration-300 shadow-md hover:shadow-[0_6px_20px_rgba(255,255,255,0.25)] hover:-translate-y-0.5">
                                Узнать цену
                            </a>
                        </div>
                    </div>
                </div>
            </div>

            {{-- RIGHT: Stacked horizontal cards (flex-1 so they fill height) --}}
            <div class="flex-1 flex flex-col gap-4">
                @foreach($products as $index => $product)
                    @if($index === 0) @continue @endif
                    @php $isImageRight = ($index % 2 === 0); @endphp

                    <div class="flex-1 group relative flex flex-col {{ $isImageRight ? 'sm:flex-row-reverse' : 'sm:flex-row' }} bg-gradient-to-br {{ $product['grad_from'] }} {{ $product['grad_to'] }} rounded-[20px] p-4 overflow-hidden transition-all duration-300 hover:-translate-y-1 shadow-md">
                        <svg class="absolute -bottom-4 -right-4 w-24 h-24 text-white/5 -rotate-12 pointer-events-none transition-transform duration-500 group-hover:scale-110 group-hover:rotate-0" fill="currentColor" viewBox="0 0 24 24">
                            <path d="M12 2.69l5.66 5.66a8 8 0 11-11.31 0z"/>
                        </svg>

                        {{-- Image --}}
                        <div class="flex-shrink-0 mb-3 sm:mb-0 {{ $isImageRight ? 'sm:ml-4' : 'sm:mr-4' }} w-full sm:w-[100px] lg:w-[110px] sm:self-center flex flex-col gap-2">
                            <a href="{{ $product['marketplace_url'] }}" target="_blank" rel="noopener nofollow" class="block cursor-pointer relative z-10 w-full aspect-square bg-white rounded-[12px] shadow-inner flex items-center justify-center overflow-hidden">
                                @if(!empty($product['image_url']))
                                    <img src="{{ $product['image_url'] }}" alt="{{ $product['title'] }}"
                                         class="w-full h-full object-contain p-[5px] group-hover:scale-105 transition-transform duration-500">
                                @else
                                    <svg class="w-10 h-10 text-zinc-300" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="1.5" d="M20 7l-8-4-8 4m16 0l-8 4m8-4v10l-8 4m0-10L4 7m8 4v10M4 7v10l8 4"></path>
                                    </svg>
                                @endif
                            </a>
                            <div class="w-full bg-white rounded-md py-1 shadow-sm flex items-center justify-center">
                                <span class="text-[9px] sm:text-[10px] font-extrabold tracking-wide uppercase {{ $product['marketplace_color'] }}">{{ $product['marketplace'] }}</span>
                            </div>
                        </div>

                        {{-- Content --}}
                        <div class="relative z-10 flex-1 flex flex-col">
                            {{-- Pills --}}
                            <div class="flex justify-between items-start mb-2">
                                <span class="px-2 py-0.5 {{ $product['badge_bg'] }} text-white text-[9px] font-bold uppercase tracking-wide rounded shadow-sm">
                                    {{ $product['badge'] }}
                                </span>
                                <div class="px-2 py-0.5 bg-black/25 rounded-full backdrop-blur-sm flex items-center gap-1 border border-white/10 shadow-sm">
                                    <div class="flex items-center">
                                        @for($s = 1; $s <= 10; $s++)
                                            <svg class="w-2.5 h-2.5 sm:w-2 sm:h-2 lg:w-2.5 lg:h-2.5 {{ $s <= round($product['rating']) ? 'text-amber-400' : 'text-white/20' }}" fill="currentColor" viewBox="0 0 20 20">
                                                <path d="M9.049 2.927c.3-.921 1.603-.921 1.902 0l1.07 3.292a1 1 0 00.95.69h3.462c.969 0 1.371 1.24.588 1.81l-2.8 2.034a1 1 0 00-.364 1.118l1.07 3.292c.3.921-.755 1.688-1.54 1.118l-2.8-2.034a1 1 0 00-1.175 0l-2.8 2.034c-.784.57-1.838-.197-1.539-1.118l1.07-3.292a1 1 0 00-.364-1.118L2.98 8.72c-.783-.57-.38-1.81.588-1.81h3.461a1 1 0 00.951-.69l1.07-3.292z"/>
                                            </svg>
                                        @endfor
                                    </div>
                                    <span class="text-white/90 text-[10px] font-bold leading-none pt-px">{{ $product['rating'] }}</span>
                                </div>
                            </div>

                            <h3 class="text-sm sm:text-base font-bold text-white mb-1.5 leading-tight group-hover:opacity-90 transition-opacity">
                                {{ $product['title'] }}
                            </h3>
                            <p class="text-white/80 text-[11px] sm:text-xs leading-relaxed mb-3 line-clamp-2">
                                {{ $product['description'] }}
                            </p>

                            {{-- Features --}}
                            @if(!empty($product['features']))
                            <ul class="flex flex-col gap-1.5 mb-3">
                                @foreach($product['features'] as $feature)
                                <li class="flex items-center gap-1.5 text-white/90 text-[11px]">
                                    <span class="flex-shrink-0 w-4 h-4 rounded-full bg-white/20 border border-white/30 flex items-center justify-center">
                                        <svg class="w-2.5 h-2.5 text-white" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2.5" d="M5 13l4 4L19 7"/>
                                        </svg>
                                    </span>
                                    <span>{{ $feature }}</span>
                                </li>
                                @endforeach
                            </ul>
                            @endif

                            {{-- Footer --}}
                            <div class="mt-auto pt-2.5 border-t border-white/10">
                                <div class="flex items-center gap-1.5 {{ $isImageRight ? 'flex-row-reverse' : '' }}">
                                    <a href="/products/{{ $product['slug'] ?? '#' }}" class="w-1/2 inline-flex items-center justify-center py-1.5 bg-white/10 hover:bg-white/20 border border-white/20 text-white rounded-full text-[9px] font-semibold transition-all duration-300 hover:-translate-y-0.5">
                                        Подробнее
                                    </a>
                                    <a href="{{ $product['marketplace_url'] }}" target="_blank" rel="noopener nofollow" class="w-1/2 inline-flex items-center justify-center py-1.5 bg-white text-zinc-900 rounded-full text-[9px] font-bold transition-all duration-300 shadow-sm hover:shadow-[0_4px_12px_rgba(255,255,255,0.25)] hover:-translate-y-0.5">
                                        Узнать цену
                                    </a>
                                </div>
                            </div>
                        </div>
                    </div>
                @endforeach
            </div>
        </div>
    @endif

</div>
@endif
