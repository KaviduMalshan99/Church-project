<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Factories\HasFactory;

class Member extends Model
{
    use HasFactory;

    // Fillable fields for mass assignment
    protected $fillable = [
        'family_no',
        'member_id',
        'member_name',
        'name_with_initials',
        'address',
        'birth_date',
        'gender',
        'relationship_to_main_person',
        'occupation',
        'baptized',
        'full_member',
        'half_member',
        'associate_member',
        'methodist_member',
        'sabbath_member',
        'nikaya',
        'religion',
        'contact_info',
        'email',
        'image',
        'held_office_in_council',
        'registered_date',
        'optional_notes',
        'interests',
        'professional_quali',
        'church_congregation',
        'nic',
        'civil_status',
        'baptized_date',
        'academic_quali',
        'member_title',
        'married_date',
        'member_status',
        'date_of_death',
        'area'
    ];

    /**
     * Relationship with Family model
     * A Member belongs to a Family.
     */
    public function family()
    {
        return $this->belongsTo(Family::class, 'family_no',);
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
        return $this->belongsTo(Member::class, 'main_person_id');
    }

    // Get the other family members associated with this member
    public function otherFamilyMembers()
    {
        return $this->hasMany(Member::class, 'main_person_id');
    }

    public function familyByNumber()
    {
        return $this->belongsTo(Family::class, 'family_no', 'family_number');
    }


}
