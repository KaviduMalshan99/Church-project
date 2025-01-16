<?php

namespace App\Models;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class AcademicQualification extends Model
{
    use HasFactory;
    protected $table = 'academic_qualifications';

    protected $fillable = [
        'name',
    ];
}
