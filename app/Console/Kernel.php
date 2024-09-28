<?php

namespace App\Console;

use Illuminate\Console\Scheduling\Schedule;
use Illuminate\Foundation\Console\Kernel as ConsoleKernel;
use Illuminate\Support\Facades\Log;
use App\Models\Event;
use Carbon\Carbon;
use App\Jobs\SendEventEmailJob;
use App\Models\CustomerEvent;

use function PHPUnit\Framework\isEmpty;

class Kernel extends ConsoleKernel
{
    
    protected function schedule(Schedule $schedule)
    {
        $schedule->call(function(){

            echo "Chạy lịch trình vào thời điểm: " . Carbon::now() . PHP_EOL;

            $events = Event::where('startDate', '<=', Carbon::now())->where('endDate', '>=', Carbon::now())->get();

            if(!empty($events)){

                foreach($events as $key => $event){

                    $customers = $event->customer_event;

                    if(!empty($customers))
                    
                        foreach($customers as $customer){
        
                            if($customer->pivot->send_status === 1){
        
                                continue;
        
                            }

        
                            SendEventEmailJob::dispatch($customer, $event);
        
                            CustomerEvent::where('id', $customer->pivot->id)->update(['send_status' => 1]);
        
                        }
                }
                echo 'Kết thúc gửi email.' . PHP_EOL;
            }

        })->everyMinute();
    }

    
    protected function commands(): void
    {
        $this->load(__DIR__.'/Commands');

        require base_path('routes/console.php');
    }
}
