<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class ApplicantsModel extends Model
{
    use HasFactory;

    protected $table = 'applicants';

    protected $fillable = [
        'application_id',
        'application_status',
        'first_name',
        'last_name',
        'email',
        'contact',
        'selected_position_id',
        'selected_position',
        'subject',
        'mssg',
        'gdrive_folderlink',
        'cv_drive_name',
        'interview_date',
    ];

    protected $casts = [
        'interview_date' => 'datetime',
    ];
}

