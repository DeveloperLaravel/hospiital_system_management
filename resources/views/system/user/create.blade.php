<x-app-layout title="إضافة مستخدم جديد">
    <main class="p-4 sm:p-6 flex-1 overflow-auto bg-gray-50 min-h-screen" dir="rtl">

        <div class="max-w-3xl mx-auto bg-white shadow-lg rounded-xl p-6 sm:p-8 mt-6">
            
            <h2 class="text-3xl sm:text-2xl font-bold text-gray-800 mb-6 text-center sm:text-right">إضافة مستخدم جديد</h2>

            {{-- عرض الأخطاء --}}
            @if($errors->any())
                <div class="mb-4 p-4 bg-red-100 text-red-800 rounded-lg">
                    <ul class="list-disc list-inside">
                        @foreach ($errors->all() as $error)
                            <li>{{ $error }}</li>
                        @endforeach
                    </ul>
                </div>
            @endif

            <form action="{{ route('users.store') }}" method="POST" class="space-y-5 text-right">
                @csrf

                <!-- الاسم -->
                <div>
                    <label for="name" class="block text-gray-700 font-semibold mb-1">الاسم</label>
                    <input type="text" name="name" id="name"
                        class="w-full border border-gray-300 rounded-lg p-3 focus:outline-none focus:ring-2 focus:ring-blue-400 transition"
                        value="{{ old('name') }}" required>
                </div>

                <!-- البريد الإلكتروني -->
                <div>
                    <label for="email" class="block text-gray-700 font-semibold mb-1">البريد الإلكتروني</label>
                    <input type="email" name="email" id="email"
                        class="w-full border border-gray-300 rounded-lg p-3 focus:outline-none focus:ring-2 focus:ring-blue-400 transition"
                        value="{{ old('email') }}" required>
                </div>

                <!-- كلمة المرور -->
                <div>
                    <label for="password" class="block text-gray-700 font-semibold mb-1">كلمة المرور</label>
                    <input type="password" name="password" id="password"
                        class="w-full border border-gray-300 rounded-lg p-3 focus:outline-none focus:ring-2 focus:ring-blue-400 transition"
                        required>
                </div>

                <!-- تأكيد كلمة المرور -->
                <div>
                    <label for="password_confirmation" class="block text-gray-700 font-semibold mb-1">تأكيد كلمة المرور</label>
                    <input type="password" name="password_confirmation" id="password_confirmation"
                        class="w-full border border-gray-300 rounded-lg p-3 focus:outline-none focus:ring-2 focus:ring-blue-400 transition"
                        required>
                </div>

                <!-- اختيار الأدوار -->
                <div>
                  <label class="block text-gray-700 font-semibold mb-1">الأدوار</label>
<div class="flex flex-wrap gap-3 min-h-[40px] items-center border border-gray-200 rounded p-2">
    @if($roles->isEmpty())
        <span class="text-red-600 text-sm">يجب معرفة الأدوار</span>
    @else
        @foreach($roles as $role)
            <label class="flex items-center gap-2 bg-gray-100 px-3 py-1 rounded-full cursor-pointer hover:bg-blue-100 transition">
                <input type="checkbox" name="roles[]" value="{{ $role->name }}"
                       class="form-checkbox h-4 w-4 text-blue-600"
                       {{ in_array($role->name, old('roles', $userRoles)) ? 'checked' : '' }}>
                <span class="text-gray-800">{{ $role->name }}</span>
            </label>
        @endforeach
    @endif
</div>

                </div>

                <!-- أزرار -->
                <div class="flex flex-col sm:flex-row justify-end gap-3 mt-6">
                    <a href="{{ route('users.index') }}" class="w-full sm:w-auto px-5 py-3 rounded-lg border border-gray-300 text-gray-700 hover:bg-gray-100 transition text-center">عودة</a>
                    <button type="submit" class="w-full sm:w-auto px-5 py-3 rounded-lg bg-blue-600 text-white hover:bg-blue-700 transition text-center">حفظ</button>
                </div>
            </form>

        </div>

    </main>
</x-app-layout>
