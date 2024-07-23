<?php

namespace App\Http\Controllers;

use App\Http\Requests\AdminRequest;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Artisan;

class AuthController extends Controller
{
    public function login()
    {
        return view('auth.login');
    }

    public function loginSubmit(AdminRequest $request)
    {
        $data = $request->validate([
            'email' => ['required', 'email'],
            'password' => ['required'],
        ]);
        if (Auth::guard()->attempt($data)) {
            
            return redirect()->route('home.index');
        } else {
            return back()->with([
                'status_failed' => 'Tài khoản hoặc mật khẩu không đúng'
            ]);
        }
    }
    
    public function logout()
    {
        Auth::guard()->logout();
        return redirect()->route('auth');
    }
}
