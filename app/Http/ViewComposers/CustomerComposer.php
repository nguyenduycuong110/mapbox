<?php  
namespace App\Http\ViewComposers;

use Illuminate\View\View;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Cookie;
use App\Models\Customer;

class CustomerComposer
{


    public function __construct(
        
    ){
        
    }

    public function compose(View $view)
    {
        $customer_cookie = Customer::where('id', Cookie::get('customer_id'))->first();

        $customer = Auth::guard('customer')->user() ?? $customer_cookie;

        $view->with('customerAuth', $customer);

    }

   

}