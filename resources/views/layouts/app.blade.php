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

<div x-data="{ open:false }" class="flex min-h-screen">

    <!-- Mobile sidebar overlay -->
    <div x-show="open" class="fixed inset-0 bg-black/40 z-20 md:hidden" @click="open=false"></div>

    <!-- Sidebar -->
    @include('layouts.navigation')
     <!-- Main content -->
    <div class="flex-1 flex flex-col">

        <!-- Navbar -->
        <div class="bg-white shadow p-4 flex justify-between items-center sticky top-0 z-10">
            <!-- زر فتح sidebar للموبايل -->
            <button @click="open=true" class="md:hidden bg-blue-900 text-white px-3 py-1 rounded">
                ☰
            </button>

            <h1 class="font-bold text-lg">Dashboard</h1>

            <!-- الترحيب + زر خروج -->
            <div class="flex items-center space-x-4">

                <span class="text-gray-700 font-semibold">
                    مرحبا، {{ auth()->user()->name ?? 'Admin' }}
                </span>

             <form method="POST" action="{{ route('logout') }}">
    @csrf
    <button
        type="submit"
        class="flex items-center gap-2 px-5 py-2 bg-red-600 text-white font-semibold rounded-lg shadow-md
               hover:bg-red-700 hover:shadow-lg transition duration-300 transform hover:-translate-y-0.5 active:scale-95"
    >
        <!-- أيقونة الخروج -->
        <svg xmlns="http://www.w3.org/2000/svg" class="h-5 w-5" fill="none" viewBox="0 0 24 24" stroke="currentColor">
          <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
                d="M17 16l4-4m0 0l-4-4m4 4H7m6 4v1m0-10V5" />
        </svg>
        تسجيل خروج
    </button>
</form>

            </div>
        </div>


                {{ $slot }}

    </div>
</div>

    @livewireScripts


    </body>
</html>
