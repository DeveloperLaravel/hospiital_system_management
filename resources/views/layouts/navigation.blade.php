<!-- Sidebar -->
<aside
    class="fixed md:static z-30 w-64 bg-blue-900 text-white min-h-screen transform md:translate-x-0 transition"
    :class="open ? 'translate-x-0' : 'translate-x-full md:translate-x-0'"
>
    <div class="p-6 text-xl font-bold border-b border-blue-700">
        🏥 إدارة المستشفى
    </div>

<nav class="p-4 space-y-4">

    <!-- النظام -->
    <div>
        <p class="text-xs uppercase text-blue-200 mb-2 tracking-wider">
            النظام
        </p>

        <a href="{{ route('dashboard') }}" class="block p-3 rounded hover:bg-blue-700">
            Dashboard
        </a>
    </div>

    <!-- إدارة المستخدمين (Admin فقط أو من لديه صلاحيات) -->
    @can('manage users')
    <div class="border-t border-blue-500/40"></div>

    <div>
        <p class="text-xs uppercase text-blue-200 mb-2 tracking-wider">
            إدارة المستخدمين
        </p>

        <a href="{{ route('users.index') }}" class="block p-3 rounded hover:bg-blue-700">
            المستخدمون
        </a>
    </div>
    @endcan

    @can('manage roles')
    <a href="{{ route('roles.index') }}" class="block p-3 rounded hover:bg-blue-700">
        الأدوار
    </a>
    @endcan

    @can('manage permissions')
    <a href="{{ route('permissions.index') }}" class="block p-3 rounded hover:bg-blue-700">
        الصلاحيات
    </a>
    @endcan


    <!-- إدارة المستشفى -->
    <div class="border-t border-blue-500/40"></div>

    <div>
        <p class="text-xs uppercase text-blue-200 mb-2 tracking-wider">
            إدارة المستشفى
        </p>

        @can('department-list')
        <a href="{{ route('departments.index') }}" class="block p-3 rounded hover:bg-blue-700">
            الأقسام
        </a>
        @endcan

        @can('view doctors')
        <a href="{{ route('doctors.index') }}" class="block p-3 rounded hover:bg-blue-700">
            الأطباء
        </a>
        @endcan

        @can('patient-list')
        <a href="{{ route('patients.index') }}" class="block p-3 rounded hover:bg-blue-700">
            المرضى
        </a>
        @endcan

        @can('view appointments')
        <a href="{{ route('appointments.index') }}" class="block p-3 rounded hover:bg-blue-700">
            المواعيد
        </a>
        @endcan
              @can('medical_records.view')
        <a href="{{ route('medical_records.index') }}" class="block p-3 rounded hover:bg-blue-700">
           للسجل الطبي
        </a>
      
        @endcan
    </div>

</nav>
</aside>
