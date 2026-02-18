@props([
    'title',      // نص العنوان
    'count' => null, // الرقم الكبير
    'icon' => '',   // أيقونة
    'gradient' => 'from-gray-500 to-gray-600', // الخلفية
    'performance' => null // إذا أردنا شريط الأداء
])

<div class="bg-gradient-to-br {{ $gradient }} text-white rounded-2xl shadow-lg p-6">
    <div class="flex justify-between items-center">
        <div>
            <p class="opacity-80 text-sm">{{ $title }}</p>
            @if($count !== null)
                <p class="text-3xl font-bold mt-1">{{ $count }}</p>
            @endif
        </div>
        <div class="bg-white/20 p-3 rounded-xl text-2xl">
            {!! $icon !!}
        </div>
    </div>

    @if($performance !== null)
        <div class="mt-4">
            <p class="text-sm opacity-80">مؤشر الأداء</p>
            <p class="text-3xl font-bold mt-2">{{ $performance }}%</p>
            <div class="w-full bg-white/30 rounded-full h-2 mt-2">
                <div class="bg-white h-2 rounded-full" style="width: {{ $performance }}%"></div>
            </div>
        </div>
    @endif
</div>
