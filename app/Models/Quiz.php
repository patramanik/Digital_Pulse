<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class Quiz extends Model
{
    protected $table = 'quiz';

    // Mass assignable fields
    protected $fillable = [
        'question',
        'options',
        'corr_ans',
        'expl',
        'class_subject_id',
        'level',
        'entry_id',
        'entry_ts',
    ];

    // Cast 'options' JSON to array automatically
    protected $casts = [
        'options' => 'array',
        'entry_ts' => 'datetime',
    ];

    /**
     * Relationship: Quiz belongs to a class_subject
     */
    public function classSubject()
    {
        return $this->belongsTo(ClassSubjectModel::class, 'class_subject_id');
    }

    /**
     * Convenience relationships to directly access class and subject
     */
    public function class()
    {
        return $this->classSubject()->with('class');
    }

    public function subject()
    {
        return $this->classSubject()->with('subject');
    }
    public function getFormattedOptionsAttribute()
    {
        return collect($this->options)->map(function ($option) {
            return $option['id'] . ': ' . $option['text'];
        })->toArray();
    }
}
