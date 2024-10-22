<?php

namespace App\Listeners;

use App\Events\OrderShipped;
use Illuminate\Support\Facades\Log;
use Illuminate\Support\Facades\Mail;
use App\Mail\OrderEmailSentSuccessfully;
use Illuminate\Queue\InteractsWithQueue;
use Illuminate\Contracts\Queue\ShouldQueue;

class SendNotification implements ShouldQueue
{
    /**
     * Create the event listener.
     */
    public function __construct()
    {
        //
    }

    /**
     * Handle the event.
     */
    public function handle(OrderShipped $event): void
    {
        Mail::to($event->order->email)->send(new OrderEmailSentSuccessfully($event->order, $event->carts));

        Log::debug(__CLASS__ . ' send email to ' . $event->order->email);
    }
}
