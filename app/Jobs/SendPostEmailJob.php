<?php

namespace App\Jobs;

use Illuminate\Bus\Queueable;
use Illuminate\Contracts\Queue\ShouldBeUnique;
use Illuminate\Contracts\Queue\ShouldQueue;
use Illuminate\Foundation\Bus\Dispatchable;
use Illuminate\Queue\InteractsWithQueue;
use Illuminate\Queue\SerializesModels;
use App\Models\Customer;
use App\Models\Post;
use Illuminate\Support\Facades\Mail; 
use Illuminate\Support\Facades\Log;
use App\Mail\EventNotificationPostMail;

class SendPostEmailJob implements ShouldQueue
{
    use Dispatchable, InteractsWithQueue, Queueable, SerializesModels;

    protected $customer;

    protected $post;

    public $tries = 3;

    public $retryAfter = 90;

    public function __construct(Customer $customer, $post)
    {
        $this->customer = $customer;
        $this->post = $post;
    }
    
    public function handle()
    {
        try {
            $repo = loadClass('Post');
            $temp = $this->post = $repo->getPostById($this->post->id, 1);
            Mail::to($this->customer->email)->send(new EventNotificationPostMail($temp));
        } catch (\Exception $e) {
            Log::error('Lỗi: '. $e->getMessage()());
        }
    }
}
