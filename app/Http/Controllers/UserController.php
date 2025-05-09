<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\User;
use Illuminate\Auth\Events\Registered;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Password;
use Illuminate\Auth\Events\PasswordReset;
use Illuminate\Support\Facades\Hash;
use Illuminate\Support\Str;

class UserController extends Controller
{
    
    public function create()
    {
        return view('user.create');
    }


    public function store(Request $request)
    {   

        $request->validate([
            'name' => ['required', 'max:50'],
            'surname' => ['required', 'max:50'],
            'nickname' => ['required', 'max:50'],
            'email' => ['required', 'email', 'max:255', 'unique:users'],
            'password' => ['required', 'confirmed']
        ]);

        $user = User::create($request->all());
        event(new Registered($user));
        Auth::login($user);

        return redirect()->route('verification.notice');
    }


    public function login()
    {
        return view('user.login');
    }

    public function loginAuth(Request $request)
    {   
        $credentials = $request->validate([
           'email' => ['required', 'email'],
           'password' => ['required'],
        ]);
        
        if (Auth::attempt($credentials)){
            $request->session()->regenerate();
            return redirect()->intended('dashboard')->with('success', 'Welcome, ' . Auth::user()->name . '!');
        }

        return back()->withErrors([
            'email' => 'Wrong email or password',
        ]);
    }

    public function dashboard()
    {
        return view('user.dashboard');
    }

    
    public function logout()
    {
        Auth::logout();
        return redirect()->route('login'); 
    }

    
    public function forgotPasswordStore(Request $request) 
    {
        $request->validate(['email' => 'required|email']);

        $status = Password::sendResetLink(
            $request->only('email')
        );

        return $status === Password::RESET_LINK_SENT
            ? back()->with(['status' => __($status)])
            : back()->withErrors(['email' => __($status)]); 
    }


    public function resetPasswordUpdate(Request $request) 
    {
        $request->validate([
            'token' => 'required',
            'email' => 'required|email',
            'password' => 'required|min:8|confirmed',
        ]);

        $status = Password::reset(
            $request->only('email', 'password', 'password_confirmation', 'token'),
            function (User $user, string $password) {
                $user->forceFill([
                    'password' => $password
                ])->setRememberToken(Str::random(60));

                $user->save();

                event(new PasswordReset($user));
            }
        );

        return $status === Password::PASSWORD_RESET
            ? redirect()->route('login')->with('success', __($status))
            : back()->withErrors(['email' => [__($status)]]);
    }
}
