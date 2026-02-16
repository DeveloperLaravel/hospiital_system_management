    <!-- Sidebar -->
    <aside
        class="fixed md:static z-30 w-64 bg-blue-900 text-white min-h-screen transform md:translate-x-0 transition"
        :class="open ? 'translate-x-0' : 'translate-x-full md:translate-x-0'"
    >
        <div class="p-6 text-xl font-bold border-b border-blue-700">
            🏥 إدارة المستشفى
        </div>

        <nav class="p-4 space-y-2">
            <a href="{{ route('dashboard') }}" class="block p-3 rounded hover:bg-blue-700">Dashboard</a>
            <a href="{{ route('users.index') }}" class="block p-3 rounded hover:bg-blue-700">المستخدمون</a>
            <a href="{{ route('roles.index') }}" class="block p-3 rounded hover:bg-blue-700">الادوار</a>
            <a href="#" class="block p-3 rounded hover:bg-blue-700">المرضى</a>
            <a href="#" class="block p-3 rounded hover:bg-blue-700">الأطباء</a>
            <a href="#" class="block p-3 rounded hover:bg-blue-700">المواعيد</a>
            <a href="#" class="block p-3 rounded hover:bg-blue-700">الفواتير</a>
        </nav>
    </aside>