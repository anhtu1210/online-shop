<?php

namespace App\Listeners;

use App\Events\OrderShipped;
use Illuminate\Contracts\Queue\ShouldQueue;
use Illuminate\Queue\InteractsWithQueue;
use Illuminate\Support\Facades\Log;
//
class UpdateStock implements ShouldQueue    
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
        try {
            // dd($event->order->details);
            foreach ($event->order->details as $product) {
                $product->decrement('qty', $product->pivot->quantity);
            }
        } catch (\Exception $exception) {
            Log::error(__CLASS__ . '@' . __FUNCTION__, [
                'line' => $exception->getLine(),
                'message' => $exception->getMessage()
            ]);
        }
    }
}
