<!DOCTYPE html>
<html dir="rtl">
<head>
<meta charset="UTF-8">
<style>
body { font-family: DejaVu Sans; font-size: 12px; }
.header { text-align: center; border-bottom: 2px solid #444; padding-bottom: 10px; margin-bottom: 20px; }
.logo { width: 80px; }
.title { font-size: 18px; font-weight: bold; }
table { width: 100%; border-collapse: collapse; margin-top: 10px; }
th, td { border: 1px solid #999; padding: 6px; }
th { background: #eee; }
.footer { margin-top: 40px; }
.signature { margin-top: 60px; }
</style>
</head>
<body>

<div class="header">
    <img src="{{ public_path('logo.png') }}" class="logo">
    <div class="title">مستشفى الحياة</div>
    <div>Prescription</div>
</div>

<div class="info">
    <strong>رقم الوصفة:</strong> {{ $prescription->id }} <br>
    <strong>المريض:</strong> {{ $prescription->patient->name ?? '-' }} <br>
    <strong>تاريخ الطباعة:</strong> {{ now()->format('Y-m-d') }}
</div>

<table>
<thead>
<tr>
<th>الدواء</th>
<th>الجرعة</th>
<th>التكرار</th>
<th>المدة</th>
<th>الكمية</th>
<th>تعليمات</th>
</tr>
</thead>
<tbody>
@foreach($items as $item)
<tr>
<td>{{ $item->medication->name }}</td>
<td>{{ $item->dosage }}</td>
<td>{{ $item->frequency }}</td>
<td>{{ $item->duration }}</td>
<td>{{ $item->quantity }}</td>
<td>{{ $item->instructions ?? '-' }}</td>
</tr>
@endforeach
</tbody>
</table>

<div class="footer">
<div class="signature">
_______________________ <br>
توقيع الطبيب
</div>
</div>

</body>
</html>