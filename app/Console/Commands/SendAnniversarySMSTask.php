<?php

namespace App\Console\Commands;

use App\Http\Controllers\SMSController;
use Illuminate\Console\Command;

class SendAnniversarySMSTask extends Command
{
    protected $signature = 'send:anniversary-sms';
    protected $description = 'Send anniversary SMS to members on their anniversary';

    public function __construct()
    {
        parent::__construct();
    }

    public function handle()
    {
        // Use the service container to resolve the SMSController instance with its dependencies
        $smsController = app(SMSController::class);
        $smsController->sendAnniversarySMS();
        $this->info('Anniversary SMS sent successfully!');
    }
}
