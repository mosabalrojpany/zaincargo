<?php

namespace App\Mail\Customers;

use Illuminate\Bus\Queueable;
use Illuminate\Mail\Mailable;
use Illuminate\Queue\SerializesModels;

class UpdatePassword extends Mailable
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
        $subject = 'لقد تم تحديث كلمة المرور الخاصة بك';

        return $this->view('emails.customers.update_password')
            ->subject($subject)
            ->with([
                'subject' => $subject,
                'customer' => $this->customer,
            ]);
    }
}
