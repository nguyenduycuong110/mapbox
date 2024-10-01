<?php  
namespace App\Http\ViewComposers;

use Illuminate\View\View;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Cookie;
use App\Models\User;

class UserComposer
{


    public function __construct(
        
    ){
        
    }

    public function compose(View $view)
    {
        $user_cookie = user::where('id', Cookie::get('user_id'))->first();

        $user = Auth::guard('web')->user() ?? $user_cookie;

        $view->with('userAuth', $user);

    }

   

}