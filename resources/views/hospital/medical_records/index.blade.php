<x-app-layout>

<main class="min-h-screen bg-gray-50 p-6 flex-1 overflow-auto"
      dir="rtl"
      x-data="{ open:false, isEdit:false, id:null, name:'', description:'' }">

<div class="max-w-7xl mx-auto">

    <!-- Header -->
    <div class="flex justify-between items-center mb-6">

    {{-- HEADER --}}
    <div class="page-header mb-4 d-flex justify-content-between align-items-center">

        <div>

            <h3 class="fw-bold mb-1">
                🏥 السجلات الطبية
            </h3>

            <small>
                إدارة وتشخيص المرضى بسهولة
            </small>

        </div>

        <button onclick="window.print()" class="btn btn-light fw-bold">

            🖨 طباعة

        </button>

    </div>



    {{-- STATS --}}
    <div class="row mb-4">

        <div class="col-md-6">

            <div class="stat-card stat-blue">

                📄 عدد السجلات
                <h4 class="fw-bold">
                    {{ $records->total() }}
                </h4>

            </div>

        </div>


        <div class="col-md-6">

            <div class="stat-card stat-green">

                📅 سجلات اليوم
                <h4 class="fw-bold">
                    {{ $records->where('visit_date',today())->count() }}
                </h4>

            </div>

        </div>

    </div>




    {{-- SEARCH --}}
    <div class="soft-card p-3 mb-4">

        <form class="row g-2">

            <div class="col-md-10">

                <input
                    name="search"
                    class="form-control"
                    placeholder="🔎 بحث باسم المريض أو الطبيب"
                    value="{{ request('search') }}"
                >

            </div>

            <div class="col-md-2 d-grid">

                <button class="btn btn-primary">

                    بحث

                </button>

            </div>

        </form>

    </div>




    {{-- ADD --}}
    <div class="soft-card p-4 mb-4">

        <h5 class="fw-bold mb-3 text-primary">

            ➕ إضافة سجل جديد

        </h5>


        <form method="POST"
              action="{{ route('medical-records.store') }}">

            @csrf


            <div class="row g-3">


                <div class="col-md-4">

                    <label class="fw-bold mb-1">

                        المريض

                    </label>

                    <select name="patient_id"
                            class="form-select"
                            required>

                        <option value="">
                            اختر
                        </option>

                        @foreach($patients as $id=>$name)

                            <option value="{{ $id }}">
                                {{ $name }}
                            </option>

                        @endforeach

                    </select>

                </div>



                <div class="col-md-4">

                    <label class="fw-bold mb-1">

                        الطبيب

                    </label>

                    <select name="doctor_id"
                            class="form-select"
                            required>

                        <option value="">
                            اختر
                        </option>

                        @foreach($doctors as $id=>$name)

                            <option value="{{ $id }}">
                                {{ $name }}
                            </option>

                        @endforeach

                    </select>

                </div>



                <div class="col-md-4">

                    <label class="fw-bold mb-1">

                        التاريخ

                    </label>

                    <input type="date"
                           name="visit_date"
                           class="form-control">

                </div>


                <div class="col-md-4">

                    <label class="fw-bold">

                        التشخيص

                    </label>

                    <input name="diagnosis"
                           class="form-control">

                </div>



                <div class="col-md-4">

                    <label class="fw-bold">

                        العلاج

                    </label>

                    <input name="treatment"
                           class="form-control">

                </div>



                <div class="col-md-4">

                    <label class="fw-bold">

                        ملاحظات

                    </label>

                    <input name="notes"
                           class="form-control">

                </div>


            </div>


            <button class="btn btn-success mt-3">

                💾 حفظ

            </button>


        </form>

    </div>




    {{-- TABLE --}}
    <div class="soft-card p-3">

        <h5 class="fw-bold mb-3 text-primary">

            📋 جميع السجلات

        </h5>


        <div class="table-responsive">

            <table class="table text-center align-middle">


                <thead>

                    <tr>

                        <th>#</th>
                        <th>المريض</th>
                        <th>الطبيب</th>
                        <th>التاريخ</th>
                        <th>التشخيص</th>
                        <th>التحكم</th>

                    </tr>

                </thead>


                <tbody>

                    @forelse($records as $record)

                        <tr>

                            <td class="fw-bold text-primary">
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

                            <td class="text-muted">
                                {{ Str::limit($record->diagnosis,30) }}
                            </td>

                            <td>


                                <a href="{{ route('medical-records.show',$record) }}"
                                   class="btn btn-info btn-sm">

                                    عرض

                                </a>


                                <a href="{{ route('medical-records.edit',$record) }}"
                                   class="btn btn-warning btn-sm">

                                    تعديل

                                </a>


                                <form method="POST"
                                      action="{{ route('medical-records.destroy',$record) }}"
                                      style="display:inline">

                                    @csrf
                                    @method('DELETE')

                                    <button class="btn btn-danger btn-sm">

                                        حذف

                                    </button>

                                </form>


                            </td>

                        </tr>

                    @empty

                        <tr>

                            <td colspan="6" class="text-muted p-4">

                                لا توجد بيانات

                            </td>

                        </tr>

                    @endforelse


                </tbody>


            </table>

        </div>


        {{ $records->links() }}


    </div>


</div>


</x-app-layout>
