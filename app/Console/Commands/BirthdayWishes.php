<?php

namespace App\Console\Commands;

use App\Mail\BirthdayWishesMail;
use App\Models\Member;
use Illuminate\Console\Command;
use Illuminate\Support\Facades\Mail;
use Illuminate\Support\Facades\Http;

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
                $phoneNumber = $member->contact_info;
                $message = "{$member->member_name} \n We wish you a wonderful day filled with joy and happiness. Have an amazing birthday!";
                $response = Http::post('https://app.notify.lk/api/v1/send', [
                    'user_id'   => config('services.notify.user_id'),
                    'api_key'   => config('services.notify.api_key'),
                    'sender_id' => 'NotifyDEMO',
                    'to'        => $phoneNumber,
                    'message'   => $message,
                ]);
                logger('Queued birthday wishes for ' . $member->member_name);
                logger('Queued birthday wishes email ' . $member->email);
                logger('Queued birthday wishes SMS ' . $member->contact_info);
            }
        } else {
            logger('No birthdays today.');
        }
    }
}
