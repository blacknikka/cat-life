<?php

namespace App\Http\Controllers;

use Illuminate\Http\JsonResponse;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;

class CookieAuthenticationController extends Controller
{
    public const ERR_LOGIN_SUCCEEDED = 'ログインしました';
    public const ERR_LOGIN_FILED = 'ログインに失敗しました。再度お試しください';
    public const ERR_LOGOUT_SUCCEEDED = 'ログアウトしました';

    /**
     * 認証の試行を処理
     *
     * @param  Request  $request
     * @return JsonResponse
     */
    public function login(Request $request): JsonResponse
    {
        $credentials = $request->validate([
            'email' => ['required', 'email'],
            'password' => ['required'],
        ]);

        if (Auth::attempt($credentials)) {
            $request->session()->regenerate();

            return new JsonResponse(['message' => self::ERR_LOGIN_SUCCEEDED]);
        }

        return new JsonResponse(['message' => self::ERR_LOGIN_FILED], 401);
    }

    /**
     * @param Request $request
     * @return JsonResponse
     */
    public function logout(Request $request): JsonResponse
    {
        Auth::guard()->logout();
        $request->session()->invalidate();
        $request->session()->regenerateToken();

        return new JsonResponse(['message' => self::ERR_LOGOUT_SUCCEEDED]);
    }
}
