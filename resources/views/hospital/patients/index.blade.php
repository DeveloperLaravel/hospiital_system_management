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

    <!-- جدول المرضى -->
    <div class="bg-white rounded-3xl shadow-xl overflow-hidden">

        <div class="p-6 border-b bg-gradient-to-r from-blue-600 to-indigo-600 text-white flex flex-col sm:flex-row justify-between items-center gap-3">
            <h2 class="text-xl font-semibold flex items-center gap-2">
                <i class="fa-solid fa-list"></i>
                قائمة المرضى
            </h2>

            {{-- <!-- حقل البحث -->
            <input type="text" id="search" placeholder="ابحث عن المريض..."
                   class="w-full sm:w-1/3 border border-gray-300 rounded-xl p-3 focus:outline-none focus:ring-2 focus:ring-blue-400 shadow-sm"
            > --}}
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

                    <td class="px-4 py-3 flex gap-2 justify-end">
                        @can('patients.edit')
                        <button onclick='openEditModal(@json($patient))'
                            class="px-3 py-2 bg-yellow-400 hover:bg-yellow-500 text-white rounded-xl shadow-md transition flex items-center gap-1">
                            <i class="fa-solid fa-pen"></i>
                        </button>
                        @endcan

                        @can('patients.delete')
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
                    <td colspan="6" class="text-center py-6 text-gray-500">
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
    @can('patients.create')
    <div class="bg-white rounded-3xl shadow-xl p-8">

        <h2 class="text-xl font-bold text-gray-800 mb-6 flex items-center gap-2">
            <i class="fa-solid fa-user-plus text-green-600"></i>
            إضافة / تعديل مريض
        </h2>

        <form id="patient-form" action="{{ route('patients.store') }}" method="POST" class="grid grid-cols-1 md:grid-cols-2 gap-6">
            @csrf
            @method('POST')

            <input type="text" name="name" placeholder="الاسم" class="input-style" required>
            <input type="text" name="national_id" placeholder="رقم الهوية" class="input-style">
            <input type="number" name="age" placeholder="العمر" class="input-style">
            <select name="gender" class="input-style">
                <option value="">اختر الجنس</option>
                <option value="male">ذكر</option>
                <option value="female">أنثى</option>
            </select>
            <input type="text" name="phone" placeholder="الهاتف" class="input-style">
            <input type="text" name="blood_type" placeholder="فصيلة الدم" class="input-style">
            <textarea name="address" placeholder="العنوان" class="md:col-span-2 input-style"></textarea>

            <div class="md:col-span-2 flex justify-end gap-4">
                <button type="reset" class="px-6 py-3 rounded-xl border border-gray-300 hover:bg-gray-100 transition">تفريغ</button>
                <button type="submit" class="px-6 py-3 rounded-xl bg-blue-600 text-white hover:bg-blue-700 shadow-lg transition">حفظ</button>
            </div>
        </form>

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
    form.querySelector('[name="_method"]').value = 'PUT';

    Object.keys(patient).forEach(key => {
        if (form.querySelector(`[name="${key}"]`)) {
            form.querySelector(`[name="${key}"]`).value = patient[key] ?? '';
        }
    });

    window.scrollTo({ top: form.offsetTop - 20, behavior: 'smooth' });
}

// بحث مباشر (Live Search)
document.addEventListener('DOMContentLoaded', function() {
    const searchInput = document.getElementById('search');

    searchInput.addEventListener('keyup', function() {
        const query = this.value;

        fetch(`/patients/search?q=${query}`, {
            headers: { 'X-Requested-With': 'XMLHttpRequest' }
        })
        .then(response => response.text())
        .then(html => {
            document.getElementById('patients-table-body').innerHTML = html;
        })
        .catch(err => console.error(err));
    });
});
</script>
</x-app-layout>
