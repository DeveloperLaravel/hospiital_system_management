<nav class="flex-1 p-4 space-y-6 text-sm overflow-y-auto" x-data="navigation()" @click="handleLinkClick($event)">

    {{-- Dashboard --}}
    <div>
        <a href="{{ route('dashboard') }}" class="sidebar-item {{ request()->routeIs('dashboard') ? 'sidebar-active' : '' }}">
            <x-icon name="home" />
            <span x-show="!collapsed" x-transition:enter="transition ease-out duration-150" x-transition:enter-start="opacity-0" class="whitespace-nowrap">لوحة التحكم</span>
        </a>
    </div>


    {{-- ===================== إدارة النظام ===================== --}}
    @canany(['manage user','manage roles','permission manage'])
    <div>
        <p class="sidebar-section" x-show="!collapsed" x-transition:enter="transition ease-out duration-150" x-transition:enter-start="opacity-0">إدارة النظام</p>

        <div class="space-y-1">
            @can('manage user')
            <a href="{{ route('users.index') }}" class="sidebar-item {{ request()->routeIs('users.*') ? 'sidebar-active' : '' }}">
                <x-icon name="users" />
                <span x-show="!collapsed" class="whitespace-nowrap">المستخدمون</span>
            </a>
            @endcan

            @can('manage roles')
            <a href="{{ route('roles.index') }}" class="sidebar-item {{ request()->routeIs('roles.*') ? 'sidebar-active' : '' }}">
                <x-icon name="shield" />
                <span x-show="!collapsed" class="whitespace-nowrap">الأدوار</span>
            </a>
            @endcan

            @can('permission manage')
            <a href="{{ route('permissions.index') }}" class="sidebar-item {{ request()->routeIs('permissions.*') ? 'sidebar-active' : '' }}">
                <x-icon name="key" />
                <span x-show="!collapsed" class="whitespace-nowrap">الصلاحيات</span>
            </a>
            @endcan
        </div>
    </div>
    @endcanany



    {{-- ===================== الإدارة الطبية ===================== --}}
    <div>
        <p class="sidebar-section" x-show="!collapsed" x-transition:enter="transition ease-out duration-150" x-transition:enter-start="opacity-0">الإدارة الطبية</p>

        <div class="space-y-1">
            <a href="{{ route('departments.index') }}" class="sidebar-item {{ request()->routeIs('departments.index') ? 'sidebar-active' : '' }}">
                <x-icon name="building" />
                <span x-show="!collapsed" class="whitespace-nowrap">الأقسام</span>
            </a>

            <a href="{{ route('doctors.index') }}" class="sidebar-item {{ request()->routeIs('doctors.index') ? 'sidebar-active' : '' }}">
                <x-icon name="user-md" />
                <span x-show="!collapsed" class="whitespace-nowrap">الأطباء</span>
            </a>

            <a href="{{ route('patients.index') }}" class="sidebar-item {{ request()->routeIs('patients.*') ? 'sidebar-active' : '' }}">
                <x-icon name="user" />
                <span x-show="!collapsed" class="whitespace-nowrap">المرضى</span>
            </a>

            <a href="{{ route('appointments.index') }}" class="sidebar-item {{ request()->routeIs('appointments.*') ? 'sidebar-active' : '' }}">
                <x-icon name="calendar" />
                <span x-show="!collapsed" class="whitespace-nowrap">المواعيد</span>
            </a>

            <a href="{{ route('rooms.index') }}" class="sidebar-item {{ request()->routeIs('rooms.*') ? 'sidebar-active' : '' }}">
                <x-icon name="bed" />
                <span x-show="!collapsed" class="whitespace-nowrap">الغرف</span>
            </a>

            <a href="{{ route('medical-records.index') }}" class="sidebar-item {{ request()->routeIs('medical-records.*') ? 'sidebar-active' : '' }}">
                <x-icon name="clipboard" />
                <span x-show="!collapsed" class="whitespace-nowrap">السجل الطبي</span>
            </a>

            <a href="{{ route('prescriptions.index') }}" class="sidebar-item {{ request()->routeIs('prescriptions.*') ? 'sidebar-active' : '' }}">
                <x-icon name="file-medical" />
                <span x-show="!collapsed" class="whitespace-nowrap">الوصفات</span>
            </a>

            <a href="{{ route('medications.index') }}" class="sidebar-item {{ request()->routeIs('medications.*') ? 'sidebar-active' : '' }}">
                <x-icon name="capsule" />
                <span x-show="!collapsed" class="whitespace-nowrap">الأدوية</span>
            </a>
        </div>
    </div>



    {{-- ===================== الإدارة المالية ===================== --}}
    <div>
        <p class="sidebar-section" x-show="!collapsed" x-transition:enter="transition ease-out duration-150" x-transition:enter-start="opacity-0">الإدارة المالية</p>

        <div class="space-y-1">
            <a href="{{ route('invoices.index') }}" class="sidebar-item {{ request()->routeIs('invoices.*') ? 'sidebar-active' : '' }}">
                <x-icon name="cash" />
                <span x-show="!collapsed" class="whitespace-nowrap">الفواتير</span>
            </a>
        </div>
    </div>

</nav>
