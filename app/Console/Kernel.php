<?php

namespace App\Console;

use App\Message;
use Illuminate\Console\Scheduling\Schedule;
use Illuminate\Foundation\Console\Kernel as ConsoleKernel;

class Kernel extends ConsoleKernel
{
    /**
     * The Artisan commands provided by your application.
     *
     * @var array
     */
    protected $commands = [
        //
    ];

    /**
     * Define the application's command schedule.
     *
     * @param  \Illuminate\Console\Scheduling\Schedule $schedule
     *
     * @return void
     */
    protected function schedule(Schedule $schedule)
    {
        // $schedule->command('inspire')
        //          ->hourly();

        $schedule->call(function () {

            //Get unsent messages and send them in the background
            $messages = Message::limit(10)->where('messages.status', '=', '0')->select('messages.id','messages.body','users.phone','messages.type','users.verification_code','users.id as users_id')
                ->join('users', 'messages.user_id', '=', 'users.id')
                ->get();
            sendMessages($messages);

        })->everyMinute()
            ->name("SendUnsentMessages")
         // ->withoutOverlapping()
          ->appendOutputTo(storage_path('schedule/background.txt'));

    }

    /**
     * Register the Closure based commands for the application.
     *
     * @return void
     */
    protected function commands()
    {
        require base_path('routes/console.php');
    }
}
