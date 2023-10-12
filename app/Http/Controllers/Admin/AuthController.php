<?php

namespace App\Http\Controllers\Admin;

use App\Enums\UserRoleEnum;
use App\Events\User\MailNotiUser;
use App\Http\Controllers\Controller;
use App\Http\Requests\RegisterAdminRequest;
use App\Models\User;
use Illuminate\Support\Facades\Auth;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Hash;
use Laravel\Socialite\Facades\Socialite;

class AuthController extends Controller
{
    /**
     * Construct
     */
    public function __construct(User $user)
    {
        $this->user = $user;
    }

    public function login(Request $request)
    {
        if (auth()->check()) {
            if (auth()->user()->status == User::USER_STATUS['INACTIVE']) {
                auth()->logout();
                return redirect()->route("admin.login")->with('invalidLogin', 'Tài khoản đã bị vô hiệu hóa.!');
            }
            return redirect()->route("admin.dashboards");
        }
        return view('backend.login.index');
    }

    public function handleLogin(Request $request)
    {
        try {
            if (auth()->attempt(['email' => $request->email, 'password' => $request->password], $request->remember ? true : false)) {
                if (auth()->user()->status == User::USER_STATUS['INACTIVE']) {
                    // $user = $this->user->where("email", auth()->user()->email)->first();
                    // $tokenResult = $user->createToken('authToken')->plainTextToken;
                    // dd($tokenResult);
                    auth()->logout();
                    return redirect()->route("admin.login")->with('invalidLogin', 'Tài khoản đã bị vô hiệu hóa.!');
                }
                $this->user->where('id', auth()->user()->id)->update([
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

    public function callback($provider)
    {
        try {
            $data = Socialite::driver($provider)->user();
            $user = $this->user->where('email', $data->email)->first();
            if (is_null($user)) {
                $this->user->where('email', $data->email)->delete();
                $user = new User();
                $user->email = $data->email;
                $user->level = 'staff';
            }
            $user->username   = $data->name;
            $user->avatar = $data->avatar;
            $user->last_login = now();
            $user->save();
            Auth::login($user, true);
            if (auth()->user()->status == User::USER_STATUS['INACTIVE']) {
                auth()->logout();
                return redirect()->route('admin.login')->withErrors([
                    'invalidLogin' => 'Tài khoản đã bị vô hiệu hóa.',
                ]);
            }
            return redirect()->route('admin.login');
        } catch (\Exception $e) {
            return redirect()->route('admin.login');
        }
    }

    public function registering(RegisterAdminRequest $request)
    {
        // $password = Hash::make($request->password);
        // $user = $this->user->create([
        //     'email' => $request->email,
        //     'username' => $request->userName,
        //     'fullname' => $request->fullName,
        //     'password' => $password,
        // ]);
        // Auth::login($user);
        // return redirect()->route('admin.login')->with('registerSuccess', 'Create Account Success!');
    }

    public function logout()
    {
        Auth::guard('web')->logout();
        request()->session()->invalidate();
        request()->session()->regenerateToken();
        return redirect()->route('admin.login');
    }
}
