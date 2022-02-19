<?php

namespace App\Mail\Customers;

use Illuminate\Bus\Queueable;
use Illuminate\Contracts\Queue\ShouldQueue;
use Illuminate\Mail\Mailable;
use Illuminate\Queue\SerializesModels;

class Activation extends Mailable implements ShouldQueue
{
    use Queueable, SerializesModels;

    protected $customer;

    /**
     * Create a new message instance.
     *
     * @return void
     */
    public function __construct($customer)
    {
        $this->customer = $customer;
    }

    /**
     * Build the message.
     *
     * @return $this
     */
    public function build()
    {
        $subject = 'لقد تم تفعيل عضويتك في ' . config('app.name');

        return $this->view('emails.customers.activation')
            ->subject($subject)
            ->with([
                'subject' => $subject,
                'customer' => $this->customer,
            ]);
    }
}
