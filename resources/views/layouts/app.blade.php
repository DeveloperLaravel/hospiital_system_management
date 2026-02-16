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
<body class="bg-gray-100 font-sans">

<div x-data="{ open:false }" class="flex min-h-screen">

    <!-- Mobile sidebar overlay -->
    <div x-show="open" class="fixed inset-0 bg-black/40 z-20 md:hidden" @click="open=false"></div>

    <!-- Sidebar -->
    @include('layouts.navigation')
     <!-- Main content -->
    <div class="flex-1 flex flex-col">

        <!-- Navbar -->
        <header class="bg-white shadow p-4 flex justify-between items-center sticky top-0 z-10">
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
                        class="flex items-center px-4 py-2 bg-red-600 hover:bg-red-700 text-white rounded-lg shadow transition duration-300"
                    >
                        <svg xmlns="http://www.w3.org/2000/svg" class="h-5 w-5 ml-2" fill="none" viewBox="0 0 24 24" stroke="currentColor">
                          <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M17 16l4-4m0 0l-4-4m4 4H7m6 4v1m0-10V5" />
                        </svg>
                        تسجيل خروج
                    </button>
                </form>
            </div>
        </header>

                {{ $slot }}
            <div class="bg-white rounded-xl shadow p-6 mt-6">
                <h2 class="font-bold mb-4">إحصائيات المستشفى</h2>
                <canvas id="hospitalChart" class="w-full h-64"></canvas>
            </div>

        </main>
    </div>
</div>


        <!-- Alpine -->
<script src="https://unpkg.com/alpinejs" defer></script>

<!-- Chart.js -->
<script src="https://cdn.jsdelivr.net/npm/chart.js"></script>

<script>
const ctx = document.getElementById('hospitalChart');







new Chart(ctx, {
    type: 'bar',
    data: {
        labels: ['المرضى', 'الأطباء', 'المواعيد', 'الفواتير'],
        datasets: [{
            label: 'إحصائيات',
            data: [120, 25, 43, 18],
            borderWidth: 1
        }]
    },
    options: {
        responsive: true,
        plugins: {
            legend: { display: false }
        }
    }
});
</script>
    </body>
</html>
