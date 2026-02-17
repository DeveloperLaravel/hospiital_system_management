

    <nav class="flex-1 p-3 space-y-2 text-sm">

        <p class="text-xs uppercase text-blue-200 mt-2 mb-1">النظام</p>

        <a href="{{ route('dashboard') }}"
           class="flex items-center gap-3 px-3 py-2 rounded-lg hover:bg-blue-700 transition">
            Dashboard
        </a>

        @can('manage users')
        <p class="text-xs uppercase text-blue-200 mt-4 mb-1">إدارة المستخدمين</p>

        <a href="{{ route('users.index') }}"
           class="block px-4 py-2 rounded-lg hover:bg-blue-700/70 transition">
            المستخدمون
        </a>
        @endcan

        @can('manage roles')
        <a href="{{ route('roles.index') }}"
           class="block px-4 py-2 rounded-lg hover:bg-blue-700/70 transition">
            الأدوار
        </a>
        @endcan

        @can('manage permissions')
        <a href="{{ route('permissions.index') }}"
           class="block px-4 py-2 rounded-lg hover:bg-blue-700/70 transition">
            الصلاحيات
        </a>
        @endcan

        <p class="text-xs uppercase text-blue-200 mt-4 mb-1">إدارة المستشفى</p>

        @can('department-list')
        <a href="{{ route('departments.index') }}"
           class="block px-4 py-2 rounded-lg hover:bg-blue-700/70 transition">
            الأقسام
        </a>
        @endcan

        @can('view doctors')
        <a href="{{ route('doctors.index') }}"
           class="block px-4 py-2 rounded-lg hover:bg-blue-700/70 transition">
            الأطباء
        </a>
        @endcan

        @can('patient-list')
        <a href="{{ route('patients.index') }}"
           class="block px-4 py-2 rounded-lg hover:bg-blue-700/70 transition">
            المرضى
        </a>
        @endcan

        @can('view appointments')
        <a href="{{ route('appointments.index') }}"
           class="block px-4 py-2 rounded-lg hover:bg-blue-700/70 transition">
            المواعيد
        </a>
        @endcan

        @can('medical_records.view')
        <a href="{{ route('medical_records.index') }}"
           class="block px-4 py-2 rounded-lg hover:bg-blue-700/70 transition">
            السجل الطبي
        </a>
        @endcan

    </nav>
