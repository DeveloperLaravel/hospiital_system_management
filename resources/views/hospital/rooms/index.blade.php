<x-app-layout title="إدارة الغرف والمرضى">
<div class="p-6 space-y-6" x-data="hospitalRooms()">

    {{-- العنوان + زر إضافة غرفة --}}
    <div class="flex justify-between items-center">
        <h1 class="text-2xl font-bold">قائمة الغرف</h1>
        <button @click="openRoomModal()"
                class="bg-green-600 hover:bg-green-700 text-white px-4 py-2 rounded shadow">
            + إضافة غرفة
        </button>
    </div>

    {{-- رسائل النجاح --}}
    {{-- <x-alerts /> --}}

    {{-- جدول الغرف --}}
    <div class="overflow-x-auto bg-white rounded-lg shadow p-4">
        <table class="w-full text-right table-auto">
            <thead>
                <tr class="bg-gray-100">
                    <th class="px-4 py-2">رقم الغرفة</th>
                    <th class="px-4 py-2">النوع</th>
                    <th class="px-4 py-2">الحالة</th>
                    <th class="px-4 py-2">المريض الحالي</th>
                    <th class="px-4 py-2">العمليات</th>
                </tr>
            </thead>
            <tbody>
                @foreach($rooms as $room)
                    <tr class="border-t">
                        <td class="px-4 py-2">{{ $room->room_number }}</td>
                        <td class="px-4 py-2 capitalize">{{ $room->type }}</td>
                        <td class="px-4 py-2">
                            <span :class="{'text-green-600': '{{ $room->status }}'=='available','text-red-600': '{{ $room->status }}'=='occupied'}"
                                  class="font-semibold">
                                {{ $room->status == 'available' ? 'متاحة' : 'مشغولة' }}
                            </span>
                        </td>
                        <td class="px-4 py-2">
                            {{ $room->currentPatient()?->name ?? '-' }}
                        </td>
                        <td class="px-4 py-2 space-x-2">
                            <button @click="openRoomModal({{ $room->id }}, '{{ $room->room_number }}', '{{ $room->type }}', '{{ $room->status }}')"
                                    class="text-blue-600 hover:underline">تعديل</button>

                            <button @click="openAdmitModal({{ $room->id }})"
                                    class="text-green-600 hover:underline"
                                    x-show="'{{ $room->status }}'=='available'">إدخال مريض</button>

                            <button @click="openDischargeModal({{ $room->id }})"
                                    class="text-red-600 hover:underline"
                                    x-show="'{{ $room->status }}'=='occupied'">إخراج المريض</button>

                            <form action="{{ route('rooms.destroy', $room) }}" method="POST" class="inline">
                                @csrf
                                @method('DELETE')
                                <button type="submit" class="text-gray-600 hover:underline">حذف</button>
                            </form>
                        </td>
                    </tr>
                @endforeach
            </tbody>
        </table>

        <div class="mt-4">
            {{ $rooms->links() }}
        </div>
    </div>

    {{-- مودال إضافة/تعديل الغرفة --}}
    <div x-show="showRoomModal" class="fixed inset-0 flex items-center justify-center bg-black bg-opacity-50 z-50">
        <div @click.away="closeRoomModal()" class="bg-white rounded-lg shadow-lg w-96 p-6 relative">
            <h2 class="text-xl font-bold mb-4" x-text="roomModalTitle"></h2>

            <form :action="roomFormAction" method="POST">
                @csrf
                <template x-if="isRoomEdit">
                    <input type="hidden" name="_method" value="PUT">
                </template>

                <div class="mb-4">
                    <label class="block mb-1 font-semibold">رقم الغرفة</label>
                    <input type="text" name="room_number" x-model="roomForm.room_number"
                           class="w-full border rounded px-3 py-2">
                </div>

                <div class="mb-4">
                    <label class="block mb-1 font-semibold">النوع</label>
                    <select name="type" x-model="roomForm.type" class="w-full border rounded px-3 py-2">
                        <option value="single">Single</option>
                        <option value="double">Double</option>
                        <option value="ICU">ICU</option>
                    </select>
                </div>

                <div class="mb-4">
                    <label class="block mb-1 font-semibold">الحالة</label>
                    <select name="status" x-model="roomForm.status" class="w-full border rounded px-3 py-2">
                        <option value="available">متاحة</option>
                        <option value="occupied">مشغولة</option>
                    </select>
                </div>

                <div class="flex justify-end space-x-2">
                    <button type="button" @click="closeRoomModal()" class="px-4 py-2 bg-gray-300 rounded hover:bg-gray-400">إلغاء</button>
                    <button type="submit" class="px-4 py-2 bg-blue-600 text-white rounded hover:bg-blue-700">حفظ</button>
                </div>
            </form>
        </div>
    </div>

    {{-- مودال إدخال المريض --}}
    <div x-show="showAdmitModal" class="fixed inset-0 flex items-center justify-center bg-black bg-opacity-50 z-50">
        <div @click.away="closeAdmitModal()" class="bg-white rounded-lg shadow-lg w-96 p-6 relative">
            <h2 class="text-xl font-bold mb-4">إدخال مريض إلى الغرفة</h2>
            <form :action="admitFormAction" method="POST">
                @csrf
                <div class="mb-4">
                    <label class="block mb-1 font-semibold">اختر المريض</label>
                    <select name="patient_id" class="w-full border rounded px-3 py-2">
                        @foreach($patients as $patient)
                            <option value="{{ $patient->id }}">{{ $patient->name }}</option>
                        @endforeach
                    </select>
                </div>
                <div class="flex justify-end space-x-2">
                    <button type="button" @click="closeAdmitModal()" class="px-4 py-2 bg-gray-300 rounded hover:bg-gray-400">إلغاء</button>
                    <button type="submit" class="px-4 py-2 bg-green-600 text-white rounded hover:bg-green-700">إدخال</button>
                </div>
            </form>
        </div>
    </div>

    {{-- مودال إخراج المريض --}}
    <div x-show="showDischargeModal" class="fixed inset-0 flex items-center justify-center bg-black bg-opacity-50 z-50">
        <div @click.away="closeDischargeModal()" class="bg-white rounded-lg shadow-lg w-96 p-6 relative">
            <h2 class="text-xl font-bold mb-4">تأكيد إخراج المريض</h2>
            <p class="mb-4">هل أنت متأكد أنك تريد إخراج المريض من الغرفة؟</p>
            <form :action="dischargeFormAction" method="POST">
                @csrf
                @method('PUT')
                <div class="flex justify-end space-x-2">
                    <button type="button" @click="closeDischargeModal()" class="px-4 py-2 bg-gray-300 rounded hover:bg-gray-400">إلغاء</button>
                    <button type="submit" class="px-4 py-2 bg-red-600 text-white rounded hover:bg-red-700">إخراج</button>
                </div>
            </form>
        </div>
    </div>

