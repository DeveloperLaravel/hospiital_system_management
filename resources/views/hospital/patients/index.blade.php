<x-app-layout title="إدارة المرضى">
<main class="min-h-screen bg-gradient-to-br from-blue-50 to-indigo-100 p-4 sm:p-6 lg:p-8" dir="rtl">

<div class="max-w-7xl mx-auto space-y-8">

    <!-- Header -->
    <div class="flex flex-col sm:flex-row justify-between items-start sm:items-center gap-4">
        <div>
            <h1 class="text-3xl font-bold text-gray-800 flex items-center gap-3">
                <i class="fa-solid fa-hospital-user text-blue-600"></i>
                إدارة المرضى
            </h1>
            <p class="text-gray-500 mt-1">نظام إدارة المرضى الحديث</p>
        </div>
    </div>

    <!-- إشعار النجاح -->
    @if(session('success'))
    <div class="bg-green-100 border border-green-300 text-green-800 px-4 py-3 rounded-xl shadow-sm flex items-center gap-3">
        <i class="fa-solid fa-circle-check"></i>
        {{ session('success') }}
    </div>
    @endif

    <!-- إشعار الخطأ -->
    @if(session('error'))
    <div class="bg-red-100 border border-red-300 text-red-800 px-4 py-3 rounded-xl shadow-sm flex items-center gap-3">
        <i class="fa-solid fa-circle-exclamation"></i>
        {{ session('error') }}
    </div>
    @endif

    <!-- إحصائيات المرضى -->
    @if(isset($statistics))
    <div class="grid grid-cols-2 md:grid-cols-4 gap-4">
        <!-- إجمالي المرضى -->
        <div class="bg-white rounded-2xl shadow-lg p-5 border-r-4 border-blue-500">
            <div class="flex items-center justify-between">
                <div>
                    <p class="text-gray-500 text-sm">إجمالي المرضى</p>
                    <p class="text-2xl font-bold text-gray-800">{{ $statistics['total_patients'] }}</p>
                </div>
                <div class="w-12 h-12 bg-blue-100 rounded-full flex items-center justify-center">
                    <i class="fa-solid fa-users text-blue-600 text-xl"></i>
                </div>
            </div>
        </div>

        <!-- المرضى الذكور -->
        <div class="bg-white rounded-2xl shadow-lg p-5 border-r-4 border-indigo-500">
            <div class="flex items-center justify-between">
                <div>
                    <p class="text-gray-500 text-sm">الذكور</p>
                    <p class="text-2xl font-bold text-gray-800">{{ $statistics['male_patients'] }}</p>
                </div>
                <div class="w-12 h-12 bg-indigo-100 rounded-full flex items-center justify-center">
                    <i class="fa-solid fa-person text-indigo-600 text-xl"></i>
                </div>
            </div>
        </div>

        <!-- المرضى الإناث -->
        <div class="bg-white rounded-2xl shadow-lg p-5 border-r-4 border-pink-500">
            <div class="flex items-center justify-between">
                <div>
                    <p class="text-gray-500 text-sm">الإناث</p>
                    <p class="text-2xl font-bold text-gray-800">{{ $statistics['female_patients'] }}</p>
                </div>
                <div class="w-12 h-12 bg-pink-100 rounded-full flex items-center justify-center">
                    <i class="fa-solid fa-person-dress text-pink-600 text-xl"></i>
                </div>
            </div>
        </div>

        <!-- المرضى لديهم رصيد -->
        <div class="bg-white rounded-2xl shadow-lg p-5 border-r-4 border-yellow-500">
            <div class="flex items-center justify-between">
                <div>
                    <p class="text-gray-500 text-sm">لديهم رصيد</p>
                    <p class="text-2xl font-bold text-gray-800">{{ $statistics['patients_with_balance'] }}</p>
                </div>
                <div class="w-12 h-12 bg-yellow-100 rounded-full flex items-center justify-center">
                    <i class="fa-solid fa-sack-dollar text-yellow-600 text-xl"></i>
                </div>
            </div>
        </div>
    </div>

    <!-- الإحصائيات المالية -->
    <div class="grid grid-cols-2 md:grid-cols-2 gap-4">
        <div class="bg-gradient-to-r from-red-500 to-red-600 rounded-2xl shadow-lg p-5 text-white">
            <div class="flex items-center justify-between">
                <div>
                    <p class="text-red-100 text-sm">إجمالي الرصيد المستحق</p>
                    <p class="text-2xl font-bold">{{ $statistics['formatted_total_balance'] }}</p>
                </div>
                <div class="w-12 h-12 bg-white/20 rounded-full flex items-center justify-center">
                    <i class="fa-solid fa-money-bill-wave text-xl"></i>
                </div>
            </div>
        </div>

        <div class="bg-gradient-to-r from-green-500 to-green-600 rounded-2xl shadow-lg p-5 text-white">
            <div class="flex items-center justify-between">
                <div>
                    <p class="text-green-100 text-sm">إجمالي المدفوع</p>
                    <p class="text-2xl font-bold">{{ $statistics['formatted_total_paid'] }}</p>
                </div>
                <div class="w-12 h-12 bg-white/20 rounded-full flex items-center justify-center">
                    <i class="fa-solid fa-check-circle text-xl"></i>
                </div>
            </div>
        </div>
    </div>
    @endif

    <!-- نموذج البحث والفلترة -->
    <div class="bg-white rounded-2xl shadow-lg p-6">
        <form method="GET" action="{{ route('patients.index') }}" class="flex flex-wrap gap-4 items-end">
            <!-- البحث -->
            <div class="flex-1 min-w-[200px]">
                <label class="block text-sm font-medium text-gray-700 mb-1">البحث</label>
                <div class="relative">
                    <input type="text" name="search" value="{{ $filters['search'] ?? '' }}"
                        placeholder="البحث بالاسم أو رقم الهاتف أو الهوية..."
                        class="w-full pl-10 pr-4 py-2.5 border border-gray-300 rounded-xl focus:ring-2 focus:ring-blue-400 focus:border-transparent">
                    <i class="fa-solid fa-search absolute left-3 top-1/2 -translate-y-1/2 text-gray-400"></i>
                </div>
            </div>

            <!-- فلتر الجنس -->
            <div class="w-40">
                <label class="block text-sm font-medium text-gray-700 mb-1">الجنس</label>
                <select name="gender" class="w-full px-4 py-2.5 border border-gray-300 rounded-xl focus:ring-2 focus:ring-blue-400 focus:border-transparent">
                    <option value="">الكل</option>
                    <option value="male" {{ ($filters['gender'] ?? '') == 'male' ? 'selected' : '' }}>ذكر</option>
                    <option value="female" {{ ($filters['gender'] ?? '') == 'female' ? 'selected' : '' }}>أنثى</option>
                </select>
            </div>

            <!-- فلتر فصيلة الدم -->
            <div class="w-40">
                <label class="block text-sm font-medium text-gray-700 mb-1">فصيلة الدم</label>
                <select name="blood_type" class="w-full px-4 py-2.5 border border-gray-300 rounded-xl focus:ring-2 focus:ring-blue-400 focus:border-transparent">
                    <option value="">الكل</option>
                    @foreach(['A+', 'A-', 'B+', 'B-', 'AB+', 'AB-', 'O+', 'O-'] as $blood)
                        <option value="{{ $blood }}" {{ ($filters['blood_type'] ?? '') == $blood ? 'selected' : '' }}>{{ $blood }}</option>
                    @endforeach
                </select>
            </div>

            <!-- فلتر حالة الرصيد -->
            <div class="w-48">
                <label class="block text-sm font-medium text-gray-700 mb-1">حالة الرصيد</label>
                <select name="balance_status" class="w-full px-4 py-2.5 border border-gray-300 rounded-xl focus:ring-2 focus:ring-blue-400 focus:border-transparent">
                    <option value="">الكل</option>
                    <option value="with_balance" {{ ($filters['balance_status'] ?? '') == 'with_balance' ? 'selected' : '' }}>لديهم رصيد</option>
                    <option value="overdue" {{ ($filters['balance_status'] ?? '') == 'overdue' ? 'selected' : '' }}>متأخرين</option>
                    <option value="no_limit" {{ ($filters['balance_status'] ?? '') == 'no_limit' ? 'selected' : '' }}>بدون حد ائتماني</option>
                </select>
            </div>

            <!-- أزرار البحث وإعادة التعيين -->
            <div class="flex gap-2">
                <button type="submit" class="px-6 py-2.5 bg-blue-600 text-white rounded-xl hover:bg-blue-700 transition shadow-md">
                    <i class="fa-solid fa-search ml-1"></i> بحث
                </button>
                @if(request()->has('search') || request()->has('gender') || request()->has('blood_type') || request()->has('balance_status'))
                <a href="{{ route('patients.index') }}" class="px-6 py-2.5 bg-gray-500 text-white rounded-xl hover:bg-gray-600 transition shadow-md">
                    <i class="fa-solid fa-rotate-left ml-1"></i> إعادة
                </a>
                @endif
            </div>
        </form>
    </div>

    <!-- جدول المرضى -->
    <div class="bg-white rounded-3xl shadow-xl overflow-hidden">

        <div class="p-6 border-b bg-gradient-to-r from-blue-600 to-indigo-600 text-white flex flex-col sm:flex-row justify-between items-center gap-3">
            <h2 class="text-xl font-semibold flex items-center gap-2">
                <i class="fa-solid fa-list"></i>
                قائمة المرضى
            </h2>
            <span class="px-3 py-1 bg-white/20 rounded-full text-sm">
                {{ $patients->total() }} مريض
            </span>
        </div>

        <div class="overflow-x-auto">
            <table class="min-w-full text-sm text-right">
                <thead class="bg-gray-100 text-gray-700">
                    <tr>
                        <th class="px-4 py-3">الاسم</th>
                        <th class="px-4 py-3">الهوية</th>
                        <th class="px-4 py-3">العمر</th>
                        <th class="px-4 py-3">الجنس</th>
                        <th class="px-4 py-3">الهاتف</th>
                        <th class="px-4 py-3">فصيلة الدم</th>
                        <th class="px-4 py-3 bg-yellow-50">الرصيد</th>
                        <th class="px-4 py-3 bg-green-50">المدفوع</th>
                        <th class="px-4 py-3">الحد الائتماني</th>
                        <th class="px-4 py-3">الحالة</th>
                        <th class="px-4 py-3">الإجراءات</th>
                    </tr>
                </thead>
                <tbody id="patients-table-body" class="divide-y">
                @forelse($patients as $patient)
                <tr class="hover:bg-blue-50 transition">
                    <td class="px-4 py-3 font-medium text-gray-800 flex items-center gap-2">
                        <div class="w-8 h-8 bg-blue-100 text-blue-600 rounded-full flex items-center justify-center">
                            <i class="fa-solid fa-user"></i>
                        </div>
                        {{ $patient->name }}
                    </td>

                    <td class="px-4 py-3">{{ $patient->national_id ?? '-' }}</td>
                    <td class="px-4 py-3">{{ $patient->age ?? '-' }}</td>
                    <td class="px-4 py-3">
                        @if($patient->gender == 'male')
                            <span class="px-3 py-1 text-xs bg-blue-100 text-blue-700 rounded-full">ذكر</span>
                        @elseif($patient->gender == 'female')
                            <span class="px-3 py-1 text-xs bg-pink-100 text-pink-700 rounded-full">أنثى</span>
                        @else
                            -
                        @endif
                    </td>
                    <td class="px-4 py-3">{{ $patient->phone ?? '-' }}</td>
                    <td class="px-4 py-3">
                        @if($patient->blood_type)
                            <span class="px-3 py-1 text-xs bg-red-100 text-red-700 rounded-full">{{ $patient->blood_type }}</span>
                        @else
                            -
                        @endif
                    </td>

                    <!-- الرصيد المستحق -->
                    <td class="px-4 py-3 bg-yellow-50">
                        <span class="font-bold {{ $patient->balance > 0 ? 'text-red-600' : 'text-green-600' }}">
                            {{ number_format($patient->balance ?? 0, 2) }}
                        </span>
                    </td>

                    <!-- إجمالي المدفوع -->
                    <td class="px-4 py-3 bg-green-50">
                        <span class="font-bold text-green-600">
                            {{ number_format($patient->total_paid ?? 0, 2) }}
                        </span>
                    </td>

                    <!-- الحد الائتماني -->
                    <td class="px-4 py-3">
                        <span class="text-gray-600">
                            {{ number_format($patient->credit_limit ?? 0, 2) }}
                        </span>
                    </td>

                    <!-- حالة الرصيد -->
                    <td class="px-4 py-3">
                        @php
                            $statusColors = [
                                'مدفوع' => 'bg-green-100 text-green-700',
                                'متأخر' => 'bg-red-100 text-red-700',
                                'تحذير' => 'bg-yellow-100 text-yellow-700',
                                'معلق' => 'bg-gray-100 text-gray-700'
                            ];
                        @endphp
                        <span class="px-3 py-1 text-xs rounded-full {{ $statusColors[$patient->balance_status] ?? 'bg-gray-100 text-gray-700' }}">
                            {{ $patient->balance_status }}
                        </span>
                    </td>

                    <td class="px-4 py-3 flex gap-2 justify-end flex-wrap">
                        <!-- زر دفع -->
                        @can('patients-edit')
                        <button onclick='openPaymentModal(@json($patient))'
                            class="px-3 py-2 bg-green-500 hover:bg-green-600 text-white rounded-xl shadow-md transition flex items-center gap-1"
                            title="دفع">
                            <i class="fa-solid fa-dollar-sign"></i>
                        </button>
                        @endcan

                        @can('patients-edit')
                        <button onclick='openEditModal(@json($patient))'
                            class="px-3 py-2 bg-yellow-400 hover:bg-yellow-500 text-white rounded-xl shadow-md transition flex items-center gap-1">
                            <i class="fa-solid fa-pen"></i>
                        </button>
                        @endcan

                        @can('patients-delete')
                        <form action="{{ route('patients.destroy', $patient->id) }}" method="POST"
                              onsubmit="return confirm('هل أنت متأكد من حذف هذا المريض؟')">
                            @csrf
                            @method('DELETE')
                            <button type="submit"
                                class="px-3 py-2 bg-red-500 hover:bg-red-600 text-white rounded-xl shadow-md transition flex items-center gap-1">
                                <i class="fa-solid fa-trash"></i>
                            </button>
                        </form>
                        @endcan
                    </td>
                </tr>
                @empty
                <tr>
                    <td colspan="11" class="text-center py-6 text-gray-500">
                        <i class="fa-solid fa-bed-pulse text-2xl mb-2"></i>
                        <p>لا يوجد مرضى حتى الآن</p>
                    </td>
                </tr>
                @endforelse
                </tbody>
            </table>
        </div>

        <div class="p-4 bg-gray-50">
            {{ $patients->links() }}
        </div>

    </div>

    <!-- نموذج الإضافة / التعديل -->
    @can('patients-create')
    <div class="bg-white rounded-3xl shadow-xl p-8">

        <h2 class="text-xl font-bold text-gray-800 mb-6 flex items-center gap-2">
            <i class="fa-solid fa-user-plus text-green-600"></i>
            إضافة مريض جديد
        </h2>

        <form id="patient-form" action="{{ route('patients.store') }}" method="POST" class="grid grid-cols-1 md:grid-cols-2 lg:grid-cols-3 gap-6">
            @csrf
            @method('POST')

            <div>
                <label class="block text-sm font-medium text-gray-700 mb-1">الاسم *</label>
                <input type="text" name="name" placeholder="أدخل اسم المريض" class="input-style" required>
            </div>

            <div>
                <label class="block text-sm font-medium text-gray-700 mb-1">رقم الهوية</label>
                <input type="text" name="national_id" placeholder="أرقم الهوية" class="input-style">
            </div>

            <div>
                <label class="block text-sm font-medium text-gray-700 mb-1">العمر</label>
                <input type="number" name="age" placeholder="أدخل العمر" class="input-style" min="0" max="150">
            </div>

            <div>
                <label class="block text-sm font-medium text-gray-700 mb-1">الجنس</label>
                <select name="gender" class="input-style">
                    <option value="">اختر الجنس</option>
                    <option value="male">ذكر</option>
                    <option value="female">أنثى</option>
                </select>
            </div>

            <div>
                <label class="block text-sm font-medium text-gray-700 mb-1">الهاتف</label>
                <input type="text" name="phone" placeholder="أدخل رقم الهاتف" class="input-style">
            </div>

            <div>
                <label class="block text-sm font-medium text-gray-700 mb-1">فصيلة الدم</label>
                <select name="blood_type" class="input-style">
                    <option value="">اختر فصيلة الدم</option>
                    @foreach(['A+', 'A-', 'B+', 'B-', 'AB+', 'AB-', 'O+', 'O-'] as $blood)
                        <option value="{{ $blood }}">{{ $blood }}</option>
                    @endforeach
                </select>
            </div>

            <div>
                <label class="block text-sm font-medium text-gray-700 mb-1">الرصيد المستحق</label>
                <input type="number" step="0.01" name="balance" placeholder="0.00" class="input-style" value="0">
            </div>

            <div>
                <label class="block text-sm font-medium text-gray-700 mb-1">المدفوع</label>
                <input type="number" step="0.01" name="total_paid" placeholder="0.00" class="input-style" value="0">
            </div>

            <div>
                <label class="block text-sm font-medium text-gray-700 mb-1">الحد الائتماني</label>
                <input type="number" step="0.01" name="credit_limit" placeholder="0.00" class="input-style" value="0">
            </div>

            <div class="md:col-span-2 lg:col-span-3">
                <label class="block text-sm font-medium text-gray-700 mb-1">العنوان</label>
                <textarea name="address" placeholder="أدخل العنوان" class="input-style" rows="2"></textarea>
            </div>

            <div class="md:col-span-2 lg:col-span-3 flex justify-end gap-4">
                <button type="reset" class="px-6 py-3 rounded-xl border border-gray-300 hover:bg-gray-100 transition">تفريغ</button>
                <button type="submit" class="px-6 py-3 rounded-xl bg-blue-600 text-white hover:bg-blue-700 shadow-lg transition">حفظ</button>
            </div>
        </form>

    </div>
    @endcan

    <!-- نموذج الدفع -->
    @can('patients-edit')
    <div id="payment-modal" class="hidden fixed inset-0 z-50 flex items-center justify-center bg-black/50">
        <div class="bg-white rounded-xl shadow-2xl w-full max-w-md p-6">
            <h3 class="text-lg font-bold mb-4 text-gray-800">
                <i class="fa-solid fa-dollar-sign text-green-600"></i>
                دفع مبلغ للمريض
            </h3>
            <p id="payment-patient-name" class="text-gray-600 mb-4"></p>

            <form id="payment-form" method="POST">
                @csrf
                <div class="mb-4">
                    <label class="block text-gray-700 mb-2">مبلغ الدفع</label>
                    <input type="number" step="0.01" name="amount" class="input-style" required min="0.01" placeholder="أدخل المبلغ">
                </div>

                <div class="flex justify-end gap-2">
                    <button type="button" onclick="closePaymentModal()" class="px-4 py-2 rounded bg-gray-300 hover:bg-gray-400 transition">إلغاء</button>
                    <button type="submit" class="px-4 py-2 rounded bg-green-500 text-white hover:bg-green-600 transition">دفع</button>
                </div>
            </form>
        </div>
    </div>
    @endcan

