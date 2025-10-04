<?php

namespace App\Http\Controllers;

use App\Http\Controllers\Controller;
use App\Models\Classes;
use App\Models\ClassSubjectModel;
use App\Models\Quiz;
use Illuminate\Http\Request;

class TestController extends Controller
{
    public function TestCreate()
    {
        $classes = Classes::all();
        return view('admin.Test.test_create', compact('classes'));
    }

    public function getSubjectsByClass($classId)
    {
        $subjects = ClassSubjectModel::with('subject')
            ->where('class_id', $classId)
            ->get()
            ->map(function ($row) {
                return [
                    'id' => $row->subject->id,
                    'subject_name' => $row->subject->subject_name,
                ];
            });

        return response()->json($subjects);
    }


   public function getQuizzesByClass(Request $request)
    {
        $request->validate([
            'class_id' => 'required|exists:class,id',
            'subject_id' => 'required|exists:subject,id',
        ]);

        $quizzes = Quiz::with(['classSubject.class', 'classSubject.subject'])
            ->whereHas('classSubject', function ($q) use ($request) {
                $q->where('class_id', $request->class_id)
                  ->where('subject_id', $request->subject_id);
            })
            ->get()
            ->map(function($quiz) {
                return [
                    'id' => $quiz->id,
                    'question' => $quiz->question,
                    'formatted_options' => $quiz->formatted_options, // make sure Quiz model has formatted_options attribute
                    'corr_ans' => $quiz->corr_ans,
                    'expl' => $quiz->expl,
                    'level' => $quiz->level,
                    'class_subject' => [
                        'class' => $quiz->classSubject->class,
                        'subject' => $quiz->classSubject->subject
                    ]
                ];
            });

        return response()->json($quizzes);
    }
}
