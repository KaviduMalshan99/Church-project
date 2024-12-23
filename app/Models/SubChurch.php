<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Factories\HasFactory;

class SubChurch extends Model
{
    use HasFactory;

    protected $fillable = ['parent_church_id', 'church_name', 'location', 'contact_info'];

    public function church()
    {
        
        return $this->belongsTo(Church::class, 'parent_church_id');
    }
}
