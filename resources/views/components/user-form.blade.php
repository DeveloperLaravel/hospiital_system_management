<div class="max-w-6xl mx-auto bg-white shadow rounded-xl p-6">

@if($errors->any())
<div class="bg-red-100 p-4 rounded mb-4">
    <ul class="list-disc list-inside text-red-700">
        @foreach($errors->all() as $error)
            <li>{{ $error }}</li>
        @endforeach
    </ul>
</div>
@endif

<form method="POST"
      action="{{ isset($user) ? route('users.update', $user->id) : route('users.store') }}">
@csrf
@if(isset($user))
    @method('PUT')
@endif

<div class="grid grid-cols-1 lg:grid-cols-3 gap-6">

    <!-- البيانات الأساسية -->
    <div class="bg-gray-50 p-4 rounded-lg">
        <h2 class="font-bold text-lg mb-4 border-b pb-2">البيانات الأساسية</h2>

        <label class="block mb-2">الاسم</label>
        <input type="text" name="name"
            value="{{ old('name', $user->name ?? '') }}"
            class="w-full border rounded p-2 mb-3">

        <label class="block mb-2">البريد الإلكتروني</label>
        <input type="email" name="email"
            value="{{ old('email', $user->email ?? '') }}"
            class="w-full border rounded p-2 mb-3">

        @if(!isset($user))
        <label class="block mb-2">كلمة المرور</label>
        <input type="password" name="password"
            class="w-full border rounded p-2 mb-3">
        @endif

        <label class="block mb-2">تأكيد كلمة المرور</label>
        <input type="password" name="password_confirmation"
               class="w-full border rounded p-2 mb-3">

        <label class="block mb-2">الحالة</label>
        <select name="status" class="w-full border rounded p-2">
            <option value="1" {{ old('status', $user->status ?? 1) ? 'selected' : '' }}>مفعل</option>
            <option value="0" {{ !old('status', $user->status ?? 1) ? 'selected' : '' }}>موقوف</option>
        </select>
    </div>

    <!-- الأدوار -->
    <div class="bg-blue-50 p-4 rounded-lg">
        <h2 class="font-bold text-lg mb-4 border-b pb-2">الأدوار</h2>

        @foreach($roles as $role)
            <label class="flex items-center gap-2 mb-2">
                <input type="checkbox" name="roles[]"
                    value="{{ $role->name }}"
                    {{ isset($user) && $user->hasRole($role->name) ? 'checked' : '' }}>
                {{ $role->name }}
            </label>
        @endforeach
    </div>

    <!-- الصلاحيات -->
    <div class="bg-green-50 p-4 rounded-lg overflow-y-auto max-h-[400px]">
        <h2 class="font-bold text-lg mb-4 border-b pb-2">الصلاحيات</h2>

        @foreach($permissions->groupBy(function($item){
            return explode('-', $item->name)[0];
        }) as $group => $groupPermissions)

            <div class="mb-4">
                <h3 class="font-semibold text-sm mb-2 text-gray-700">
                    {{ strtoupper($group) }}
                </h3>

                @foreach($groupPermissions as $permission)
                    <label class="flex items-center gap-2 mb-1 text-sm">
                        <input type="checkbox" name="permissions[]"
                            value="{{ $permission->name }}"
                            {{ isset($user) && $user->hasPermissionTo($permission->name) ? 'checked' : '' }}>
                        {{ $permission->name }}
                    </label>
                @endforeach
            </div>

        @endforeach
    </div>

</div>

<div class="mt-6 text-end">
    <button class="bg-blue-600 text-white px-6 py-2 rounded-lg hover:bg-blue-700 transition">
        {{ isset($user) ? 'تحديث المستخدم' : 'إنشاء المستخدم' }}
    </button>
</div>

</form>
</div>
