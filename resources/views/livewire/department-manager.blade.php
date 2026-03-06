<main class="min-h-screen bg-gradient-to-br from-blue-50 to-indigo-100 p-4 sm:p-6 lg:p-8" dir="rtl" lang="ar">

    {{-- عنوان الصفحة وأزرار التحكم --}}
    <div class="flex flex-col md:flex-row justify-between items-start md:items-center gap-4 mb-6">
        <h1 class="text-2xl font-bold text-gray-800">إدارة الأقسام</h1>
        <button
            wire:click="create"
            class="bg-blue-600 hover:bg-blue-700 text-white px-4 py-2 rounded-lg shadow transition flex items-center gap-2 w-full md:w-auto"
        >
            <svg xmlns="http://www.w3.org/2000/svg" class="h-5 w-5" fill="none" viewBox="0 0 24 24" stroke="currentColor">
                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 4v16m8-8H4" />
            </svg>
            إضافة قسم جديد
        </button>
    </div>

    {{-- رسائل النجاح والخطأ --}}
    @if(session()->has('success'))
        <div class="bg-green-100 border-l-4 border-green-500 text-green-700 p-4 rounded shadow-md mb-4" role="alert">
            <div class="flex items-center">
                <svg xmlns="http://www.w3.org/2000/svg" class="h-6 w-6 ml-2" fill="none" viewBox="0 0 24 24" stroke="currentColor">
                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M5 13l4 4L19 7" />
                </svg>
                <span class="font-medium">{{ session('success') }}</span>
            </div>
        </div>
    @endif

    @if(session()->has('error'))
        <div class="bg-red-100 border-l-4 border-red-500 text-red-700 p-4 rounded shadow-md mb-4" role="alert">
            <div class="flex items-center">
                <svg xmlns="http://www.w3.org/2000/svg" class="h-6 w-6 ml-2" fill="none" viewBox="0 0 24 24" stroke="currentColor">
                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 8v4m0 4h.01M21 12a9 9 0 11-18 0 9 9 0 0118 0z" />
                </svg>
                <span class="font-medium">{{ session('error') }}</span>
            </div>
        </div>
    @endif

    {{-- قسم البحث --}}
    <div class="bg-white p-4 rounded-lg shadow mb-6">
        <div class="flex flex-col sm:flex-row gap-3 items-start sm:items-center">
            <div class="relative flex-1 w-full">
                <svg xmlns="http://www.w3.org/2000/svg" class="h-5 w-5 absolute right-3 top-1/2 transform -translate-y-1/2 text-gray-400" fill="none" viewBox="0 0 24 24" stroke="currentColor">
                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M21 21l-6-6m2-5a7 7 0 11-14 0 7 7 0 0114 0z" />
                </svg>
                <input
                    type="text"
                    wire:model.live="search"
                    placeholder="البحث بالاسم أو الوصف..."
                    class="border border-gray-300 rounded-lg pr-10 py-2 w-full focus:ring-2 focus:ring-blue-500 focus:border-blue-500 transition"
                />
            </div>
            <button
                wire:click="$set('search', '')"
                class="bg-gray-500 hover:bg-gray-600 text-white px-4 py-2 rounded-lg w-full sm:w-auto transition"
            >
                إعادة تعيين
            </button>
        </div>
    </div>

    {{-- جدول الأقسام --}}
    <div class="bg-white rounded-lg shadow overflow-x-auto">
        <table class="w-full text-sm text-right min-w-[700px]">
            <thead class="bg-gray-100 text-gray-700">
                <tr>
                    <th class="p-4 font-semibold">#</th>
                    <th class="p-4 font-semibold">اسم القسم</th>
                    <th class="p-4 font-semibold">الوصف</th>
                    <th class="p-4 font-semibold">الراتب</th>
                    <th class="p-4 font-semibold">عدد الأطباء</th>
                    <th class="p-4 font-semibold">عدد الممرضين</th>
                    <th class="p-4 font-semibold">التحكم</th>
                </tr>
            </thead>
            <tbody class="divide-y divide-gray-200">
                @forelse($departments as $department)
                <tr class="hover:bg-gray-50 transition">
                    <td class="p-4 text-gray-600">{{ $department->id }}</td>
                    <td class="p-4 font-medium text-gray-800">{{ $department->name }}</td>
                    <td class="p-4 text-gray-600">{{ $department->description ?? '-' }}</td>
                    <td class="p-4 text-gray-600">{{ number_format($department->salary, 2) }}</td>
                    <td class="p-4">
                        <span class="bg-blue-100 text-blue-800 px-2 py-1 rounded-full text-xs font-medium">
                            {{ $department->doctors()->count() }}
                        </span>
                    </td>
                    <td class="p-4">
                        <span class="bg-green-100 text-green-800 px-2 py-1 rounded-full text-xs font-medium">
                            {{ $department->nurses()->count() }}
                        </span>
                    </td>
                    <td class="p-4">
                        <div class="flex flex-col sm:flex-row gap-2 justify-end">
                            <button
                                wire:click="edit({{ $department->id }})"
                                class="bg-yellow-500 hover:bg-yellow-600 text-white px-3 py-1.5 rounded-lg transition flex items-center gap-1 w-full sm:w-auto"
                            >
                                تعديل
                            </button>
                            <button
                                wire:click="delete({{ $department->id }})"
                                onclick="confirm('هل أنت متأكد من حذف هذا القسم؟') || event.stopImmediatePropagation()"
                                class="bg-red-600 hover:bg-red-700 text-white px-3 py-1.5 rounded-lg transition flex items-center gap-1 w-full sm:w-auto"
                            >
                                حذف
                            </button>
                        </div>
                    </td>
                </tr>
                @empty
                <tr>
                    <td colspan="7" class="p-8 text-center text-gray-500">
                        لا توجد أقسام مسجلة
                    </td>
                </tr>
                @endforelse
            </tbody>
        </table>
    </div>

    {{-- الترقيم --}}
    <div class="mt-4">
        {{ $departments->links() }}
    </div>

    {{-- Modal الإضافة والتعديل --}}
    @if($isOpen)
    <div class="fixed inset-0 z-50 overflow-y-auto" aria-labelledby="modal-title" role="dialog" aria-modal="true">
        <div class="flex items-end justify-center min-h-screen pt-4 px-4 pb-20 text-center sm:block sm:p-0">
            <div
                wire:click="closeModal"
                class="fixed inset-0 bg-gray-500 bg-opacity-75 transition-opacity"
                aria-hidden="true"
            ></div>
            <span class="hidden sm:inline-block sm:align-middle sm:h-screen">&#8203;</span>
            <div class="inline-block align-bottom bg-white rounded-lg text-right overflow-hidden shadow-xl transform transition-all sm:my-8 sm:align-middle sm:max-w-lg w-full p-4 sm:p-6 lg:p-8">
                {{-- محتوى الـ Modal --}}
               {{-- محتوى الـ Modal --}}
