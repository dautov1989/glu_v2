@props(['category', 'products'])

@php
    $marketplaceColors = [
        'Wildberries' => ['bg' => 'bg-[#cb11ab]', 'hover' => 'hover:bg-[#a60d8c]'],
        'Ozon' => ['bg' => 'bg-[#005bff]', 'hover' => 'hover:bg-[#004ada]'],
        'Яндекс Маркет' => ['bg' => 'bg-[#ffcc00]', 'hover' => 'hover:bg-[#e6b800]', 'text' => 'text-black'],
        'ЕАПТЕКА' => ['bg' => 'bg-[#00a38e]', 'hover' => 'hover:bg-[#008775]'],
        'Мегамаркет' => ['bg' => 'bg-[#21A038]', 'hover' => 'hover:bg-[#1a802d]'],
    ];

    $items = $products->map(function ($product, $index) use ($marketplaceColors) {
        $mc = $marketplaceColors[$product->marketplace] ?? ['bg' => 'bg-cyan-600', 'hover' => 'hover:bg-cyan-700', 'text' => 'text-white'];
        return [
            'id' => $product->id ?? ($index + 1),
            'title' => $product->title,
            'description' => $product->description,
            'image_url' => $product->image_url,
            'marketplace' => $product->marketplace,
            'marketplace_url' => $product->marketplace_url,
            'rating' => $product->rating ?? 9,
            'badge' => $product->badge ?? '',
            'characteristics' => is_array($product->features) ? $product->features : [],
            'expert_review' => $product->review_text ?? '',
            'btn_bg' => $mc['bg'],
            'btn_hover' => $mc['hover'],
            'btn_text' => $mc['text'] ?? 'text-white',
        ];
    });
@endphp

<div class="mt-4" x-data="{ 
    modalOpen: false, 
    activeProduct: null,
    revealed: false,
    products: @js($items),
    openModal(id) {
        this.activeProduct = this.products.find(p => p.id === id);
        this.modalOpen = true;
        document.body.style.overflow = 'hidden';
    },
    closeModal() {
        this.modalOpen = false;
        setTimeout(() => { this.activeProduct = null; }, 300);
        document.body.style.overflow = '';
    }
}" x-init="setTimeout(() => revealed = true, 100)">

    <!-- Product Grid ("Ремешок") -->
    <div class="grid grid-cols-2 md:grid-cols-3 xl:grid-cols-4 gap-3 md:gap-4 w-full">
        <template x-for="(product, index) in products" :key="product.id">
            <div @click="openModal(product.id)" x-show="revealed" x-transition:enter="transition ease-out duration-700"
                x-transition:enter-start="opacity-0 translate-y-8 scale-95"
                x-transition:enter-end="opacity-100 translate-y-0 scale-100"
                :style="`transition-delay: ${index * 100}ms`"
                class="bg-white dark:bg-zinc-800/80 border border-cyan-100/50 dark:border-cyan-800/30 rounded-2xl cursor-pointer hover:border-cyan-400 dark:hover:border-cyan-500 transition-all duration-300 group shadow-sm hover:shadow-md hover:-translate-y-1 flex flex-col overflow-hidden">


                <!-- Top Expert Badge (Sticky Header) -->
                <div class="relative z-10 bg-cyan-500 dark:bg-cyan-600 w-full py-1 sm:py-1.5 shadow-sm">
                    <span
                        class="block w-full text-center text-white text-[9px] sm:text-[10px] font-black uppercase tracking-wider"
                        x-text="product.badge"></span>
                </div>

                <div class="flex flex-col flex-1">
                    <!-- Image Container (Shimmer/5:4) - Reduced height -->
                    <div
                        class="relative w-full aspect-[5/4] bg-white dark:bg-zinc-900/10 flex items-center justify-center overflow-hidden group-hover:shadow-[inset_0_0_20px_rgba(0,0,0,0.03)] transition-shadow">
                        <img x-show="product.image_url" :src="product.image_url" :alt="product.title"
                            class="w-full h-full object-contain p-2 group-hover:scale-110 transition-transform duration-700 mix-blend-multiply dark:mix-blend-normal">
                        <svg x-show="!product.image_url" class="w-10 h-10 text-zinc-100 dark:text-zinc-800" fill="none"
                            viewBox="0 0 24 24" stroke="currentColor">
                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="1.5"
                                d="M4 16l4.586-4.586a2 2 0 012.828 0L16 16m-2-2l1.586-1.586a2 2 0 012.828 0L20 14m-6-6h.01M6 20h12a2 2 0 002-2V6a2 2 0 00-2-2H6a2 2 0 00-2 2v12a2 2 0 002 2z" />
                        </svg>
                    </div>

                    <!-- Info Snippet (Just Title) -->
                    <div class="p-2 mt-auto text-center">
                        <h4 class="font-bold text-zinc-800 dark:text-zinc-200 text-[10px] sm:text-[11px] leading-tight line-clamp-2 transition-colors group-hover:text-cyan-600 dark:group-hover:text-cyan-400"
                            x-text="product.title"></h4>
                    </div>
                </div>
            </div>
        </template>
    </div>

    <x-product-modal />
</div>