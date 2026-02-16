<x-app-layout title="تعديل المستخدم">
    <main class="p-4 sm:p-6 flex-1 overflow-auto bg-gray-50 min-h-screen" dir="rtl">

    <div class="max-w-3xl mx-auto bg-white shadow-md rounded-lg p-6 mt-6">

        <h2 class="text-2xl font-bold text-gray-800 mb-4">تعديل بيانات المستخدم</h2>

        <x-validation-errors class="mb-4"/>

        <form action="{{ route('users.update',$user) }}" method="POST" class="space-y-4">
            @csrf
            @method('PUT')

            <!-- الاسم -->
            <div>
                <label for="name" class="block text-gray-700 font-semibold mb-1">الاسم</label>
                <input type="text" name="name" id="name" 
                       class="w-full border border-gray-300 rounded-md p-2 focus:ring-2 focus:ring-blue-500"
                       value="{{ old('name', $user->name) }}" required>
            </div>

            <!-- البريد الإلكتروني -->
            <div>
                <label for="email" class="block text-gray-700 font-semibold mb-1">البريد الإلكتروني</label>
                <input type="email" name="email" id="email" 
                       class="w-full border border-gray-300 rounded-md p-2 focus:ring-2 focus:ring-blue-500"
                       value="{{ old('email', $user->email) }}" required>
            </div>

            <!-- كلمة المرور -->
            <div>
                <label for="password" class="block text-gray-700 font-semibold mb-1">كلمة المرور (اختياري)</label>
                <input type="password" name="password" id="password" 
                       class="w-full border border-gray-300 rounded-md p-2 focus:ring-2 focus:ring-blue-500">
            </div>

            <!-- تأكيد كلمة المرور -->
            <div>
                <label for="password_confirmation" class="block text-gray-700 font-semibold mb-1">تأكيد كلمة المرور</label>
                <input type="password" name="password_confirmation" id="password_confirmation" 
                       class="w-full border border-gray-300 rounded-md p-2 focus:ring-2 focus:ring-blue-500">
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
            <div class="flex justify-end gap-3 mt-4">
                <a href="{{ route('users.index') }}" class="px-4 py-2 rounded-md border border-gray-300 text-gray-700 hover:bg-gray-100 transition">عودة</a>
                <button type="submit" class="px-4 py-2 rounded-md bg-green-600 text-white hover:bg-green-700 transition">تحديث</button>
            </div>
        </form>

    </div>
</main>
</x-app-layout>
