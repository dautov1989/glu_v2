@props([
    'post',
    'size' => 'small', // 'large', 'medium', 'small'
    'badge' => null, // 'top', 'popular', 'new'
    'gradient' => 'blue', // 'blue', 'teal', 'steel', 'indigo'
    'icon' => 'default'
])

@php
    // Классы размеров для CSS Grid
    $sizeClasses = [
        'large' => 'col-span-2 row-span-2 lg:col-span-2 lg:row-span-2',
        'medium' => 'col-span-2 row-span-1 lg:col-span-2 lg:row-span-1',
        'small' => 'col-span-1 row-span-1',
        'mobile' => 'w-full', // Для мобильных просто полная ширина
    ];

    // Улучшенные градиенты с более тёмными и насыщенными цветами
    $gradients = [
        'blue' => 'from-blue-600 via-cyan-500 to-blue-500',
        'teal' => 'from-teal-600 via-emerald-500 to-teal-500',
        'steel' => 'from-slate-700 via-gray-600 to-slate-600',
        'indigo' => 'from-indigo-600 via-purple-500 to-indigo-500'
    ];

    $gradientClass = $gradients[$gradient] ?? $gradients['blue'];
    $sizeClass = $sizeClasses[$size] ?? $sizeClasses['small'];

    // Уменьшенный паддинг для компактности
    $padding = $size === 'large' ? 'p-4 md:p-6' : ($size === 'medium' || $size === 'mobile' ? 'p-4 md:p-4' : 'p-2 md:p-3');
    
    // Показывать ли полное описание
    $showDescription = in_array($size, ['large', 'medium', 'mobile', 'small']);
    $showTags = in_array($size, ['large', 'medium', 'mobile']);
    $showButton = in_array($size, ['large', 'medium', 'mobile']);
@endphp

<article 
    class="bento-card relative overflow-hidden rounded-2xl {{ $sizeClass }} group cursor-pointer transition-all duration-500 hover:-translate-y-2 hover:shadow-2xl"
    style="min-height: {{ $size === 'large' ? '400px' : ($size === 'medium' ? '200px' : ($size === 'mobile' ? '380px' : '180px')) }}"
