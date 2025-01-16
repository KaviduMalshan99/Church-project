<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Factories\HasFactory;

class Gift extends Model
{
    use HasFactory;

    protected $fillable = [
        'sender_id',
        'type',
        'amount'
    ];

    public function member()
    {
        return $this->belongsTo(Member::class, 'sender_id', 'member_id');
    }
}
