<?php

namespace App\Console\Commands;

use App\Mail\BirthdayWishesMail;
use App\Models\Member;
use Illuminate\Console\Command;
use Illuminate\Support\Facades\Mail;

class BirthdayWishes extends Command
{
    protected $signature = 'app:birthday-wishes';
    protected $description = 'Send birthday wishes to members who have a birthday today';

    public function handle()
    {
        $members = Member::whereDate('birth_date', today())->get();

        if ($members->isNotEmpty()) {
            foreach ($members as $member) {
                Mail::to($member->email)->queue(new BirthdayWishesMail($member)); // Queued mail
                logger('Queued birthday wishes for ' . $member->member_name);
            }
        } else {
            logger('No birthdays today.');
        }
    }
}
