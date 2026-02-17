<x-app-layout>
    <main class="p-6 flex-1 overflow-auto">

        <!-- Cards الاحصائيات -->
        <div class="grid grid-cols-1 md:grid-cols-2 lg:grid-cols-4 gap-6 mt-8">
            <div class="bg-white rounded-xl shadow-lg p-6 flex flex-col items-center">
                <h2 class="text-xl font-semibold text-gray-700 mb-2">المرضى</h2>
                <p class="text-3xl font-bold text-blue-600">{{ $patientsCount }}</p>
            </div>
            <div class="bg-white rounded-xl shadow-lg p-6 flex flex-col items-center">
                <h2 class="text-xl font-semibold text-gray-700 mb-2">الأطباء</h2>
                <p class="text-3xl font-bold text-green-600">{{ $doctorsCount }}</p>
            </div>
            <div class="bg-white rounded-xl shadow-lg p-6 flex flex-col items-center">
                <h2 class="text-xl font-semibold text-gray-700 mb-2">المواعيد</h2>
                <p class="text-3xl font-bold text-yellow-500">{{ $appointmentsCount }}</p>
            </div>
            <div class="bg-white rounded-xl shadow-lg p-6 flex flex-col items-center">
                <h2 class="text-xl font-semibold text-gray-700 mb-2">الفواتير</h2>
                {{-- <p class="text-3xl font-bold text-red-500">{{ $billsCount }}</p> --}}
            </div>
        </div>

        <!-- Chart -->
        <div class="bg-white rounded-xl shadow p-6 mt-6">
            <h2 class="font-bold mb-4">إحصائيات المستشفى</h2>
            <canvas id="hospitalChart" class="w-full h-64"></canvas>
        </div>

        <!-- Table احترافي -->
        <div class="bg-white rounded-xl shadow p-6 mt-6">
            <h2 class="font-bold mb-4">آخر 5 مرضى</h2>
            <table class="w-full table-auto border border-gray-200">
                <thead>
                    <tr class="bg-gray-100">
                        <th class="p-2 border">الاسم</th>
                        <th class="p-2 border">العمر</th>
                        <th class="p-2 border">الجنس</th>
                        <th class="p-2 border">الهاتف</th>
                    </tr>
                </thead>
                <tbody>
                    @foreach(\App\Models\Patient::latest()->take(5)->get() as $patient)
                        <tr>
                            <td class="p-2 border">{{ $patient->name }}</td>
                            <td class="p-2 border">{{ $patient->age ?? '-' }}</td>
                            <td class="p-2 border">{{ ucfirst($patient->gender ?? '-') }}</td>
                            <td class="p-2 border">{{ $patient->phone ?? '-' }}</td>
                        </tr>
                    @endforeach
                </tbody>
            </table>
        </div>

    </main>

    <!-- Alpine.js و Chart.js -->
    <script src="https://unpkg.com/alpinejs" defer></script>
    <script src="https://cdn.jsdelivr.net/npm/chart.js"></script>
    <script>
        const ctx = document.getElementById('hospitalChart');

        new Chart(ctx, {
            type: 'bar',
            data: {
                labels: ['المرضى', 'الأطباء', 'المواعيد', 'الفواتير'],
                datasets: [{
                    label: 'إحصائيات',
                    data: [
                        {{ $patientsCount }},
                        {{ $doctorsCount }},
                        {{ $appointmentsCount }},
                    ],
                    backgroundColor: ['#3b82f6', '#10b981', '#facc15', '#ef4444'],
                    borderWidth: 1
                }]
            },
            options: {
                responsive: true,
                plugins: { legend: { display: false } }
            }
        });
    </script>
</x-app-layout>
