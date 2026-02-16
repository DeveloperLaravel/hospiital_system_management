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

        <!-- Scripts -->
        @vite(['resources/css/app.css', 'resources/js/app.js'])
    </head>
    <body class="font-sans text-gray-900 antialiased bg-gray-100">

    <div class="min-h-screen flex flex-col justify-center items-center relative overflow-hidden">
        <!-- Background decoration -->
        <div class="absolute top-0 left-0 w-full h-1/3 bg-indigo-600 skew-y-[-6deg] transform origin-top-left"></div>
        <div class="absolute bottom-0 right-0 w-full h-1/4 bg-indigo-300 skew-y-[6deg] transform origin-bottom-right opacity-30"></div>

  
        <!-- Login Form -->
        <div class="z-10 w-full sm:max-w-md bg-white shadow-2xl rounded-2xl px-8 py-10">
            <h2 class="text-2xl font-bold text-gray-800 mb-6 text-center">تسجيل الدخول إلى نظام المستشفى</h2>

            {{ $slot }}

            <p class="mt-6 text-center text-gray-500 text-sm">
                © {{ date('Y') }} جميع الحقوق محفوظة لمستشفى الشروق
            </p>
        </div>
    </div>

    <!-- Responsive tweaks -->
    <style>
        @media (max-width: 640px) {
            body { padding: 0 1rem; }
        }
    </style>
</body>

</html>
