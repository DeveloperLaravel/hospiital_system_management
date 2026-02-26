<nav class="flex-1 p-4 space-y-6 text-sm overflow-y-auto">

    {{-- Dashboard --}}
    <div>

        <a href="{{ route('dashboard') }}"
           class="sidebar-item {{ request()->routeIs('dashboard') ? 'sidebar-active' : '' }}">

            {{-- icon --}}
            <svg class="sidebar-icon" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                <path stroke-width="2" d="M3 12l2-2 4 4 8-8 4 4"/>
            </svg>

            <span x-show="!sidebarCollapsed">
                لوحة التحكم
            </span>

        </a>

    </div>


    {{-- إدارة النظام --}}
    <div>

        <p class="sidebar-section" x-show="!sidebarCollapsed">
            إدارة النظام
        </p>


        @can('manage users')
        <a href="{{ route('users.index') }}"
           class="sidebar-item {{ request()->routeIs('users.*') ? 'sidebar-active' : '' }}">

            <svg class="sidebar-icon" fill="none" stroke="currentColor">
                <path stroke-width="2"
                      d="M17 20h5v-1a4 4 0 00-5-3.87M9 20H4v-1a4 4 0 015-3.87"/>
            </svg>

            <span x-show="!sidebarCollapsed">
                المستخدمون
            </span>

        </a>
        @endcan


        @can('manage roles')
        <a href="{{ route('roles.index') }}"
           class="sidebar-item {{ request()->routeIs('roles.*') ? 'sidebar-active' : '' }}">

            <svg class="sidebar-icon" fill="none" stroke="currentColor">
                <path stroke-width="2"
                      d="M12 15l-3.5 2 1-4L6 10l4-.5L12 6l2 3.5 4 .5-3.5 3 1 4z"/>
            </svg>

            <span x-show="!sidebarCollapsed">
                الأدوار
            </span>

        </a>
        @endcan


        @can('permission manage')
        <a href="{{ route('permissions.index') }}"
           class="sidebar-item {{ request()->routeIs('permissions.*') ? 'sidebar-active' : '' }}">

            <svg class="sidebar-icon" fill="none" stroke="currentColor">
                <path stroke-width="2"
                      d="M12 11c0-3 2-5 5-5s5 2 5 5"/>
            </svg>

            <span x-show="!sidebarCollapsed">
                الصلاحيات
            </span>

        </a>
        @endcan

    </div>


    {{-- الإدارة الطبية --}}
    <div>

        <p class="sidebar-section" x-show="!sidebarCollapsed">
            الإدارة الطبية
        </p>


        <a href="{{ route('departments.index') }}"
           class="sidebar-item {{ request()->routeIs('departments.*') ? 'sidebar-active' : '' }}">

            🏥
            <span x-show="!sidebarCollapsed">
                الأقسام
            </span>

        </a>


        <a href="{{ route('doctors.index') }}"
           class="sidebar-item {{ request()->routeIs('doctors.*') ? 'sidebar-active' : '' }}">

            👨‍⚕️
            <span x-show="!sidebarCollapsed">
                الأطباء
            </span>

        </a>


        <a href="{{ route('nurses.index') }}"
           class="sidebar-item {{ request()->routeIs('nurses.*') ? 'sidebar-active' : '' }}">

            👩‍⚕️
            <span x-show="!sidebarCollapsed">
                الممرضون
            </span>

        </a>


        <a href="{{ route('patients.index') }}"
           class="sidebar-item {{ request()->routeIs('patients.*') ? 'sidebar-active' : '' }}">

            🧑‍🦽
            <span x-show="!sidebarCollapsed">
                المرضى
            </span>

        </a>


        <a href="{{ route('appointments.index') }}"
           class="sidebar-item {{ request()->routeIs('appointments.*') ? 'sidebar-active' : '' }}">

            📅
            <span x-show="!sidebarCollapsed">
                المواعيد
            </span>

        </a>


        <a href="{{ route('rooms.index') }}"
           class="sidebar-item {{ request()->routeIs('rooms.*') ? 'sidebar-active' : '' }}">

            🛏
            <span x-show="!sidebarCollapsed">
                الغرف
            </span>

        </a>


        <a href="{{ route('prescriptions.index') }}"
           class="sidebar-item {{ request()->routeIs('prescriptions.*') ? 'sidebar-active' : '' }}">

            💊
            <span x-show="!sidebarCollapsed">
                الوصفات
            </span>

        </a>


        <a href="{{ route('medical_records.index') }}"
           class="sidebar-item {{ request()->routeIs('medical_records.*') ? 'sidebar-active' : '' }}">

            📋
            <span x-show="!sidebarCollapsed">
                السجل الطبي
            </span>

        </a>

    </div>


    {{-- المالية --}}
    <div>

        <p class="sidebar-section" x-show="!sidebarCollapsed">
            الإدارة المالية
        </p>

        <a href="{{ route('invoices.index') }}"
           class="sidebar-item {{ request()->routeIs('invoices.*') ? 'sidebar-active' : '' }}">

            💰
            <span x-show="!sidebarCollapsed">
                الفواتير
            </span>

        </a>

    </div>

</nav>
