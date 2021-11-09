<?php

namespace App\Providers;

use Illuminate\Support\ServiceProvider;
use Illuminate\Mail\Events\MessageSent;
use Event;
use Log;

class AppServiceProvider extends ServiceProvider
{
    /**
     * Register any application services.
     *
     * @return void
     */
    public function register()
    {
        //
    }

    /**
     * Bootstrap any application services.
     *
     * @return void
     */
    public function boot()
    {
        Event::listen(function (MessageSent $message) {
            if(isset($message->data['event'])){
                $log = "Event ".$message->data['event']->title." : "." sent to ".$message->data['user']->email;
                Log::info($log);
            }
        });
    }
}
