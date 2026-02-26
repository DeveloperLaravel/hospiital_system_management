<!DOCTYPE html>
<html lang="ar" dir="rtl">
<head>
    <meta charset="UTF-8">
    <title>فاتورة رقم #{{ $invoice->id }}</title>

    <script src="https://cdn.tailwindcss.com"></script>

    <style>
        @media print {
            .no-print {
                display: none !important;
            }

            body {
                -webkit-print-color-adjust: exact;
            }
        }

        body {
            font-family: Tahoma, sans-serif;
        }
    </style>
</head>
<body class="bg-gray-100 p-8">

<div class="max-w-4xl mx-auto bg-white shadow-lg rounded-lg p-8">

    {{-- أزرار --}}
    <div class="flex justify-between items-center mb-6 no-print">
        <button onclick="window.print()"
                class="bg-blue-600 hover:bg-blue-700 text-white px-6 py-2 rounded-lg">
            🖨 طباعة
        </button>

        <a href="{{ route('invoices.index') }}"
           class="bg-gray-500 hover:bg-gray-600 text-white px-6 py-2 rounded-lg">
            رجوع
        </a>
    </div>


    {{-- الهيدر --}}
    <div class="flex justify-between items-center border-b pb-4 mb-6">
        <div>
            <h1 class="text-2xl font-bold text-gray-800">
                فاتورة
            </h1>
            <p class="text-gray-500">
                رقم الفاتورة: #{{ $invoice->id }}
            </p>
            <p class="text-gray-500">
                التاريخ: {{ $invoice->created_at->format('Y-m-d') }}
            </p>
        </div>

        <div class="text-left">
            <h2 class="text-lg font-semibold text-gray-700">
                اسم المريض
            </h2>
            <p class="text-gray-600">
                {{ $invoice->patient->name }}
            </p>
        </div>
    </div>


    {{-- جدول العناصر --}}
    <table class="w-full text-sm border border-gray-200">
        <thead class="bg-gray-100">
            <tr>
                <th class="p-3 border">#</th>
                <th class="p-3 border">الوصف</th>
                <th class="p-3 border">الكمية</th>
                <th class="p-3 border">السعر</th>
                <th class="p-3 border">الإجمالي</th>
            </tr>
        </thead>
        <tbody>
            @foreach($invoice->items as $index => $item)
                <tr class="text-center">
                    <td class="p-3 border">{{ $index + 1 }}</td>
                    <td class="p-3 border">{{ $item->description }}</td>
                    <td class="p-3 border">{{ $item->quantity }}</td>
                    <td class="p-3 border">{{ number_format($item->price,2) }} د.ل</td>
                    <td class="p-3 border font-semibold">
                        {{ number_format($item->quantity * $item->price,2) }} د.ل
                    </td>
                </tr>
            @endforeach
        </tbody>
    </table>


    {{-- الإجمالي --}}
    <div class="mt-6 flex justify-end">
        <div class="w-64">
            <div class="flex justify-between border-b py-2">
                <span>الإجمالي الكلي:</span>
                <span class="font-bold text-lg">
                    {{ number_format($invoice->total,2) }} د.ل
                </span>
            </div>

            <div class="flex justify-between py-2">
                <span>الحالة:</span>
                @if($invoice->status == 'paid')
                    <span class="text-green-600 font-bold">
                        ✔ مدفوعة
                    </span>
                @else
                    <span class="text-red-600 font-bold">
                        ✖ غير مدفوعة
                    </span>
                @endif
            </div>
        </div>
    </div>


    {{-- تذييل --}}
    <div class="mt-12 text-center text-gray-400 text-xs">
        شكراً لزيارتكم — نتمنى لكم دوام الصحة
    </div>

</div>

<script>
    // طباعة تلقائية عند فتح الصفحة (اختياري)
    // window.onload = function() { window.print(); }
</script>

</body>
</html>
