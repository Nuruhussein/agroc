<?php

namespace App\Mail;

use App\Models\OrderItem;
use Illuminate\Bus\Queueable;
use Illuminate\Mail\Mailable;
use Illuminate\Queue\SerializesModels;

class DeliveryStatusUpdated extends Mailable
{
    use Queueable, SerializesModels;

    public $orderItem;
    public $newStatus;

    /**
     * Create a new message instance.
     */
    public function __construct(OrderItem $orderItem, string $newStatus = 'delivered')
    {
        $this->orderItem = $orderItem;
        $this->newStatus = $newStatus;
    }

    /**
     * Build the message.
     */
    public function build()
    {
        return $this->subject('Your Order Item Delivery Status Updated')
                    ->view('emails.delivery_status_updated');
    }
}