</div>

{{-- AlpineJS --}}
<script>
function hospitalRooms() {
    return {
        // الغرف
        showRoomModal: false,
        isRoomEdit: false,
        roomModalTitle: '',
        roomFormAction: '',
        roomForm: { room_number: '', type: 'single', status: 'available' },

        showAdmitModal: false,
        admitFormAction: '',

        showDischargeModal: false,
        dischargeFormAction: '',

        openRoomModal(id=null, room_number='', type='single', status='available') {
            this.showRoomModal = true;
            this.isRoomEdit = !!id;
            this.roomModalTitle = this.isRoomEdit ? 'تعديل الغرفة' : 'إضافة غرفة جديدة';
            this.roomFormAction = this.isRoomEdit ? '/rooms/'+id : '{{ route('rooms.store') }}';
            this.roomForm = { room_number, type, status };
        },
        closeRoomModal() {
            this.showRoomModal = false;
        },

        openAdmitModal(roomId) {
            this.showAdmitModal = true;
            this.admitFormAction = '/rooms/' + roomId + '/admit';
        },
        closeAdmitModal() {
            this.showAdmitModal = false;
        },

        openDischargeModal(roomId) {
            this.showDischargeModal = true;
            this.dischargeFormAction = '/rooms/' + roomId + '/discharge';
        },
        closeDischargeModal() {
            this.showDischargeModal = false;
        }
    }
}
</script>
</x-app-layout>
