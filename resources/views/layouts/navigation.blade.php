<nav class="flex-1 p-3 space-y-2 text-sm overflow-y-auto">

    <!-- Dashboard -->
    <a href="{{ route('dashboard') }}"
       class="flex items-center gap-3 px-4 py-2 rounded-lg transition
              text-gray-100 font-medium
              hover:bg-blue-600 hover:text-white
              {{ request()->routeIs('dashboard') ? 'bg-blue-700 text-white shadow-lg' : '' }}"
       :title="'Dashboard'">
        <svg xmlns="http://www.w3.org/2000/svg" class="h-5 w-5 text-blue-300" fill="none"
             viewBox="0 0 24 24" stroke="currentColor">
            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
                  d="M3 3h18v18H3V3z" />
        </svg>
        <span x-show="!sidebarCollapsed">Dashboard</span>
    </a>

    <!-- Users -->
    {{-- @can('manage users') --}}
    <a href="{{ route('users.index') }}"
       class="flex items-center gap-3 px-4 py-2 rounded-lg transition
              text-gray-100 font-medium
              hover:bg-blue-600 hover:text-white
              {{ request()->routeIs('users.*') ? 'bg-blue-700 text-white shadow-lg' : '' }}"
       :title="'المستخدمون'">
        <svg xmlns="http://www.w3.org/2000/svg" class="h-5 w-5 text-yellow-300" fill="none"
             viewBox="0 0 24 24" stroke="currentColor">
            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
                  d="M5.121 17.804A5 5 0 0112 12m0 0a5 5 0 016.879 5.804M12 12v1m0 0H6m6 0h6" />
        </svg>
        <span x-show="!sidebarCollapsed">المستخدمون</span>
    </a>
    {{-- @endcan --}}

    <!-- Roles -->
    {{-- @can('manage roles') --}}
    <a href="{{ route('roles.index') }}"
       class="flex items-center gap-3 px-4 py-2 rounded-lg transition
              text-gray-100 font-medium
              hover:bg-blue-600 hover:text-white
              {{ request()->routeIs('roles.*') ? 'bg-blue-700 text-white shadow-lg' : '' }}"
       :title="'الأدوار'">
        <svg xmlns="http://www.w3.org/2000/svg" class="h-5 w-5 text-purple-300" fill="none"
             viewBox="0 0 24 24" stroke="currentColor">
            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
                  d="M12 4v16m8-8H4" />
        </svg>
        <span x-show="!sidebarCollapsed">الأدوار</span>
    </a>
    {{-- @endcan --}}

    <!-- Permissions -->
    {{-- @can('manage permissions') --}}
    <a href="{{ route('permissions.index') }}"
       class="flex items-center gap-3 px-4 py-2 rounded-lg transition
              text-gray-100 font-medium
              hover:bg-blue-600 hover:text-white
              {{ request()->routeIs('permissions.*') ? 'bg-blue-700 text-white shadow-lg' : '' }}"
       :title="'الصلاحيات'">
        <svg xmlns="http://www.w3.org/2000/svg" class="h-5 w-5 text-pink-300" fill="none"
             viewBox="0 0 24 24" stroke="currentColor">
            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
                  d="M12 8v4l3 3m6 0a9 9 0 11-18 0 9 9 0 0118 0z" />
        </svg>
        <span x-show="!sidebarCollapsed">الصلاحيات</span>
    </a>
    {{-- @endcan --}}

    <!-- Departments -->
    @can('department-list')
    <a href="{{ route('departments.index') }}"
       class="flex items-center gap-3 px-4 py-2 rounded-lg transition
              text-gray-100 font-medium
              hover:bg-blue-600 hover:text-white
              {{ request()->routeIs('departments.*') ? 'bg-blue-700 text-white shadow-lg' : '' }}"
       :title="'الأقسام'">
        <svg xmlns="http://www.w3.org/2000/svg" class="h-5 w-5 text-green-300" fill="none"
             viewBox="0 0 24 24" stroke="currentColor">
            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
                  d="M8 7V3m8 4V3m-9 8h10M5 21h14" />
        </svg>
        <span x-show="!sidebarCollapsed">الأقسام</span>
    </a>
    @endcan

    <!-- Doctors -->
    @can('view doctors')
    <a href="{{ route('doctors.index') }}"
       class="flex items-center gap-3 px-4 py-2 rounded-lg transition
              text-gray-100 font-medium
              hover:bg-blue-600 hover:text-white
              {{ request()->routeIs('doctors.*') ? 'bg-blue-700 text-white shadow-lg' : '' }}"
       :title="'الأطباء'">
        <svg xmlns="http://www.w3.org/2000/svg" class="h-5 w-5 text-teal-300" fill="none"
             viewBox="0 0 24 24" stroke="currentColor">
            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
                  d="M12 14l9-5-9-5-9 5 9 5z" />
        </svg>
        <span x-show="!sidebarCollapsed">الأطباء</span>
    </a>
    @endcan

    <!-- Patients -->
    @can('patient-list')
    <a href="{{ route('patients.index') }}"
       class="flex items-center gap-3 px-4 py-2 rounded-lg transition
              text-gray-100 font-medium
              hover:bg-blue-600 hover:text-white
              {{ request()->routeIs('patients.*') ? 'bg-blue-700 text-white shadow-lg' : '' }}"
       :title="'المرضى'">
        <svg xmlns="http://www.w3.org/2000/svg" class="h-5 w-5 text-orange-300" fill="none"
             viewBox="0 0 24 24" stroke="currentColor">
            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
                  d="M5 3v18h14V3H5z" />
        </svg>
        <span x-show="!sidebarCollapsed">المرضى</span>
    </a>
    @endcan

    <!-- Appointments -->
    @can('view appointments')
    <a href="{{ route('appointments.index') }}"
       class="flex items-center gap-3 px-4 py-2 rounded-lg transition
              text-gray-100 font-medium
              hover:bg-blue-600 hover:text-white
              {{ request()->routeIs('appointments.*') ? 'bg-blue-700 text-white shadow-lg' : '' }}"
       :title="'المواعيد'">
        <svg xmlns="http://www.w3.org/2000/svg" class="h-5 w-5 text-red-300" fill="none"
             viewBox="0 0 24 24" stroke="currentColor">
            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
                  d="M8 7V3m8 4V3M3 21h18" />
        </svg>
        <span x-show="!sidebarCollapsed">المواعيد</span>
    </a>
    @endcan

    <!-- Medical Records -->
    @can('medical_records.view')
    <a href="{{ route('medical_records.index') }}"
       class="flex items-center gap-3 px-4 py-2 rounded-lg transition
              text-gray-100 font-medium
              hover:bg-blue-600 hover:text-white
              {{ request()->routeIs('medical_records.*') ? 'bg-blue-700 text-white shadow-lg' : '' }}"
       :title="'السجل الطبي'">
        <svg xmlns="http://www.w3.org/2000/svg" class="h-5 w-5 text-indigo-300" fill="none"
             viewBox="0 0 24 24" stroke="currentColor">
            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
                  d="M9 12h6m2 0a9 9 0 11-18 0 9 9 0 0118 0z" />
        </svg>
        <span x-show="!sidebarCollapsed">السجل الطبي</span>
    </a>
    @endcan


       @can('medicine-list')
    <a href="{{ route('medicines.index') }}"
       class="flex items-center gap-3 px-4 py-2 rounded-lg transition
              text-gray-100 font-medium
              hover:bg-blue-600 hover:text-white
              {{ request()->routeIs('medicines.*') ? 'bg-blue-700 text-white shadow-lg' : '' }}"
       :title="'للأدوية'">
        <svg xmlns="http://www.w3.org/2000/svg" class="h-5 w-5 text-red-300" fill="none"
             viewBox="0 0 24 24" stroke="currentColor">
            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
                  d="M8 7V3m8 4V3M3 21h18" />
        </svg>
        <span x-show="!sidebarCollapsed">للأدوية</span>
    </a>
    @endcan
</nav>
