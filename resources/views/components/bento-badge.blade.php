@props(['type' => null])

@if($type)
    @php
        $badgeStyles = [
            'top' => [
                'bg' => 'bg-gradient-to-r from-red-500 to-orange-500',
                'text' => '#ТОП',
                'glow' => 'shadow-lg shadow-red-500/50 dark:shadow-red-500/30',
                'animation' => 'animate-pulse'
            ],
            'popular' => [
                'bg' => 'bg-gradient-to-r from-blue-500 to-cyan-500',
                'text' => '#ПОПУЛЯРНОЕ',
                'glow' => 'shadow-md shadow-blue-500/30 dark:shadow-blue-500/20',
                'animation' => ''
            ],
            'new' => [
                'bg' => 'bg-gradient-to-r from-green-500 to-emerald-500',
                'text' => '#НОВОЕ',
                'glow' => 'shadow-md shadow-green-500/30 dark:shadow-green-500/20',
                'animation' => ''
            ]
        ];

        $badge = $badgeStyles[$type] ?? null;
    @endphp

    @if($badge)
        <div
            class="inline-flex items-center px-3 py-1 rounded-full text-white text-xs font-bold tracking-wide {{ $badge['bg'] }} {{ $badge['glow'] }} {{ $badge['animation'] }} transition-all duration-300">
            {{ $badge['text'] }}
        </div>
    @endif
@endif