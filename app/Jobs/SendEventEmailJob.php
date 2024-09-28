<?php

namespace App\Jobs;

use Illuminate\Bus\Queueable;
use Illuminate\Contracts\Queue\ShouldBeUnique;
use Illuminate\Contracts\Queue\ShouldQueue;
use Illuminate\Foundation\Bus\Dispatchable;
use Illuminate\Queue\InteractsWithQueue;
use Illuminate\Queue\SerializesModels;
use App\Models\Customer;
use Illuminate\Support\Facades\Mail; 
use Illuminate\Support\Facades\Log;
use App\Mail\EventNotificationMail;

class SendEventEmailJob implements ShouldQueue
{
    use Dispatchable, InteractsWithQueue, Queueable, SerializesModels;

    protected $customer;
    protected $event;

    public $tries = 3;

    public $retryAfter = 90;

    public function __construct(Customer $customer, $event)
    {
        $this->customer = $customer;
        $this->event = $event;
    }

    
    public function handle()
    {
        try {
            Mail::to($this->customer->email)->send(new EventNotificationMail($this->event));
        } catch (\Exception $e) {
            Log::error('Lỗi: '. $e->getMessage()());
        }

    }
}
