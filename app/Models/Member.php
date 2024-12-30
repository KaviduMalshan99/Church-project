<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Factories\HasFactory;

class Member extends Model
{
    use HasFactory;

    // Fillable fields for mass assignment
    protected $fillable = [
        'family_id',
        'main_member_id',
        'church_id',
        'member_name',
        'birth_date',
        'gender',
        'relationship_to_main_person',
        'occupation',
        'baptized',
        'full_member',
        'methodist_member',
        'sabbath_member',
        'nikaya',
        'religion_if_not_catholic',
        'contact_info',
        'email',
        'image',
        'held_office_in_council',
    ];

    /**
     * Relationship with Family model
     * A Member belongs to a Family.
     */
    public function family()
    {
        return $this->belongsTo(Family::class, 'family_id');
    }

    /**
     * Relationship with Church model
     * A Member belongs to a Church.
     */
    public function church()
    {
        return $this->belongsTo(Church::class, 'church_id');
    }

    // Get the main family member for this member
    public function mainMember()
    {
        return $this->belongsTo(FamilyMember::class, 'main_member_id');
    }

    // Get the other family members associated with this member
    public function otherFamilyMembers()
    {
        return $this->hasMany(FamilyMember::class, 'main_member_id');
    }


}
