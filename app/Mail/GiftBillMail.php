<?php

namespace App\Mail;

use Illuminate\Bus\Queueable;
use Illuminate\Mail\Mailable;
use Illuminate\Queue\SerializesModels;

class GiftBillMail extends Mailable
{
    use Queueable, SerializesModels;

    public $gift;
    public $pdfPath;

    /**
     * Create a new message instance.
     */
    public function __construct($gift, $pdfPath)
    {
        $this->gift = $gift;
        $this->pdfPath = $pdfPath;
    }

    /**
     * Build the message.
     */
    public function build()
    {
        return $this->view('AdminDashboard.emails.gift-bill')
                    ->subject('Your Fund Bill')
                    ->attach(storage_path('app/public/' . $this->pdfPath))
                    ->with([
                        'gift' => $this->gift,
                    ]);
    }
}
