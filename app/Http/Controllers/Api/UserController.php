<?php

namespace App\Http\Controllers\Api;

use Illuminate\Support\Str;
use Illuminate\Http\Request;
use App\Http\Controllers\Controller;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Redis;
use Illuminate\Support\Facades\Cookie;

class UserController extends Controller
{
    public function login(Request $request)
    {
        $credentials = $request->validate([
            'phone'    => ['required'],
            'password' => ['required'],
            // 'projectId' => ['required'],
        ]);

        $systemItemId = $request->input('projectId');

        if (Auth::guard('web')->attempt($credentials, true)) {
            $request->session()->regenerateToken();
            $user = Auth::user();

            $token = Str::random(60); // 生成一个长度为 60 的随机 token
            // 将 token 存储到 Redis，设置过期时间为一天
            Redis::set('auth_token:' . $token, $user->id . '_' . $systemItemId, 'EX', 86400); // 设置过期时间为一天

            return [
                'status' => 200,
                'token'  => $token,
            ];
        }

        return [
            'status' => 400,
            'msg'    => '帐号密码不匹配',
        ];
    }

    public function changeSystemItemId(Request $request)
    {
        $rules = [
            'projectId' => 'required|integer',
        ];
        $input        = $this->validateParams($request, $rules);
        $systemItemId = $input['projectId'];
        $token        = Cookie::get('auth_token', '');
        $userId       = app('user_id') ?? '';

        Redis::set('auth_token:' . $token, $userId . '_' . $systemItemId, 'EX', 86400); // 设置过期时间为一天

        return [
            'status' => 200,
        ];
    }
}
