<div class="p-6" dir="rtl" lang="ar">

    @if(session()->has('message'))
        <div class="mb-4 p-3 bg-green-100 text-green-700 rounded shadow">
            {{ session('message') }}
        </div>
    @endif

    <div class="flex justify-between items-center mb-6">
        <h2 class="text-2xl font-bold">إدارة المواعيد</h2>

        <div class="flex gap-3">
            <input type="text" wire:model="search" placeholder="بحث باسم المريض..."
                   class="border px-3 py-2 rounded">

            <button wire:click="create"
                    class="bg-blue-600 text-white px-4 py-2 rounded hover:bg-blue-700">
                إضافة موعد
            </button>
        </div>
    </div>

    <div class="bg-white shadow rounded overflow-hidden">
        <table class="min-w-full text-center">
            <thead class="bg-gray-100">
                <tr>
                    <th class="p-3">المريض</th>
                    <th class="p-3">الطبيب</th>
                    <th class="p-3">التاريخ</th>
                    <th class="p-3">الوقت</th>
                    <th class="p-3">الحالة</th>
                    <th class="p-3">الإجراءات</th>
                </tr>
            </thead>
            <tbody>
            @forelse($appointments as $appointment)
                <tr class="border-t hover:bg-gray-50">
                    <td class="p-3">{{ $appointment->patient->name }}</td>
                    <td class="p-3">{{ $appointment->doctor->name }}</td>
                    <td class="p-3">{{ $appointment->date }}</td>
                    <td class="p-3">{{ $appointment->time }}</td>
                    <td class="p-3">
                        @if($appointment->status == 'confirmed')
                            <span class="px-2 py-1 text-xs bg-green-100 text-green-700 rounded">مؤكد</span>
                        @elseif($appointment->status == 'pending')
                            <span class="px-2 py-1 text-xs bg-yellow-100 text-yellow-700 rounded">قيد الانتظار</span>
                        @elseif($appointment->status == 'completed')
                            <span class="px-2 py-1 text-xs bg-blue-100 text-blue-700 rounded">مكتمل</span>
                        @else
                            <span class="px-2 py-1 text-xs bg-red-100 text-red-700 rounded">ملغي</span>
                        @endif
                    </td>
                    <td class="p-3 flex justify-center gap-2">
                        <button wire:click="edit({{ $appointment->id }})"
                                class="bg-yellow-500 text-white px-2 py-1 rounded hover:bg-yellow-600">
                            تعديل
                        </button>

                        <button wire:click="delete({{ $appointment->id }})"
                                class="bg-red-600 text-white px-2 py-1 rounded hover:bg-red-700">
                            حذف
                        </button>
                    </td>
                </tr>
            @empty
                <tr>
                    <td colspan="6" class="p-4 text-gray-500">لا توجد مواعيد</td>
                </tr>
            @endforelse
            </tbody>
        </table>

        <div class="p-4">
            {{ $appointments->links() }}
        </div>
    </div>

    <!-- Modal -->
    @if($isModalOpen)
        <div class="fixed inset-0 bg-black bg-opacity-40 flex items-center justify-center z-50">
            <div class="bg-white p-6 rounded-lg w-96 shadow-lg">

                <h3 class="text-lg font-bold mb-4">
                    {{ $appointmentId ? 'تعديل موعد' : 'إضافة موعد' }}
                </h3>

                <div class="space-y-3">
                    <select wire:model="patient_id" class="w-full border p-2 rounded">
                        <option value="">اختر المريض</option>
                        @foreach($patients as $patient)
                            <option value="{{ $patient->id }}">{{ $patient->name }}</option>
                        @endforeach
                    </select>
                    @error('patient_id') <span class="text-red-500 text-sm">{{ $message }}</span> @enderror

                    <select wire:model="doctor_id" class="w-full border p-2 rounded">
                        <option value="">اختر الطبيب</option>
                        @foreach($doctors as $doctor)
                            <option value="{{ $doctor->id }}">{{ $doctor->name }}</option>
                        @endforeach
                    </select>
                    @error('doctor_id') <span class="text-red-500 text-sm">{{ $message }}</span> @enderror

                    <input type="date" wire:model="date" class="w-full border p-2 rounded">
                    @error('date') <span class="text-red-500 text-sm">{{ $message }}</span> @enderror

                    <input type="time" wire:model="time" class="w-full border p-2 rounded">
                    @error('time') <span class="text-red-500 text-sm">{{ $message }}</span> @enderror

                    <select wire:model="status" class="w-full border p-2 rounded">
                        <option value="pending">قيد الانتظار</option>
                        <option value="confirmed">مؤكد</option>
                        <option value="completed">مكتمل</option>
                        <option value="cancelled">ملغي</option>
                    </select>
                </div>

                <div class="flex justify-end gap-2 mt-4">
                    <button wire:click="$set('isModalOpen', false)" class="bg-gray-500 text-white px-3 py-1 rounded">إلغاء</button>
                    <button wire:click="store" class="bg-blue-600 text-white px-3 py-1 rounded">حفظ</button>
                </div>
            </div>
        </div>
    @endif
</div>
