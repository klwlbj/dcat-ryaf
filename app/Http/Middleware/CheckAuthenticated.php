<?php

namespace App\Http\Middleware;

use Closure;
use App\Models\User;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Redis;
use Illuminate\Support\Facades\Cookie;

class CheckAuthenticated
{
    public function handle($request, Closure $next)
    {
        // 区分Web和Api类型的route
        $isApi = $request->is('api/*');
        $token = Cookie::get('auth_token', '');

        if (empty($token)) {
            return $this->responseError($isApi, 'token is null');
        }

        $redisValue = Redis::get('auth_token:' . $token);

        $user = null;
        if ($redisValue) {
            list($userId, $systemItemId) = explode('_', $redisValue);
            // 获取projectId，供查询企业时用
            app()->instance('system_item_id', $systemItemId);
            app()->instance('user_id', $userId);
            $user = User::find($userId);
            Auth::setUser($user);
        }
        if (!$user) {
            return $this->responseError($isApi, 'Login Failed');
        }

        return $next($request);
    }

    /**
     * 根据不同类型返回错误或跳转
     * @param bool $isApi
     * @param string $error
     * @return \Illuminate\Contracts\Foundation\Application|\Illuminate\Http\JsonResponse|\Illuminate\Http\RedirectResponse|\Illuminate\Routing\Redirector
     */
    private function responseError(bool $isApi, string $error)
    {
        if ($isApi) {
            return response()->json(['error' => $error], 400);
        }

        return redirect('/web/login'); // 如果用户未登录，则重定向到登录页面
    }
}
