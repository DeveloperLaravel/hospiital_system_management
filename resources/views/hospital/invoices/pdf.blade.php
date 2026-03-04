<!DOCTYPE html>
<html dir="rtl">
<head>
    <meta charset="UTF-8">
    <title>فاتورة رقم {{ $invoice->invoice_number }}</title>
    <style>
        body { font-family: DejaVu Sans; font-size: 12px; }
        .header { text-align: center; border-bottom: 2px solid #444; padding-bottom: 10px; margin-bottom: 20px; }
        .logo { width: 80px; }
        .title { font-size: 18px; font-weight: bold; }
        .invoice-info { margin-bottom: 20px; }
        .invoice-info table { width: 100%; }
        .invoice-info td { padding: 5px; }
        table { width: 100%; border-collapse: collapse; margin-top: 10px; }
        th, td { border: 1px solid #999; padding: 8px; text-align: right; }
        th { background: #eee; }
        .total-row { font-weight: bold; background: #f5f5f5; }
        .footer { margin-top: 40px; }
        .signature { margin-top: 60px; }
        .status-paid { color: green; }
        .status-unpaid { color: red; }
    </style>
</head>
<body>

<div class="header">
    <div class="title">مستشفى الحياة</div>
    <div>الفاتورة الطبية</div>
</div>

<div class="invoice-info">
    <table>
        <tr>
            <td><strong>رقم الفاتورة:</strong> {{ $invoice->invoice_number }}</td>
            <td><strong>التاريخ:</strong> {{ $invoice->invoice_date?->format('Y-m-d') }}</td>
        </tr>
        <tr>
            <td><strong>المريض:</strong> {{ $invoice->patient_name }}</td>
            <td><strong>حالة الفاتورة:</strong>
                @if($invoice->status === 'paid')
                    <span class="status-paid">مدفوعة</span>
                @else
                    <span class="status-unpaid">غير مدفوعة</span>
                @endif
            </td>
        </tr>
        @if($invoice->due_date)
        <tr>
            <td><strong>تاريخ الاستحقاق:</strong> {{ $invoice->due_date?->format('Y-m-d') }}</td>
            <td></td>
        </tr>
        @endif
    </table>
</div>

<table>
    <thead>
        <tr>
            <th>#</th>
            <th>الخدمة</th>
            <th>الوصف</th>
            <th>السعر</th>
            <th>الكمية</th>
            <th>المجموع</th>
        </tr>
    </thead>
    <tbody>
        @foreach($invoice->items as $item)
        <tr>
            <td>{{ $loop->iteration }}</td>
            <td>{{ $item->service }}</td>
            <td>{{ $item->description ?? '-' }}</td>
            <td>{{ number_format($item->price, 2) }} $</td>
            <td>{{ $item->quantity }}</td>
            <td>{{ number_format($item->price * $item->quantity, 2) }} $</td>
        </tr>
        @endforeach
        <tr class="total-row">
            <td colspan="5" style="text-align: left;">المجموع الكلي</td>
            <td>{{ number_format($invoice->total, 2) }} $</td>
        </tr>
    </tbody>
</table>

@if($invoice->notes)
<div style="margin-top: 20px;">
    <strong>ملاحظات:</strong>
    <p>{{ $invoice->notes }}</p>
</div>
@endif

<div class="footer">
    <div class="signature">
        <table style="width: 100%;">
            <tr>
                <td style="text-align: center; width: 50%;">
                    _______________________ <br>
                    توقيع المريض
                </td>
                <td style="text-align: center; width: 50%;">
                    _______________________ <br>
                    توقيع الطبيب
                </td>
            </tr>
        </table>
    </div>
    <div style="text-align: center; margin-top: 30px; color: #666;">
        تاريخ الطباعة: {{ now()->format('Y-m-d H:i') }}
    </div>
</div>

</body>
</html>
