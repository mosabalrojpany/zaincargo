<?php

namespace App\Jobs\Notifications\Shipments;

use App\Notifications\Shipments\OnTheWay;
use Illuminate\Bus\Queueable;
use Illuminate\Contracts\Queue\ShouldQueue;
use Illuminate\Foundation\Bus\Dispatchable;
use Illuminate\Queue\InteractsWithQueue;
use Illuminate\Queue\SerializesModels;

class SendOnTheWayNotification implements ShouldQueue
{
    use Dispatchable, InteractsWithQueue, Queueable, SerializesModels;

    protected $trip;

    /**
     * Create a new job instance.
     *
     * @return void
     */
    public function __construct($trip)
    {
        $this->trip = $trip;
    }

    /**
     * Execute the job.
     *
     * @return void
     */
    public function handle()
    {
        $this->trip->load(['invoices', 'invoices.customer']);

        foreach ($this->trip->invoices as $shipment) {
            $shipment->customer->notify(new OnTheWay($shipment));
        }
    }

}
