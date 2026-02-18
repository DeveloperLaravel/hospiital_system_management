@props([
    'title' => 'الجدول',
    'patients' => collect()
])

<div class="bg-white rounded-2xl shadow-sm p-4 md:p-6 mt-8">
    <h2 class="font-semibold mb-4">{{ $title }}</h2>

    <div class="overflow-x-auto">
        <x-dashboard-table title="آخر المرضى" :patients="\App\Models\Patient::latest()->take(5)->get()" />

    </div>
</div>
