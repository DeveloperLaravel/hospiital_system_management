<x-app-layout>
<main class="relative min-h-screen flex-1 overflow-auto">

    <!-- خلفية الصورة -->
    <div class="fixed inset-0 -z-10">
        <img src="{{ asset('images/user.png') }}"
             class="w-full h-full object-cover"
             alt="Users Background">

        <!-- طبقة تدرج احترافية فوق الصورة -->
        <div class="absolute inset-0 bg-gradient-to-br from-blue-900/70 via-black/60 to-indigo-900/70 backdrop-blur-sm"></div>
    </div>

    <!-- المحتوى -->
    <div class="p-4 sm:p-6 lg:p-12 max-w-7xl mx-auto">

        <!-- Header -->
        <div class="flex flex-col md:flex-row justify-between items-start md:items-center mb-6 space-y-4 md:space-y-0">
            <h1 class="text-2xl sm:text-3xl md:text-4xl font-extrabold text-white drop-shadow-lg">
                إدارة المستخدمين
            </h1>
  @can('users-create')
            <a href="{{ route('users.create') }}"
               class="flex items-center gap-2 px-4 sm:px-5 py-2 sm:py-3 bg-blue-600 text-white font-semibold rounded-2xl shadow-xl
                      hover:bg-blue-700 hover:shadow-2xl transition duration-300 transform hover:-translate-y-1 active:scale-95">
                <svg xmlns="http://www.w3.org/2000/svg" class="h-5 sm:h-6 w-5 sm:w-6" fill="none" viewBox="0 0 24 24" stroke="currentColor">
                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 4v16m8-8H4"/>
                </svg>
                إضافة مستخدم
            </a>
             @endcan
        </div>

        <!-- بطاقة شفافة للجدول -->
            <x-users-table :users="$users" />

    </div>

</main>
</x-app-layout>
