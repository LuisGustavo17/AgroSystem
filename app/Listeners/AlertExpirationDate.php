<?php

namespace App\Listeners;

use Illuminate\Queue\InteractsWithQueue;
use Illuminate\Contracts\Queue\ShouldQueue;

class AlertExpirationDate
{
    /**
     * Create the event listener.
     *
     * @return void
     */
    public function __construct()
    {
        //
    }

    /**
     * Handle the event.
     *
     * @param  AlertExpirationDate  $event
     * @return void
     */ //AlertExpirationDate $event
    public function handle()
    {
        dd('teste aqui');
    }
}
