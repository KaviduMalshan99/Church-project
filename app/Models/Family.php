<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Factories\HasFactory;

class Family extends Model
{
    use HasFactory;

    // Fillable fields for mass assignment
    protected $fillable = [
        'main_person_id',
        'family_number',
        'family_name',
    ];

    /**
     * Relationship with Member model
     * A Family has many Members.
     */
    public function members()
    {
        return $this->hasMany(Member::class, 'family_id');
    }

    /**
     * Relationship with Member model for the main person
     * A Family belongs to one main person.
     */
    public function mainPerson()
    {
        return $this->belongsTo(Member::class, 'main_person_id');
    }
}
