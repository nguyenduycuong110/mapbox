<?php

namespace App\Http\Controllers\Frontend;

use App\Http\Controllers\FrontendController;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use App\Http\Requests\Customer\EditProfileRequest;
use App\Http\Requests\Customer\RecoverCustomerPasswordRequest;
use App\Services\Interfaces\CustomerServiceInterface  as CustomerService;
use App\Models\Customer;
use Illuminate\Support\Facades\Cookie;

class CustomerController extends FrontendController
{
  
    protected $customerService;
    protected $customer;

    public function __construct(
        CustomerService $customerService,
    ){

        $this->customerService = $customerService;
        parent::__construct();
    
    }

  
    public function profile(){

        $customer = Customer::where('id', Cookie::get('customer_id'))->first();

        $system = $this->system;

        $seo = [
            'meta_title' => 'Trang quản lý tài khoản khách hàng'.$customer['name'],
            'meta_keyword' => '',
            'meta_description' => '',
            'meta_image' => '',
            'canonical' => route('customer.profile')
        ];
        return view('frontend.auth.customer.profile', compact(
            'seo',
            'system',
            'customer',
        ));
    }

    public function updateProfile(EditProfileRequest $request){

        $customer_cookie = Customer::where('id', Cookie::get('customer_id'))->first();

        $customerId =  Auth::guard('customer')->user()->id ?? $customer_cookie->id;
        
        if($this->customerService->update($customerId, $request)){
            return redirect()->route('customer.profile')->with('success','Thêm mới bản ghi thành công');
        }
        return redirect()->route('customer.profile')->with('error','Thêm mới bản ghi không thành công. Hãy thử lại');
    }


    public function logout(){
        $customerId = Cookie::get('customer_id');
        if($customerId){
            Cookie::queue(Cookie::forget('customer_id'));
            Auth::guard('customer')->logout();
        }
        return redirect()->route('home.index')->with('success', 'Bạn đã đăng xuất khỏi hệ thống.');
    }


}
