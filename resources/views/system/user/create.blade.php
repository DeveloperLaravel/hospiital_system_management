<x-app-layout title="إضافة مستخدم جديد">
    <main class="p-6 flex-1 overflow-auto bg-gray-50 min-h-screen" dir="rtl">
        <div class="max-w-3xl mx-auto bg-white shadow-xl rounded-2xl p-8 mt-8">
            
            <!-- العنوان -->
            <h2 class="text-3xl font-extrabold text-gray-800 mb-8 text-right">إضافة مستخدم جديد</h2>

            <!-- عرض الأخطاء -->
            @if($errors->any())
                <div class="mb-6 p-4 bg-red-100 text-red-800 rounded-lg border border-red-200">
                    <ul class="list-disc list-inside">
                        @foreach ($errors->all() as $error)
                            <li>{{ $error }}</li>
                        @endforeach
                    </ul>
                </div>
            @endif

            <!-- النموذج -->
            <form action="{{ route('users.store') }}" method="POST" class="space-y-6 text-right">
                @csrf

                <!-- الاسم -->
                <div>
                    <label for="name" class="block text-gray-700 font-semibold mb-2">الاسم</label>
                    <input type="text" name="name" id="name"
                        class="w-full border border-gray-300 rounded-xl p-3 focus:outline-none focus:ring-2 focus:ring-blue-400 transition shadow-sm"
                        value="{{ old('name') }}" required>
                </div>

                <!-- البريد الإلكتروني -->
                <div>
                    <label for="email" class="block text-gray-700 font-semibold mb-2">البريد الإلكتروني</label>
                    <input type="email" name="email" id="email"
                        class="w-full border border-gray-300 rounded-xl p-3 focus:outline-none focus:ring-2 focus:ring-blue-400 transition shadow-sm"
                        value="{{ old('email') }}" required>
                </div>

                <!-- كلمة المرور -->
                <div>
                    <label for="password" class="block text-gray-700 font-semibold mb-2">كلمة المرور</label>
                    <input type="password" name="password" id="password"
                        class="w-full border border-gray-300 rounded-xl p-3 focus:outline-none focus:ring-2 focus:ring-blue-400 transition shadow-sm"
                        required>
                </div>

                <!-- تأكيد كلمة المرور -->
                <div>
                    <label for="password_confirmation" class="block text-gray-700 font-semibold mb-2">تأكيد كلمة المرور</label>
                    <input type="password" name="password_confirmation" id="password_confirmation"
                        class="w-full border border-gray-300 rounded-xl p-3 focus:outline-none focus:ring-2 focus:ring-blue-400 transition shadow-sm"
                        required>
                </div>

                <!-- اختيار الأدوار -->
                <div>
                    <label class="block text-gray-700 font-semibold mb-2">الأدوار</label>
                    <div class="flex flex-wrap gap-3 min-h-[50px] items-center border border-gray-200 rounded-xl p-3 bg-gray-50">
                        @if($roles->isEmpty())
                            <span class="text-red-600 text-sm">يجب معرفة الأدوار</span>
                        @else
                            @foreach($roles as $role)
                                <label class="flex items-center gap-2 bg-gray-100 px-4 py-2 rounded-full cursor-pointer hover:bg-blue-100 transition shadow-sm">
                                    <input type="checkbox" name="roles[]" value="{{ $role->name }}"
                                           class="form-checkbox h-5 w-5 text-blue-600"
                                           {{ in_array($role->name, old('roles', $userRoles)) ? 'checked' : '' }}>
                                    <span class="text-gray-800 font-medium">{{ $role->name }}</span>
                                </label>
                            @endforeach
                        @endif
                    </div>
                </div>

                <!-- الأزرار -->
                <div class="flex flex-col sm:flex-row justify-end gap-4 mt-8">
                    <a href="{{ route('users.index') }}"
                        class="w-full sm:w-auto px-6 py-3 rounded-xl border border-gray-300 text-gray-700 hover:bg-gray-100 transition text-center shadow-sm">
                        العودة
                    </a>
                    <button type="submit"
                        class="w-full sm:w-auto px-6 py-3 rounded-xl bg-blue-600 text-white font-semibold hover:bg-blue-700 transition shadow-md text-center">
                        حفظ
                    </button>
                </div>
            </form>
        </div>
    </main>
</x-app-layout>
