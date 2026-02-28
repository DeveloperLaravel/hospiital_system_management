<!DOCTYPE html>
<html dir="rtl">
<head>

<meta charset="UTF-8">

<style>

body {
    font-family: DejaVu Sans;
    font-size: 12px;
}

.header {
    text-align: center;
    border-bottom: 2px solid #444;
    padding-bottom: 10px;
    margin-bottom: 20px;
}

.logo {
    width: 80px;
}

.title {
    font-size: 18px;
    font-weight: bold;
}

.info {
    margin-bottom: 15px;
}

table {
    width: 100%;
    border-collapse: collapse;
    margin-top: 10px;
}

th, td {
    border: 1px solid #999;
    padding: 6px;
}

th {
    background: #eee;
}

.footer {
    margin-top: 40px;
}

.signature {
    margin-top: 60px;
}

</style>

</head>
<body>


{{-- header --}}
<div class="header">

    <img src="{{ public_path('logo.png') }}"
         class="logo">

    <div class="title">
        مستشفى الحياة
    </div>

    <div>
        Medical Report
    </div>

</div>



{{-- patient info --}}
<div class="info">

    <strong>
        اسم المريض:
    </strong>

    {{ $patient->name }}

    <br>


    <strong>
        رقم المريض:
    </strong>

    {{ $patient->id }}

    <br>


    <strong>
        تاريخ الطباعة:
    </strong>

    {{ now()->format('Y-m-d') }}

</div>



{{-- table --}}
<table>

<thead>

<tr>

<th>
التاريخ
</th>

<th>
الطبيب
</th>

<th>
التشخيص
</th>

<th>
العلاج
</th>

<th>
ملاحظات
</th>

</tr>

</thead>


<tbody>

@foreach($records as $record)

<tr>

<td>
{{ $record->visit_date }}
</td>

<td>
{{ $record->doctor->name }}
</td>

<td>
{{ $record->diagnosis }}
</td>

<td>
{{ $record->treatment }}
</td>

<td>
{{ $record->notes }}
</td>

</tr>

@endforeach

</tbody>

</table>



{{-- signature --}}
<div class="footer">

    <div class="signature">

        _______________________

        <br>

        توقيع الطبيب

    </div>

</div>


</body>
</html>
