<?php

namespace App\Http\Middleware;

use Closure;
use Illuminate\Http\Request;
use Symfony\Component\HttpFoundation\Response;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Cookie;

class User
{
    /**
     * Handle an incoming request.
     *
     * @param  \Closure(\Illuminate\Http\Request): (\Symfony\Component\HttpFoundation\Response)  $next
     */

    public function handle(Request $request, Closure $next): Response
    {
        $user_id = Cookie::get('user_id');
        if($user_id == null){
            return redirect()->route('fe.auth.login')->with('error','Bạn phải đăng nhập để sử dụng chức năng này');
        }

        return $next($request);
    }
}
