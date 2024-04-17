<?php

namespace App\Http\Controllers\Api;

use Illuminate\Http\Request;
use App\Http\Controllers\Controller;
use Illuminate\Support\Facades\Auth;

class UserController extends Controller
{
    public function login(Request $request)
    {
        // 验证 todo
        $credentials = $request->validate([
            'phone'    => ['required'],
            'password' => ['required'],
        ]);

        if (Auth::guard('web')->attempt($credentials)) {
            $request->session()->regenerate();
            // $user = Auth::guard('web')->user();
            // Auth::guard('web')->login($user);
            //
            // $token = $user->createToken('111')->accessToken;

            return [
                'status' => 200,
                // 'token'  => Auth::guard('web')->token,
            ];
        }

        return back()->withErrors([
            'phone' => '手机号有误',
        ]);
    }
}
