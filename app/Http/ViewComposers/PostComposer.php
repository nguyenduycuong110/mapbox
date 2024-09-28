<?php  
namespace App\Http\ViewComposers;

use Illuminate\View\View;
use App\Repositories\Interfaces\PostRepositoryInterface  as PostRepository;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Cookie;
use App\Models\Customer;

class PostComposer
{

    protected $postRepository;

    public function __construct(
        PostRepository $postRepository,
    ){
        $this->postRepository = $postRepository;
    }

    public function compose(View $view)
    {
        $customer_cookie = Customer::where('id', Cookie::get('customer_id'))->first();

        $customer = Auth::guard('customer')->user() ?? $customer_cookie;

        $customer_alert= $customer->alert ?? null;

        $notifications = null;

        $total_read = null;
         
        if($customer_alert == 1){

            $customer_id = $customer->id;

            $notifications = $this->postRepository->getNotification($customer_id);

            $total_read = ($this->postRepository->getTotalNotification($customer_id))->first()->total_is_read ?? 0;

        }

        $view->with('notifications', $notifications)

        ->with('total_read', $total_read);

    }
}