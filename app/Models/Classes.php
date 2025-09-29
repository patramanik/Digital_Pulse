<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class Classes extends Model
{
    protected $table = 'class'; // Explicitly set table name

    // Mass assignable fields
    protected $fillable = [
        'class_name',
        'entry_id',
        'entry_ts'
    ];

    // Optional: define relationship with ClassSubjectModel
    public function subjects()
    {
        return $this->belongsToMany(
         SubjectModel::class,
            'class_subject',
            'class_id',
            'subject_id'
        );
    }
}
