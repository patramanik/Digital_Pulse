<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class SubjectModel extends Model
{
    protected $table = 'subject';

    // Fields that can be mass-assigned
    protected $fillable = [
        'subject_name',
        'entry_ts',
        'entry_id',
    ];
}
