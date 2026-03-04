<x-app-layout>
<div class="p-6 bg-gray-50 min-h-screen" dir="rtl">

    <div class="max-w-3xl mx-auto">
        <div class="flex justify-between items-center mb-6">
            <h1 class="text-2xl font-bold">تفاصيل الدواء</h1>
            <div class="flex gap-2">
                <a href="{{ route('medications.edit', $medication) }}" class="bg-yellow-500 text-white px-4 py-2 rounded-xl hover:bg-yellow-600 transition">
                    تعديل
                </a>
                <a href="{{ route('medications.index') }}" class="bg-gray-500 text-white px-4 py-2 rounded-xl hover:bg-gray-600 transition">
                    رجوع
                </a>
            </div>
        </div>

        <div class="bg-white p-6 rounded-2xl shadow-md space-y-6">
            {{--基本信息 --}}
            <div class="grid grid-cols-2 gap-4 border-b pb-4">
                <div>
                    <span class="text-gray-500">اسم الدواء:</span>
                    <span class="font-bold mr-2">{{ $medication->name }}</span>
                </div>
                <div>
                    <span class="text-gray-500">النوع:</span>
                    <span class="font-bold mr-2">{{ $medication->type ?? '-' }}</span>
                </div>
                <div>
                    <span class="text-gray-500">الكمية:</span>
                    <span class="font-bold mr-2 {{ $medication->quantity <= $medication->min_stock ? 'text-red-600' : '' }}">
                        {{ $medication->quantity }}
                    </span>
                </div>
                <div>
                    <span class="text-gray-500">الحد الأدنى:</span>
                    <span class="font-bold mr-2">{{ $medication->min_stock }}</span>
                </div>
                <div>
                    <span class="text-gray-500">السعر:</span>
                    <span class="font-bold mr-2">{{ number_format($medication->price, 2) }}</span>
                </div>
                <div>
                    <span class="text-gray-500">تاريخ الانتهاء:</span>
                    <span class="font-bold mr-2 {{ $medication->isExpiringSoon ? 'text-red-600' : '' }}">
                        {{ $medication->expiry_date ? $medication->expiry_date->format('Y-m-d') : '-' }}
                    </span>
                </div>
                <div>
                    <span class="text-gray-500">الحالة:</span>
                    @if($medication->is_active)
                        <span class="px-2 py-1 bg-green-100 text-green-700 rounded-full text-sm">نشط</span>
                    @else
                        <span class="px-2 py-1 bg-red-100 text-red-700 rounded-full text-sm">غير نشط</span>
                    @endif
                </div>
                <div>
                    <span class="text-gray-500">مخزون منخفض:</span>
                    @if($medication->isLowStock)
                        <span class="px-2 py-1 bg-red-100 text-red-700 rounded-full text-sm">نعم</span>
                    @else
                        <span class="px-2 py-1 bg-green-100 text-green-700 rounded-full text-sm">لا</span>
                    @endif
                </div>
            </div>

            @if($medication->description)
            <div>
                <h3 class="text-lg font-bold mb-2">الوصف</h3>
                <p class="text-gray-700">{{ $medication->description }}</p>
            </div>
            @endif

            {{-- إجراءات --}}
            <div class="flex gap-3 pt-4 border-t">
                <form action="{{ route('medications.destroy', $medication) }}" method="POST" class="inline">
                    @csrf
                    @method('DELETE')
                    <button type="submit" onclick="return confirm('هل أنت متأكد من الحذف؟')"
                            class="px-4 py-2 bg-red-600 text-white rounded-xl hover:bg-red-700 transition">
                        حذف
                    </button>
                </form>
            </div>
        </div>
    </div>
</div>
</x-app-layout>
