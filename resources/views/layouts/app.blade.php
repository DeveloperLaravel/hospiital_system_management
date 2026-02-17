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
    @livewireStyles

        <!-- Scripts -->
        @vite(['resources/css/app.css', 'resources/js/app.js'])

    </head>
<body class="bg-gray-100 font-sans">

<div class="flex min-h-screen">

    <!-- Mobile sidebar overlay -->

    <!-- Sidebar -->
    {{-- @include('layouts.navigation') --}}
     <!-- Main content -->

    <!-- Navbar -->
  <div class="flex-1 flex flex-col">
<div x-data="{ sidebarOpen: false, sidebarCollapsed: false }" class="flex min-h-screen bg-gray-100">

    <!-- Overlay (موبايل فقط) -->
    <div 
        x-show="sidebarOpen" 
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
        class="fixed md:relative z-30 bg-blue-900 text-white min-h-screen
               transform md:translate-x-0 transition-all duration-300 ease-in-out
               flex flex-col"
    >

        <!-- Logo -->
        <div class="h-16 flex items-center justify-between px-4 border-b border-blue-700">
            <span x-show="!sidebarCollapsed" class="font-bold text-lg tracking-wide">
                🏥 إدارة المستشفى
            </span>

            <!-- زر تصغير في الديسكتوب -->
            <button 
                @click="sidebarCollapsed = !sidebarCollapsed"
                class="hidden md:block text-white hover:text-gray-300"
            >
                ☰
            </button>
        </div>

        <!-- روابط -->
       


         @include('layouts.navigation') 
       

    </aside>

    <!-- المحتوى الرئيسي -->
    <div class="flex-1 flex flex-col transition-all duration-300">

        <!-- Navbar -->
        <header class="bg-white border-b px-4 md:px-6 py-3 flex items-center justify-between sticky top-0 z-10 shadow-sm">

            <!-- اليسار -->
            <div class="flex items-center gap-3">

                <!-- زر الموبايل -->
                <button
                    @click="sidebarOpen = true"
                    class="md:hidden bg-blue-800 text-white px-3 py-1.5 rounded-lg shadow-sm hover:bg-blue-900 transition"
                >
                    ☰
                </button>

                <h1 class="font-semibold text-gray-700 text-base md:text-lg">
                    Dashboard
                </h1>
            </div>

            <!-- اليمين -->
            <div class="flex items-center gap-3 md:gap-5">

                <div class="hidden sm:block text-gray-600 font-medium text-sm md:text-base">
                    مرحبا، {{ auth()->user()->name ?? 'Admin' }}
                </div>

                <!-- Logout -->
                <form method="POST" action="{{ route('logout') }}">
                    @csrf
                    <button
                        type="submit"
                        class="flex items-center gap-2 px-3 md:px-4 py-2
                               bg-red-500 text-white text-sm font-semibold
                               rounded-lg shadow-sm hover:bg-red-600
                               transition duration-200"
                    >
                        <svg xmlns="http://www.w3.org/2000/svg"
                             class="h-4 w-4 md:h-5 md:w-5"
                             fill="none"
                             viewBox="0 0 24 24"
                             stroke="currentColor">
                            <path stroke-linecap="round"
                                  stroke-linejoin="round"
                                  stroke-width="2"
                                  d="M17 16l4-4m0 0l-4-4m4 4H7" />
                        </svg>

                        <span class="hidden md:inline">تسجيل خروج</span>
                    </button>
                </form>

            </div>
        </header>

        <!-- الصفحة -->
            {{ $slot }}

    </div>
</div>

    @livewireScripts


    </body>
</html>
