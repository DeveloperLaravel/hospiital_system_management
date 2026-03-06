<aside
    :class="{
        'translate-x-0': sidebarOpen,
        '-translate-x-full md:translate-x-0': !sidebarOpen,
        'w-64': !sidebarCollapsed,
        'w-20': sidebarCollapsed
    }"
    class="fixed md:relative z-50 bg-gradient-to-b from-blue-900 via-blue-800 to-blue-900
           text-white h-full transform transition-all duration-300 ease-in-out
           flex flex-col shadow-2xl"
>
    <!-- Sidebar Header -->
    <div class="h-16 flex items-center justify-between px-4 border-b border-white/10 bg-white/5">
        <!-- Logo -->
        <div class="flex items-center gap-3 overflow-hidden">
            <div class="w-10 h-10 bg-white/10 rounded-xl flex items-center justify-center flex-shrink-0">
                <span class="text-2xl">🏥</span>
            </div>
            <span x-show="!sidebarCollapsed" class="font-bold text-lg whitespace-nowrap">
                مستشفى的上
            </span>
        </div>

        <!-- Collapse Button -->
        <button
            @click="sidebarCollapsed = !sidebarCollapsed"
            class="hidden md:flex w-8 h-8 items-center justify-center rounded-lg
                   hover:bg-white/10 transition-colors"
        >
            <svg x-show="!sidebarCollapsed" class="w-5 h-5" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M11 19l-7-7 7-7m8 14l-7-7 7-7"/>
            </svg>
            <svg x-show="sidebarCollapsed" class="w-5 h-5" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M13 5l7 7-7 7M5 5l7 7-7 7"/>
            </svg>
        </button>
    </div>

    <!-- Navigation Links -->
    <nav class="flex-1 overflow-y-auto py-4 px-3 space-y-1">
        @include('layouts.navigation')
    </nav>

    <!-- Sidebar Footer -->
    <div class="p-4 border-t border-white/10 bg-white/5">
        <div x-show="!sidebarCollapsed" class="flex items-center gap-3">
            <div class="w-10 h-10 bg-blue-600 rounded-full flex items-center justify-center">
                <span class="text-sm font-bold">{{ substr(auth()->user()->name, 0, 1) }}</span>
            </div>
            <div class="flex-1 min-w-0">
                <p class="text-sm font-medium truncate">{{ auth()->user()->name }}</p>
                <p class="text-xs text-white/60 truncate">{{ auth()->user()->getRoleNames()->first() }}</p>
            </div>
        <div x-show="sidebarCollapsed" class="flex justify-center">
            <div class="w-10 h-10 bg-blue-600 rounded-full flex items-center justify-center">
                <span class="text-sm font-bold">{{ substr(auth()->user()->name, 0, 1) }}</span>
            </div>
    </div>
</aside>
