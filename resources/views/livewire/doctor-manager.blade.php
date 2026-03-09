    <div class="min-h-screen bg-gradient-to-br from-blue-50 via-white to-indigo-100" dir="rtl" lang="ar">

        {{-- Header Section --}}
        <div class="bg-white shadow-lg border-b border-gray-200">
            <div class="max-w-7xl mx-auto px-4 sm:px-6 lg:px-8 py-6">
                <div class="flex flex-col md:flex-row md:items-center md:justify-between gap-4">
                    <div class="flex items-center gap-4">
                        <div class="bg-gradient-to-br from-blue-500 to-indigo-600 p-3 rounded-xl shadow-lg">
                            <svg xmlns="http://www.w3.org/2000/svg" class="h-8 w-8 text-white" fill="none" viewBox="0 0 24 24" stroke="currentColor">
                                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M16 7a4 4 0 11-8 0 4 4 0 018 0zM12 14a7 7 0 00-7 7h14a7 7 0 00-7-7z" />
                            </svg>
                        </div>
                        <div>
                            <h1 class="text-2xl md:text-3xl font-bold text-gray-800">إدارة الأطباء</h1>
                            <p class="text-sm text-gray-500 mt-1">إضافة وتعديل وحذف الأطباء</p>
                        </div>
                    </div>

                      <div class="flex items-center gap-3">
                        {{-- User Role Badge --}}
                        <div class="hidden lg:flex items-center gap-2">
                            <div class="px-3 py-1.5 rounded-lg text-xs font-bold {{ $this->isAdmin() ? 'bg-gradient-to-r from-purple-500 to-pink-500 text-white' : ($this->isSupervisor() ? 'bg-gradient-to-r from-blue-500 to-cyan-500 text-white' : 'bg-gradient-to-r from-gray-500 to-slate-500 text-white') }}">
                                @if($this->isAdmin())
                                <svg xmlns="http://www.w3.org/2000/svg" class="h-3.5 w-3.5 inline ml-1" fill="none" viewBox="0 0 24 24" stroke="currentColor">
                                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M5.121 17.804A13.937 13.937 0 0112 16c2.5 0 4.847.655 6.879 1.804M15 10a3 3 0 11-6 0 3 3 0 016 0zm6 2a9 9 0 11-18 0 9 9 0 0118 0z" />
                                </svg>
                                @elseif($this->isSupervisor())
                                <svg xmlns="http://www.w3.org/2000/svg" class="h-3.5 w-3.5 inline ml-1" fill="none" viewBox="0 0 24 24" stroke="currentColor">
                                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M9 12l2 2 4-4m5.618-4.016A11.955 11.955 0 0112 2.944a11.955 11.955 0 01-8.618 3.04A12.02 12.02 0 003 9c0 5.591 3.824 10.29 9 11.622 5.176-1.332 9-6.03 9-11.622 0-1.042-.133-2.052-.382-3.016z" />
                                </svg>
                                @else
                                <svg xmlns="http://www.w3.org/2000/svg" class="h-3.5 w-3.5 inline ml-1" fill="none" viewBox="0 0 24 24" stroke="currentColor">
                                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M16 7a4 4 0 11-8 0 4 4 0 018 0zM12 14a7 7 0 00-7 7h14a7 7 0 00-7-7z" />
                                </svg>
                                @endif
                                {{ $this->getUserRole() }}
                            </div>
                          {{-- Quick Permissions Indicators --}}
                        <div class="hidden md:flex items-center gap-1 px-2 py-1 bg-gray-100 rounded-lg text-xs">
                            @if($this->canCreate())
                            <span class="w-2 h-2 bg-green-500 rounded-full" title="يمكن إنشاء أقسام"></span>
                            @else
                            <span class="w-2 h-2 bg-red-300 rounded-full" title="لا يمكن إنشاء أقسام"></span>
                            @endif

                            @if(auth()->user()->can('doctors-edit'))
                            <span class="w-2 h-2 bg-green-500 rounded-full" title="يمكن تعديل أقسام"></span>
                            @else
                            <span class="w-2 h-2 bg-red-300 rounded-full" title="لا يمكن تعديل أقسام"></span>
                            @endif

                            @if(auth()->user()->can('doctors-delete'))
                            <span class="w-2 h-2 bg-green-500 rounded-full" title="يمكن حذف أقسام"></span>
                            @else
                            <span class="w-2 h-2 bg-red-300 rounded-full" title="لا يمكن حذف أقسام"></span>
                            @endif
                        </div>
                         </div>
                    @if($hasPermission && $this->canCreate())
                        <button
                            wire:click="create"
                            class="inline-flex items-center gap-2 bg-gradient-to-r from-blue-600 to-indigo-600 hover:from-blue-700 hover:to-indigo-700 text-white px-5 py-2.5 rounded-xl font-medium shadow-lg hover:shadow-xl transition-all duration-300 transform hover:-translate-y-0.5"
                        >
                            <svg xmlns="http://www.w3.org/2000/svg" class="h-5 w-5" fill="none" viewBox="0 0 24 24" stroke="currentColor">
                                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 4v16m8-8H4" />
                            </svg>
                            <span class="hidden sm:inline">إضافة طبيب جديد</span>
                            <span class="sm:hidden">إضافة</span>
                        </button>
                    @endif
                </div>
            </div>
        </div>
 </div>
        {{-- Messages --}}
        <div class="max-w-7xl mx-auto px-4 sm:px-6 lg:px-8 mt-6">
            @if(session()->has('success'))
                <div class="bg-green-50 border border-green-200 rounded-xl p-4 mb-4 flex items-center gap-3 animate-pulse">
                    <div class="bg-green-100 p-2 rounded-full">
                        <svg xmlns="http://www.w3.org/2000/svg" class="h-5 w-5 text-green-600" fill="none" viewBox="0 0 24 24" stroke="currentColor">
                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M5 13l4 4L19 7" />
                        </svg>
                    </div>
                    <span class="text-green-700 font-medium">{{ session('success') }}</span>
                </div>
            @endif

            @if(session()->has('error'))
                <div class="bg-red-50 border border-red-200 rounded-xl p-4 mb-4 flex items-center gap-3 animate-pulse">
                    <div class="bg-red-100 p-2 rounded-full">
                        <svg xmlns="http://www.w3.org/2000/svg" class="h-5 w-5 text-red-600" fill="none" viewBox="0 0 24 24" stroke="currentColor">
                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 8v4m0 4h.01M21 12a9 9 0 11-18 0 9 9 0 0118 0z" />
                        </svg>
                    </div>
                    <span class="text-red-700 font-medium">{{ session('error') }}</span>
                </div>
            @endif
        </div>

        {{-- Search Section --}}
        <div class="max-w-7xl mx-auto px-4 sm:px-6 lg:px-8 mt-4">
            <div class="bg-white rounded-2xl shadow-md border border-gray-100 p-4">
                <div class="flex flex-col sm:flex-row gap-3">
                    <div class="relative flex-1">
                        <div class="absolute inset-y-0 right-0 pr-4 flex items-center pointer-events-none">
                            <svg xmlns="http://www.w3.org/2000/svg" class="h-5 w-5 text-gray-400" fill="none" viewBox="0 0 24 24" stroke="currentColor">
                                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M21 21l-6-6m2-5a7 7 0 11-14 0 7 7 0 0114 0z" />
                            </svg>
                        </div>
                        <input
                            type="text"
                            wire:model.live="search"
                            placeholder="البحث بالاسم أو الهاتف أو التخصص..."
                            class="w-full pr-12 py-3 bg-gray-50 border border-gray-200 rounded-xl focus:bg-white focus:ring-2 focus:ring-blue-500 focus:border-blue-500 transition-all duration-200 text-gray-700 placeholder-gray-400"
                        />
                    </div>
                    <button
                        wire:click="$set('search', '')"
                        class="px-5 py-3 bg-gray-100 hover:bg-gray-200 text-gray-700 rounded-xl font-medium transition-colors duration-200 flex items-center justify-center gap-2"
                    >
                        <svg xmlns="http://www.w3.org/2000/svg" class="h-4 w-4" fill="none" viewBox="0 0 24 24" stroke="currentColor">
                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M4 4v5h.582m15.356 2A8.001 8.001 0 004.582 9m0 0H9m11 11v-5h-.581m0 0a8.003 8.003 0 01-15.357-2m15.357 2H15" />
                        </svg>
                        إعادة
                    </button>
                </div>
            </div>
        </div>

        {{-- Stats Cards --}}
        <div class="max-w-7xl mx-auto px-4 sm:px-6 lg:px-8 mt-4">
            <div class="grid grid-cols-2 lg:grid-cols-4 gap-4">
                <div class="bg-white rounded-xl shadow-md border border-gray-100 p-4">
                    <div class="flex items-center gap-3">
                        <div class="bg-blue-100 p-2 rounded-lg">
                            <svg xmlns="http://www.w3.org/2000/svg" class="h-5 w-5 text-blue-600" fill="none" viewBox="0 0 24 24" stroke="currentColor">
                                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M17 20h5v-2a3 3 0 00-5.356-1.857M17 20H7m10 0v-2c0-.656-.126-1.283-.356-1.857M7 20H2v-2a3 3 0 015.356-1.857M7 20v-2c0-.656.126-1.283.356-1.857m0 0a5.002 5.002 0 019.288 0M15 7a3 3 0 11-6 0 3 3 0 016 0zm6 3a2 2 0 11-4 0 2 2 0 014 0zM7 10a2 2 0 11-4 0 2 2 0 014 0z" />
                            </svg>
                        </div>
                        <div>
                            <p class="text-xs text-gray-500">إجمالي الأطباء</p>
                            <p class="text-xl font-bold text-gray-800">{{ $doctors->total() }}</p>
                        </div>
                    </div>
                </div>
                <div class="bg-white rounded-xl shadow-md border border-gray-100 p-4">
                    <div class="flex items-center gap-3">
                        <div class="bg-green-100 p-2 rounded-lg">
                            <svg xmlns="http://www.w3.org/2000/svg" class="h-5 w-5 text-green-600" fill="none" viewBox="0 0 24 24" stroke="currentColor">
                                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M9 12l2 2 4-4m6 2a9 9 0 11-18 0 9 9 0 0118 0z" />
                            </svg>
                        </div>
                        <div>
                            <p class="text-xs text-gray-500">الأقسام</p>
                            <p class="text-xl font-bold text-gray-800">{{ $departments->count() }}</p>
                        </div>
                    </div>
                </div>
            </div>
        </div>

        {{-- Table Section --}}
        <div class="max-w-7xl mx-auto px-4 sm:px-6 lg:px-8 mt-6 mb-8">
            @if(!$hasPermission)
                <div class="bg-red-50 border border-red-200 rounded-xl p-8 text-center">
                    <svg xmlns="http://www.w3.org/2000/svg" class="h-16 w-16 mx-auto text-red-400 mb-4" fill="none" viewBox="0 0 24 24" stroke="currentColor">
                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 15v2m-6 4h12a2 2 0 002-2v-6a2 2 0 00-2-2H6a2 2 0 00-2 2v6a2 2 0 002 2zm10-10V7a4 4 0 00-8 0v4h8z" />
                    </svg>
                    <h3 class="text-xl font-bold text-red-700 mb-2">لا توجد صلاحية للعرض</h3>
                    <p class="text-red-600">ليس لديك صلاحية للوصول إلى صفحة إدارة الأطباء. يرجى التواصل مع المسؤول للحصول على الصلاحية المطلوبة.</p>
                </div>
            @else
                <div class="overflow-x-auto">
                    <table class="w-full">
                        <thead class="bg-gradient-to-r from-gray-50 to-gray-100">
                            <tr>
                                <th class="px-4 py-4 text-right text-xs font-semibold text-gray-600 uppercase tracking-wider">#</th>
                                <th class="px-4 py-4 text-right text-xs font-semibold text-gray-600 uppercase tracking-wider">الاسم</th>
                                <th class="px-4 py-4 text-right text-xs font-semibold text-gray-600 uppercase tracking-wider hidden md:table-cell">الهاتف</th>
                                <th class="px-4 py-4 text-right text-xs font-semibold text-gray-600 uppercase tracking-wider hidden lg:table-cell">التخصص</th>
                                <th class="px-4 py-4 text-right text-xs font-semibold text-gray-600 uppercase tracking-wider hidden lg:table-cell">الترخيص</th>
                                <th class="px-4 py-4 text-right text-xs font-semibold text-gray-600 uppercase tracking-wider">القسم</th>
                                <th class="px-4 py-4 text-right text-xs font-semibold text-gray-600 uppercase tracking-wider">التحكم</th>
                            </tr>
                        </thead>
                        <tbody class="divide-y divide-gray-100">
                            @forelse($doctors as $doctor)
                            <tr class="hover:bg-blue-50/50 transition-colors duration-150">
                                <td class="px-4 py-4 whitespace-nowrap">
                                    <span class="inline-flex items-center justify-center w-8 h-8 bg-blue-100 text-blue-700 text-sm font-bold rounded-full">
                                        {{ $doctor->id }}
                                    </span>
                                </td>
                                <td class="px-4 py-4">
                                    <div class="flex items-center gap-3">
                                        <div class="bg-gradient-to-br from-indigo-400 to-blue-500 w-10 h-10 rounded-full flex items-center justify-center text-white font-bold">
                                            {{ substr($doctor->name, 0, 1) }}
                                        </div>
                                        <div>
                                            <p class="font-semibold text-gray-800">{{ $doctor->name }}</p>
                                            <p class="text-xs text-gray-500 md:hidden">{{ $doctor->phone ?? '-' }}</p>
                                        </div>
                                    </div>
                                </td>
                                <td class="px-4 py-4 whitespace-nowrap hidden md:table-cell">
                                    <span class="inline-flex items-center px-2.5 py-0.5 rounded-full text-xs font-medium bg-gray-100 text-gray-700">
                                        {{ $doctor->phone ?? '-' }}
                                    </span>
                                </td>
                                <td class="px-4 py-4 whitespace-nowrap hidden lg:table-cell">
                                    <span class="text-gray-700">{{ $doctor->specialization }}</span>
                                </td>
                                <td class="px-4 py-4 whitespace-nowrap hidden lg:table-cell">
                                    <span class="text-gray-500 text-sm">{{ $doctor->license_number ?? '-' }}</span>
                                </td>
                                <td class="px-4 py-4 whitespace-nowrap">
                                    <span class="inline-flex items-center px-2.5 py-0.5 rounded-full text-xs font-medium bg-blue-100 text-blue-700">
                                        {{ $doctor->department->name ?? '-' }}
                                    </span>
                                </td>
                                <td class="px-4 py-4 whitespace-nowrap">
                                    <div class="flex items-center gap-2">
                                        @if($this->canEdit())
                                            <button
                                                wire:click="edit({{ $doctor->id }})"
                                                class="p-2 bg-yellow-100 hover:bg-yellow-200 text-yellow-700 rounded-lg transition-colors duration-200"
                                                title="تعديل"
                                            >
                                                <svg xmlns="http://www.w3.org/2000/svg" class="h-4 w-4" fill="none" viewBox="0 0 24 24" stroke="currentColor">
                                                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M11 5H6a2 2 0 00-2 2v11a2 2 0 002 2h11a2 2 0 002-2v-5m-1.414-9.414a2 2 0 112.828 2.828L11.828 15H9v-2.828l8.586-8.586z" />
                                                </svg>
                                            </button>
                                        @endif
                                        @if($this->canDelete())
                                            <button
                                                wire:click="delete({{ $doctor->id }})"
                                                onclick="confirm('هل أنت متأكد من حذف هذا الطبيب؟') || event.stopImmediatePropagation()"
                                                class="p-2 bg-red-100 hover:bg-red-200 text-red-700 rounded-lg transition-colors duration-200"
                                                title="حذف"
                                            >
                                                <svg xmlns="http://www.w3.org/2000/svg" class="h-4 w-4" fill="none" viewBox="0 0 24 24" stroke="currentColor">
                                                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M19 7l-.867 12.142A2 2 0 0116.138 21H7.862a2 2 0 01-1.995-1.858L5 7m5 4v6m4-6v6m1-10V4a1 1 0 00-1-1h-4a1 1 0 00-1 1v3M4 7h16" />
                                                </svg>
                                            </button>
                                        @endif
                                    </div>
                                </td>
                            </tr>
                            @empty
                            <tr>
                                <td colspan="7" class="px-4 py-16">
                                    <div class="text-center">
                                        <svg xmlns="http://www.w3.org/2000/svg" class="h-16 w-16 mx-auto text-gray-300 mb-4" fill="none" viewBox="0 0 24 24" stroke="currentColor">
                                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M16 7a4 4 0 11-8 0 4 4 0 018 0zM12 14a7 7 0 00-7 7h14a7 7 0 00-7-7z" />
                                        </svg>
                                        <p class="text-gray-500 text-lg">لا يوجد أطباء مسجلون</p>
                                        <p class="text-gray-400 text-sm mt-1">قم بإضافة طبيب جديد للبدء</p>
                                    </div>
                                </td>
                            </tr>
                            @endforelse
                        </tbody>
                    </table>
                </div>

                {{-- Pagination --}}
                @if($doctors->hasPages())
                <div class="bg-gray-50 px-4 py-4 border-t border-gray-100">
                    {{ $doctors->links() }}
                </div>
                @endif
            @endif
        </div>

        {{-- Modal --}}
        @if($isOpen)
        <div class="fixed inset-0 z-50 overflow-y-auto" aria-labelledby="modal-title" role="dialog" aria-modal="true">
            <div class="flex items-end justify-center min-h-screen pt-4 px-4 pb-20 text-center sm:block sm:p-0">
                <div wire:click="closeModal" class="fixed inset-0 bg-gray-900 bg-opacity-50 transition-opacity"></div>
                <span class="hidden sm:inline-block sm:align-middle sm:h-screen">&#8203;</span>

                <div class="inline-block align-bottom bg-white rounded-2xl text-right overflow-hidden shadow-2xl transform transition-all sm:my-8 sm:align-middle sm:max-w-lg w-full">
                    {{-- Modal Header --}}
                    <div class="bg-gradient-to-r from-blue-600 to-indigo-600 px-6 py-4">
                        <div class="flex items-center justify-between">
                            <h3 class="text-lg font-bold text-white" id="modal-title">
                                {{ $isEditMode ? 'تعديل طبيب' : 'إضافة طبيب جديد' }}
                            </h3>
                            <button wire:click="closeModal" class="text-white hover:bg-white/20 rounded-lg p-1 transition-colors">
                                <svg xmlns="http://www.w3.org/2000/svg" class="h-6 w-6" fill="none" viewBox="0 0 24 24" stroke="currentColor">
                                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M6 18L18 6M6 6l12 12" />
                                </svg>
                            </button>
                        </div>
                    </div>

                    {{-- Modal Body --}}
                    <div class="px-6 py-6">
                        <div class="space-y-5">
                            {{-- Name --}}
                            <div>
                                <label for="name" class="block text-sm font-semibold text-gray-700 mb-2">
                                    اسم الطبيب <span class="text-red-500">*</span>
                                </label>
                                <input
                                    type="text"
                                    id="name"
                                    wire:model="name"
                                    class="w-full px-4 py-3 bg-gray-50 border border-gray-200 rounded-xl focus:bg-white focus:ring-2 focus:ring-blue-500 focus:border-blue-500 transition-all duration-200"
                                    placeholder="أدخل اسم الطبيب"
                                />
                                @error('name')
                                    <p class="mt-1 text-sm text-red-500">{{ $message }}</p>
                                @enderror
                            </div>

                            {{-- Phone --}}
                            <div>
                                <label for="phone" class="block text-sm font-semibold text-gray-700 mb-2">
                                    الهاتف
                                </label>
                                <input
                                    type="text"
                                    id="phone"
                                    wire:model="phone"
                                    class="w-full px-4 py-3 bg-gray-50 border border-gray-200 rounded-xl focus:bg-white focus:ring-2 focus:ring-blue-500 focus:border-blue-500 transition-all duration-200"
                                    placeholder="أدخل رقم الهاتف"
                                />
                            </div>

                            {{-- Specialization --}}
                            <div>
                                <label for="specialization" class="block text-sm font-semibold text-gray-700 mb-2">
                                    التخصص <span class="text-red-500">*</span>
                                </label>
                                <input
                                    type="text"
                                    id="specialization"
                                    wire:model="specialization"
                                    class="w-full px-4 py-3 bg-gray-50 border border-gray-200 rounded-xl focus:bg-white focus:ring-2 focus:ring-blue-500 focus:border-blue-500 transition-all duration-200"
                                    placeholder="أدخل التخصص"
                                />
                                @error('specialization')
                                    <p class="mt-1 text-sm text-red-500">{{ $message }}</p>
                                @enderror
                            </div>

                            {{-- License Number --}}
                            <div>
                                <label for="license_number" class="block text-sm font-semibold text-gray-700 mb-2">
                                    رقم الترخيص
                                </label>
                                <input
                                    type="text"
                                    id="license_number"
                                    wire:model="license_number"
                                    class="w-full px-4 py-3 bg-gray-50 border border-gray-200 rounded-xl focus:bg-white focus:ring-2 focus:ring-blue-500 focus:border-blue-500 transition-all duration-200"
                                    placeholder="أدخل رقم الترخيص"
                                />
                            </div>

                            {{-- Department --}}
                            <div>
                                <label for="department_id" class="block text-sm font-semibold text-gray-700 mb-2">
                                    القسم <span class="text-red-500">*</span>
                                </label>
                                <select
                                    id="department_id"
                                    wire:model="department_id"
                                    class="w-full px-4 py-3 bg-gray-50 border border-gray-200 rounded-xl focus:bg-white focus:ring-2 focus:ring-blue-500 focus:border-blue-500 transition-all duration-200"
                                >
                                    <option value="">اختر القسم</option>
                                    @foreach($departments as $id => $name)
                                        <option value="{{ $id }}">{{ $name }}</option>
                                    @endforeach
                                </select>
                                @error('department_id')
                                    <p class="mt-1 text-sm text-red-500">{{ $message }}</p>
                                @enderror
                            </div>
                        </div>
                    </div>

                    {{-- Modal Footer --}}
                    <div class="bg-gray-50 px-6 py-4 flex gap-3 justify-end">
                        <button
                            wire:click="closeModal"
                            type="button"
                            class="px-5 py-2.5 bg-gray-200 hover:bg-gray-300 text-gray-700 rounded-xl font-medium transition-colors duration-200"
                        >
                            إلغاء
                        </button>
                        <button
                            wire:click="store"
                            type="button"
                            class="px-5 py-2.5 bg-gradient-to-r from-blue-600 to-indigo-600 hover:from-blue-700 hover:to-indigo-700 text-white rounded-xl font-medium transition-all duration-200 shadow-lg hover:shadow-xl"
                        >
                            {{ $isEditMode ? 'حفظ التغييرات' : 'إضافة الطبيب' }}
                        </button>
                    </div>
                </div>
            </div>
        </div>
        @endif

    </div>

