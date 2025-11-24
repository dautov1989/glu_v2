<header x-data="{ open: false }" class="sticky top-0 z-50 w-full bg-white/90 backdrop-blur-md dark:bg-zinc-900/90 border-b border-zinc-200/50 dark:border-zinc-800/50 shadow-lg shadow-zinc-200/50 dark:shadow-zinc-900/50 transition-all duration-300">
    <div class="max-w-7xl mx-auto px-4 sm:px-6 lg:px-8">
        <div class="flex justify-between items-center h-20 gap-x-8">
            <!-- Logo -->
            <div class="flex-shrink-0 flex items-center">
                <a href="{{ route('home') }}" class="flex items-center gap-2 group">
                    <div class="bg-red-500 rounded-full p-1.5 text-white shadow-md shadow-red-500/30 group-hover:scale-110 transition-transform duration-300">
                        <svg xmlns="http://www.w3.org/2000/svg" viewBox="0 0 24 24" fill="currentColor" class="size-5">
                            <path d="M11.25 4.533A9.707 9.707 0 0 0 6 3a9.735 9.735 0 0 0-3.25.555.75.75 0 0 0-.5.516l-1.432 3.26a5.25 5.25 0 0 0 0 4.336l1.432 3.26a.75.75 0 0 0 .5.516H6c.536 0 1.064.034 1.582.1l-.012.025c-.15.312-.292.63-.426.95-.404.972-.726 2.005-.96 3.085a.75.75 0 0 0 .659.897 7.5 7.5 0 0 0 7.208-4.816A7.5 7.5 0 0 0 21.75 12a9.716 9.716 0 0 0-4.233-8.179.75.75 0 0 0-.815 1.161 8.216 8.216 0 0 1 3.548 7.018 6 6 0 0 1-11.52 1.98.75.75 0 0 0-1.5-.03 7.502 7.502 0 0 0-3.18 5.819 7.99 7.99 0 0 1-2.948-4.964 3.75 3.75 0 0 1 0-3.098 7.99 7.99 0 0 1 2.948-4.964A8.25 8.25 0 0 1 6 4.5c.693 0 1.366.09 2.007.259a.75.75 0 0 0 .848-.66c.096-.548.23-1.08.4-1.595.166-.51.382-1.003.64-1.471a.75.75 0 0 0-.645-1.133Z" />
                        </svg>
                    </div>
                    <span class="text-2xl font-bold tracking-tight text-zinc-800 dark:text-white">
                        Glucosa
                    </span>
                </a>
            </div>

            <!-- Navigation -->
            <nav class="hidden lg:flex items-center gap-1">
                @php
                    $navItems = [
                        ['label' => 'Home', 'href' => '#', 'active' => true],
                        ['label' => 'Doctors', 'href' => '#', 'active' => false],
                        ['label' => 'News', 'href' => '#', 'active' => false],
                        ['label' => 'Services', 'href' => '#', 'active' => false],
                        ['label' => 'Gallery', 'href' => '#', 'active' => false],
                        ['label' => 'Shop', 'href' => '#', 'active' => false],
                        ['label' => 'Pages', 'href' => '#', 'active' => false],
                        ['label' => 'Contact', 'href' => '#', 'active' => false],
                    ];
                @endphp

                @foreach($navItems as $item)
                    <a href="{{ $item['href'] }}"
                       class="px-4 py-2 text-sm font-medium rounded-full transition-all duration-300
                       {{ $item['active']
                            ? 'bg-cyan-50 text-cyan-600 dark:bg-cyan-900/30 dark:text-cyan-400'
                            : 'text-zinc-600 hover:text-cyan-600 hover:bg-zinc-50 dark:text-zinc-400 dark:hover:text-white dark:hover:bg-zinc-800'
                       }}">
                        {{ $item['label'] }}
                    </a>
                @endforeach
                
                <!-- Appointment Button (Distinct) -->
                 <a href="#" class="ml-4 px-6 py-2.5 text-sm font-semibold text-white bg-cyan-500 hover:bg-cyan-600 rounded-full shadow-lg shadow-cyan-500/30 hover:shadow-cyan-500/50 transform hover:-translate-y-0.5 transition-all duration-300 flex items-center gap-2">
                    <span>Appointment</span>
                    <svg xmlns="http://www.w3.org/2000/svg" viewBox="0 0 20 20" fill="currentColor" class="w-4 h-4">
                      <path fill-rule="evenodd" d="M3 3.5A1.5 1.5 0 0 1 4.5 2h6.879a1.5 1.5 0 0 1 1.06.44l4.122 4.12A1.5 1.5 0 0 1 17 7.622V16.5a1.5 1.5 0 0 1-1.5 1.5h-11A1.5 1.5 0 0 1 3 16.5v-13Zm10.857 5.691a.75.75 0 0 0-1.214-.882l-3.483 4.79-1.88-1.88a.75.75 0 1 0-1.06 1.061l2.5 2.5a.75.75 0 0 0 1.137-.089l4-5.5Z" clip-rule="evenodd" />
                    </svg>
                </a>
            </nav>

            <!-- Mobile menu button -->
            <div class="lg:hidden flex items-center">
                <button type="button" 
                        @click="open = !open"
                        class="p-2 rounded-full text-zinc-500 hover:text-cyan-600 hover:bg-cyan-50 dark:hover:bg-zinc-800 transition-colors focus:outline-none focus:ring-2 focus:ring-inset focus:ring-cyan-500">
                    <span class="sr-only">Open menu</span>
                    <!-- Icon when menu is closed -->
                    <svg x-show="!open" class="h-6 w-6" fill="none" viewBox="0 0 24 24" stroke-width="1.5" stroke="currentColor" aria-hidden="true">
                        <path stroke-linecap="round" stroke-linejoin="round" d="M3.75 6.75h16.5M3.75 12h16.5m-16.5 5.25h16.5" />
                    </svg>
                    <!-- Icon when menu is open -->
                     <svg x-show="open" x-cloak class="h-6 w-6" fill="none" viewBox="0 0 24 24" stroke-width="1.5" stroke="currentColor" aria-hidden="true">
                        <path stroke-linecap="round" stroke-linejoin="round" d="M6 18L18 6M6 6l12 12" />
                    </svg>
                </button>
            </div>
        </div>
    </div>

    <!-- Mobile menu, show/hide based on menu state. -->
    <div x-show="open" 
         x-transition:enter="transition ease-out duration-200"
         x-transition:enter-start="opacity-0 -translate-y-2"
         x-transition:enter-end="opacity-100 translate-y-0"
         x-transition:leave="transition ease-in duration-150"
         x-transition:leave-start="opacity-100 translate-y-0"
         x-transition:leave-end="opacity-0 -translate-y-2"
         class="lg:hidden border-t border-zinc-200 dark:border-zinc-800 bg-white dark:bg-zinc-900" 
         id="mobile-menu">
        <div class="space-y-1 px-4 pb-3 pt-2">
            @foreach($navItems as $item)
                <a href="{{ $item['href'] }}"
                   class="block px-3 py-2 text-base font-medium rounded-md transition-colors
                   {{ $item['active']
                        ? 'bg-cyan-50 text-cyan-600 dark:bg-cyan-900/30 dark:text-cyan-400'
                        : 'text-zinc-600 hover:text-cyan-600 hover:bg-zinc-50 dark:text-zinc-400 dark:hover:text-white dark:hover:bg-zinc-800'
                   }}">
                    {{ $item['label'] }}
                </a>
            @endforeach
             <a href="#" class="mt-4 block w-full text-center px-6 py-3 text-base font-semibold text-white bg-cyan-500 hover:bg-cyan-600 rounded-full shadow-lg shadow-cyan-500/30 transition-all duration-300">
                Appointment
            </a>
        </div>
    </div>
</header>
