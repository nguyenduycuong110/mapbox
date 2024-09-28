<?php

namespace App\Http\Middleware;

use Closure;
use Illuminate\Http\Request;
use Symfony\Component\HttpFoundation\Response;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Cookie;

class CheckLogin
{
    /**
     * Handle an incoming request.
     *
     * @param  \Closure(\Illuminate\Http\Request): (\Symfony\Component\HttpFoundation\Response)  $next
     */

    public function handle(Request $request, Closure $next): Response
    {

        $customer_id = Cookie::get('customer_id');
        
        if($customer_id !== null){

            return redirect()->route('customer.profile')->with('error','Bạn phải đăng xuất để tiến hành đăng nhập lại !');

        }else{}

        return $next($request);
    }
}