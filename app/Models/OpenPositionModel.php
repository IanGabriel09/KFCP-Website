<?php

namespace App\Models;

use App\Models\OpenPositionModel;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class OpenPositionModel extends Model
{
    use HasFactory;

    protected $table = 'open_positions';

    protected $fillable = [
        'UID',
        'pos_name',
        'pos_quantity',
        'date_posted',
        'job_type',
        'job_description',
        'qualifications',
        'benefits',
    ];

    protected $casts = [
        'qualifications' => 'array',
        'benefits' => 'array',
    ];
}
