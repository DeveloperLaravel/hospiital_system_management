<x-app-layout title="إضافة مستخدم جديد">
    <main class="p-4 sm:p-6 flex-1 overflow-auto bg-gray-50 min-h-screen">

        <div class="max-w-3xl mx-auto bg-white shadow-lg rounded-xl p-6 sm:p-8 mt-6">
            
            <h2 class="text-3xl sm:text-2xl font-bold text-gray-800 mb-6 text-center sm:text-left">إضافة مستخدم جديد</h2>

            {{-- عرض الأخطاء --}}
            <x-validation-errors class="mb-4"/>

            <form action="{{ route('users.store') }}" method="POST" class="space-y-5">
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
                    <label class="block text-gray-700 font-semibold mb-2">الأدوار</label>
                    <div class="flex flex-wrap gap-3">
                        @foreach($roles as $role)
                            <label class="flex items-center gap-2 bg-gray-100 px-4 py-2 rounded-full cursor-pointer hover:bg-blue-100 transition">
                                <input type="checkbox" name="roles[]" value="{{ $role->name }}"
                                    class="form-checkbox h-5 w-5 text-blue-600" 
                                    {{ in_array($role->name, old('roles', [])) ? 'checked' : '' }}>
                                <span class="text-gray-800 font-medium">{{ $role->name }}</span>
                            </label>
                        @endforeach
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
