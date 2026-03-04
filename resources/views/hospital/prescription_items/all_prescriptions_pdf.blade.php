<!DOCTYPE html>
<html dir="rtl">
<head>
    <meta charset="UTF-8">
    <title>تقرير وصفات المريض - {{ $patient->id }}</title>
    <style>
        * {
            margin: 0;
            padding: 0;
            box-sizing: border-box;
        }
        body {
            font-family: 'DejaVu Sans', 'Tahoma', sans-serif;
            font-size: 11px;
            line-height: 1.6;
            color: #333;
        }
        .header {
            text-align: center;
            border-bottom: 2px solid #2563eb;
            padding-bottom: 15px;
            margin-bottom: 20px;
        }
        .hospital-name {
            font-size: 18px;
            font-weight: bold;
            color: #1e40af;
        }
        .report-title {
            font-size: 14px;
            color: #6b7280;
            margin-top: 3px;
        }
        .patient-info {
            margin-bottom: 25px;
            padding: 15px;
            background-color: #f9fafb;
            border-radius: 8px;
            border-right: 4px solid #2563eb;
        }
        .info-row {
            display: flex;
            justify-content: space-between;
            margin-bottom: 5px;
        }
        .info-label {
            font-weight: bold;
            color: #4b5563;
        }
        .info-value {
            color: #1f2937;
        }
        .prescription {
            margin-bottom: 30px;
            page-break-inside: avoid;
        }
        .prescription-header {
            background-color: #2563eb;
            color: white;
            padding: 10px 15px;
            border-radius: 8px 8px 0 0;
            display: flex;
            justify-content: space-between;
            align-items: center;
        }
        .prescription-title {
            font-weight: bold;
        }
        .prescription-date {
            font-size: 10px;
            opacity: 0.9;
        }
        table {
            width: 100%;
            border-collapse: collapse;
            margin-top: 0;
        }
        th, td {
            border: 1px solid #d1d5db;
            padding: 8px;
            text-align: center;
        }
        th {
            background-color: #f3f4f6;
            color: #374151;
            font-weight: bold;
            font-size: 10px;
        }
        tr:nth-child(even) {
            background-color: #f9fafb;
        }
        .doctor-info {
            background-color: #f3f4f6;
            padding: 8px 12px;
            font-size: 10px;
            border: 1px solid #e5e7eb;
            border-top: none;
        }
        .notes {
            padding: 10px;
            background-color: #fef3c7;
            font-size: 10px;
            border: 1px solid #fcd34d;
            border-top: none;
        }
        .footer {
            margin-top: 50px;
            page-break-inside: avoid;
        }
        .signature {
            margin-top: 50px;
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
            margin-top: 30px;
            font-weight: bold;
            color: #4b5563;
        }
        .print-date {
            text-align: left;
            color: #6b7280;
            font-size: 10px;
            margin-top: 20px;
        }
        .no-prescriptions {
            text-align: center;
            padding: 40px;
            color: #6b7280;
        }
    </style>
</head>
<body>

    <div class="header">
        <div class="hospital-name">مستشفى الحياة</div>
        <div class="report-title">تقرير جميع وصفات المريض</div>
    </div>

    <div class="patient-info">
        <div class="info-row">
            <span class="info-label">اسم المريض:</span>
            <span class="info-value">{{ $patient->name }}</span>
        </div>
        <div class="info-row">
            <span class="info-label">رقم المريض:</span>
            <span class="info-value">#{{ $patient->id }}</span>
        </div>
        @if($patient->phone)
        <div class="info-row">
            <span class="info-label">رقم الهاتف:</span>
            <span class="info-value">{{ $patient->phone }}</span>
        </div>
        @endif
        <div class="info-row">
            <span class="info-label">إجمالي الوصفات:</span>
            <span class="info-value">{{ $prescriptions->count() }}</span>
        </div>
    </div>

    @forelse($prescriptions as $prescription)
    <div class="prescription">
        <div class="prescription-header">
            <span class="prescription-title">الوصفة رقم: #{{ $prescription->id }}</span>
            <span class="prescription-date">التاريخ: {{ $prescription->created_at->format('Y-m-d') }}</span>
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
                @forelse($prescription->items as $index => $item)
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

        @if($prescription->doctor)
        <div class="doctor-info">
            <strong>الطبيب المعالج:</strong> {{ $prescription->doctor->name }}
        </div>
        @endif

        @if($prescription->notes)
        <div class="notes">
            <strong>ملاحظات:</strong> {{ $prescription->notes }}
        </div>
        @endif
    </div>
    @empty
    <div class="no-prescriptions">
        <p>لا توجد وصفات طبية لهذا المريض</p>
    </div>
    @endforelse

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
