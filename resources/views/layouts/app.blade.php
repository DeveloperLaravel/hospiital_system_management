<!DOCTYPE html>
<html lang="ar" dir="rtl">
<head>
    <meta charset="utf-8">
    <meta name="viewport" content="width=device-width, initial-scale=1">
    <meta name="csrf-token" content="{{ csrf_token() }}">

    <title>{{ $title ?? 'نظام إدارة المستشفى' }}</title>

    <!-- Fonts -->
    <link rel="preconnect" href="https://fonts.bunny.net">
    <link href="https://fonts.bunny.net/css?family=figtree:400,500,600,700&display=swap" rel="stylesheet" />

    <!-- Scripts -->
    @vite(['resources/css/app.css', 'resources/js/app.js'])


        <!-- Alpine.js -->
    <!-- Livewire Styles -->

    <style>
        [x-cloak] { display: none !important; }
        ::-webkit-scrollbar { width: 8px; height: 8px; }
        ::-webkit-scrollbar-track { background: #f1f5f9; }
        ::-webkit-scrollbar-thumb { background: #94a3b8; border-radius: 4px; }
        ::-webkit-scrollbar-thumb:hover { background: #64748b; }
    </style>
    @livewireStyles

</head>
<body class="bg-gray-100 font-sans antialiased">

<!-- Root Alpine Component -->
<div x-data="{
    sidebarOpen: false,
    sidebarCollapsed: localStorage.getItem('sidebarCollapsed') === 'true',
    toggleSidebar() { this.sidebarOpen = !this.sidebarOpen },
    init() {
        this.$watch('sidebarCollapsed', value => localStorage.setItem('sidebarCollapsed', value));
    }
}" class="flex h-screen overflow-hidden">

    <!-- Mobile Overlay -->
    <div x-show="sidebarOpen"
         x-transition:enter="transition ease-out duration-300"
         x-transition:enter-start="opacity-0"
         x-transition:enter-end="opacity-100"
         x-transition:leave="transition ease-in duration-200"
         x-transition:leave-start="opacity-100"
         x-transition:leave-end="opacity-0"
         @click="sidebarOpen = false"
         class="fixed inset-0 bg-black/50 z-40 md:hidden">
    </div>

    <!-- Sidebar Component -->
    @include('components.sidebar')

    <!-- Main Content -->
    <div class="flex-1 flex flex-col overflow-hidden bg-gray-50">

        <!-- Header Component -->
        @include('components.header')

        <!-- Page Content -->
        <main class="flex-1 overflow-y-auto p-4 md:p-6">
            {{ $slot }}
        </main>

    </div>

<!-- Livewire Scripts -->
@livewireScripts
<script>
    document.addEventListener('DOMContentLoaded', function() {
        if (window.Alpine) {
            window.Alpine.start();
        }
    });
</script>

</body>
</html>
