<?php

namespace App\Mail;

use Illuminate\Bus\Queueable;
use Illuminate\Mail\Mailable;
use Illuminate\Queue\SerializesModels;

class OrderStatusMail extends Mailable
{
    use Queueable, SerializesModels;

    public $details; // This will hold the data from your form

    /**
     * Create a new message instance.
     *
     * @return void
     */
    public function __construct($details)
    {
        $this->details = $details;
    }

    /**
     * Build the message.
     *
     * @return $this
     */
    public function build()
    {
        return $this->subject('Order Update')
                    // IMPORTANT: Use ->markdown() because your email template uses @component('mail::...')
                    ->markdown('admin.order_mail')
                    // Pass the $details array to the view so it can access the data
                    // The keys of the $details array (greeting, firstline, etc.)
                    // will become variables in your Blade template ($greeting, $firstline)
                    ->with($this->details);
    }
}
