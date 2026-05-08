<?php

namespace App\Models;

use App\Enum\ExperienceLevel;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Job extends Model
{
    use HasFactory;

    protected $casts = [
        'experiences' => ExperienceLevel::class,
    ];
}
