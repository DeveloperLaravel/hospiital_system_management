<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Models\User;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Hash;
use Spatie\Permission\Models\Role;

class UserController extends Controller
{
    public function index()
    {
        $users = User::with('roles')->paginate(10);

        return view('system.user.index', compact('users'));
    }

    public function create()
    {
        $roles = Role::all();

        return view('system.user.create', compact('roles'));
    }

    public function store(Request $request)
    {
        $request->validate([
            'name' => 'required|string|max:255',
            'email' => 'required|email|unique:users,email,',
            'password' => 'nullable|string|min:6|confirmed',
            'roles' => 'required|array',
        ],
            [
                'name.required' => 'الاسم مطلوب.',
                'name.string' => 'الاسم يجب أن يكون نصًا.',
                'name.max' => 'الاسم لا يمكن أن يزيد عن 255 حرفًا.',

                'email.required' => 'البريد الإلكتروني مطلوب.',
                'email.email' => 'البريد الإلكتروني يجب أن يكون بصيغة صحيحة.',
                'email.unique' => 'البريد الإلكتروني مستخدم مسبقًا.',

                'password.string' => 'كلمة المرور يجب أن تكون نصًا.',
                'password.min' => 'كلمة المرور يجب أن تكون 6 أحرف على الأقل.',
                'password.confirmed' => 'تأكيد كلمة المرور غير مطابق.',

                'roles.required' => 'يجب اختيار دور واحد على الأقل.',
                'roles.array' => 'الأدوار يجب أن تكون على شكل قائمة.',
            ]);

        $user = User::create([
            'name' => $request->name,
            'email' => $request->email,
            'password' => Hash::make($request->password),
        ]);

        $user->syncRoles($request->roles);

        return redirect()->route('system.user.index')->with('success', 'تم إنشاء المستخدم بنجاح');
    }

    public function edit(User $user)
    {
        $roles = Role::all();

        return view('system.user.edit', compact('user', 'roles'));
    }

    public function update(Request $request, User $user)
    {
        $request->validate([
            'name' => 'required|string|max:255',
            'email' => 'required|email|unique:users,email,'.$user->id,
            'password' => 'nullable|string|min:6|confirmed',
            'roles' => 'required|array',
        ],
            [
                'name.required' => 'الاسم مطلوب.',
                'name.string' => 'الاسم يجب أن يكون نصًا.',
                'name.max' => 'الاسم لا يمكن أن يزيد عن 255 حرفًا.',

                'email.required' => 'البريد الإلكتروني مطلوب.',
                'email.email' => 'البريد الإلكتروني يجب أن يكون بصيغة صحيحة.',
                'email.unique' => 'البريد الإلكتروني مستخدم مسبقًا.',

                'password.string' => 'كلمة المرور يجب أن تكون نصًا.',
                'password.min' => 'كلمة المرور يجب أن تكون 6 أحرف على الأقل.',
                'password.confirmed' => 'تأكيد كلمة المرور غير مطابق.',

                'roles.required' => 'يجب اختيار دور واحد على الأقل.',
                'roles.array' => 'الأدوار يجب أن تكون على شكل قائمة.',
            ]);

        $user->name = $request->name;
        $user->email = $request->email;
        if ($request->password) {
            $user->password = Hash::make($request->password);
        }
        $user->save();

        $user->syncRoles($request->roles);

        return redirect()->route('users.index')->with('success', 'تم تحديث المستخدم بنجاح');
    }

    public function destroy(User $user)
    {
        $user->delete();

        return redirect()->route('users.index')->with('success', 'تم حذف المستخدم بنجاح');
    }
}
