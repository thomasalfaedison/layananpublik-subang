<?php

namespace App\Http\Controllers;

use App\Constants\DashboardConstant;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;

class AuthController extends Controller
{
    public function login(Request $request)
    {   
        if (Auth::check()) {
            return redirect(route(DashboardConstant::RouteIndex));
        }

        if ($request->isMethod('POST')) {
            $request->validate([
                'username' => 'required',
                'password' => 'required',
                // 'tahun' => 'required',
            ], [
                'username.required' => 'Username wajib diisi',
                'password.required' => 'Password wajib diisi',
                // 'tahun.required' => 'Tahun wajib diisi',
            ]);

            $credentials = $request->only('username', 'password');

            if (Auth::attempt($credentials)) {
                // session(['tahun' => $request->tahun]);
                return redirect(route(DashboardConstant::RouteIndex));
            }

            return redirect()->back()->with('danger', 'Username atau password salah')->withInput();
        }

        return view('auth.login');
    }

    public function logout()
    {
        Auth::logout();

        return redirect('/');
    }
}
