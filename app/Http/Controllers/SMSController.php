<?php

namespace App\Http\Controllers;

use App\Models\Member;
use App\Services\NotifyLkService;
use App\Models\MessageSent;
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
            // Calculate the age from birth_date
            $age = Carbon::parse($member->birth_date)->age;

            // Get the ordinal suffix for the age
            $ageWithSuffix = $this->getOrdinalSuffix($age);

            // Format the phone number to ensure it starts with 94
            $phoneNumber = $member->contact_info;
            if (substr($phoneNumber, 0, 2) !== '94') {
                // Prepend 94 if not present
                $phoneNumber = '94' . ltrim($phoneNumber, '0');
            }

            // Message with age and ordinal suffix
            $message = "Happy {$ageWithSuffix} Birthday, {$member->member_name}! \n";
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


    public function sendAnniversarySMS()
    {
        $today = Carbon::now()->format('m-d');
        $members = Member::whereRaw('DATE_FORMAT(married_date, "%m-%d") = ?', [$today])->get();
    
        foreach ($members as $member) {
            $marriedDate = Carbon::parse($member->married_date);
            $yearsMarried = (int) $marriedDate->diffInYears(Carbon::now());
    
            // If the anniversary hasn't occurred yet this year, subtract 1 from the years
            if ($marriedDate->month > Carbon::now()->month || ($marriedDate->month == Carbon::now()->month && $marriedDate->day > Carbon::now()->day)) {
                $yearsMarried--;
            }
    
            // Get the ordinal suffix for the anniversary year
            $anniversaryWithSuffix = $this->getOrdinalSuffix($yearsMarried);
    
            // Format the phone number to ensure it starts with 94
            $phoneNumber = $member->contact_info;
            if (substr($phoneNumber, 0, 2) !== '94') {
                // Prepend 94 if not present
                $phoneNumber = '94' . ltrim($phoneNumber, '0');
            }
    
            // Message with years of marriage and ordinal suffix
            $message = "Happy {$anniversaryWithSuffix} Anniversary, {$member->member_name}! \n";
            $message .= "Wishing you a day filled with love and happiness! May this year bring you more joy and togetherness.";
            $message .= "Enjoy this special day, full of blessings. \n\n";
            $message .= "Warm wishes,\n";
            $message .= "Church Moratumulla Family ";
    
            // Send SMS
            $response = $this->notifyLkService->sendSMS($phoneNumber, $message);
    
            if ($response && isset($response->status) && $response->status == 'success') {
                \Log::info("Anniversary message sent to {$phoneNumber} for {$member->member_name}");
            } else {
                // Log the full response for better insight
                \Log::error("Failed to send SMS to {$phoneNumber} for Happy {$anniversaryWithSuffix} Anniversary, {$member->member_name}. Response: " . json_encode($response));
                $errorMessage = isset($response->error) ? $response->error : 'Unknown error';
                \Log::error("Error: {$errorMessage}");
            }
        }
    
        return 'Anniversary SMS sent!';
    }
    
    

 

    // Helper function to get ordinal suffix
    private function getOrdinalSuffix($number)
    {
        $suffix = ['th', 'st', 'nd', 'rd'];
        $lastDigit = $number % 10;
        $lastTwoDigits = $number % 100;

        if ($lastTwoDigits >= 11 && $lastTwoDigits <= 13) {
            // Special case for numbers ending in 11, 12, or 13
            return $number . $suffix[0];
        }

        // Return the correct suffix based on the last digit
        return $number . ($suffix[$lastDigit] ?? $suffix[0]);
    }



    public function showMainMembers()
    {
        $members = Member::where('relationship_to_main_person', 'Main member')->get();
        return view('AdminDashboard.messages.message', compact('members'));
    }
    


    public function sendGroupSMS(Request $request)
    {
        $selectedMembers = $request->input('member_ids');
        $message = $request->input('message');

        if (empty($selectedMembers)) {
            return back()->with('error', 'Please select at least one member.');
        }

        $members = Member::whereIn('id', $selectedMembers)->get();

        foreach ($members as $member) {
            $phoneNumber = $member->contact_info;
            if (substr($phoneNumber, 0, 2) !== '94') {
                $phoneNumber = '94' . ltrim($phoneNumber, '0');
            }

            $response = $this->notifyLkService->sendSMS($phoneNumber, $message);

            $status = ($response && isset($response->status) && $response->status == 'success') ? 'success' : 'failed';
            MessageSent::create([
                'member_id' => $member->id,
                'message' => $message,
                'status' => $status,
                'sent_at' => now(),
            ]);

            if ($status == 'success') {
                \Log::info("Message sent to {$phoneNumber} for {$member->member_name}");
            } else {
                \Log::error("Failed to send SMS to {$phoneNumber}. Response: " . json_encode($response));
            }
        }

        return back()->with('success', 'Messages sent successfully!');
    }


    public function viewSentMessages()
    {
        $messages = MessageSent::with('member')->orderBy('sent_at', 'desc')->paginate(10);
        return view('AdminDashboard.messages.message_list', compact('messages'));
    }
    

    
}
