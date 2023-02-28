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

    public function index(Request $request)
    {
        if (auth()->check()) {
            if (!$request->session()->has('sessionUserRole')) {
                $request->session()->put('sessionUserRole', strtolower(UserRoleEnum::getKeys(auth()->user()->level)[0]));
            }
            return redirect()->route("admin.dashboards");
        }
        return view('backend.login.index');
    }

    public function handleLogin(Request $request)
    {
        try {
            $field = filter_var($request->user_name, FILTER_VALIDATE_EMAIL) ? 'email' : 'username';
            if (auth()->attempt([$field => $request->user_name, 'password' => $request->password])) {
                if (!$request->session()->has('sessionUserRole')) {
                    $request->session()->put('sessionUserRole', strtolower(UserRoleEnum::getKeys(auth()->user()->level)[0]));
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
        $data = Socialite::driver($provider)->user();
        $user = $this->user->where('email', $data->email)->first();
        $user->email = $data->email;
        $user->level = '1';
        $user->username   = $data->nickname;
        $user->fullname   = $data->name;
        $user->avatar = $data->avatar;
        $user->save();
        $param['plainPassword'] = '123';
        event(new MailNotiUser($user, $param));
        Auth::login($user);
        // if (auth()->user()->status == User::USER_STATUS['INACTIVE']) {
        //     auth()->logout();
        //     return redirect()->route('admin.login')->withErrors([
        //         'error' => 'Tài khoản đã bị vô hiệu hóa.',
        //     ]);
        // }
        return redirect()->route('admin.login');
    }

    public function registering(RegisterAdminRequest $request)
    {
        $password = Hash::make($request->password);
        $user = $this->user->create([
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
