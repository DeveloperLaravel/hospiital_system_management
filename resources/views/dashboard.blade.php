<x-app-layout>
 <main class="flex-1 overflow-y-auto bg-gray-50">
<div class="max-w-7xl mx-auto px-4 sm:px-6 lg:px-8 py-6">

    <!-- Header -->
    <div class="flex flex-col lg:flex-row lg:items-center lg:justify-between gap-2 mb-6">
        <h1 class="text-xl md:text-2xl font-bold text-gray-700">
            لوحة التحكم
        </h1>
        <p class="text-sm text-gray-500">
            مؤشرات الأداء والإحصائيات العامة
        </p>
    </div>

    <!-- Cards -->
    <div class="grid gap-4 sm:grid-cols-2 xl:grid-cols-4">

       <!-- Patients -->
       <x-dashboard-card title="المرضى" :count="$patientsCount" icon="👥" gradient="from-blue-500 to-blue-600" />


      <!-- Doctors -->
<x-dashboard-card title="الأطباء" :count="$doctorsCount" icon="🩺" gradient="from-emerald-500 to-emerald-600" />

       <!-- Appointments -->
     <x-dashboard-card title="المواعيد" :count="$appointmentsCount" icon="📅" gradient="from-amber-400 to-amber-500" />

      <!-- Performance -->
 <x-dashboard-card title="مؤشر الأداء" :performance="$performance ?? 75" icon="⚡" gradient="from-indigo-600 to-indigo-700" />

    </div>

 <!-- Charts -->
<div class="grid grid-cols-1 md:grid-cols-2 xl:grid-cols-3 gap-6 mt-8">

  <x-chart-card title="المرضى شهريًا" label="Patients" id="patientsChart" color="blue" />

   <x-chart-card title="المواعيد الأسبوعية" label="Appointments" id="appointmentsChart" color="green" />

    <!-- Doughnut Chart -->

     <x-chart-card title="توزيع البيانات" label="Overview" id="hospitalChart" color="yellow" />
</div>

    <!-- Table -->
    <div class="bg-white rounded-2xl shadow-sm p-4 md:p-6 mt-8">
        <h2 class="font-semibold mb-4">آخر المرضى</h2>

        <div class="overflow-x-auto">
            <table class="w-full text-sm">
                <thead class="bg-gray-100 text-gray-700">
                    <tr>
                        <th class="p-3 text-right">الاسم</th>
                        <th class="p-3 text-right">العمر</th>
                        <th class="p-3 text-right">الجنس</th>
                        <th class="p-3 text-right">الهاتف</th>
                    </tr>
                </thead>
                <tbody>
                    @foreach(\App\Models\Patient::latest()->take(5)->get() as $patient)
                    <tr class="border-b hover:bg-gray-50">
                        <td class="p-3">{{ $patient->name }}</td>
                        <td class="p-3">{{ $patient->age ?? '-' }}</td>
                        <td class="p-3">{{ ucfirst($patient->gender ?? '-') }}</td>
                        <td class="p-3">{{ $patient->phone ?? '-' }}</td>
                    </tr>
                    @endforeach
                </tbody>
            </table>
        </div>
    </div>

</div>
</main>

<script src="https://cdn.jsdelivr.net/npm/chart.js"></script>
<script>
/* إعدادات عامة لكل الرسومات */
Chart.defaults.font.family = "Cairo";
Chart.defaults.plugins.legend.display = false;
Chart.defaults.elements.line.borderWidth = 3;
Chart.defaults.elements.point.radius = 4;
Chart.defaults.animation.duration = 900;
</script>
{{-- resources/views/components/hospital-chart.blade.php --}}
<div>
    <canvas id="hospitalChart" width="400" height="400"></canvas>

    <script>
        document.addEventListener('DOMContentLoaded', function () {
            const ctx = document.getElementById('hospitalChart').getContext('2d');

            const gradientBlue = ctx.createLinearGradient(0, 0, 0, 400);
            gradientBlue.addColorStop(0, '#3b82f6');
            gradientBlue.addColorStop(1, '#1e40af');

            const gradientGreen = ctx.createLinearGradient(0, 0, 0, 400);
            gradientGreen.addColorStop(0, '#10b981');
            gradientGreen.addColorStop(1, '#065f46');

            const gradientYellow = ctx.createLinearGradient(0, 0, 0, 400);
            gradientYellow.addColorStop(0, '#facc15');
            gradientYellow.addColorStop(1, '#ca8a04');

            new Chart(ctx, {
                type: 'doughnut',
                data: {
                    labels: ['المرضى', 'الأطباء', 'المواعيد'],
                    datasets: [{
                        data: [
                            {{ $patientsCount ?? 0 }},
                            {{ $doctorsCount ?? 0 }},
                            {{ $appointmentsCount ?? 0 }}
                        ],
                        backgroundColor: [
                            gradientBlue,
                            gradientGreen,
                            gradientYellow
                        ],
                        borderWidth: 0,
                        hoverOffset: 15
                    }]
                },
                options: {
                    responsive: true,
                    cutout: '65%',
                    plugins: {
                        legend: {
                            position: 'bottom',
                            labels: {
                                usePointStyle: true,
                                padding: 20
                            }
                        },
                        tooltip: {
                            backgroundColor: '#1f2937',
                            padding: 12,
                            titleColor: '#fff',
                            bodyColor: '#fff'
                        }
                    }
                }
            });
        });
    </script>
</div>


<script>
/* المرضى شهريًا */
new Chart(document.getElementById('patientsChart'), {
    type: 'line',
    data: {
        labels: {!! json_encode($patientsMonthly->keys()) !!},
        datasets: [{
            label: 'مرضى جدد',
            data: {!! json_encode($patientsMonthly->values()) !!},
            borderColor: '#3b82f6',
            backgroundColor: 'rgba(59,130,246,0.1)',
            fill: true,
            tension: 0.4
        }]
    },
    options: {
        responsive: true,
        plugins: { legend: { display: false } }
    }
});

/* المواعيد الأسبوعية */
new Chart(document.getElementById('appointmentsChart'), {
    type: 'bar',
    data: {
        labels: {!! json_encode($appointmentsWeekly->keys()) !!},
        datasets: [{
            label: 'المواعيد',
            data: {!! json_encode($appointmentsWeekly->values()) !!},
            backgroundColor: '#10b981',
            borderRadius: 6
        }]
    },
    options: {
        responsive: true,
        plugins: { legend: { display: false } }
    }
});
</script>

</x-app-layout>
