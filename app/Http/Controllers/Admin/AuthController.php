<?php

namespace App\Http\Controllers\Admin;

use App\Enums\UserRoleEnum;
use App\Http\Controllers\Controller;
use App\Models\User;
use Illuminate\Support\Facades\Auth;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Hash;

class AuthController extends Controller
{
    public function index()
    {
        if (auth()->check()) {
            return redirect()->route("admin.dashboards");
        }
        return view('backend.login.index');
    }

    public function handleLogin(Request $request)
    {
        try {
            if (auth()->attempt(['email' => $request->email, 'password' => $request->password])) {
                $role = strtolower(UserRoleEnum::getKeys(auth()->user()->level)[0]);
                $request->session()->put('sessionEmailUser', auth()->user()->email);
                $request->session()->put('sessionIdUser', auth()->user()->id);
                $request->session()->put('sessionUserName', auth()->user()->fullname);
                $request->session()->put('sessionUserAvatar', auth()->user()->avatar);
                $request->session()->put('sessionUserRole', $role);
                User::query()->where('id', auth()->user()->id)->update([
                    'last_login' => now()
                ]);
                return redirect()->route("admin.dashboards");
            }
            return redirect()->back()->with('invalidLogin', 'Mật khẩu không chính xác');
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
        Auth::login($user);
        return redirect()->route('admin.login')->with('registerSuccess', 'Create Account Success!');
    }

    public function logout(Request $request)
    {
        auth()->logout();
        request()->session()->invalidate();
        request()->session()->regenerateToken();
        return redirect()->route('admin.login')->with('logoutSuccess', 'Account Logout Successful!');
    }
}
