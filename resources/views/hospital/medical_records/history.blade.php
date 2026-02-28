<x-app-layout>

<div class="p-6 bg-gray-50 min-h-screen" dir="rtl">

    {{-- معلومات المريض --}}
    <div class="bg-white p-6 rounded shadow mb-6">

        <h1 class="text-2xl font-bold mb-2">
            الملف الطبي
        </h1>
<a href="{{ route('patients.prescriptions.pdf', $patient->id) }}"
   class="bg-green-700 text-white px-4 py-2 rounded mb-4 inline-block">
   تحميل جميع الوصفات PDF
</a>
        <div class="text-gray-700">

            <div>
                الاسم:
                <span class="font-bold">
                    {{ $patient->name }}
                </span>
            </div>

            <div>
                رقم المريض:
                {{ $patient->id }}
            </div>

        </div>

    </div>



    {{-- Timeline --}}
    <div class="bg-white p-6 rounded shadow">

        <h2 class="font-bold mb-6">
            التاريخ الطبي
        </h2>


        <div class="relative border-r-2 border-blue-500">

            @forelse($records as $record)

            <div class="mb-6 mr-6">

                {{-- النقطة --}}
                <div
                    class="absolute w-4 h-4 bg-blue-600 rounded-full -right-2">
                </div>


                <div class="bg-gray-50 p-4 rounded shadow">

                    <div class="flex justify-between">

                        <span class="font-bold">
                            {{ $record->visit_date }}
                        </span>

                        <span class="text-sm text-gray-500">
                            د.
                            {{ $record->doctor->name }}
                        </span>

                    </div>


                    <div class="mt-2">

                        <div>
                            <span class="font-bold">
                                التشخيص:
                            </span>

                            {{ $record->diagnosis ?? '-' }}
                        </div>


                        <div>
                            <span class="font-bold">
                                العلاج:
                            </span>

                            {{ $record->treatment ?? '-' }}
                        </div>


                        @if($record->notes)

                        <div>
                            <span class="font-bold">
                                ملاحظات:
                            </span>

                            {{ $record->notes }}
                        </div>

                        @endif

                    </div>

                </div>

            </div>

            @empty

            <div class="text-gray-500">
                لا يوجد سجل طبي
            </div>

            @endforelse

        </div>

    </div>


    {{-- زر رجوع --}}
    <div class="mt-6">

        <a href="{{ url()->previous() }}"
            class="bg-gray-600 text-white px-4 py-2 rounded">

            رجوع

        </a>

    </div>

</div>

</x-app-layout>
