<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Factories\HasFactory;

class Church extends Model
{
    use HasFactory;
    
    protected $fillable = ['church_name', 'location', 'contact_info'];

    public function subChurches()
    {
        return $this->hasMany(SubChurch::class, 'parent_church_id');
    }
}
