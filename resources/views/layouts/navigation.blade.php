<aside
    class="fixed md:static z-30 w-64 bg-gradient-to-b from-blue-900 to-blue-800 text-white
           min-h-screen transform md:translate-x-0 transition duration-200 shadow-xl"
    :class="open ? 'translate-x-0' : 'translate-x-full md:translate-x-0'"
>

    <div class="p-6 text-xl font-bold border-b border-blue-700 tracking-wide">
        🏥 إدارة المستشفى
    </div>

    <nav class="p-4 space-y-2 text-sm">

        <p class="text-xs uppercase text-blue-200 mt-2 mb-1">النظام</p>

        <a href="{{ route('dashboard') }}"
           class="block px-4 py-2 rounded-lg hover:bg-blue-700/70 transition">
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
</aside>
