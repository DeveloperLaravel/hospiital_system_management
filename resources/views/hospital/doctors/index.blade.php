<x-app-layout title="إدارة الأطباء">
          <main class="p-6 flex-1 overflow-auto" dir="rtl" lang="ar">

<div class="grid grid-cols-1 md:grid-cols-3 gap-6">

    <!-- جدول الأطباء -->
    <div class="md:col-span-2 bg-white shadow rounded-lg p-4">
        <h2 class="text-xl font-bold mb-4">قائمة الأطباء</h2>

        <table class="w-full text-right">
            <thead class="bg-gray-50">
                <tr>
                    <th class="p-2">الاسم</th>
                    <th class="p-2">القسم</th>
                    <th class="p-2">التخصص</th>
                    <th class="p-2">الإجراءات</th>
                </tr>
            </thead>

            <tbody>
                @foreach($doctors as $doctor)
                    <tr class="border-t">
                        <td class="p-2">{{ $doctor->name }}</td>
                        <td class="p-2">{{ $doctor->department->name }}</td>
                        <td class="p-2">{{ $doctor->specialization }}</td>

                        <td class="p-2">
                            <a href="{{ route('doctors.index', ['edit' => $doctor->id]) }}"
                               class="text-yellow-600 font-semibold">
                                تعديل
                            </a>
@can('doctor-delete')
                            <form method="POST"
                                  action="{{ route('doctors.destroy', $doctor) }}"
                                  class="inline">
                                @csrf
                                @method('DELETE')
                                <button class="text-red-600">حذف</button>
                            </form>
                            @endcan
                        </td>
                    </tr>
                @endforeach
            </tbody>
        </table>
    </div>

    <!-- الفورم -->
    <div class="bg-white shadow rounded-lg p-4">
        <h2 class="text-xl font-bold mb-4">
            {{ isset($editDoctor) ? 'تعديل الطبيب' : 'إضافة طبيب' }}
        </h2>

        <form method="POST"
              action="{{ isset($editDoctor)
                        ? route('doctors.update', $editDoctor)
                        : route('doctors.store') }}">

            @csrf
            @if(isset($editDoctor))
                @method('PUT')
            @endif

            <input name="name"
                   placeholder="اسم الطبيب"
                   value="{{ $editDoctor->name ?? '' }}"
                   class="w-full border p-2 rounded mb-2">

            <select name="department_id" class="w-full border p-2 rounded mb-2">
                @foreach($departments as $id => $name)
                    <option value="{{ $id }}"
                        {{ (isset($editDoctor) && $editDoctor->department_id == $id) ? 'selected' : '' }}>
                        {{ $name }}
                    </option>
                @endforeach
            </select>

            <input name="specialization"
                   placeholder="التخصص"
                   value="{{ $editDoctor->specialization ?? '' }}"
                   class="w-full border p-2 rounded mb-2">

            <input name="phone"
                   placeholder="الهاتف"
                   value="{{ $editDoctor->phone ?? '' }}"
                   class="w-full border p-2 rounded mb-2">

            <input name="license_number"
                   placeholder="رقم الترخيص"
                   value="{{ $editDoctor->license_number ?? '' }}"
                   class="w-full border p-2 rounded mb-3">

            <button class="bg-blue-600 text-white px-4 py-2 rounded w-full">
                {{ isset($editDoctor) ? 'تحديث' : 'حفظ' }}
            </button>
        </form>
    </div>
{{-- <livewire:appointments /> --}}

</div>


    </main>
</x-app-layout>
