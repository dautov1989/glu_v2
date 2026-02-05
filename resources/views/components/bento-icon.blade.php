@props(['icon' => 'default', 'position' => 'bottom-right'])

@php
    $positionClasses = [
        'bottom-right' => 'bottom-4 right-4',
        'bottom-left' => 'bottom-4 left-4',
        'top-right' => 'top-4 right-4',
        'top-left' => 'top-4 left-4',
        'center' => 'top-1/2 left-1/2 -translate-x-1/2 -translate-y-1/2',
    ];
    $posClass = $positionClasses[$position] ?? $positionClasses['bottom-right'];
@endphp

<div class="absolute {{ $posClass }} opacity-25 dark:opacity-35 pointer-events-none">
    @switch($icon)
        @case('nutrition')
        @case('diet')
            {{-- Тарелка с едой --}}
            <svg class="w-32 h-32 md:w-40 md:h-40 text-white" fill="currentColor" viewBox="0 0 24 24">
                <path d="M12 2C6.48 2 2 6.48 2 12s4.48 10 10 10 10-4.48 10-10S17.52 2 12 2zm0 18c-4.41 0-8-3.59-8-8s3.59-8 8-8 8 3.59 8 8-3.59 8-8 8z"/>
                <circle cx="12" cy="12" r="3"/>
            </svg>
            @break

        @case('recipe')
            {{-- Поварской колпак --}}
            <svg class="w-32 h-32 md:w-40 md:h-40 text-white" fill="currentColor" viewBox="0 0 24 24">
                <path d="M12.5 1.5c-1.5 0-2.7.7-3.5 1.8-.8-1.1-2-1.8-3.5-1.8C3.5 1.5 2 3.1 2 5c0 1.5 1 2.8 2.4 3.3L5 20h14l.6-11.7C20.9 7.8 22 6.5 22 5c0-1.9-1.5-3.5-3.5-3.5-1.5 0-2.7.7-3.5 1.8-.8-1.1-2-1.8-3.5-1.8z"/>
            </svg>
            @break

        @case('sport')
        @case('workout')
            {{-- Гантель --}}
            <svg class="w-32 h-32 md:w-40 md:h-40 text-white" fill="currentColor" viewBox="0 0 24 24">
                <path d="M20.57 14.86L22 13.43 20.57 12 17 15.57 8.43 7 12 3.43 10.57 2 9.14 3.43 7.71 2 5.57 4.14 4.14 2.71 2.71 4.14l1.43 1.43L2 7.71l1.43 1.43L2 10.57 3.43 12 7 8.43 15.57 17 12 20.57 13.43 22l1.43-1.43L16.29 22l2.14-2.14 1.43 1.43 1.43-1.43-1.43-1.43L22 16.29z"/>
            </svg>
            @break

        @case('gadget')
        @case('technology')
            {{-- Смарт-часы --}}
            <svg class="w-32 h-32 md:w-40 md:h-40 text-white" fill="currentColor" viewBox="0 0 24 24">
                <path d="M20 12c0-2.54-1.19-4.81-3.04-6.27L16 0H8l-.95 5.73C5.19 7.19 4 9.45 4 12s1.19 4.81 3.05 6.27L8 24h8l.96-5.73C18.81 16.81 20 14.54 20 12zM6 12c0-3.31 2.69-6 6-6s6 2.69 6 6-2.69 6-6 6-6-2.69-6-6z"/>
            </svg>
            @break

        @case('glucometer')
            {{-- Глюкометр --}}
            <svg class="w-32 h-32 md:w-40 md:h-40 text-white" fill="currentColor" viewBox="0 0 24 24">
                <path d="M19 3H5c-1.1 0-2 .9-2 2v14c0 1.1.9 2 2 2h14c1.1 0 2-.9 2-2V5c0-1.1-.9-2-2-2zm-7 14c-2.76 0-5-2.24-5-5s2.24-5 5-5 5 2.24 5 5-2.24 5-5 5z"/>
                <circle cx="12" cy="12" r="3"/>
            </svg>
            @break

        @case('medicine')
            {{-- Таблетка --}}
            <svg class="w-32 h-32 md:w-40 md:h-40 text-white" fill="currentColor" viewBox="0 0 24 24">
                <path d="M4.22 11.29l7.07-7.07c.78-.78 2.05-.78 2.83 0L19.78 9.9c.78.78.78 2.05 0 2.83l-7.07 7.07c-.78.78-2.05.78-2.83 0L4.22 14.12c-.78-.78-.78-2.05 0-2.83zM13 9c-.55 0-1 .45-1 1s.45 1 1 1 1-.45 1-1-.45-1-1-1zm-2 2c-.55 0-1 .45-1 1s.45 1 1 1 1-.45 1-1-.45-1-1-1z"/>
            </svg>
            @break

        @case('insulin')
            {{-- Шприц --}}
            <svg class="w-32 h-32 md:w-40 md:h-40 text-white" fill="currentColor" viewBox="0 0 24 24">
                <path d="M17 3v2h-2v1h2v2l2-2.5L17 3zm-4 1H6c-.55 0-1 .45-1 1v3c0 .55.45 1 1 1h1v9l1 2h2l1-2V9h1c.55 0 1-.45 1-1V5c0-.55-.45-1-1-1zm-2 12h-2v-2h2v2zm0-4h-2V8h2v4z"/>
            </svg>
            @break

        @case('health')
            {{-- Сердце с пульсом --}}
            <svg class="w-32 h-32 md:w-40 md:h-40 text-white" fill="currentColor" viewBox="0 0 24 24">
                <path d="M16.5 3c-1.74 0-3.41.81-4.5 2.09C10.91 3.81 9.24 3 7.5 3 4.42 3 2 5.42 2 8.5c0 3.78 3.4 6.86 8.55 11.54L12 21.35l1.45-1.32C18.6 15.36 22 12.28 22 8.5 22 5.42 19.58 3 16.5 3zm-4.4 15.55l-.1.1-.1-.1C7.14 14.24 4 11.39 4 8.5 4 6.5 5.5 5 7.5 5c1.54 0 3.04.99 3.57 2.36h1.87C13.46 5.99 14.96 5 16.5 5c2 0 3.5 1.5 3.5 3.5 0 2.89-3.14 5.74-7.9 10.05z"/>
            </svg>
            @break

        @case('prevention')
            {{-- Щит --}}
            <svg class="w-32 h-32 md:w-40 md:h-40 text-white" fill="currentColor" viewBox="0 0 24 24">
                <path d="M12 1L3 5v6c0 5.55 3.84 10.74 9 12 5.16-1.26 9-6.45 9-12V5l-9-4zm-2 16l-4-4 1.41-1.41L10 14.17l6.59-6.59L18 9l-8 8z"/>
            </svg>
            @break

        @default
            {{-- Книга (по умолчанию) --}}
            <svg class="w-32 h-32 md:w-40 md:h-40 text-white" fill="currentColor" viewBox="0 0 24 24">
                <path d="M18 2H6c-1.1 0-2 .9-2 2v16c0 1.1.9 2 2 2h12c1.1 0 2-.9 2-2V4c0-1.1-.9-2-2-2zM6 4h5v8l-2.5-1.5L6 12V4z"/>
            </svg>
    @endswitch
</div>