>
    {{-- Градиентный фон --}}
    <div class="absolute inset-0 bg-gradient-to-br {{ $gradientClass }} dark:opacity-90 transition-all duration-700
        {{ $size === 'large' ? 'group-hover:bg-gradient-to-tr' : '' }} bento-bg-pulse"></div>

    {{-- Затемнённый оверлей для улучшения читабельности --}}
    <div class="absolute inset-0 bg-black/20 dark:bg-black/30"></div>

    {{-- Декоративная иконка --}}
    @php
        // Центрируем иконку для больших и маленьких блоков,
        // для средних (широких) оставляем в углу. Мобильные тоже по центру!
        $iconPosition = ($size === 'large' || $size === 'small' || $size === 'mobile') ? 'center' : 'bottom-right';
    @endphp
    <x-bento-icon :icon="$icon" :position="$iconPosition" />

    {{-- Glassmorphism overlay --}}
    <div class="absolute inset-0 backdrop-blur-[2px] border border-white/20 dark:border-white/10 rounded-2xl"></div>

    {{-- Контент --}}
    <a href="{{ route('post.show', $post->slug) }}" class="relative h-full flex flex-col {{ $padding }} z-10">
        
        {{-- Верхняя часть: Бейдж (+ Дата для L/M/Mobile) --}}
        @if($size === 'small')
            {{-- Для маленьких блоков только бейдж --}}
            <div class="mb-2">
                <x-bento-badge :type="$badge" />
            </div>
        @else
            {{-- Для больших блоков бейдж + дата --}}
            <div class="flex items-start justify-between mb-2 md:mb-3">
                <x-bento-badge :type="$badge" />
                
                <time class="text-xs md:text-sm text-white/80 dark:text-white/70 font-medium bg-black/20 dark:bg-black/30 px-3 py-1 rounded-full backdrop-blur-sm">
                    {{ $post->published_at->format('d.m.Y') }}
                </time>
            </div>
        @endif

        {{-- Заголовок --}}
        <h3 class="font-bold text-white dark:text-white mb-2 md:mb-3 leading-tight
            {{ $size === 'large' ? 'text-2xl md:text-3xl lg:text-4xl' : ($size === 'medium' || $size === 'mobile' ? 'text-xl md:text-xl lg:text-2xl' : 'text-sm md:text-base line-clamp-5') }}">
            {{ $post->title }}
        </h3>

        {{-- Spacer (Толкает контент вниз) --}}
        <div class="flex-1"></div>

        {{-- Описание (для L и M блоков) --}}
        @if($showDescription && isset($post->fallbackDescription))
            <p class="text-white/90 dark:text-white/80 leading-relaxed mb-2 md:mb-3
                {{ $size === 'large' || $size === 'mobile' ? 'text-sm md:text-base line-clamp-4' : ($size === 'small' ? 'text-xs line-clamp-2 opacity-90' : 'text-sm md:text-base line-clamp-2') }}">
                {{ $post->fallbackDescription }}
            </p>
        @endif

        {{-- Теги (для L и M блоков) --}}
        @if($showTags && isset($post->fallbackKeywords) && !empty($post->fallbackKeywords))
            <div class="flex flex-wrap gap-2 mb-2 md:mb-3">
                @foreach(array_slice($post->fallbackKeywords, 0, 4) as $keyword)
                    <span class="text-xs px-2 py-1 bg-white/30 dark:bg-white/20 text-white rounded-md backdrop-blur-sm">
                        {{ $keyword }}
                    </span>
                @endforeach
            </div>
        @endif

        {{-- Нижняя часть: Кнопка + Просмотры --}}
        <div class="flex items-center justify-between pt-2">
            
            {{-- Кнопка "Читать" (для L и M блоков) --}}
            @if($showButton)
                <div class="inline-flex items-center gap-1.5 md:gap-2 px-4 py-2 md:px-6 md:py-3 bg-white/20 dark:bg-white/10 hover:bg-white/40 dark:hover:bg-white/20 text-white font-bold text-sm md:text-base rounded-full backdrop-blur-md border border-white/40 dark:border-white/20 shadow-lg hover:shadow-xl hover:scale-105 transition-all duration-300 group-hover:gap-2 md:group-hover:gap-3">
                    <span class="md:hidden">Читать</span>
                    <span class="hidden md:inline">Читать полностью</span>
                    <svg class="w-4 h-4 md:w-5 md:h-5 transform group-hover:translate-x-1 transition-transform" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M17 8l4 4m0 0l-4 4m4-4H3" />
                    </svg>
                </div>
            @else
                {{-- Пустой блок для Small карточек, чтобы flex justify-between работал корректно, если нужно --}}
                {{-- Но так как justify-between, если нет кнопки, статистика прижмется к краям. Лучше оставим пустым или сделаем flex-row-reverse? --}}
                {{-- Проще просто поменять порядок в HTML. Если кнопки нет (Small), то статистика будет СЛЕВА (первым элементом).
                     Стоп, пользователь хочет КНОПКУ СЛЕВА, ПРОСМОТРЫ СПРАВА.
                     Если это Small блок (кнопки нет), то просмотры должны быть СПРАВА? 
                     Сейчас они были слева. Если я просто поменяю HTML, то без кнопки статистика будет СЛЕВА (первым элементом).
                     Чтобы статистика была СПРАВА в Small блоке, нужно добавить мл-auto или пустой div.
                --}}
                <div></div> 
            @endif

            {{-- Просмотры (+ Время чтения для Large) (+ Дата для маленьких блоков) --}}
            <div class="flex items-center gap-3 lg:gap-4 text-white/80 dark:text-white/70 text-xs md:text-sm">
                @if($size === 'small')
                    <time class="font-medium">{{ $post->published_at->format('d.m.Y') }}</time>
                    <span class="w-1 h-1 bg-white/50 rounded-full"></span>
                @endif
                
                {{-- Просмотры --}}
                <div class="flex items-center gap-1.5">
                    <svg class="w-4 h-4 md:w-5 md:h-5" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M15 12a3 3 0 11-6 0 3 3 0 016 0z" />
                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M2.458 12C3.732 7.943 7.523 5 12 5c4.478 0 8.268 2.943 9.542 7-1.274 4.057-5.064 7-9.542 7-4.477 0-8.268-2.943-9.542-7z" />
                    </svg>
                    <span class="font-semibold">{{ number_format($post->views) }}</span>
                </div>

                {{-- Время чтения (только для Large и Mobile) --}}
                @if($size === 'large' || $size === 'mobile')
                    @php
                        // Примерный расчет: 1500 символов = 1 минута
                        $readingTime = ceil(mb_strlen(strip_tags($post->content ?? '')) / 1500); 
                        $readingTime = $readingTime < 1 ? 1 : $readingTime;
                    @endphp
                    <span class="w-1 h-1 bg-white/50 rounded-full"></span>
                    <div class="flex items-center gap-1.5" title="Время чтения">
                        <svg class="w-4 h-4 md:w-5 md:h-5" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 8v4l3 3m6-3a9 9 0 11-18 0 9 9 0 0118 0z" />
                        </svg>
                        <span>{{ $readingTime }} мин</span>
                    </div>
                @endif
            </div>
        </div>
    </a>
</article>

@if($size === 'large')
    <style>
        @keyframes bentoPulse {
            0%, 100% { background-position: 0% 50%; }
            50% { background-position: 100% 50%; }
        }
        
        .bento-bg-pulse {
            background-size: 200% 200%;
            animation: bentoPulse 7s ease-in-out infinite;
        }
    </style>
@endif
