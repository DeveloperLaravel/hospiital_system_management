<nav class="flex-1 p-4 space-y-8 text-sm overflow-y-auto">

    {{-- Dashboard --}}
    <div>
        <a href="{{ route('dashboard') }}"
           class="sidebar-item {{ request()->routeIs('dashboard') ? 'sidebar-active' : '' }}">
            <span x-show="!sidebarCollapsed">لوحة التحكم</span>
        </a>
    </div>

    {{-- إدارة النظام --}}
    @canany(['manage user','manage roles','permission manage'])
    <div>

        <p class="sidebar-section" x-show="!sidebarCollapsed">
            إدارة النظام
        </p>

        <div class="space-y-1">

            @can('manage user')
            <a href="{{ route('users.index') }}"
               class="sidebar-item {{ request()->routeIs('users.*') ? 'sidebar-active' : '' }}">
                <span x-show="!sidebarCollapsed">المستخدمون</span>
            </a>
            @endcan

            @can('manage roles')
            <a href="{{ route('roles.index') }}"
               class="sidebar-item {{ request()->routeIs('admin.roles.*') ? 'sidebar-active' : '' }}">
                <span x-show="!sidebarCollapsed">الأدوار</span>
            </a>
            @endcan

            @can('permission manage')
            <a href="{{ route('permissions.index') }}"
               class="sidebar-item {{ request()->routeIs('admin.permissions.*') ? 'sidebar-active' : '' }}">
                <span x-show="!sidebarCollapsed">الصلاحيات</span>
            </a>
            @endcan

        </div>
    </div>
    @endcanany


    {{-- الإدارة الطبية --}}
    {{-- @canany([
        'view-departments',
        'view-doctors',
        'view-patients',
        'view-appointments',
        'view-rooms'
    ]) --}}
    <div>

        <p class="sidebar-section" x-show="!sidebarCollapsed">
            الإدارة الطبية
        </p>

        <div class="space-y-1">

            <a href="{{ route('departments.index') }}"
               class="sidebar-item {{ request()->routeIs('departments.*') ? 'sidebar-active' : '' }}">
                🏥
                <span x-show="!sidebarCollapsed">الأقسام</span>
            </a>

            <a href="{{ route('doctors.index') }}"
               class="sidebar-item {{ request()->routeIs('doctors.*') ? 'sidebar-active' : '' }}">
                👨‍⚕️
                <span x-show="!sidebarCollapsed">الأطباء</span>
            </a>

            <a href="{{ route('patients.index') }}"
               class="sidebar-item {{ request()->routeIs('patients.*') ? 'sidebar-active' : '' }}">
                🧑‍🦽
                <span x-show="!sidebarCollapsed">المرضى</span>
            </a>

            <a href="{{ route('appointments.index') }}"
               class="sidebar-item {{ request()->routeIs('appointments.*') ? 'sidebar-active' : '' }}">
                📅
                <span x-show="!sidebarCollapsed">المواعيد</span>
            </a>

            <a href="{{ route('rooms.index') }}"
               class="sidebar-item {{ request()->routeIs('rooms.*') ? 'sidebar-active' : '' }}">
                🛏
                <span x-show="!sidebarCollapsed">الغرف</span>
            </a>

            <a href="{{ route('medical-records.index') }}"
               class="sidebar-item {{ request()->routeIs('medical-records.*') ? 'sidebar-active' : '' }}">
                📋
                <span x-show="!sidebarCollapsed">السجل الطبي</span>
            </a>

            <a href="{{ route('prescriptions.index') }}"
               class="sidebar-item {{ request()->routeIs('prescriptions.*') ? 'sidebar-active' : '' }}">
                💊
                <span x-show="!sidebarCollapsed">الوصفات</span>
            </a>

            <a href="{{ route('medications.index') }}"
               class="sidebar-item {{ request()->routeIs('medications.*') ? 'sidebar-active' : '' }}">
                💉
                <span x-show="!sidebarCollapsed">الأدوية</span>
            </a>
   <a href="{{ route('prescription-items.index') }}"
               class="sidebar-item {{ request()->routeIs('prescription-items.*') ? 'sidebar-active' : '' }}">
                 💊
                <span x-show="!sidebarCollapsed"> الوصفات الطبية</span>
            </a>
              <a href="{{ route('medicine-transactions.index') }}"
               class="sidebar-item {{ request()->routeIs('medicine-transactions.*') ? 'sidebar-active' : '' }}">
                🏥
                <span x-show="!sidebarCollapsed"> حركات الدواء</span>
            </a>

        </div>
    </div>
    {{-- @endcanany --}}


    {{-- الإدارة المالية --}}
    @can('view-invoices')
    <div>

        <p class="sidebar-section" x-show="!sidebarCollapsed">
            الإدارة المالية
        </p>

        <div class="space-y-1">
            <a href="{{ route('invoices.index') }}"
               class="sidebar-item {{ request()->routeIs('invoices.*') ? 'sidebar-active' : '' }}">
                💰
                <span x-show="!sidebarCollapsed">الفواتير</span>
            </a>
        </div>

    </div>
    @endcan

</nav>
