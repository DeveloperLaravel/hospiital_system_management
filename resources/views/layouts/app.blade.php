<!DOCTYPE html>
<html lang="{{ str_replace('_', '-', app()->getLocale()) }}">
    <head>
        <meta charset="utf-8">
        <meta name="viewport" content="width=device-width, initial-scale=1">
        <meta name="csrf-token" content="{{ csrf_token() }}">

        <title>{{ config('app.name', 'Laravel') }}</title>

        <!-- Fonts -->
        <link rel="preconnect" href="https://fonts.bunny.net">
        <link href="https://fonts.bunny.net/css?family=figtree:400,500,600&display=swap" rel="stylesheet" />
            <script src="https://cdn.jsdelivr.net/npm/alpinejs@3.x.x/dist/cdn.min.js" defer></script>

    @livewireStyles

        <!-- Scripts -->
        @vite(['resources/css/app.css', 'resources/js/app.js'])

    </head>
<body class="bg-gray-100 font-sans">

<div x-data="{ sidebarOpen: false, sidebarCollapsed: false }"
     class="flex h-screen overflow-hidden">

    <!-- Overlay للموبايل -->
    <div x-show="sidebarOpen"
         x-transition.opacity
         class="fixed inset-0 bg-black/40 z-20 md:hidden"
         @click="sidebarOpen = false">
    </div>

    <!-- Sidebar -->
    <aside
        :class="{
            'translate-x-0': sidebarOpen,
            '-translate-x-full': !sidebarOpen,
            'w-64': !sidebarCollapsed,
            'w-20': sidebarCollapsed
        }"
        class="fixed md:relative z-30 bg-blue-900 text-white h-full
               transform md:translate-x-0 transition-all duration-300
               flex flex-col"
    >

        <!-- Logo -->
        <div class="h-16 flex items-center justify-between px-4 border-b border-blue-700">
            <span x-show="!sidebarCollapsed" class="font-bold text-lg">
                🏥 إدارة المستشفى
            </span>

            <button
                @click="sidebarCollapsed = !sidebarCollapsed"
                class="hidden md:block"
            >
                ☰
            </button>
        </div>

        <!-- روابط -->
        @include('layouts.navigation')
    </aside>

    <!-- Main -->
    <div class="flex-1 flex flex-col overflow-hidden">

        <!-- Navbar -->
        <header class="bg-white border-b px-4 md:px-6 py-3
                       flex items-center justify-between
                       shadow-sm">

            <div class="flex items-center gap-3">
                <button
                    @click="sidebarOpen = true"
                    class="md:hidden bg-blue-800 text-white px-3 py-1.5 rounded-lg">
                    ☰
                </button>

                <h1 class="font-semibold text-gray-700">
                    Dashboard
                </h1>
            </div>

            <div class="flex items-center gap-3">
                <span class="hidden sm:block text-gray-600">
                    {{ auth()->user()->name }}
                </span>

                <form method="POST" action="{{ route('logout') }}">
                    @csrf
                    <button class="bg-red-500 text-white px-3 py-2 rounded-lg hover:bg-red-600">
                        خروج
                    </button>
                </form>
            </div>
        </header>

        <!-- Content -->
        <main class="flex-1 overflow-y-auto p-4 md:p-6">
            {{ $slot }}
        </main>

    </div>

</div>

@livewireScripts
</body>
</html>
