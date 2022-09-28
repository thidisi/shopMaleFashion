<?php

namespace App\Http\Controllers\Admin;

use App\Enums\UserRoleEnum;
use App\Http\Controllers\Controller;
use App\Models\User;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Hash;

class AuthController extends Controller
{
    public function index()
    {
        return view('backend.login.index');
    }

    public function handleLogin(Request $request)
    {
        try {
            $user = User::query()
                ->where('username', $request->get('userName'))
                ->firstOrFail();
            if ($user !== null) {
                $hasPassword = $user->password;
                $password = $request->get('passwordUser');
                if (Hash::check($password, $hasPassword)) {
                    $role = strtolower(UserRoleEnum::getKeys($user->level)[0]);
                    $request->session()->put('sessionEmailUser', $user->email);
                    $request->session()->put('sessionIdUser', $user->id);
                    $request->session()->put('sessionUserName', $user->fullname);
                    $request->session()->put('sessionUserAvatar', $user->avatar);
                    $request->session()->put('sessionUserRole', $role);
                    User::query()->where('id', $user->id)->update([
                        'last_login' => now()
                    ]);
                    return redirect()->route("admin.dashboards");
                }
                return redirect()->back()->with('invalidLogin', 'Mật khẩu không chính xác');
            }
        } catch (\Throwable $e) {
            return redirect()->route("admin.login")->with('invalidLogin', 'Tài khoản không tồn tại!');
        }
    }

    public function register()
    {
        return view('backend.login.register');
    }

    public function registering(Request $request)
    {
        $password = Hash::make($request->password);
        $user = User::query()
            ->create([
                'email' => $request->email,
                'username' => $request->userName,
                'fullname' => $request->fullName,
                'password' => $password,
            ]);
        return redirect()->route('admin.login')->with('registerSuccess', 'Create Account Success!');
    }

    public function logout(Request $request)
    {
        // Auth::logout();
        $request->session()->flush();
        return redirect()->route('admin.login')->with('logoutSuccess', 'Account Logout Successful!');
    }
}
