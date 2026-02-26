<x-app-layout>

<div class="p-3 sm:p-6 space-y-6" dir="rtl">

    {{-- رسالة نجاح --}}
    @if(session('success'))
        <div class="bg-green-100 text-green-700 p-3 rounded text-sm sm:text-base">
            {{ session('success') }}
        </div>
    @endif


    {{-- العنوان + بحث + زر --}}
    <div class="flex flex-col sm:flex-row gap-3 sm:justify-between sm:items-center">

        <form method="GET" class="w-full sm:w-auto">

            <input type="text"
                   name="search"
                   value="{{ request('search') }}"
                   placeholder="بحث باسم الدواء..."
                   class="border px-3 py-2 rounded w-full sm:w-64">

        </form>


        <button onclick="openCreateModal()"
            class="bg-blue-600 hover:bg-blue-700 text-white px-4 py-2 rounded w-full sm:w-auto">

            + إضافة وصفة

        </button>

    </div>



    {{-- عرض Desktop --}}
    <div class="hidden md:block bg-white shadow rounded overflow-x-auto">

        <table class="w-full text-sm">

            <thead class="bg-gray-100">
                <tr>
                    <th class="p-3 text-right">المريض</th>
                    <th class="p-3 text-right">الدواء</th>
                    <th class="p-3 text-right">الجرعة</th>
                    <th class="p-3 text-right">المدة</th>
                    <th class="p-3 text-center">التحكم</th>
                </tr>
            </thead>

            <tbody>

                @foreach($prescriptions as $p)

                <tr class="border-b hover:bg-gray-50">

                    <td class="p-3">
                        {{ optional(optional($p->medicalRecord)->patient)->name ?? '-' }}
                    </td>

                    <td class="p-3">
                        {{ optional($p->medication)->name ?? '-' }}
                    </td>

                    <td class="p-3">
                        {{ $p->dosage }}
                    </td>

                    <td class="p-3">
                        {{ $p->duration }}
                    </td>

                    <td class="p-3 flex gap-3 justify-center">

                        <button
                            onclick="openEditModal(
                                {{ $p->id }},
                                '{{ $p->medical_record_id }}',
                                '{{ $p->medication_id }}',
                                '{{ $p->dosage }}',
                                '{{ $p->duration }}'
                            )"
                            class="text-blue-600 hover:underline">
                            تعديل
                        </button>


                        <form method="POST"
                              action="{{ route('prescriptions.destroy',$p) }}">

                            @csrf
                            @method('DELETE')

                            <button
                                onclick="return confirm('حذف؟')"
                                class="text-red-600 hover:underline">

                                حذف

                            </button>

                        </form>

                    </td>

                </tr>

                @endforeach

            </tbody>

        </table>

    </div>



    {{-- عرض Mobile (بطاقات) --}}
    <div class="md:hidden space-y-3">

        @foreach($prescriptions as $p)

        <div class="bg-white shadow rounded p-4 space-y-2">

            <div>
                <span class="text-gray-500 text-sm">المريض:</span>
                <div class="font-semibold">
                    {{ optional(optional($p->medicalRecord)->patient)->name ?? '-' }}
                </div>
            </div>


            <div>
                <span class="text-gray-500 text-sm">الدواء:</span>
                <div>
                    {{ optional($p->medication)->name ?? '-' }}
                </div>
            </div>


            <div class="flex justify-between">

                <div>
                    <span class="text-gray-500 text-sm">الجرعة</span>
                    <div>{{ $p->dosage }}</div>
                </div>


                <div>
                    <span class="text-gray-500 text-sm">المدة</span>
                    <div>{{ $p->duration }}</div>
                </div>

            </div>


            <div class="flex justify-between pt-2 border-t">

                <button
                    onclick="openEditModal(
                        {{ $p->id }},
                        '{{ $p->medical_record_id }}',
                        '{{ $p->medication_id }}',
                        '{{ $p->dosage }}',
                        '{{ $p->duration }}'
                    )"
                    class="text-blue-600">

                    تعديل

                </button>


                <form method="POST"
                      action="{{ route('prescriptions.destroy',$p) }}">

                    @csrf
                    @method('DELETE')

                    <button
                        onclick="return confirm('حذف؟')"
                        class="text-red-600">

                        حذف

                    </button>

                </form>

            </div>

        </div>

        @endforeach

    </div>



    <div>
        {{ $prescriptions->links() }}
    </div>


</div>




{{-- Modal --}}
<div id="modal"
     class="fixed inset-0 bg-black/50 hidden items-center justify-center p-3 z-50">

    <div class="bg-white rounded shadow w-full max-w-md p-4 sm:p-6">

        <h2 id="modalTitle"
            class="text-lg font-bold mb-4 text-center">
        </h2>


        <form method="POST" id="form">

            @csrf
            <span id="method"></span>


          <select name="medical_record_id"
        id="record"
        required
        class="w-full border p-2 mb-3 rounded">

    <option value="">
        اختر المريض
    </option>

    @forelse($records as $record)

        <option value="{{ $record->id }}">

            {{ $record->patient?->name ?? 'مريض غير معروف' }}

        </option>

    @empty

        <option disabled>
            لا يوجد مرضى
        </option>

    @endforelse

</select>

            <select name="medication_id"
                    id="medication"
                    class="w-full border p-2 mb-3 rounded">

                @foreach($medications as $m)
                    <option value="{{ $m->id }}">
                        {{ $m->name }}
                    </option>
                @endforeach

            </select>


            <input type="text"
                   name="dosage"
                   id="dosage"
                   placeholder="الجرعة"
                   class="w-full border p-2 mb-3 rounded">


            <input type="text"
                   name="duration"
                   id="duration"
                   placeholder="المدة"
                   class="w-full border p-2 mb-4 rounded">



            <div class="flex flex-col sm:flex-row gap-2">

                <button
                    class="bg-blue-600 hover:bg-blue-700 text-white px-4 py-2 rounded w-full">

                    حفظ

                </button>


                <button
                    type="button"
                    onclick="closeModal()"
                    class="bg-gray-400 hover:bg-gray-500 text-white px-4 py-2 rounded w-full">

                    إلغاء

                </button>

            </div>


        </form>

    </div>

</div>




<script>

const modal=document.getElementById('modal')
const modalTitle=document.getElementById('modalTitle')
const form=document.getElementById('form')
const method=document.getElementById('method')


function openCreateModal()
{
    modal.classList.remove('hidden')
    modal.classList.add('flex')

    modalTitle.innerText="إضافة وصفة"

    form.action="{{ route('prescriptions.store') }}"

    method.innerHTML=""

    form.reset()
}



function openEditModal(id,record,medication,dosage,duration)
{
    modal.classList.remove('hidden')
    modal.classList.add('flex')

    modalTitle.innerText="تعديل وصفة"

    form.action="/prescriptions/"+id

    method.innerHTML='@method("PUT")'

    document.getElementById('record').value=record
    document.getElementById('medication').value=medication
    document.getElementById('dosage').value=dosage
    document.getElementById('duration').value=duration
}



function closeModal()
{
    modal.classList.add('hidden')
    modal.classList.remove('flex')
}

</script>


</x-app-layout>
