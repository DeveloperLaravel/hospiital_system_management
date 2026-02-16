    <!-- Sidebar -->
    <aside
        class="fixed md:static z-30 w-64 bg-blue-900 text-white min-h-screen transform md:translate-x-0 transition"
        :class="open ? 'translate-x-0' : 'translate-x-full md:translate-x-0'"
    >
        <div class="p-6 text-xl font-bold border-b border-blue-700">
            🏥 إدارة المستشفى
        </div>

<nav class="p-4 space-y-4">

    <!-- القسم العام -->
    <div>
        <p class="text-xs uppercase text-blue-200 mb-2 tracking-wider">
            النظام
        </p>

        <a href="{{ route('dashboard') }}" class="block p-3 rounded hover:bg-blue-700 transition">
            Dashboard
        </a>
    </div>

    <!-- فاصل -->
    <div class="border-t border-blue-500/40"></div>

    <!-- إدارة المستخدمين -->
    <div>
        <p class="text-xs uppercase text-blue-200 mb-2 tracking-wider">
            إدارة المستخدمين
        </p>

        <a href="{{ route('users.index') }}" class="block p-3 rounded hover:bg-blue-700 transition">
            المستخدمون
        </a>

        <a href="{{ route('roles.index') }}" class="block p-3 rounded hover:bg-blue-700 transition">
            الأدوار
        </a>

        <a href="{{ route('permissions.index') }}" class="block p-3 rounded hover:bg-blue-700 transition">
            الصلاحيات
        </a>
    </div>

    <!-- فاصل -->
    <div class="border-t border-blue-500/40"></div>

    <!-- إدارة المستشفى -->
    <div>
        <p class="text-xs uppercase text-blue-200 mb-2 tracking-wider">
            إدارة المستشفى
        </p>

          <a href="{{ route('departments.index') }}" class="block p-3 rounded hover:bg-blue-700 transition">
            اقسام
              </a>
              <a href="{{ route('doctors.index') }}" class="block p-3 rounded hover:bg-blue-700 transition">
                
            دكتور
        </a>
        </a>
        <a href="#" class="block p-3 rounded hover:bg-blue-700 transition">
            المرضى
        </a>

        <a href="#" class="block p-3 rounded hover:bg-blue-700 transition">
            الأطباء
        </a>

        <a href="#" class="block p-3 rounded hover:bg-blue-700 transition">
            المواعيد
        </a>

        <a href="#" class="block p-3 rounded hover:bg-blue-700 transition">
            الفواتير
        </a>
    </div>

</nav>

    </aside>