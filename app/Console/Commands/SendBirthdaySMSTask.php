<?php

namespace App\Console\Commands;

use App\Http\Controllers\SMSController;
use Illuminate\Console\Command;

class SendBirthdaySMSTask extends Command
{
    protected $signature = 'send:birthday-sms';
    protected $description = 'Send birthday SMS to members on their birthday';

    public function __construct()
    {
        parent::__construct();
    }

    public function handle()
    {
        // Use the service container to resolve the SMSController instance with its dependencies
        $smsController = app(SMSController::class);
        $smsController->sendBirthdaySMS();
        $this->info('Birthday SMS sent successfully!');
    }
}
