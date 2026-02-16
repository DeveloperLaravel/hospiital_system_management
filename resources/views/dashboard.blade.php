<x-app-layout>
      <!-- Content -->
        <main class="p-6 flex-1 overflow-auto">

            <!-- Stats Cards -->
            <div class="grid grid-cols-1 sm:grid-cols-2 lg:grid-cols-4 gap-6 mb-6">

  <!-- Main -->
   <div class="bg-white p-6 rounded-xl shadow">
                    <p class="text-gray-500">المرضى</p>
                    <h2 class="text-2xl font-bold">120</h2>
                </div>

                <div class="bg-white p-6 rounded-xl shadow">
                    <p class="text-gray-500">الأطباء</p>
                    <h2 class="text-2xl font-bold">25</h2>
                </div>

                <div class="bg-white p-6 rounded-xl shadow">
                    <p class="text-gray-500">المواعيد</p>
                    <h2 class="text-2xl font-bold">43</h2>
                </div>

                <div class="bg-white p-6 rounded-xl shadow">
                    <p class="text-gray-500">الفواتير</p>
                    <h2 class="text-2xl font-bold">18</h2>
                </div>

            </div>

            <!-- Chart -->
            <div class="bg-white rounded-xl shadow p-6">
                <h2 class="font-bold mb-4">إحصائيات المستشفى</h2>
                <canvas id="hospitalChart"></canvas>
            </div>


    </div>
    </div>
        </main>
    
</x-app-layout>
