@props([
    'title',
    'label' => '',
    'id',          // معرف canvas
    'color' => 'blue-500',
])

<div class="bg-white/90 backdrop-blur rounded-2xl shadow-sm hover:shadow-xl transition duration-300 border border-gray-100">
    <div class="flex items-center justify-between p-5 border-b">
        <h2 class="font-semibold text-gray-700">{{ $title }}</h2>
        <span class="text-xs bg-{{ $color }}-100 text-{{ $color }}-600 px-3 py-1 rounded-full">{{ $label }}</span>
    </div>
    <div class="p-5">
        <div class="h-56 md:h-64">
            <canvas id="{{ $id }}"></canvas>
        </div>
    </div>
</div>