<div class="space-y-6">

    {{-- رأس الـ Modal --}}
    <div>
        <h3 class="text-lg sm:text-xl font-semibold text-gray-900" id="modal-title">
            {{ $isEditMode ? 'تعديل قسم' : 'إضافة قسم جديد' }}
        </h3>
    </div>

    {{-- نموذج البيانات --}}
    <div class="grid grid-cols-1 gap-4 sm:grid-cols-2">

        {{-- اسم القسم --}}
        <div class="col-span-1 sm:col-span-2">
            <label for="name" class="block text-sm font-medium text-gray-700 mb-1">
                اسم القسم <span class="text-red-500">*</span>
            </label>
            <input
                type="text"
                id="name"
                wire:model="name"
                class="w-full border border-gray-300 rounded-lg px-4 py-2 focus:ring-2 focus:ring-blue-500 focus:border-blue-500 transition @error('name') border-red-500 @enderror"
                placeholder="أدخل اسم القسم"
            />
            @error('name')
                <p class="mt-1 text-sm text-red-600">{{ $message }}</p>
            @enderror
        </div>

        {{-- الوصف --}}
        <div class="col-span-1 sm:col-span-2">
            <label for="description" class="block text-sm font-medium text-gray-700 mb-1">
                الوصف
            </label>
            <textarea
                id="description"
                wire:model="description"
                rows="3"
                class="w-full border border-gray-300 rounded-lg px-4 py-2 focus:ring-2 focus:ring-blue-500 focus:border-blue-500 transition"
                placeholder="أدخل وصف القسم (اختياري)"
            ></textarea>
        </div>

        {{-- الراتب --}}
        <div class="col-span-1 sm:col-span-2 relative">
            <label for="salary" class="block text-sm font-medium text-gray-700 mb-1">
                الراتب الأساسي
            </label>
            <div class="relative">
                <span class="absolute left-3 top-1/2 transform -translate-y-1/2 text-gray-500">$</span>
                <input
                    type="number"
                    id="salary"
                    wire:model="salary"
                    min="0"
                    step="0.01"
                    class="w-full border border-gray-300 rounded-lg pr-8 pl-4 py-2 focus:ring-2 focus:ring-blue-500 focus:border-blue-500 transition"
                    placeholder="0.00"
                />
            </div>
        </div>

    </div>

    {{-- أزرار التحكم --}}
    <div class="flex flex-col sm:flex-row sm:justify-end gap-3 mt-4">
        <button
            wire:click="closeModal"
            type="button"
            class="w-full sm:w-auto px-4 py-2 bg-gray-300 text-gray-700 rounded-lg hover:bg-gray-400 transition"
        >
            إلغاء
        </button>
        <button
            wire:click="store"
            type="button"
            class="w-full sm:w-auto px-4 py-2 bg-blue-600 text-white rounded-lg hover:bg-blue-700 transition"
        >
            {{ $isEditMode ? 'حفظ التغييرات' : 'إضافة القسم' }}
        </button>
    </div>

</div>
            </div>
        </div>
    </div>
    @endif

</main>
