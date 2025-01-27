<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Factories\HasFactory;

class SystemUser extends Model
{
    use HasFactory;
    protected $table = 'system_users';

    protected $fillable = [
        'name', 'email', 'contact', 'password', 'image','role','signature',
    ];
}
