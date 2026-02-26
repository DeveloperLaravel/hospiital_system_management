<x-app-layout>
<div class="p-6">

    <div class="flex justify-between mb-4 gap-4">

        <form method="GET" class="flex gap-2">
            <input type="text"
                   name="search"
                   value="{{ request('search') }}"
                   placeholder="بحث باسم المريض..."
                   class="border rounded px-3 py-2">

            <select name="status" class="border rounded px-3 py-2">
                <option value="">كل الحالات</option>
                <option value="paid" @selected(request('status')=='paid')>مدفوعة</option>
                <option value="unpaid" @selected(request('status')=='unpaid')>غير مدفوعة</option>
            </select>

          <button class="bg-gray-700 hover:bg-gray-800 text-white px-4 py-2 rounded-lg transition">
    فلترة
</button>
        </form>

      <a href="{{ route('invoices.create') }}"
   class="bg-blue-600 hover:bg-blue-700 text-white px-5 py-2 rounded-lg shadow transition">
    + إضافة فاتورة
</a>
    </div>

    <div class="bg-white shadow rounded overflow-hidden">
        <table class="w-full text-sm">
            <thead class="bg-gray-100">
                <tr>
                    <th class="p-3">المريض</th>
                    <th class="p-3">المبلغ</th>
                    <th class="p-3">الحالة</th>
                    <th class="p-3">التاريخ</th>
                    <th class="p-3">تحكم</th>
                </tr>
            </thead>
            <tbody>
                @foreach($invoices as $invoice)
                <tr class="border-b">
                    <td class="p-3">
                        {{ $invoice->patient->name }}
                    </td>
                    <td class="p-3">
                        {{ number_format($invoice->total,2) }} د.ل
                    </td>
                 <td class="p-3">
    @if($invoice->status == 'paid')
        <span class="px-3 py-1 text-xs font-bold bg-green-100 text-green-700 rounded-full">
            ✔ مدفوعة
        </span>
    @else
        <span class="px-3 py-1 text-xs font-bold bg-red-100 text-red-700 rounded-full">
            ✖ غير مدفوعة
        </span>
    @endif
</td>
                    <td class="p-3">
                        {{ $invoice->created_at->format('Y-m-d') }}
                    </td>
                    <td class="p-3">
    <div class="flex flex-wrap gap-2">



        {{-- عناصر الفاتورة --}}
        <a href="{{ route('invoices.items.index', $invoice->id) }}"
           class="px-3 py-1 text-xs font-medium bg-indigo-100 text-indigo-700 rounded-full hover:bg-indigo-200 transition">
            العناصر
        </a>

        {{-- تعديل --}}
        <a href="{{ route('invoices.edit',$invoice) }}"
           class="px-3 py-1 text-xs font-medium bg-blue-100 text-blue-700 rounded-full hover:bg-blue-200 transition">
            تعديل
        </a>

        {{-- تغيير الحالة --}}
        {{-- @if($invoice->status == 'unpaid')
            <form method="POST"
                  action="{{ route('invoices.markPaid',$invoice) }}">
                @csrf
                @method('PATCH')
                <button class="px-3 py-1 text-xs font-medium bg-green-100 text-green-700 rounded-full hover:bg-green-200 transition">
                    تعليم كمدفوعة
                </button>
            </form>
        @endif --}}

        {{-- طباعة --}}
        <a href="{{ route('invoices.print',$invoice) }}"
           target="_blank"
           class="px-3 py-1 text-xs font-medium bg-yellow-100 text-yellow-700 rounded-full hover:bg-yellow-200 transition">
            طباعة
        </a>

        {{-- حذف --}}
        <form method="POST"
              action="{{ route('invoices.destroy',$invoice) }}"
              onsubmit="return confirm('هل أنت متأكد من حذف الفاتورة؟')">
            @csrf
            @method('DELETE')
            <button class="px-3 py-1 text-xs font-medium bg-red-100 text-red-700 rounded-full hover:bg-red-200 transition">
                حذف
            </button>
        </form>

    </div>
</td>
                </tr>
                @endforeach
            </tbody>
        </table>

        <div class="p-4">
            {{ $invoices->links() }}
        </div>
    </div>

</div>
</x-app-layout>
