<!DOCTYPE html>
<html dir="rtl">
<head>
    <meta charset="UTF-8">
    <title>وصفة طبية - {{ $prescription->id }}</title>
    <style>
        * {
            margin: 0;
            padding: 0;
            box-sizing: border-box;
        }
        body {
            font-family: 'DejaVu Sans', 'Tahoma', sans-serif;
            font-size: 12px;
            line-height: 1.6;
            color: #333;
        }
        .header {
            text-align: center;
            border-bottom: 2px solid #2563eb;
            padding-bottom: 15px;
            margin-bottom: 20px;
        }
        .logo {
            width: 60px;
            height: auto;
        }
        .hospital-name {
            font-size: 18px;
            font-weight: bold;
            color: #1e40af;
            margin-top: 5px;
        }
        .prescription-title {
            font-size: 14px;
            color: #6b7280;
            margin-top: 3px;
        }
        .info-section {
            margin-bottom: 20px;
            padding: 15px;
            background-color: #f9fafb;
            border-radius: 8px;
            border-right: 4px solid #2563eb;
        }
        .info-row {
            display: flex;
            justify-content: space-between;
            margin-bottom: 8px;
        }
        .info-label {
            font-weight: bold;
            color: #4b5563;
        }
        .info-value {
            color: #1f2937;
        }
        table {
            width: 100%;
            border-collapse: collapse;
            margin-top: 15px;
        }
        th, td {
            border: 1px solid #d1d5db;
            padding: 10px;
            text-align: center;
        }
        th {
            background-color: #2563eb;
            color: white;
            font-weight: bold;
        }
        tr:nth-child(even) {
            background-color: #f9fafb;
        }
        tr:hover {
            background-color: #f3f4f6;
        }
        .footer {
            margin-top: 50px;
            page-break-inside: avoid;
        }
        .signature {
            margin-top: 60px;
            display: flex;
            justify-content: space-between;
        }
        .signature-box {
            text-align: center;
            width: 45%;
        }
        .signature-line {
            border-top: 1px solid #374151;
            padding-top: 8px;
            margin-top: 40px;
            font-weight: bold;
            color: #4b5563;
        }
        .notes {
            margin-top: 30px;
            padding: 15px;
            background-color: #fef3c7;
            border-radius: 8px;
            border-right: 4px solid #f59e0b;
        }
        .notes-title {
            font-weight: bold;
            color: #92400e;
            margin-bottom: 8px;
        }
        .print-date {
            text-align: left;
            color: #6b7280;
            font-size: 10px;
            margin-top: 20px;
        }
    </style>
</head>
<body>

    <div class="header">
        <div class="hospital-name">مستشفى الحياة</div>
        <div class="prescription-title">وصفة طبية</div>
    </div>

    <div class="info-section">
        <div class="info-row">
            <span class="info-label">رقم الوصفة:</span>
            <span class="info-value">#{{ $prescription->id }}</span>
        </div>
        <div class="info-row">
            <span class="info-label">المريض:</span>
            <span class="info-value">{{ $prescription->medicalRecord?->patient?->name ?? '-' }}</span>
        </div>
        <div class="info-row">
            <span class="info-label">الطبيب المعالج:</span>
            <span class="info-value">{{ $prescription->doctor?->name ?? '-' }}</span>
        </div>
        <div class="info-row">
            <span class="info-label">التاريخ:</span>
            <span class="info-value">{{ $prescription->created_at->format('Y-m-d') }}</span>
        </div>
    </div>

    <table>
        <thead>
            <tr>
                <th style="width: 5%">#</th>
                <th style="width: 20%">الدواء</th>
                <th style="width: 15%">الجرعة</th>
                <th style="width: 15%">التكرار</th>
                <th style="width: 10%">المدة</th>
                <th style="width: 10%">الكمية</th>
                <th style="width: 25%">تعليمات</th>
            </tr>
        </thead>
        <tbody>
            @forelse($items as $index => $item)
                <tr>
                    <td>{{ $index + 1 }}</td>
                    <td>{{ $item->medication?->name ?? '-' }}</td>
                    <td>{{ $item->dosage }}</td>
                    <td>{{ $item->frequency }}</td>
                    <td>{{ $item->duration }} يوم</td>
                    <td>{{ $item->quantity }}</td>
                    <td>{{ $item->instructions ?? '-' }}</td>
                </tr>
            @empty
                <tr>
                    <td colspan="7">لا توجد عناصر في هذه الوصفة</td>
                </tr>
            @endforelse
        </tbody>
    </table>

    @if($prescription->notes)
    <div class="notes">
        <div class="notes-title">ملاحظات الطبيب:</div>
        <div>{{ $prescription->notes }}</div>
    </div>
    @endif

    <div class="footer">
        <div class="signature">
            <div class="signature-box">
                <div class="signature-line">توقيع الطبيب</div>
            </div>
            <div class="signature-box">
                <div class="signature-line">ختم المستشفى</div>
            </div>
        </div>
    </div>

    <div class="print-date">
        تاريخ الطباعة: {{ now()->format('Y-m-d H:i:s') }}
    </div>

</body>
</html>
