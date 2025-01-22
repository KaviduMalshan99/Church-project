<?php

namespace App\Mail;

use Illuminate\Bus\Queueable;
use Illuminate\Mail\Mailable;
use Illuminate\Queue\SerializesModels;
use Illuminate\Contracts\Queue\ShouldQueue; // Add this

class BirthdayWishesMail extends Mailable implements ShouldQueue // Queueable mail
{
    use Queueable, SerializesModels;

    public $member;

    public function __construct($member)
    {
        $this->member = $member;
    }

    public function build()
    {
        return $this->subject('Happy Birthday ' . $this->member->member_name)
                    ->view('emails.birthday_wishes');
    }
}
