<?php

namespace App\Models;
use Illuminate\Database\Eloquent\Factories\HasFactory;

use Illuminate\Database\Eloquent\Model;

class ContributionType extends Model
{
    use HasFactory;
    protected $table = 'contribution_types';

    protected $fillable = [
        'name',
    ];
}
