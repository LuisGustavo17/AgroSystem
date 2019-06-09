<?php

namespace App\Providers;

use Illuminate\Support\Facades\Event;
use Illuminate\Auth\Events\Registered;
use Illuminate\Auth\Events\Login;
use Illuminate\Auth\Listeners\SendEmailVerificationNotification;
//use Illuminate\Auth\Listeners\AlertExpirationDate;
use Illuminate\Foundation\Support\Providers\EventServiceProvider as ServiceProvider;

class EventServiceProvider extends ServiceProvider
{
    /**
     * The event listener mappings for the application.
     *
     * @var array
     */
    protected $listen = [
        Registered::class => [
            SendEmailVerificationNotification::class,
        ],
        /*
        Login::class => [
            AlertExpirationDate::class,
        ],
        */
        \App\Events\OutputProduct::class => [
            \App\Listeners\AlertStockMin::class,
        ],/*
        \App\Events\SystemLogin::class => [
            \App\Listeners\AlertExpirationDate::class,
        ],*/
    ];

    /**
     * Register any events for your application.
     *
     * @return void
     */
    public function boot()
    {
        parent::boot();

        //
    }
}
