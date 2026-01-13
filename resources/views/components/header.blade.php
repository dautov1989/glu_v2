<header x-data="{ 
    openCategory: null, 
    mobileOpen: false, 
    toggleCategory(id) {
        if (this.openCategory === id) {
            this.openCategory = null;
        } else {
            this.openCategory = id;
        }
    },
    closeMenu() {
        this.openCategory = null;
    },
    megaMenu: @js($megaMenuCategories ?? [])
}" @click.outside="closeMenu"
    class="sticky top-0 z-50 w-full bg-gradient-to-r from-white via-cyan-50/30 to-white dark:from-zinc-900 dark:via-cyan-950/20 dark:to-zinc-900 backdrop-blur-md border-b border-cyan-200/50 dark:border-cyan-800/50 shadow-md shadow-cyan-200/20 dark:shadow-cyan-900/10 transition-all duration-300">
    <div class="max-w-7xl mx-auto px-4 sm:px-6 lg:px-8">
        <div class="flex justify-between items-center h-20 gap-x-8">
            <!-- Logo -->
            <div class="flex-shrink-0 flex items-center">
                <a href="{{ route('home') }}" class="flex items-center gap-3 group relative">
                    <!-- Icon Container with animations -->
                    <div class="relative">
                        <!-- Animated pulsing glow - always active -->
                        <div
                            class="absolute -inset-2 bg-gradient-to-r from-cyan-500 via-blue-500 to-teal-500 group-hover:from-purple-500 group-hover:via-pink-500 group-hover:to-rose-500 rounded-full blur-md opacity-50 animate-pulse transition-all duration-500">
                        </div>

                        <!-- Rotating glow - always active -->
                        <div class="absolute -inset-1.5 bg-gradient-to-r from-cyan-400 to-blue-600 group-hover:from-purple-400 group-hover:to-pink-600 rounded-full blur opacity-40 animate-spin transition-all duration-500"
                            style="animation-duration: 3s;"></div>

                        <!-- Icon background with gradient -->
                        <div
                            class="relative bg-gradient-to-br from-cyan-500 via-blue-500 to-blue-600 group-hover:from-purple-500 group-hover:via-pink-500 group-hover:to-rose-600 rounded-full p-2 text-white shadow-xl shadow-cyan-500/50 group-hover:shadow-purple-500/60 transition-all duration-500 scale-100 group-hover:scale-110 rotate-0 group-hover:rotate-12">
                            <!-- Icon with animation -->
                            <svg xmlns="http://www.w3.org/2000/svg" viewBox="0 0 24 24" fill="currentColor"
                                class="w-6 h-6 transition-transform duration-300 group-hover:scale-110">
                                <path
                                    d="M11.25 4.533A9.707 9.707 0 0 0 6 3a9.735 9.735 0 0 0-3.25.555.75.75 0 0 0-.5.516l-1.432 3.26a5.25 5.25 0 0 0 0 4.336l1.432 3.26a.75.75 0 0 0 .5.516H6c.536 0 1.064.034 1.582.1l-.012.025c-.15.312-.292.63-.426.95-.404.972-.726 2.005-.96 3.085a.75.75 0 0 0 .659.897 7.5 7.5 0 0 0 7.208-4.816A7.5 7.5 0 0 0 21.75 12a9.716 9.716 0 0 0-4.233-8.179.75.75 0 0 0-.815 1.161 8.216 8.216 0 0 1 3.548 7.018 6 6 0 0 1-11.52 1.98.75.75 0 0 0-1.5-.03 7.502 7.502 0 0 0-3.18 5.819 7.99 7.99 0 0 1-2.948-4.964 3.75 3.75 0 0 1 0-3.098 7.99 7.99 0 0 1 2.948-4.964A8.25 8.25 0 0 1 6 4.5c.693 0 1.366.09 2.007.259a.75.75 0 0 0 .848-.66c.096-.548.23-1.08.4-1.595.166-.51.382-1.003.64-1.471a.75.75 0 0 0-.645-1.133Z" />
                            </svg>

                            <!-- Sparkle effect - always visible -->
                            <div
                                class="absolute top-0 right-0 w-2 h-2 bg-white rounded-full opacity-70 group-hover:opacity-100 animate-ping transition-opacity">
                            </div>
                        </div>
                    </div>

                    <!-- Text with gradient animation - always animated -->
                    <div class="relative overflow-hidden">
                        <span
                            class="text-2xl font-bold tracking-tight bg-gradient-to-r from-cyan-600 via-blue-600 to-cyan-600 group-hover:from-purple-600 group-hover:via-pink-600 group-hover:to-purple-600 dark:from-cyan-400 dark:via-blue-400 dark:to-cyan-400 dark:group-hover:from-purple-400 dark:group-hover:via-pink-400 dark:group-hover:to-purple-400 bg-clip-text text-transparent bg-[length:200%_100%] animate-gradient transition-all duration-500 group-hover:tracking-wide">
                            Glucosa
                        </span>

                        <!-- Underline effect - always visible, changes color on hover -->
                        <div
                            class="absolute bottom-0 left-0 h-0.5 w-full bg-gradient-to-r from-cyan-500 to-blue-500 group-hover:from-purple-500 group-hover:to-pink-500 transition-all duration-500 ease-out">
                        </div>
                    </div>

                    <!-- Floating particles effect - always visible -->
                    <div class="absolute -top-1 -right-1 w-1 h-1 bg-cyan-400 group-hover:bg-purple-400 rounded-full opacity-70 animate-bounce transition-colors duration-500"
                        style="animation-delay: 0.1s;"></div>
                    <div class="absolute top-1 -right-2 w-1.5 h-1.5 bg-blue-400 group-hover:bg-pink-400 rounded-full opacity-70 animate-bounce transition-colors duration-500"
                        style="animation-delay: 0.3s;"></div>
                </a>
            </div>

            <style>
                @keyframes gradient {

                    0%,
                    100% {
                        background-position: 0% 50%;
                    }

                    50% {
                        background-position: 100% 50%;
                    }
                }

                .animate-gradient {
                    animation: gradient 3s ease infinite;
                }
            </style>

            <!-- Navigation -->
            <nav class="hidden lg:flex items-center gap-4">
                <template x-for="category in megaMenu" :key="category.id">
                    <div class="relative">
                        <button @click="toggleCategory(category.id)"
                            class="relative px-4 py-2.5 text-base font-semibold rounded-xl transition-all duration-300 flex items-center gap-2 group"
                            :class="{ 
                                    'bg-gradient-to-r from-cyan-500 to-blue-500 text-white shadow-lg shadow-cyan-500/40 hover:shadow-cyan-500/60 scale-105': openCategory === category.id,
                                    'bg-gradient-to-r from-white to-cyan-50/50 dark:from-zinc-800 dark:to-cyan-950/30 text-zinc-700 dark:text-zinc-300 border border-cyan-200/30 dark:border-cyan-800/30 shadow-sm shadow-cyan-200/20 dark:shadow-cyan-900/10 hover:from-cyan-50 hover:to-blue-50 hover:text-cyan-600 dark:hover:from-cyan-900/30 dark:hover:to-blue-900/30 dark:hover:text-cyan-400 hover:border-cyan-300 dark:hover:border-cyan-700 hover:shadow-md hover:shadow-cyan-300/30 dark:hover:shadow-cyan-800/20 hover:scale-105': openCategory !== category.id
                                }">
                            <!-- Subtle glow effect for inactive state -->
                            <div x-show="openCategory !== category.id"
                                class="absolute inset-0 bg-gradient-to-r from-cyan-400/0 via-cyan-400/5 to-blue-400/0 rounded-xl opacity-0 group-hover:opacity-100 transition-opacity duration-300">
                            </div>

                            <span class="relative z-10" x-text="category.label"></span>
                            <svg xmlns="http://www.w3.org/2000/svg" fill="none" viewBox="0 0 24 24" stroke-width="2"
                                stroke="currentColor" class="relative z-10 w-4 h-4 transition-transform duration-200"
                                :class="{ 'rotate-180': openCategory === category.id }">
                                <path stroke-linecap="round" stroke-linejoin="round" d="m19.5 8.25-7.5 7.5-7.5-7.5" />
                            </svg>
                        </button>



                        <!-- Mega Menu Dropdown -->
                        <div x-show="openCategory === category.id" x-cloak
                            x-transition:enter="transition ease-out duration-200"
                            x-transition:enter-start="opacity-0 translate-y-1"
                            x-transition:enter-end="opacity-100 translate-y-0"
                            x-transition:leave="transition ease-in duration-150"
                            x-transition:leave-start="opacity-100 translate-y-0"
                            x-transition:leave-end="opacity-0 translate-y-1"
                            class="fixed left-0 right-0 top-[80px] mx-auto max-w-7xl px-4 sm:px-6 lg:px-8 z-50">

                            <!-- Backdrop blur effect -->
                            <div class="relative">
                                <div
                                    class="absolute -inset-2 bg-gradient-to-r from-cyan-500/10 via-blue-500/10 to-teal-500/10 rounded-2xl blur-xl">
                                </div>

                                <div
                                    class="relative bg-white dark:bg-zinc-900 rounded-2xl shadow-2xl shadow-cyan-500/20 dark:shadow-cyan-900/40 border border-cyan-200/50 dark:border-cyan-800/50 overflow-hidden">

                                    <div class="p-8">
                                        <!-- Header with gradient - centered -->


                                        <div class="grid grid-cols-4 gap-6">
                                            <template x-for="subSection in category.children" :key="subSection.label">
                                                <div class="group space-y-4">
                                                    <!-- Level 2 Header - simplified hover -->
                                                    <div
                                                        class="pb-3 border-b border-cyan-200/50 dark:border-cyan-700/50">
                                                        <h3 class="text-sm font-bold uppercase tracking-wider text-cyan-700 dark:text-cyan-300 relative inline-block"
                                                            x-text="subSection.label">
                                                        </h3>
                                                        <!-- Simple underline on hover -->
                                                        <div
                                                            class="h-0.5 w-0 bg-gradient-to-r from-cyan-500 to-blue-500 group-hover:w-full transition-all duration-300 mt-1">
                                                        </div>
                                                    </div>

                                                    <!-- Level 3 & 4 List -->
                                                    <ul class="space-y-2.5">
                                                        <template x-for="type in subSection.children" :key="type.label">
                                                            <li>
                                                                <a :href="type.url || '#'"
                                                                    class="text-sm font-semibold text-cyan-600 dark:text-cyan-400 hover:text-blue-600 dark:hover:text-blue-400 transition-colors block"
                                                                    x-text="type.label"></a>
                                                                <!-- Level 4 -->
                                                                <ul class="pl-4 mt-1.5 space-y-1">
                                                                    <template x-for="detail in type.children"
                                                                        :key="detail.label">
                                                                        <li>
                                                                            <a :href="detail.url || '#'"
                                                                                class="text-xs text-zinc-600 dark:text-zinc-400 hover:text-cyan-600 dark:hover:text-cyan-400 transition-colors block py-0.5"
                                                                                x-text="detail.label"></a>
                                                                        </li>
                                                                    </template>
                                                                </ul>
                                                            </li>
                                                        </template>
                                                        <!-- If no children at level 3, just show empty state or nothing -->
                                                        <template
                                                            x-if="!subSection.children || subSection.children.length === 0">
                                                            <li class="text-xs text-zinc-400 italic">Нет подкатегорий
                                                            </li>
                                                        </template>
                                                    </ul>
                                                </div>
                                            </template>
                                        </div>
                                    </div>
                                </div>
                            </div>
                        </div>
                    </div>
                </template>
            </nav>

            <!-- Mobile menu button -->
            <div class="lg:hidden flex items-center">
                <button type="button" @click="mobileOpen = !mobileOpen"
                    class="group flex items-center gap-2 px-4 py-2 rounded-xl text-zinc-700 dark:text-zinc-300 bg-gradient-to-r from-cyan-50/80 to-blue-50/80 dark:from-zinc-800/80 dark:to-cyan-950/40 border border-cyan-200/50 dark:border-cyan-800/50 hover:border-cyan-400 dark:hover:border-cyan-600 shadow-sm shadow-cyan-200/20 dark:shadow-cyan-900/10 transition-all duration-300 focus:outline-none focus:ring-2 focus:ring-cyan-500/30">
                    <span
                        class="text-xs font-bold uppercase tracking-widest bg-gradient-to-r from-cyan-600 to-blue-600 dark:from-cyan-400 dark:to-blue-400 bg-clip-text text-transparent group-hover:from-cyan-500 group-hover:to-blue-500 transition-all"
                        x-text="mobileOpen ? 'Закрыть' : 'Категории'"></span>

                    <div class="relative w-5 h-5 flex items-center justify-center">
                        <!-- Chevron icon when closed -->
                        <svg x-show="!mobileOpen"
                            class="absolute inset-0 h-5 w-5 text-cyan-500 dark:text-cyan-400 transition-transform duration-300 group-hover:translate-y-0.5"
                            fill="none" viewBox="0 0 24 24" stroke-width="2.5" stroke="currentColor">
                            <path stroke-linecap="round" stroke-linejoin="round" d="m19.5 8.25-7.5 7.5-7.5-7.5" />
                        </svg>

                        <!-- Close icon when open -->
                        <svg x-show="mobileOpen" x-cloak
                            class="absolute inset-0 h-5 w-5 text-cyan-500 dark:text-cyan-400 transition-transform duration-300 rotate-0 group-hover:rotate-90"
                            fill="none" viewBox="0 0 24 24" stroke-width="2.5" stroke="currentColor">
                            <path stroke-linecap="round" stroke-linejoin="round" d="M6 18L18 6M6 6l12 12" />
                        </svg>
                    </div>
                </button>
            </div>
        </div>
    </div>

    <!-- Mobile menu -->
    <div x-show="mobileOpen" x-transition:enter="transition ease-out duration-200"
        x-transition:enter-start="opacity-0 -translate-y-2" x-transition:enter-end="opacity-100 translate-y-0"
        x-transition:leave="transition ease-in duration-150" x-transition:leave-start="opacity-100 translate-y-0"
        x-transition:leave-end="opacity-0 -translate-y-2"
        class="lg:hidden border-t border-zinc-200 dark:border-zinc-800 bg-white dark:bg-zinc-900" id="mobile-menu"
        x-data="{ openSubSection: null, openType: null }">
        <div class="space-y-1 px-4 pb-3 pt-2 max-h-[70vh] overflow-y-auto">
            <template x-for="category in megaMenu" :key="category.id">
                <div class="border-b border-zinc-100 dark:border-zinc-800 pb-2 mb-2">
                    <!-- Level 1: Category -->
                    <button @click="toggleCategory(category.id)"
                        class="w-full flex justify-between items-center px-3 py-2.5 text-base font-semibold rounded-lg transition-all"
                        :class="openCategory === category.id ? 'bg-gradient-to-r from-cyan-500 to-blue-500 text-white' : 'text-zinc-700 dark:text-zinc-300 hover:bg-cyan-50 dark:hover:bg-zinc-800'">
                        <span x-text="category.label"></span>
                        <svg xmlns="http://www.w3.org/2000/svg" fill="none" viewBox="0 0 24 24" stroke-width="2"
                            stroke="currentColor" class="w-4 h-4 transition-transform duration-200"
                            :class="{ 'rotate-180': openCategory === category.id }">
                            <path stroke-linecap="round" stroke-linejoin="round" d="m19.5 8.25-7.5 7.5-7.5-7.5" />
                        </svg>
                    </button>

                    <!-- Level 2: SubSections -->
                    <div x-show="openCategory === category.id" x-collapse class="mt-2 space-y-1">
                        <template x-for="subSection in category.children" :key="subSection.label">
                            <div class="ml-3">
                                <button
                                    @click="openSubSection = openSubSection === subSection.label ? null : subSection.label"
                                    class="w-full flex justify-between items-center px-3 py-2 text-sm font-bold text-cyan-700 dark:text-cyan-300 hover:bg-cyan-50 dark:hover:bg-cyan-900/20 rounded-lg transition-colors">
                                    <span x-text="subSection.label"></span>
                                    <svg xmlns="http://www.w3.org/2000/svg" fill="none" viewBox="0 0 24 24"
                                        stroke-width="2" stroke="currentColor"
                                        class="w-3 h-3 transition-transform duration-200"
                                        :class="{ 'rotate-180': openSubSection === subSection.label }">
                                        <path stroke-linecap="round" stroke-linejoin="round"
                                            d="m19.5 8.25-7.5 7.5-7.5-7.5" />
                                    </svg>
                                </button>

                                <!-- Level 3: Types -->
                                <div x-show="openSubSection === subSection.label" x-collapse
                                    class="mt-1 ml-3 space-y-1">
                                    <template x-for="type in subSection.children" :key="type.label">
                                        <div>
                                            <!-- Case 1: Has children -> Accordion Button -->
                                            <template x-if="type.children && type.children.length > 0">
                                                <div>
                                                    <button
                                                        @click="openType = openType === type.label ? null : type.label"
                                                        class="w-full flex justify-between items-center px-3 py-1.5 text-sm font-semibold text-cyan-600 dark:text-cyan-400 hover:text-blue-600 dark:hover:text-blue-400 transition-colors">
                                                        <span x-text="type.label"></span>
                                                        <svg xmlns="http://www.w3.org/2000/svg" fill="none"
                                                            viewBox="0 0 24 24" stroke-width="2" stroke="currentColor"
                                                            class="w-3 h-3 transition-transform duration-200"
                                                            :class="{ 'rotate-180': openType === type.label }">
                                                            <path stroke-linecap="round" stroke-linejoin="round"
                                                                d="m19.5 8.25-7.5 7.5-7.5-7.5" />
                                                        </svg>
                                                    </button>

                                                    <!-- Level 4: Details -->
                                                    <div x-show="openType === type.label" x-collapse
                                                        class="mt-1 ml-3 space-y-0.5">
                                                        <template x-for="detail in type.children" :key="detail.label">
                                                            <a :href="detail.url || '#'"
                                                                class="block px-3 py-1 text-xs text-zinc-600 dark:text-zinc-400 hover:text-cyan-600 dark:hover:text-cyan-400 transition-colors"
                                                                x-text="detail.label"></a>
                                                        </template>
                                                    </div>
                                                </div>
                                            </template>

                                            <!-- Case 2: No children -> Direct Link -->
                                            <template x-if="!type.children || type.children.length === 0">
                                                <a :href="type.url || '#'"
                                                    class="block w-full px-3 py-1.5 text-sm font-semibold text-cyan-600 dark:text-cyan-400 hover:text-blue-600 dark:hover:text-blue-400 transition-colors text-left">
                                                    <span x-text="type.label"></span>
                                                </a>
                                            </template>
                                        </div>
                                    </template>
                                </div>
                            </div>
                        </template>
                    </div>
                </div>
            </template>
        </div>
    </div>
</header>