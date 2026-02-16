<x-app-layout>
      <!-- Content -->
        <main class="p-6 flex-1 overflow-auto">

            <!-- Stats Cards -->


    <!-- Cards الاحصائيات -->
    <div class="grid grid-cols-1 md:grid-cols-2 lg:grid-cols-4 gap-6 mt-8">
        <div class="bg-white rounded-xl shadow-lg p-6 flex flex-col items-center">
            <h2 class="text-xl font-semibold text-gray-700 mb-2">المرضى</h2>
            <p class="text-3xl font-bold text-blue-600">120</p>
        </div>
        <div class="bg-white rounded-xl shadow-lg p-6 flex flex-col items-center">
            <h2 class="text-xl font-semibold text-gray-700 mb-2">الأطباء</h2>
            <p class="text-3xl font-bold text-green-600">25</p>
        </div>
        <div class="bg-white rounded-xl shadow-lg p-6 flex flex-col items-center">
            <h2 class="text-xl font-semibold text-gray-700 mb-2">المواعيد</h2>
            <p class="text-3xl font-bold text-yellow-500">43</p>
        </div>
        <div class="bg-white rounded-xl shadow-lg p-6 flex flex-col items-center">
            <h2 class="text-xl font-semibold text-gray-700 mb-2">الفواتير</h2>
            <p class="text-3xl font-bold text-red-500">18</p>
        </div>
    </div>
 <div class="bg-white rounded-xl shadow p-6 mt-6">
                <h2 class="font-bold mb-4">إحصائيات المستشفى</h2>
                <canvas id="hospitalChart" class="w-full h-64"></canvas>
            </div>


        </main>
   
    
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
</x-app-layout>
