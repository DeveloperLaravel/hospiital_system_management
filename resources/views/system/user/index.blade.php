<x-app-layout>
    <!-- Header مع العنوان وزر الإضافة -->

      <main class="p-6 flex-1 overflow-auto">
    <!-- Cards الاحصائيات -->
    <div class="grid grid-cols-1 md:grid-cols-2 lg:grid-cols-4 gap-6 mt-8">
    
            <div class="bg-gradient-to-r from-white-400 to-gray-400 rounded-xl shadow-lg p-6 flex flex-col items-center text-white hover:scale-105 transform transition duration-300">
       <h2 class="text-xl font-semibold text-gray-700 mb-2">المرضى</h2>
    <p class="text-3xl font-bold">120</p>
</div>
         <div class="bg-gradient-to-r from-green-400 to-gray-400 rounded-xl shadow-lg p-6 flex flex-col items-center text-white hover:scale-105 transform transition duration-300">
       <h2 class="text-xl font-semibold text-gray-700 mb-2">المرضى</h2>
    <p class="text-3xl font-bold">25</p>
</div>

 <div class="bg-gradient-to-r from-green-700 to-blue-400 rounded-xl shadow-lg p-6 flex flex-col items-center text-white hover:scale-105 transform transition duration-300">
       <h2 class="text-xl font-semibold text-gray-700 mb-2">الأطباء</h2>
    <p class="text-3xl font-bold">28</p>
</div>
   <div class="bg-gradient-to-r from-red-400 to-blue-600 rounded-xl shadow-lg p-6 flex flex-col items-center text-white hover:scale-105 transform transition duration-300">
    <h2 class="text-xl font-semibold mb-2">الفواتير</h2>
    <p class="text-3xl font-bold">18</p>
</div>
    
    </div>

    <br>
<div class="flex flex-col md:flex-row  justify-between items-start md:items-center mb-6 space-y-4 md:space-y-0">
    <a href="{{ route('users.create') }}"
       class="flex items-center gap-2 px-5 py-2 bg-blue-600 text-white font-semibold rounded-lg shadow-md
              hover:bg-blue-700 hover:shadow-lg transition duration-300 transform hover:-translate-y-0.5 active:scale-95">
        <!-- أيقونة الإضافة -->
        <svg xmlns="http://www.w3.org/2000/svg" class="h-5 w-5" fill="none" viewBox="0 0 24 24" stroke="currentColor">
            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 4v16m8-8H4"/>
        </svg>
        إضافة مستخدم
    </a>
</div>


    <!-- Table المستخدمين داخل بطاقة -->
    <div class="overflow-x-auto bg-white shadow-lg rounded-xl">
        <table class="min-w-full divide-y divide-gray-200">
            <thead class="bg-blue-50">
                <tr>
                    <th class="px-6 py-3 text-left text-xs font-semibold text-gray-600 uppercase tracking-wider">الاسم</th>
                    <th class="px-6 py-3 text-left text-xs font-semibold text-gray-600 uppercase tracking-wider">البريد الإلكتروني</th>
                    <th class="px-6 py-3 text-left text-xs font-semibold text-gray-600 uppercase tracking-wider">الأدوار</th>
                    <th class="px-6 py-3 text-left text-xs font-semibold text-gray-600 uppercase tracking-wider">الإجراءات</th>
                </tr>
            </thead>
            <tbody class="bg-white divide-y divide-gray-200">
                @foreach($users as $user)
                <tr class="hover:bg-gray-50 transition">
                    <td class="px-6 py-4 whitespace-nowrap font-medium text-gray-700">{{ $user->name }}</td>
                    <td class="px-6 py-4 whitespace-nowrap text-gray-600">{{ $user->email }}</td>
                    <td class="px-6 py-4 whitespace-nowrap text-gray-600">{{ implode(', ', $user->getRoleNames()->toArray()) }}</td>
                   <td class="px-6 py-4 whitespace-nowrap flex gap-2">
    <a href="{{ route('users.edit', $user) }}" class="p-2 bg-yellow-400 hover:bg-yellow-500 text-white rounded-lg shadow" title="تعديل">
        <svg xmlns="http://www.w3.org/2000/svg" class="h-4 w-4" fill="none" viewBox="0 0 24 24" stroke="currentColor">
            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M15.232 5.232l3.536 3.536M9 13l6-6 3.536 3.536L12 18H9v-5z"/>
        </svg>
    </a>

    <form action="{{ route('users.destroy', $user) }}" method="POST" onsubmit="return confirm('هل أنت متأكد من الحذف؟');">
        @csrf
        @method('DELETE')
        <button type="submit" class="p-2 bg-red-500 hover:bg-red-600 text-white rounded-lg shadow" title="حذف">
            <svg xmlns="http://www.w3.org/2000/svg" class="h-4 w-4" fill="none" viewBox="0 0 24 24" stroke="currentColor">
                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M19 7l-.867 12.142A2 2 0 0116.138 21H7.862a2 2 0 01-1.995-1.858L5 7m5-4h4m-4 0a1 1 0 00-1 1v1h6V4a1 1 0 00-1-1m-4 0h4"/>
            </svg>
        </button>
    </form>
</td>

                </tr>
                @endforeach
            </tbody>
        </table>
    </div>

    <!-- Pagination -->
    <div class="mt-4">
        {{ $users->links() }}
    </div>
</main>
</x-app-layout>
