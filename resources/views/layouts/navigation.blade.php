<nav class="flex-1 p-4 space-y-6 text-sm overflow-y-auto" x-data="navigation()" @click="handleLinkClick($event)">

    {{-- Dashboard --}}
    <div>
        <a href="{{ route('dashboard') }}" class="sidebar-item {{ request()->routeIs('dashboard') ? 'sidebar-active' : '' }}">
            <x-icon name="home" />
            <span x-show="!collapsed" x-transition:enter="transition ease-out duration-150" x-transition:enter-start="opacity-0" class="whitespace-nowrap">لوحة التحكم</span>
        </a>
    </div>


    {{-- ===================== إدارة النظام ===================== --}}
    @canany(['users-view', 'roles-view', 'permissions-view'])
    <div>
        <p class="sidebar-section" x-show="!collapsed" x-transition:enter="transition ease-out duration-150" x-transition:enter-start="opacity-0">إدارة النظام</p>

        <div class="space-y-1">
            @can('users-view')
            <a href="{{ route('users.index') }}" class="sidebar-item {{ request()->routeIs('users.*') ? 'sidebar-active' : '' }}">
                <x-icon name="users" />
                <span x-show="!collapsed" class="whitespace-nowrap">المستخدمون</span>
            </a>
            @endcan

            @can('roles-view')
            <a href="{{ route('roles.index') }}" class="sidebar-item {{ request()->routeIs('roles.*') ? 'sidebar-active' : '' }}">
                <x-icon name="shield" />
                <span x-show="!collapsed" class="whitespace-nowrap">الأدوار</span>
            </a>
            @endcan

            @can('permissions-view')
            <a href="{{ route('permissions.index') }}" class="sidebar-item {{ request()->routeIs('permissions.*') ? 'sidebar-active' : '' }}">
                <x-icon name="key" />
                <span x-show="!collapsed" class="whitespace-nowrap">الصلاحيات</span>
            </a>
            @endcan
        </div>
    </div>
    @endcanany



    {{-- ===================== الإدارة الطبية ===================== --}}
    @canany([
        'departments-view', 'doctors-view', 'patients-view', 'appointments-view',
        'shifts-view', 'rooms-view', 'medical-records-view', 'prescriptions-view',
        'prescription-items-view', 'medications-view', 'medicine-transactions-view', 'stock-alerts-view'
    ])
    <div>
        <p class="sidebar-section" x-show="!collapsed" x-transition:enter="transition ease-out duration-150" x-transition:enter-start="opacity-0">الإدارة الطبية</p>

        <div class="space-y-1">
            @can('departments-view')
            <a href="{{ route('departments.index') }}" class="sidebar-item {{ request()->routeIs('departments.index') ? 'sidebar-active' : '' }}">
                <x-icon name="building" />
                <span x-show="!collapsed" class="whitespace-nowrap">الأقسام</span>
            </a>
            @endcan

            @can('doctors-view')
            <a href="{{ route('doctors.index') }}" class="sidebar-item {{ request()->routeIs('doctors.index') ? 'sidebar-active' : '' }}">
                <x-icon name="user-md" />
                <span x-show="!collapsed" class="whitespace-nowrap">الأطباء</span>
            </a>
            @endcan

            @can('patients-view')
            <a href="{{ route('patients.index') }}" class="sidebar-item {{ request()->routeIs('patients.*') ? 'sidebar-active' : '' }}">
                <x-icon name="user" />
                <span x-show="!collapsed" class="whitespace-nowrap">المرضى</span>
            </a>
            @endcan

            @can('appointments-view')
            <a href="{{ route('appointments.index') }}" class="sidebar-item {{ request()->routeIs('appointments.*') ? 'sidebar-active' : '' }}">
                <x-icon name="calendar" />
                <span x-show="!collapsed" class="whitespace-nowrap">المواعيد</span>
            </a>
            @endcan

            @can('shifts-view')
            <a href="{{ route('shifts.index') }}" class="sidebar-item {{ request()->routeIs('shifts.*') ? 'sidebar-active' : '' }}">
                <x-icon name="clock" />
                <span x-show="!collapsed" class="whitespace-nowrap">الورديات</span>
            </a>
            @endcan

            @can('rooms-view')
            <a href="{{ route('rooms.index') }}" class="sidebar-item {{ request()->routeIs('rooms.*') ? 'sidebar-active' : '' }}">
                <x-icon name="bed" />
                <span x-show="!collapsed" class="whitespace-nowrap">الغرف</span>
            </a>
            @endcan

            @can('medical-records-view')
            <a href="{{ route('medical-records.index') }}" class="sidebar-item {{ request()->routeIs('medical-records.*') ? 'sidebar-active' : '' }}">
                <x-icon name="clipboard" />
                <span x-show="!collapsed" class="whitespace-nowrap">السجل الطبي</span>
            </a>
            @endcan

            @can('prescriptions-view')
            <a href="{{ route('prescriptions.index') }}" class="sidebar-item {{ request()->routeIs('prescriptions.*') ? 'sidebar-active' : '' }}">
                <x-icon name="file-medical" />
                <span x-show="!collapsed" class="whitespace-nowrap">الوصفات</span>
            </a>
            @endcan

            @can('prescription-items-view')
            <a href="{{ route('prescription-items.index') }}" class="sidebar-item {{ request()->routeIs('prescription-items.*') ? 'sidebar-active' : '' }}">
                <x-icon name="clipboard-list" />
                <span x-show="!collapsed" class="whitespace-nowrap">عناصر الوصفات</span>
            </a>
            @endcan

            @can('medications-view')
            <a href="{{ route('medications.index') }}" class="sidebar-item {{ request()->routeIs('medications.*') ? 'sidebar-active' : '' }}">
                <x-icon name="capsule" />
                <span x-show="!collapsed" class="whitespace-nowrap">الأدوية</span>
            </a>
            @endcan

            @can('medicine-transactions-view')
            <a href="{{ route('medicine-transactions.index') }}" class="sidebar-item {{ request()->routeIs('medicine-transactions.*') ? 'sidebar-active' : '' }}">
                <x-icon name="exchange" />
                <span x-show="!collapsed" class="whitespace-nowrap">المعاملات الدوائية</span>
            </a>
            @endcan

            @can('stock-alerts-view')
            <a href="{{ route('stock-alerts.index') }}" class="sidebar-item {{ request()->routeIs('stock-alerts.*') ? 'sidebar-active' : '' }}">
                <x-icon name="exclamation" />
                <span x-show="!collapsed" class="whitespace-nowrap">تنبيهات المخزون</span>
            </a>
            @endcan
        </div>
    </div>
    @endcanany



    {{-- ===================== الإدارة المالية ===================== --}}
    @canany(['invoices-view', 'invoice-items-view'])
    <div>
        <p class="sidebar-section" x-show="!collapsed" x-transition:enter="transition ease-out duration-150" x-transition:enter-start="opacity-0">الإدارة المالية</p>

        <div class="space-y-1">
            @can('invoices-view')
            <a href="{{ route('invoices.index') }}" class="sidebar-item {{ request()->routeIs('invoices.*') ? 'sidebar-active' : '' }}">
                <x-icon name="cash" />
                <span x-show="!collapsed" class="whitespace-nowrap">الفواتير</span>
            </a>
            @endcan

            @can('invoice-items-view')
            <a href="{{ route('invoice-items.index') }}" class="sidebar-item {{ request()->routeIs('invoice-items.*') ? 'sidebar-active' : '' }}">
                <x-icon name="clipboard-check" />
                <span x-show="!collapsed" class="whitespace-nowrap">عناصر الفواتير</span>
            </a>
            @endcan
        </div>
    </div>
    @endcanany

</nav>

