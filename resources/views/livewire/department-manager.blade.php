    <main class="min-h-screen bg-gradient-to-br from-blue-50 to-indigo-100 p-4 sm:p-6 lg:p-8" dir="rtl" lang="ar">

    {{-- ========================= --}}
    {{-- عنوان الصفحة وأزرار التحكم --}}
    {{-- ========================= --}}
    <div class="flex justify-between items-center">
        <h1 class="text-2xl font-bold text-gray-800">
            إدارة الأقسام
        </h1>
        <button
            wire:click="create"
            class="bg-blue-600 hover:bg-blue-700 text-white px-4 py-2 rounded-lg shadow transition flex items-center gap-2"
        >
            <svg xmlns="http://www.w3.org/2000/svg" class="h-5 w-5" fill="none" viewBox="0 0 24 24" stroke="currentColor">
                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 4v16m8-8H4" />
            </svg>
            إضافة قسم جديد
        </button>
    </div>

    {{-- ========================= --}}
    {{-- رسائل النجاح والخطأ --}}
    {{-- ========================= --}}
    @if(session()->has('success'))
        <div class="bg-green-100 border-l-4 border-green-500 text-green-700 p-4 rounded shadow-md" role="alert">
            <div class="flex items-center">
                <svg xmlns="http://www.w3.org/2000/svg" class="h-6 w-6 ml-2" fill="none" viewBox="0 0 24 24" stroke="currentColor">
                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M5 13l4 4L19 7" />
                </svg>
                <span class="font-medium">{{ session('success') }}</span>
            </div>
        </div>
    @endif

    @if(session()->has('error'))
        <div class="bg-red-100 border-l-4 border-red-500 text-red-700 p-4 rounded shadow-md" role="alert">
            <div class="flex items-center">
                <svg xmlns="http://www.w3.org/2000/svg" class="h-6 w-6 ml-2" fill="none" viewBox="0 0 24 24" stroke="currentColor">
                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 8v4m0 4h.01M21 12a9 9 0 11-18 0 9 9 0 0118 0z" />
                </svg>
                <span class="font-medium">{{ session('error') }}</span>
            </div>
        </div>
    @endif

    {{-- ========================= --}}
    {{-- قسم البحث --}}
    {{-- ========================= --}}
    <div class="bg-white p-4 rounded-lg shadow">
        <div class="flex gap-3 items-center">
            <div class="relative flex-1">
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
                class="bg-gray-500 hover:bg-gray-600 text-white px-4 py-2 rounded-lg transition"
            >
                إعادة تعيين
            </button>
        </div>
    </div>

    {{-- ========================= --}}
    {{-- جدول الأقسام --}}
    {{-- ========================= --}}
    <div class="bg-white rounded-lg shadow overflow-hidden">
        <table class="w-full text-sm text-right">
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
                        <div class="flex gap-2 justify-end">
                            <button
                                wire:click="edit({{ $department->id }})"
                                class="bg-yellow-500 hover:bg-yellow-600 text-white px-3 py-1.5 rounded-lg transition flex items-center gap-1"
                            >
                                <svg xmlns="http://www.w3.org/2000/svg" class="h-4 w-4" fill="none" viewBox="0 0 24 24" stroke="currentColor">
                                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M11 5H6a2 2 0 00-2 2v11a2 2 0 002 2h11a2 2 0 002-2v-5m-1.414-9.414a2 2 0 112.828 2.828L11.828 15H9v-2.828l8.586-8.586z" />
                                </svg>
                                تعديل
                            </button>
                            <button
                                wire:click="delete({{ $department->id }})"
                                onclick="confirm('هل أنت متأكد من حذف هذا القسم؟') || event.stopImmediatePropagation()"
                                class="bg-red-600 hover:bg-red-700 text-white px-3 py-1.5 rounded-lg transition flex items-center gap-1"
                            >
                                <svg xmlns="http://www.w3.org/2000/svg" class="h-4 w-4" fill="none" viewBox="0 0 24 24" stroke="currentColor">
                                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M19 7l-.867 12.142A2 2 0 0116.138 21H7.862a2 2 0 01-1.995-1.858L5 7m5 4v6m4-6v6m1-10V4a1 1 0 00-1-1h-4a1 1 0 00-1 1v3M4 7h16" />
                                </svg>
                                حذف
                            </button>
                        </div>
                    </td>
                </tr>
                @empty
                <tr>
                    <td colspan="7" class="p-8 text-center text-gray-500">
                        <svg xmlns="http://www.w3.org/2000/svg" class="h-12 w-12 mx-auto mb-2 text-gray-300" fill="none" viewBox="0 0 24 24" stroke="currentColor">
                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M19 11H5m14 0a2 2 0 012 2v6a2 2 0 01-2 2H5a2 2 0 01-2-2v-6a2 2 0 012-2m14 0V9a2 2 0 00-2-2M5 11V9a2 2 0 012-2m0 0V5a2 2 0 012-2h6a2 2 0 012 2v2M7 7h10" />
                        </svg>
                        لا توجد أقسام مسجلة
                    </td>
                </tr>
                @endforelse
            </tbody>
        </table>
    </div>

    {{-- ========================= --}}
    {{-- الترقيم --}}
    {{-- ========================= --}}
    <div class="mt-4">
        {{ $departments->links() }}
    </div>

    {{-- ========================= --}}
    {{-- Modal الإضافة والتعديل --}}
    {{-- ========================= --}}
    @if($isOpen)
    <div class="fixed inset-0 z-50 overflow-y-auto" aria-labelledby="modal-title" role="dialog" aria-modal="true">
        {{-- خلفية الـ Modal --}}
        <div class="flex items-end justify-center min-h-screen pt-4 px-4 pb-20 text-center sm:block sm:p-0">
            <div
                wire:click="closeModal"
                class="fixed inset-0 bg-gray-500 bg-opacity-75 transition-opacity"
                aria-hidden="true"
            ></div>
            <span class="hidden sm:inline-block sm:align-middle sm:h-screen" aria-hidden="true">&#8203;</span>

            {{-- محتوى الـ Modal --}}
            <div class="inline-block align-bottom bg-white rounded-lg text-right overflow-hidden shadow-xl transform transition-all sm:my-8 sm:align-middle sm:max-w-lg w-full p-6">

                {{-- رأس الـ Modal --}}
                <div class="mb-4">
                    <h3 class="text-lg leading-6 font-medium text-gray-900" id="modal-title">
                        {{ $isEditMode ? 'تعديل قسم' : 'إضافة قسم جديد' }}
                    </h3>
                </div>

                {{-- نموذج البيانات --}}
                <div class="space-y-4">

                    {{-- اسم القسم --}}
                    <div>
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
                    <div>
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
                    <div>
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
                <div class="mt-6 flex gap-3 justify-end">
                    <button
                        wire:click="closeModal"
                        type="button"
                        class="px-4 py-2 bg-gray-300 text-gray-700 rounded-lg hover:bg-gray-400 transition"
                    >
                        إلغاء
                    </button>
                    <button
                        wire:click="store"
                        type="button"
                        class="px-4 py-2 bg-blue-600 text-white rounded-lg hover:bg-blue-700 transition"
                    >
                        {{ $isEditMode ? 'حفظ التغييرات' : 'إضافة القسم' }}
                    </button>
                </div>
            </div>
        </div>
    </div>
    @endif

</main>


