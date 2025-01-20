<?php

namespace App\Http\Controllers;

use App\Models\Member;
use App\Services\NotifyLkService;
use Carbon\Carbon;
use Illuminate\Http\Request;

class SMSController extends Controller
{
    protected $notifyLkService;

    public function __construct(NotifyLkService $notifyLkService)
    {
        $this->notifyLkService = $notifyLkService;
    }


    public function sendBirthdaySMS()
    {
        $today = Carbon::now()->format('m-d');
        $members = Member::whereRaw('DATE_FORMAT(birth_date, "%m-%d") = ?', [$today])->get();
    
        foreach ($members as $member) {
            // Format the phone number to ensure it starts with 94
            $phoneNumber = $member->contact_info;
            if (substr($phoneNumber, 0, 2) !== '94') {
                // Prepend 94 if not present
                $phoneNumber = '94' . ltrim($phoneNumber, '0');
            }
    
            $message = "Happy Birthday, {$member->member_name}! \n";
            $message .= "Wishing you a day filled with love and happiness! May this year bring you closer to your dreams.";
            $message .= "Have an amazing day, full of blessings. \n\n";
            $message .= "Warm wishes,\n";
            $message .= "Church Moratumulla Family ";
    
            // Send SMS
            $response = $this->notifyLkService->sendSMS($phoneNumber, $message);
    
            if ($response && isset($response->status) && $response->status == 'success') {
                \Log::info("Birthday message sent to {$phoneNumber} for {$member->member_name}");
            } else {
                // Log the full response for better insight
                \Log::error("Failed to send SMS to {$phoneNumber} for {$member->member_name}. Response: " . json_encode($response));
                $errorMessage = isset($response->error) ? $response->error : 'Unknown error';
                \Log::error("Error: {$errorMessage}");
            }
            
        }
    
        return 'Birthday SMS sent!';
    }
    
}
