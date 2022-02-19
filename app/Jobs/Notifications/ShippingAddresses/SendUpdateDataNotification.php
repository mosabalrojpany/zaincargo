<?php

namespace App\Jobs\Notifications\ShippingAddresses;

use App\Models\Customer;
use App\Notifications\ShippingAddresses\UpdateData;
use Illuminate\Bus\Queueable;
use Illuminate\Contracts\Queue\ShouldQueue;
use Illuminate\Foundation\Bus\Dispatchable;
use Illuminate\Queue\InteractsWithQueue;
use Illuminate\Queue\SerializesModels;
use Notification;

class SendUpdateDataNotification implements ShouldQueue
{
    use Dispatchable, InteractsWithQueue, Queueable, SerializesModels;

    /**
     * The Shipping Address instance.
     *
     * @var \App\Models\ShippingAddress
     */
    protected $shippingAddress;

    /**
     * Create a new job instance.
     *
     * @return void
     */
    public function __construct($shippingAddress)
    {
        $this->shippingAddress = $shippingAddress;
    }

    /**
     * Execute the job.
     *
     * @return void
     */
    public function handle()
    {
        $customers = Customer::activated()->get();
        Notification::send($customers, new UpdateData($this->shippingAddress));
    }

}
