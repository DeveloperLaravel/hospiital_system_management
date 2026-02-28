 <x-app-layout>

    
 {{-- البحث --}}
    <form class="mb-3">

        <div class="input-group">

            <input
                name="search"
                class="form-control"
                placeholder="بحث باسم المريض او الطبيب"
                value="{{ request('search') }}"
            >

            <button class="btn btn-primary">
                بحث
            </button>
            
        <button onclick="window.print()"
            class="bg-gray-700 text-white px-4 py-2 rounded">
            طباعة
        </button>
        <a
 href="{{ route('patients.history',$record->patient_id) }}"
 class="bg-blue-600 text-white px-3 py-1 rounded">
 التاريخ
</a>
<a
 href="{{ route('patients.history.pdf',$patient->id) }}"
 class="bg-green-600 text-white px-4 py-2 rounded">

تحميل PDF

</a>
<a
 href="{{ route('patients.history.pdf',$patient->id) }}"
 class="bg-green-600 text-white px-4 py-2 rounded">

تقرير PDF

</a>


        </div>

    </form>


    {{-- إضافة --}}
    <form method="POST" action="{{ route('medical-records.store') }}">

        @csrf

        <div class="row mb-3">

            <div class="col">
                <select name="patient_id" class="form-control" required>
                    <option value="">المريض</option>

                    @foreach($patients as $id=>$name)
                        <option value="{{ $id }}">
                            {{ $name }}
                        </option>
                    @endforeach

                </select>
            </div>


            <div class="col">
                <select name="doctor_id" class="form-control" required>

                    <option value="">الطبيب</option>

                    @foreach($doctors as $id=>$name)
                        <option value="{{ $id }}">
                            {{ $name }}
                        </option>
                    @endforeach

                </select>
            </div>


            <div class="col">
                <input
                    type="date"
                    name="visit_date"
                    class="form-control"
                >
            </div>

        </div>


        <textarea
            name="diagnosis"
            class="form-control mb-2"
            placeholder="التشخيص"
        ></textarea>


        <textarea
            name="treatment"
            class="form-control mb-2"
            placeholder="العلاج"
        ></textarea>


        <textarea
            name="notes"
            class="form-control mb-2"
            placeholder="ملاحظات"
        ></textarea>


        <button class="btn btn-success">
            إضافة
        </button>

    </form>



    {{-- الجدول --}}
    <table class="table mt-4 table-bordered">

        <thead>

            <tr>

                <th>#</th>
                <th>المريض</th>
                <th>الطبيب</th>
                <th>التاريخ</th>
                <th>التشخيص</th>
                <th width="200">التحكم</th>

            </tr>

        </thead>


        <tbody>

            @foreach($records as $record)

                <tr>

                    <td>
                        {{ $record->id }}
                    </td>

                    <td>
                        {{ $record->patient->name }}
                    </td>

                    <td>
                        {{ $record->doctor->name }}
                    </td>

                    <td>
                        {{ $record->visit_date }}
                    </td>

                    <td>
                        {{ $record->diagnosis }}
                    </td>


                    <td>

                        <a
                            href="{{ route('medical-records.show',$record) }}"
                            class="btn btn-info btn-sm"
                        >
                            عرض
                        </a>


                        {{-- حذف --}}
                        <form
                            method="POST"
                            action="{{ route('medical-records.destroy',$record) }}"
                            style="display:inline"
                        >

                            @csrf
                            @method('DELETE')

                            <button class="btn btn-danger btn-sm">
                                حذف
                            </button>

                        </form>

                    </td>

                </tr>

            @endforeach

        </tbody>

    </table>


    {{ $records->links() }}

</div>

    </x-app-layout>
