<?php

namespace App\Listeners;

use App\Events\OrderCreated;

use Illuminate\Contracts\Queue\ShouldQueue;
use Illuminate\Queue\InteractsWithQueue;
use Illuminate\Support\Facades\Mail;
use App\Mail\OrderCreatedMail;

class SendEmailOrderCreatedListener
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
     * @param object $event
     * @return void
     */
    public function handle(OrderCreated $event)
    {
        Mail::to($event->order->users->email)
            ->send(new OrderCreatedMail($event->order));
    }
}
