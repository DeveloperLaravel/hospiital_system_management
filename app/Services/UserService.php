<?php

namespace App\Services;

use App\Models\User;
use Illuminate\Support\Facades\Hash;

class UserService
{
    public function getAllUsers()
    {
        return User::with('roles')->paginate(10);
    }

    public function createUser(array $data): User
    {

        // التحقق من البيانات مع رسائل عربية
        $user = User::create([
            'name' => $data['name'],
            'email' => $data['email'],
            'password' => Hash::make($data['password']),
            'status' => $data['status'],
        ]);

        $user->syncRoles($request->roles ?? []);
        $user->syncPermissions($request->permissions ?? []);

        return $user;
    }

    public function updateUser(array $data, User $user)
    {
        $user->update([
            'name' => $data['name'],
            'email' => $data['email'],
            'status' => $data['status'],
        ]);

        if (! empty($data['password'])) {
            $user->update([
                'password' => bcrypt($data['password']),
            ]);
        }

        $user->syncRoles($data['roles'] ?? []);
        $user->syncPermissions($data['permissions'] ?? []);

        return $user;
    }

    public function deleteUser(User $user)
    {
        if ($user->id == 1) {
            throw new \Exception('لا يمكن حذف المستخدم الأساسي');
        }

        return $user->delete();
    }
}
