<aside
    x-data="sidebar()"
    x-init="init()"
    @toggle-sidebar.window="toggle()"
    :class="{
        'translate-x-0': open,
        '-translate-x-full md:translate-x-0': !open,
        'w-72': !collapsed,
        'w-20': collapsed
    }"
    class="fixed md:relative z-50 h-screen bg-gradient-to-b from-slate-900 via-slate-800 to-slate-900 text-white transform transition-all duration-300 ease-in-out flex flex-col shadow-2xl"
>
    <!-- Sidebar Header -->
    <div class="h-20 flex items-center justify-between px-4 border-b border-white/10 bg-gradient-to-r from-slate-800/50 to-slate-900/50 backdrop-blur-sm">
        <!-- Logo -->
        <div class="flex items-center gap-3 overflow-hidden">
            <div class="w-12 h-12 bg-gradient-to-br from-emerald-400 to-teal-600 rounded-2xl flex items-center justify-center flex-shrink-0 shadow-lg shadow-emerald-500/20">
                <span class="text-2xl">🏥</span>
            </div>
            <div x-show="!collapsed" x-transition.duration.300ms class="flex flex-col">
                <span class="font-bold text-lg whitespace-nowrap bg-gradient-to-r from-white to-slate-300 bg-clip-text text-transparent">
                    مستشفى的上
                </span>
                <span class="text-xs text-slate-400 whitespace-nowrap">نظام إدارة المستشفى</span>
            </div>
        </div>

        <!-- Mobile Close Button -->
        <button
            @click="open = false"
            class="md:hidden w-8 h-8 flex items-center justify-center rounded-lg hover:bg-white/10 transition-colors"
        >
            <svg class="w-5 h-5" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M6 18L18 6M6 6l12 12"/>
            </svg>
        </button>

        <!-- Collapse Button -->
        <button
            @click="toggleCollapse()"
            class="hidden md:flex w-10 h-10 items-center justify-center rounded-xl bg-white/5 hover:bg-white/10 transition-all duration-200 hover:scale-105"
        >
            <svg x-show="!collapsed" class="w-5 h-5 text-slate-400" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M11 19l-7-7 7-7m8 14l-7-7 7-7"/>
            </svg>
            <svg x-show="collapsed" x-transition.duration.300ms class="w-5 h-5 text-slate-400" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M13 5l7 7-7 7M5 5l7 7-7 7"/>
            </svg>
        </button>
    </div>

    <!-- Navigation Links -->
    <nav class="flex-1 overflow-y-auto py-4 px-3 space-y-1" x-data="{ get isCollapsed() { return this.$el.closest('aside').__x.$data.collapsed } }">
        @include('layouts.navigation')
    </nav>

    <!-- Sidebar Footer -->
    <div class="p-4 border-t border-white/10 bg-gradient-to-r from-slate-800/50 to-slate-900/50 backdrop-blur-sm">
        <div x-show="!collapsed" x-transition.duration.300ms class="flex items-center gap-3 p-3 rounded-2xl bg-white/5">
            <div class="w-12 h-12 bg-gradient-to-br from-blue-500 to-indigo-600 rounded-xl flex items-center justify-center shadow-lg shadow-blue-500/20">
                <span class="text-lg font-bold">{{ substr(auth()->user()->name, 0, 1) }}</span>
            </div>
            <div class="flex-1 min-w-0">
                <p class="text-sm font-semibold truncate">{{ auth()->user()->name }}</p>
                <p class="text-xs text-slate-400 truncate">{{ auth()->user()->getRoleNames()->first() }}</p>
            </div>
            <form method="POST" action="{{ route('logout') }}">
                @csrf
                <button type="submit" class="p-2 rounded-lg hover:bg-red-500/20 text-slate-400 hover:text-red-400 transition-colors">
                    <svg class="w-5 h-5" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M17 16l4-4m0 0l-4-4m4 4H7m6 4v1a3 3 0 01-3 3H6a3 3 0 01-3-3V7a3 3 0 013-3h4a3 3 0 013 3v1"/>
                    </svg>
                </button>
            </form>
        </div>

        <div x-show="collapsed" x-transition.duration.300ms class="flex flex-col items-center gap-2">
            <div class="w-12 h-12 bg-gradient-to-br from-blue-500 to-indigo-600 rounded-xl flex items-center justify-center shadow-lg">
                <span class="text-lg font-bold">{{ substr(auth()->user()->name, 0, 1) }}</span>
            </div>
        </div>
    </div>
</aside>

<script>
function sidebar() {
    return {
        open: false,
        collapsed: localStorage.getItem('sidebarCollapsed') === 'true',

        init() {
            this.$watch('collapsed', (value) => {
                localStorage.setItem('sidebarCollapsed', value);
            });
        },

        toggle() {
            this.open = !this.open;
        },

        toggleCollapse() {
            this.collapsed = !this.collapsed;
        }
    }
}
</script>


