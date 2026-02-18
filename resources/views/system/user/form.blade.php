<x-app-layout :title="isset($user) ? 'تعديل المستخدم' : 'إنشاء مستخدم'">
<main class="p-6">
    <x-user-form :user="$user ?? null" :roles="$roles" :permissions="$permissions" />
</main>
</x-app-layout>
