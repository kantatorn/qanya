<?php

namespace App\Providers;

use Illuminate\Contracts\Events\Dispatcher as DispatcherContract;
use Illuminate\Foundation\Support\Providers\EventServiceProvider as ServiceProvider;

class EventServiceProvider extends ServiceProvider
{
    /**
     * The event listener mappings for the application.
     *
     * @var array
     */
    protected $listen = [

        /*NEW ANSWER*/
        'App\Events\NewAnswer' => [
            'App\Listeners\NewAnswerListener',
        ],


        //WELCOME EMAIL
        'App\Events\WelcomeUser' => [
            'App\Listeners\WelcomeListener',
        ],

        //ANON POST
        'App\Events\AnonPost' => [
            'App\Listeners\AnonPostListener',
        ],
    ];

    /**
     * Register any other events for your application.
     *
     * @param  \Illuminate\Contracts\Events\Dispatcher  $events
     * @return void
     */
    public function boot(DispatcherContract $events)
    {
        parent::boot($events);

        //
    }
}
