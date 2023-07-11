<?php

namespace App\Mail;

use Illuminate\Bus\Queueable;
use Illuminate\Mail\Mailable;
use Illuminate\Queue\SerializesModels;
use Illuminate\Contracts\Queue\ShouldQueue;

class PurchaseNotification extends Mailable
{
    use Queueable, SerializesModels;

    /**
     * Create a new message instance.
     *
     * @return void
     */
      public $idea;
      public $seller;
      public $buyer; 
   
    public function __construct($idea, $seller, $buyer)
    {
        $this->idea = $idea;
        $this->seller = $seller;
        $this->buyer = $buyer;
    }
    
    /**
     * Build the message.
     *
     * @return $this
     */
    public function build()
    {
    return $this->view('email.purchase_notification')
                ->subject('アイデア購入のお知らせ')
                ->with([
                    'idea' => $this->idea,
                    'seller' => $this->seller,
                    'buyer' => $this->buyer,
                ]);
    }
}
