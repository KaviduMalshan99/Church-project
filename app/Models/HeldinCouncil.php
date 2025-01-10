<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Factories\HasFactory;

class HeldinCouncil extends Model
{
    use HasFactory;
    
    protected $table = 'held_in_council';
    
    protected $fillable = ['name'];
}
