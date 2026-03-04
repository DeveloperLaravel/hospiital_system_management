<x-app-layout>


<div class="container-fluid">
    <div class="row">
        <div class="col-md-12">
            <div class="card">
                <div class="card-header">
                    <h3 class="card-title">تفاصيل عنصر الفاتورة</h3>
                    <div class="card-tools">
                        <a href="{{ route('invoices.items.index', $invoice) }}" class="btn btn-secondary btn-sm">
                            <i class="fas fa-arrow-right"></i> العودة للعناصر
                        </a>
                        <a href="{{ route('invoices.items.edit', [$invoice, $item]) }}" class="btn btn-primary btn-sm">
                            <i class="fas fa-edit"></i> تعديل
                        </a>
                    </div>
                </div>
                <div class="card-body">
                    <div class="row">
                        <div class="col-md-6">
                            <table class="table table-bordered">
                                <tr>
                                    <th>اسم الخدمة</th>
                                    <td>{{ $item->service }}</td>
                                </tr>
                                <tr>
                                    <th>الوصف</th>
                                    <td>{{ $item->description ?? '-' }}</td>
                                </tr>
                                <tr>
                                    <th>السعر</th>
                                    <td>{{ number_format($item->price, 2) }} $</td>
                                </tr>
                                <tr>
                                    <th>الكمية</th>
                                    <td>{{ $item->quantity }}</td>
                                </tr>
                                <tr>
                                    <th>الإجمالي</th>
                                    <td><strong>{{ number_format($item->price * $item->quantity, 2) }} $</strong></td>
                                </tr>
                                <tr>
                                    <th>تاريخ الإضافة</th>
                                    <td>{{ $item->created_at->format('Y-m-d H:i') }}</td>
                                </tr>
                            </table>
                        </div>
                        <div class="col-md-6">
                            <div class="card bg-light">
                                <div class="card-body">
                                    <h5>معلومات الفاتورة</h5>
                                    <p><strong>رقم الفاتورة:</strong> {{ $invoice->invoice_number }}</p>
                                    <p><strong>المريض:</strong> {{ $invoice->patient->name ?? '-' }}</p>
                                    <p><strong>حالة الفاتورة:</strong>
                                        @if($invoice->status == 'paid')
                                            <span class="badge bg-success">مدفوعة</span>
                                        @else
                                            <span class="badge bg-warning">غير مدفوعة</span>
                                        @endif
                                    </p>
                                    <p><strong>إجمالي الفاتورة:</strong> {{ number_format($invoice->total, 2) }} $</p>
                                </div>
                            </div>
                        </div>
                    </div>
                </div>
                <div class="card-footer">
                    <form action="{{ route('invoices.items.destroy', [$invoice, $item]) }}" method="POST" class="d-inline">
                        @csrf
                        @method('DELETE')
                        <button type="submit" class="btn btn-danger" onclick="return confirm('هل أنت متأكد من حذف هذا العنصر؟')">
                            <i class="fas fa-trash"></i> حذف
                        </button>
                    </form>
                </div>
            </div>
        </div>
    </div>
</div>
</x-app-layout>
