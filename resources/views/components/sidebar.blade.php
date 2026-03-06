<aside
    x-data="sidebar()"
    x-init="init()"
    @toggle-sidebar.window="toggle()"
    :class="[
        isOpen ? 'translate-x-0' : '-translate-x-full',
        'lg:translate-x-0',
        collapsed ? 'w-20' : 'w-72'
    ]"
    class="fixed lg:sticky top-0 z-50 h-screen bg-gradient-to-b from-slate-900 via-slate-800 to-slate-900 text-white transition-all duration-300 ease-in-out flex flex-col shadow-2xl"
>
    <!-- Header -->
    <div class="h-20 flex items-center justify-between px-4 border-b border-white/10 bg-gradient-to-r from-slate-800/50 to-slate-900/50">
        <!-- Logo -->
        <div class="flex items-center gap-3 overflow-hidden">
            <div class="w-12 h-12 bg-gradient-to-br from-emerald-400 to-teal-600 rounded-2xl flex items-center justify-center flex-shrink-0">
                <span class="text-2xl">🏥</span>
            </div>
            <div x-show="!collapsed" x-collapse class="flex flex-col">
                <span class="font-bold text-lg whitespace-nowrap">مستشفى </span>
                <span class="text-xs text-slate-400">نظام إدارة المستشفى</span>
            </div>
        </div>

        <!-- Close Button (Mobile Only) -->
        <button @click="isOpen = false" class="lg:hidden w-8 h-8 flex items-center justify-center rounded-lg hover:bg-white/10">
            <svg class="w-5 h-5" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M6 18L18 6M6 6l12 12"/>
            </svg>
        </button>

        <!-- Collapse Button (Desktop Only) -->
        <button @click="toggleCollapse()" class="hidden lg:flex w-10 h-10 items-center justify-center rounded-xl bg-white/5 hover:bg-white/10">
            <svg x-show="!collapsed" class="w-5 h-5 text-slate-400" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M11 19l-7-7 7-7m8 14l-7-7 7-7"/>
            </svg>
            <svg x-show="collapsed" x-cloak class="w-5 h-5 text-slate-400" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M13 5l7 7-7 7M5 5l7 7-7 7"/>
            </svg>
        </button>
    </div>

    <!-- Navigation -->
    <nav class="flex-1 overflow-y-auto py-4 px-3">
        @include('layouts.navigation')
    </nav>

    <div class="p-4 border-t border-white/10 bg-gradient-to-r from-slate-800/50 to-slate-900/50">
        <div x-show="!collapsed" x-collapse class="flex items-center gap-3 p-3 rounded-2xl bg-white/5">
            <div class="w-12 h-12 bg-gradient-to-br from-blue-500 to-indigo-600 rounded-xl flex items-center justify-center">
                <span class="text-lg font-bold">{{ substr(auth()->user()->name, 0, 1) }}</span>
            </div>
            <div class="flex-1 min-w-0">
                <p class="text-sm font-semibold truncate">{{ auth()->user()->name }}</p>
                <p class="text-xs text-slate-400 truncate">{{ auth()->user()->getRoleNames()->first() }}</p>
            </div>
            <form method="POST" action="{{ route('logout') }}">
                @csrf
                <button type="submit" class="p-2 rounded-lg hover:bg-red-500/20 text-slate-400 hover:text-red-400">
                    <svg class="w-5 h-5" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M17 16l4-4m0 0l-4-4m4 4H7m6 4v1a3 3 0 01-3 3H6a3 3 0 01-3-3V7a3 3 0 013-3h4a3 3 0 013 3v1"/>
                    </svg>
                </button>
            </form>
        </div>
        <div x-show="collapsed" x-cloak class="flex justify-center">
            <div class="w-12 h-12 bg-gradient-to-br from-blue-500 to-indigo-600 rounded-xl flex items-center justify-center">
                <span class="text-lg font-bold">{{ substr(auth()->user()->name, 0, 1) }}</span>
            </div>
        </div>
    </div>
</aside>

<!-- Mobile Overlay -->
<div
    x-show="isOpen"
    x-transition:enter="transition ease-out duration-300"
    x-transition:enter-start="opacity-0"
    x-transition:enter-end="opacity-100"
    x-transition:leave="transition ease-in duration-200"
    x-transition:leave-start="opacity-100"
    x-transition:leave-end="opacity-0"
    @click="isOpen = false"
    class="fixed inset-0 bg-black/50 z-40 lg:hidden"
    x-cloak
></div>

<script>
function sidebar() {
    return {
        isOpen: false,
        collapsed: localStorage.getItem('sidebarCollapsed') === 'true',

        init() {
            this.$watch('collapsed', value => localStorage.setItem('sidebarCollapsed', value));

            // Auto-close on route change (mobile)
            window.addEventListener('popstate', () => {
                this.isOpen = false;
            });
        },

        toggle() {
            this.isOpen = !this.isOpen;
        },

        toggleCollapse() {
            this.collapsed = !this.collapsed;
        },

        closeOnMobile() {
            // Close sidebar on mobile when clicking a link
            if (window.innerWidth < 1024) {
                this.isOpen = false;
            }
        }
    }
}

function navigation() {
    return {
        collapsed: false,

        init() {
            // Watch for sidebar collapse state changes
            const sidebar = this.$el.closest('aside');
            if (sidebar && sidebar.__x) {
                this.collapsed = sidebar.__x.$data.collapsed;
                this.$watch('collapsed', () => {
                    if (sidebar && sidebar.__x) {
                        sidebar.__x.$data.collapsed = this.collapsed;
                    }
                });
            }
        },

        handleLinkClick(event) {
            // Check if a link was clicked
            const link = event.target.closest('a');
            if (link) {
                // Get the sidebar component and close on mobile
                const sidebar = this.$el.closest('aside');
                if (sidebar && sidebar.__x && sidebar.__x.$data) {
                    sidebar.__x.$data.closeOnMobile();
                }
            }
        }
    }
}
</script>


