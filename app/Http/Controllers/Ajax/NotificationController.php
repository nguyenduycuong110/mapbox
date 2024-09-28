<?php

namespace App\Http\Controllers\Ajax;
use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use Illuminate\Support\Str;
use Illuminate\Support\Facades\Mail;
use App\Mail\SendConfirmMail; 
use Illuminate\Support\Facades\Cookie;
use App\Models\Notification;
use Carbon\Carbon;
use App\Repositories\Interfaces\PostRepositoryInterface  as PostRepository;
use App\Models\NotificationCustomer;

class NotificationController extends Controller
{
    protected $postRepository;

    public function __construct(PostRepository $postRepository){
        $this->postRepository = $postRepository;
    }

    public function checkNewsNotification(Request $request){

        $time = $request->last_check_time;

        $customer_id = $request->input('customer_id');

        $total = NotificationCustomer::where('customer_id', $customer_id)->count('is_read') ?? null;

        $posts = $this->postRepository->findNewsNotification($time);

        $temp = [];

        if(!is_null($posts)){
            foreach($posts as $key => $val){
                $created_at = Carbon::parse($val->created_at->format('Y-m-d H:i:s'));
                $temp[] = [
                    'id' => $val->id,
                    'image' => $val->image,
                    'name' => $val->name,
                    'canonical' => $val->canonical,
                    'created_at' =>  $created_at->diffForHumans()
                ];
            }
        }
        
        return response()->json(
            [
                'notifications' => $temp,
                'total' => $total
            ]
        );
    }
    

}
