<?php

namespace App\Http\Controllers\Auth;
;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use App\Http\Requests\LoginRequest;
use Illuminate\Support\Facades\Auth;
use App\Events\UserRegistered;
use App\Http\Requests\PasswordResetRequest;
use App\Http\Requests\UserStoreRequest;
use App\Mail\ResetPasswordMail;
use App\Models\User;
use App\Models\UserVerify;
use App\Traits\Loggable;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Hash;
use Illuminate\Support\Facades\Mail;
use Illuminate\Support\Str;
use Laravel\Socialite\Facades\Socialite;

class LoginController extends Controller
{
    public function showLogin()
    {
        return view("auth.login");
    }

    public function showRegister()
    {
        return view("auth.register");
    }

    public function login(LoginRequest $request)
    {
        $email = $request->email;
        $password = $request->password;
        $remember = $request->remember;

        !is_null($remember) ? $remember = true : $remember = false;

        $user = User::where("email", $email)->first();

        if($user && \Hash::check($password, $user->password))
        {
            Auth::login($user, $remember);
//            Auth::loginUsingId($user->id);
            return redirect()->route("home");
        } else
        {
            return redirect()
                ->route("login")
                ->withErrors([
                    "email" => "Verdiginiz bilgilerle eslesen bir kullanici bulunamadi"
                ])
                ->onlyInput("email");
        }

        dd($request->all());
    }

    public function login2(LoginRequest $request)
    {
        $email = $request->email;
        $password = $request->password;
        $remember = $request->remember;

        !is_null($remember) ? $remember = true : $remember = false;

        if (Auth::attempt(['email' => $email, 'password' => $password], $remember))
        {
            return redirect()->route("admin.index");
        }
        else
        {
            return redirect()
                ->route("login")
                ->withErrors([
                    "email" => "Verdiginiz bilgilerle eslesen bir kullanici bulunamadi"
                ])
                ->onlyInput("email");
        }
    }

    public function login3(LoginRequest $request)
    {
        $email = $request->email;
        $password = $request->password;
        $remember = $request->remember;

        !is_null($remember) ? $remember = true : $remember = false;

        if (Auth::attempt(['email' => $email, 'password' => $password, "status" => 1], $remember))
        {
            return redirect()->route("admin.index");
        }
        else
        {
            return redirect()
                ->route("login")
                ->withErrors([
                    "email" => "Verdiginiz bilgilerle eslesen bir kullanici bulunamadi"
                ])
                ->onlyInput("email");
        }
    }

    public function logout(Request $request)
    {
        if (Auth::check())
        {
            Auth::logout();

            $request->session()->invalidate();

            $request->session()->regenerateToken();

            return redirect()->route("login");
        }
    }

}
