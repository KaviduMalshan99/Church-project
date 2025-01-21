<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class MessageSent extends Model
{

    protected $table = 'messages_sent';

    protected $fillable = [
        'member_id',
        'message',
        'status',
        'sent_at',
    ];
    
    protected $casts = [
        'sent_at' => 'datetime',
    ];
  
    public function member()
    {
        return $this->belongsTo(Member::class);
    }
}
