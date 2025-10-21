<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Test extends Model
{
    use HasFactory;

    protected $table = 'tests';

    protected $fillable = [
        'title',
        'class_id',
        'subject_id',
        'quiz_ids',
        'status',
        'scheduled_at',
    ];

    protected $casts = [
        'quiz_ids' => 'array',
        'scheduled_at' => 'datetime',
    ];

    // Relationships
    public function class()
    {
        return $this->belongsTo(ClassModel::class, 'class_id');
    }

    public function subject()
    {
        return $this->belongsTo(SubjectModel::class, 'subject_id');
    }

    public function quizzes()
    {
        return Quiz::whereIn('id', $this->quiz_ids)->get();
    }
}
