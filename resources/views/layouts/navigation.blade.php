<nav class="flex-1 p-4 space-y-6 text-sm overflow-y-auto">

    {{-- Dashboard --}}
    <div>
        <a href="{{ route('dashboard') }}"
           class="sidebar-item {{ request()->routeIs('dashboard') ? 'sidebar-active' : '' }}">
            <x-icon name="home" />
            <span x-show="!sidebarCollapsed">لوحة التحكم</span>
        </a>
    </div>


    {{-- ===================== إدارة النظام ===================== --}}
    @canany(['manage user','manage roles','permission manage'])
    <div>

        <p class="sidebar-section" x-show="!sidebarCollapsed">
            إدارة النظام
        </p>

        <div class="space-y-1">

            @can('manage user')
            <a href="{{ route('users.index') }}"
               class="sidebar-item {{ request()->routeIs('users.*') ? 'sidebar-active' : '' }}">
                <x-icon name="users" />
                <span x-show="!sidebarCollapsed">المستخدمون</span>
            </a>
            @endcan

            @can('manage roles')
            <a href="{{ route('roles.index') }}"
               class="sidebar-item {{ request()->routeIs('roles.*') ? 'sidebar-active' : '' }}">
                <x-icon name="shield" />
                <span x-show="!sidebarCollapsed">الأدوار</span>
            </a>
            @endcan

            @can('permission manage')
            <a href="{{ route('permissions.index') }}"
               class="sidebar-item {{ request()->routeIs('permissions.*') ? 'sidebar-active' : '' }}">
                <x-icon name="key" />
                <span x-show="!sidebarCollapsed">الصلاحيات</span>
            </a>
            @endcan

        </div>
    </div>
    @endcanany



    {{-- ===================== الإدارة الطبية ===================== --}}
    <div>

        <p class="sidebar-section" x-show="!sidebarCollapsed">
            الإدارة الطبية
        </p>

        <div class="space-y-1">

            {{-- الأقسام --}}
            <a href="{{ route('departments.index') }}"
               class="sidebar-item {{ request()->routeIs('departments.index') ? 'sidebar-active' : '' }}">
                <x-icon name="building" />
                <span x-show="!sidebarCollapsed">الأقسام</span>
            </a>

            {{-- الأطباء --}}
            <a href="{{ route('doctors.index') }}"
               class="sidebar-item {{ request()->routeIs('doctors.index') ? 'sidebar-active' : '' }}">
                <x-icon name="user-md" />
                <span x-show="!sidebarCollapsed">الأطباء</span>
            </a>

            {{-- المرضى --}}
            <a href="{{ route('patients.index') }}"
               class="sidebar-item {{ request()->routeIs('patients.*') ? 'sidebar-active' : '' }}">
                <x-icon name="user" />
                <span x-show="!sidebarCollapsed">المرضى</span>
            </a>

            {{-- المواعيد --}}
            <a href="{{ route('appointments.index') }}"
               class="sidebar-item {{ request()->routeIs('appointments.*') ? 'sidebar-active' : '' }}">
                <x-icon name="calendar" />
                <span x-show="!sidebarCollapsed">المواعيد</span>
            </a>

            {{-- الغرف --}}
            <a href="{{ route('rooms.index') }}"
               class="sidebar-item {{ request()->routeIs('rooms.*') ? 'sidebar-active' : '' }}">
                <x-icon name="bed" />
                <span x-show="!sidebarCollapsed">الغرف</span>
            </a>

            {{-- السجل الطبي --}}
            <a href="{{ route('medical-records.index') }}"
               class="sidebar-item {{ request()->routeIs('medical-records.*') ? 'sidebar-active' : '' }}">
                <x-icon name="clipboard" />
                <span x-show="!sidebarCollapsed">السجل الطبي</span>
            </a>

            {{-- الوصفات --}}
            <a href="{{ route('prescriptions.index') }}"
               class="sidebar-item {{ request()->routeIs('prescriptions.*') ? 'sidebar-active' : '' }}">
                <x-icon name="file-medical" />
                <span x-show="!sidebarCollapsed">الوصفات</span>
            </a>

            {{-- الأدوية --}}
            <a href="{{ route('medications.index') }}"
               class="sidebar-item {{ request()->routeIs('medications.*') ? 'sidebar-active' : '' }}">
                <x-icon name="capsule" />
                <span x-show="!sidebarCollapsed">الأدوية</span>
            </a>

        </div>
    </div>



    {{-- ===================== الإدارة المالية ===================== --}}
    <div>

        <p class="sidebar-section" x-show="!sidebarCollapsed">
            الإدارة المالية
        </p>

        <div class="space-y-1">

            <a href="{{ route('invoices.index') }}"
               class="sidebar-item {{ request()->routeIs('invoices.*') ? 'sidebar-active' : '' }}">
                <x-icon name="cash" />
                <span x-show="!sidebarCollapsed">الفواتير</span>
            </a>

        </div>
    </div>

</nav>

