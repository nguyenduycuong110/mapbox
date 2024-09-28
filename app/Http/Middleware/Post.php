<?php

namespace App\Http\Middleware;

use Closure;
use Illuminate\Http\Request;
use Symfony\Component\HttpFoundation\Response;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Cookie;
use App\Models\Language;
use App\Models\Customer;
use Termwind\Components\Dd;

class Post
{
    /**
     * Handle an incoming request.
     *
     * @param  \Closure(\Illuminate\Http\Request): (\Symfony\Component\HttpFoundation\Response)  $next
     */

    public function handle(Request $request, Closure $next): Response
    {

        $locale = app()->getLocale();

        $language = Language::where('canonical', $locale)->first();

        $canonical = str_replace('.html','', $request->path());

        $class = loadClass('Post');

        $post = $class->getPostByCanonical($canonical, $language->id);

        if($post == null){
            return $next($request);
        }

        if($post->type == 1){

            return $next($request);

        }else{

            $customer_id = Cookie::get('customer_id');

            if($customer_id == null){

                return redirect()->route('fe.auth.login')->with('error', 'Bạn phải đăng nhập tài khoản Premium để xem bài viết này !');

            }else{

                $customer = Customer::where('id', $customer_id)->first();

                if($customer->customer_catalogue_id == 5){

                    return $next($request);

                }else{

                    $setupAccountCanonical = 'huong-dan-tao-tai-khoan-premium';

                    return redirect()->route('router.index', ['canonical' => $setupAccountCanonical])
                    ->with('message', 'Bạn cần tài khoản premium để xem bài viết này. Vui lòng xem hướng dẫn thiết lập tài khoản.');
                     
                }

            }

        }
        
        
    }
}