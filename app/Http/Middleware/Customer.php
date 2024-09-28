<?php

namespace App\Http\Middleware;

use Closure;
use Illuminate\Http\Request;
use Symfony\Component\HttpFoundation\Response;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Cookie;

class Customer
{
    /**
     * Handle an incoming request.
     *
     * @param  \Closure(\Illuminate\Http\Request): (\Symfony\Component\HttpFoundation\Response)  $next
     */

    public function handle(Request $request, Closure $next): Response
    {
        $customer_id = Cookie::get('customer_id');
        if($customer_id == null){
            return redirect()->route('fe.auth.login')->with('error','Bạn phải đăng nhập để sử dụng chức năng này');
        }

        return $next($request);
    }
}
