<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Factories\HasFactory;

class Gift extends Model
{
    use HasFactory;

    protected $fillable = [
        'gift_code',
        'sender_id',
        'receiver_id',
        'receiver_address',
        'greeting_title',
        'greeting_description',
        'gift_status',
    ];
}
