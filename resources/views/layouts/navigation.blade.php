<nav class="flex-1 p-3 space-y-2 text-sm overflow-y-auto">

            <a href="{{ route('dashboard') }}"
               class="flex items-center gap-3 px-3 py-2 rounded-lg hover:bg-blue-700">
                <span>📊</span>
                <span x-show="!sidebarCollapsed">Dashboard</span>
            </a>
 @can('manage users')
            <a href="{{ route('users.index') }}"
               class="flex items-center gap-3 px-3 py-2 rounded-lg hover:bg-blue-700">
                <span>👤</span>
                <span x-show="!sidebarCollapsed">المستخدمون</span>
            </a>
              @endcan
             @can('manage roles')
                  <a href="{{ route('roles.index') }}"
               class="flex items-center gap-3 px-3 py-2 rounded-lg hover:bg-blue-700">
                <span>👤</span>
                <span x-show="!sidebarCollapsed">الأدوار</span>
            </a>
             @endcan
             @can('manage permissions')
                  <a href="{{ route('permissions.index') }}"
               class="flex items-center gap-3 px-3 py-2 rounded-lg hover:bg-blue-700">
                <span>👤</span>
                <span x-show="!sidebarCollapsed"> الصلاحيات</span>
            </a>
             @endcan


                     @can('department-list')
                  <a href="{{ route('departments.index') }}"
               class="flex items-center gap-3 px-3 py-2 rounded-lg hover:bg-blue-700">
                <span>👤</span>
                <span x-show="!sidebarCollapsed">الأقسام</span>
            </a>
              @endcan
   @can('view doctors')
                  <a href="{{ route('doctors.index') }}"
               class="flex items-center gap-3 px-3 py-2 rounded-lg hover:bg-blue-700">
                <span>👤</span>
                <span x-show="!sidebarCollapsed">الأطباء</span>
            </a>
              @endcan

 @can('patient-list')
                  <a href="{{ route('patients.index') }}"
               class="flex items-center gap-3 px-3 py-2 rounded-lg hover:bg-blue-700">
                <span>👤</span>
                <span x-show="!sidebarCollapsed">المرضى</span>
            </a>
   @endcan
 @can('view appointments')
                       <a href="{{ route('appointments.index') }}"
               class="flex items-center gap-3 px-3 py-2 rounded-lg hover:bg-blue-700">
                <span>👤</span>
                <span x-show="!sidebarCollapsed">المواعيد</span>
            </a>
 @endcan
  @can('medical_records.view')
                       <a href="{{ route('medical_records.index') }}"
               class="flex items-center gap-3 px-3 py-2 rounded-lg hover:bg-blue-700">
                <span>👤</span>
                <span x-show="!sidebarCollapsed"> السجل الطبي</span>
            </a>
 @endcan
        </nav>