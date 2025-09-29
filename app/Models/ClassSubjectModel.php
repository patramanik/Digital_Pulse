<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class ClassSubjectModel extends Model
{
    protected $table = 'class_subject';
    protected $fillable = ['class_id', 'subject_id'];

    public function class()
    {
        return $this->belongsTo(Classes::class, 'class_id'); // Assuming you have Classes model
    }

    public function subject()
    {
        return $this->belongsTo(SubjectModel::class, 'subject_id'); // Assuming you have SubjectModel
    }
}
