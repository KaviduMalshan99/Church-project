<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Factories\HasFactory;

class Group extends Model
{
    use HasFactory;
    protected $fillable = [
        'group_name',
        'group_members',
    ];

    public function members()
    {
        return $this->belongsToMany(Member::class, 'group_member', 'group_id', 'member_id');
    }

    protected $casts = [
        'group_members' => 'array',
    ];
    
}
