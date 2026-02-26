<x-app-layout>
<div class="p-6">

<h2 class="text-xl font-bold mb-4">
    خدمات الفاتورة #{{ $invoice->id }}
</h2>

@if($invoice->status === 'unpaid')
<a href="{{ route('invoices.items.create', $invoice) }}"
   class="bg-blue-600 text-white px-4 py-2 rounded mb-4 inline-block">
    إضافة خدمة
</a>
@endif

<div class="bg-white shadow rounded overflow-hidden">
<table class="w-full text-sm">
    <thead class="bg-gray-100">
        <tr>
            <th class="p-3">الخدمة</th>
            <th class="p-3">السعر</th>
            <th class="p-3">تحكم</th>
        </tr>
    </thead>
    <tbody>
        @foreach($invoice->items as $item)
        <tr class="border-b">
            <td class="p-3">{{ $item->service }}</td>
            <td class="p-3">{{ number_format($item->price,2) }} د.ل</td>
            <td class="p-3 flex gap-2">
                @if($invoice->status === 'unpaid')
                <a href="{{ route('invoices.items.edit', [$invoice,$item]) }}"
                   class="text-blue-600">تعديل</a>

                <form method="POST"
                      action="{{ route('invoices.items.destroy', [$invoice,$item]) }}">
                    @csrf
                    @method('DELETE')
                    <button class="text-red-600"
                            onclick="return confirm('هل أنت متأكد؟')">
                        حذف
                    </button>
                </form>
                @endif
            </td>
        </tr>
        @endforeach
    </tbody>
</table>

<div class="p-4 font-bold text-lg">
    إجمالي الفاتورة: {{ number_format($invoice->total,2) }} د.ل
</div>

</div>
</div>
</x-app-layout>
