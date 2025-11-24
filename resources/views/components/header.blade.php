<header class="w-full bg-white dark:bg-zinc-900 border-b border-zinc-200 dark:border-zinc-800">
    <div class="max-w-7xl mx-auto px-4 sm:px-6 lg:px-8">
        <div class="flex justify-between items-center h-20 gap-x-8">
            <!-- Logo -->
            <div class="flex-shrink-0 flex items-center">
                <a href="{{ route('home') }}" class="text-3xl font-bold tracking-tight text-zinc-800 dark:text-white group">
                    <span class="text-red-500 group-hover:text-red-600 transition-colors">G</span>lucosa
                </a>
            </div>

            <!-- Navigation -->
            <nav class="hidden lg:flex items-center space-x-1">
                @php
                    $navItems = [
                        ['label' => 'Home', 'href' => '#', 'active' => true],
                        ['label' => 'Doctors', 'href' => '#', 'active' => false],
                        ['label' => 'News', 'href' => '#', 'active' => false],
                        ['label' => 'Services', 'href' => '#', 'active' => false],
                        ['label' => 'Gallery', 'href' => '#', 'active' => false],
                        ['label' => 'Shop', 'href' => '#', 'active' => false],
                        ['label' => 'Pages', 'href' => '#', 'active' => false],
                        ['label' => 'Appointment', 'href' => '#', 'active' => false],
                        ['label' => 'Contact', 'href' => '#', 'active' => false],
                    ];
                @endphp

                @foreach($navItems as $item)
                    <a href="{{ $item['href'] }}"
                       class="px-4 py-2 text-sm font-medium rounded-md transition-all duration-200
                       {{ $item['active']
                            ? 'bg-cyan-400 text-white shadow-sm'
                            : 'text-zinc-500 hover:text-zinc-900 dark:text-zinc-400 dark:hover:text-white hover:bg-zinc-50 dark:hover:bg-zinc-800'
                       }}">
                        {{ $item['label'] }}
                    </a>
                @endforeach
            </nav>

            <!-- Mobile menu button placeholder -->
            <div class="lg:hidden flex items-center">
                <button type="button" class="p-2 rounded-md text-zinc-400 hover:text-zinc-500 hover:bg-zinc-100 dark:hover:bg-zinc-800 focus:outline-none focus:ring-2 focus:ring-inset focus:ring-cyan-500">
                    <span class="sr-only">Open menu</span>
                    <svg class="h-6 w-6" fill="none" viewBox="0 0 24 24" stroke-width="1.5" stroke="currentColor" aria-hidden="true">
                        <path stroke-linecap="round" stroke-linejoin="round" d="M3.75 6.75h16.5M3.75 12h16.5m-16.5 5.25h16.5" />
                    </svg>
                </button>
            </div>
        </div>
    </div>
</header>
