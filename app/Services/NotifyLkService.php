<?php

namespace App\Services;

use NotifyLk\Api\SmsApi;

class NotifyLkService
{
    protected $userId;
    protected $apiKey;
    protected $senderId;

    public function __construct()
    {
        $this->userId = env('NOTIFYLK_USER_ID');
        $this->apiKey = env('NOTIFYLK_API_KEY');
        $this->senderId = env('NOTIFYLK_SENDER_ID', 'ChurchDemo');
    }


    public function sendSMS($phoneNumber, $message)
    {
        // Get values from .env file
        $userId = env('NOTIFYLK_USER_ID');
        $apiKey = env('NOTIFYLK_API_KEY');
        $senderId = env('NOTIFYLK_SENDER_ID', 'NotifyDEMO');
    
        // Construct the URL with all required parameters
        $url = "https://app.notify.lk/api/v1/send?user_id={$userId}&api_key={$apiKey}&sender_id={$senderId}&to={$phoneNumber}&message=" . urlencode($message);
    
        // Send the request using cURL
        $ch = curl_init();
        curl_setopt($ch, CURLOPT_URL, $url);
        curl_setopt($ch, CURLOPT_RETURNTRANSFER, true);
        $response = curl_exec($ch);
        curl_close($ch);
    
        // Return the response
        $result = json_decode($response, true);

    // Log the result for debugging
    \Log::info('Notify.lk SMS Response', $result);

    return $result;
    }
    
}

