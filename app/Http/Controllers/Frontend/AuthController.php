<?php

namespace App\Http\Controllers\Frontend;

use App\Http\Controllers\FrontendController;
use App\Services\Interfaces\UserServiceInterface  as UserService;
use App\Repositories\Interfaces\UserRepositoryInterface  as UserRepository;
use App\Http\Requests\AuthRegisterRequest;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Hash;
use Illuminate\Support\Str; 
use Illuminate\Support\Facades\Cookie;

class AuthController extends FrontendController
{
    protected $userService;
    public function __construct(
        UserService $userService,
        UserRepository $userRepository,
    ){
        $this->userService = $userService;
        $this->userRepository = $userRepository;
        parent::__construct();
    }

    public function index(){

        $system = $this->system;

        $seo = [
            'meta_title' => 'Trang đăng nhập - Hệ thống website '.$this->system['homepage_company'],
            'meta_keyword' => '',
            'meta_description' => '',
            'meta_image' => '',
            'canonical' => route('fe.auth.login')
        ];

        $config = $this->config();

        return view('frontend.auth.index', compact(
            'seo',
            'system',
            'config'
        ));
    }
  

    public function login(Request $request){

        $credentials = [

            'email' => $request->input('email'),

            'password' => $request->input('password')
            
        ];
        
        if(Auth::guard('web')->attempt($credentials)){

            $request->session()->regenerate();

            $user_id = Auth::guard('web')->id();

            Cookie::queue(Cookie::make('user_id', $user_id, 180));

            return redirect()->route('home.index')->with('success', 'Đăng nhập thành công');
        }

        return redirect()->route('home.index')->with('error','Email hoặc Mật khẩu không chính xác');
    }

    private function config(){
        return [
            'css' => [
                'backend/css/bootstrap.min.css',
                'https://harnishdesign.net/demo/html/oxyy/vendor/bootstrap/css/bootstrap.min.css'
            ]
        ];
    }

}