</div>
</main>

<style>
.input-style {
    @apply w-full border border-gray-300 rounded-xl p-3 focus:outline-none focus:ring-2 focus:ring-blue-400 transition shadow-sm;
}
</style>

<script>
function openEditModal(patient) {
    const form = document.getElementById('patient-form');
    form.action = `/patients/${patient.id}`;

    // Remove old method input if exists
    const oldMethod = form.querySelector('input[name="_method"]');
    if (oldMethod) oldMethod.remove();

    // Add PUT method
    const methodInput = document.createElement('input');
    methodInput.type = 'hidden';
    methodInput.name = '_method';
    methodInput.value = 'PUT';
    form.appendChild(methodInput);

    // Fill form fields
    const fields = ['name', 'national_id', 'age', 'gender', 'phone', 'blood_type', 'balance', 'total_paid', 'credit_limit', 'address'];
    fields.forEach(field => {
        const input = form.querySelector(`[name="${field}"]`);
        if (input && patient[field] !== undefined) {
            input.value = patient[field] ?? '';
        }
    });

    window.scrollTo({ top: form.offsetTop - 20, behavior: 'smooth' });
}

function openPaymentModal(patient) {
    const modal = document.getElementById('payment-modal');
    const form = document.getElementById('payment-form');
    const patientName = document.getElementById('payment-patient-name');

    form.action = `/patients/${patient.id}/payment`;
    patientName.textContent = `المريض: ${patient.name} - الرصيد المستحق: ${patient.balance ?? 0}`;

    modal.classList.remove('hidden');
}

function closePaymentModal() {
    const modal = document.getElementById('payment-modal');
    modal.classList.add('hidden');
}

// إغلاق النافذة عند الضغط خارجها
document.getElementById('payment-modal')?.addEventListener('click', function(e) {
    if (e.target === this) {
        closePaymentModal();
    }
});
</script>
</x-app-layout>
