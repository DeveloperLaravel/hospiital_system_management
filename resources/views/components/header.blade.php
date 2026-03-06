<header class="bg-white border-b border-gray-200 shadow-sm">
    <div class="flex items-center justify-between h-16 px-4 md:px-6">

        <!-- Left Side -->
        <div class="flex items-center gap-4">
            <!-- Mobile Menu Button -->
            <button
                @click="sidebarOpen = true"
                class="md:hidden inline-flex items-center justify-center w-10 h-10
                       rounded-lg bg-blue-600 text-white hover:bg-blue-700
                       transition-colors"
            >
                <svg class="w-6 h-6" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M4 6h16M4 12h16M4 18h16"/>
                </svg>
            </button>

            <!-- Page Title -->
            <div>
                <h2 class="text-lg font-semibold text-gray-800">
                    {{ $pageTitle ?? 'لوحة التحكم' }}
                </h2>
            </div>

        <!-- Right Side -->
        <div class="flex items-center gap-3">
            <!-- User Info -->
            <div class="hidden sm:flex items-center gap-3 px-3 py-2 bg-gray-50 rounded-lg">
                <div class="w-8 h-8 bg-blue-600 rounded-full flex items-center justify-center">
                    <span class="text-xs font-bold text-white">{{ substr(auth()->user()->name, 0, 1) }}</span>
                </div>
                <div class="text-sm">
                    <p class="font-medium text-gray-700">{{ auth()->user()->name }}</p>
                    <p class="text-xs text-gray-500">{{ auth()->user()->getRoleNames()->first() }}</p>
                </div>

            <!-- Logout Button -->
            <form method="POST" action="{{ route('logout') }}">
                @csrf
                <button
                    type="submit"
                    class="inline-flex items-center gap-2 px-4 py-2 bg-red-500 text-white
                           rounded-lg hover:bg-red-600 transition-colors text-sm font-medium"
                >
                    <svg class="w-4 h-4" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
                              d="M17 16l4-4m0 0l-4-4m4 4H7m6 4v1a3 3 0 01-3 3H6a3 3 0 01-3-3V7a3 3 0 013-3h4a3 3 0 013 3v1"/>
                    </svg>
                    <span class="hidden sm:inline">خروج</span>
                </button>
            </form>
        </div>
</header>
