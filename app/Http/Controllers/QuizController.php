<?php

namespace App\Http\Controllers;

use App\Models\Classes;
use App\Models\ClassSubjectModel;
use App\Models\Quiz;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;

class QuizController extends Controller
{
    //

    public function QuizFormView()
    {
        // Fetch all class-subject mappings with related class & subject
        $classes = Classes::all();

        return view('admin.Quiz.quiz', compact('classes'));
    }
    public function getSubjectsByClass($classId)
    {
        $subjects = ClassSubjectModel::with('subject')
            ->where('class_id', $classId)
            ->get()
            ->pluck('subject')
            ->map(function ($subject) {
                return [
                    'id' => $subject->id,
                    'subject_name' => $subject->subject_name,
                ];
            });

        return response()->json($subjects);
    }



    public function QuizFormStore(Request $request)
    {
        $request->validate([
            'class_id'       => 'required|exists:class,id',
            'subject_id'     => 'required|exists:subject,id',
            'question'       => 'required|string',
            'options'        => 'required|array|min:2',
            'correct_answer' => 'required|integer',
            'level'          => 'required|in:easy,medium,hard',
        ]);

        // Get or create class_subject_id
        $classSubject = ClassSubjectModel::firstOrCreate([
            'class_id'   => $request->class_id,
            'subject_id' => $request->subject_id,
        ]);

        // Transform plain options into objects with ID
        $options = collect($request->options)->map(function ($option, $index) {
            return [
                'id'   => $index + 1,
                'text' => $option,
            ];
        })->toArray();

        // Save quiz
        $quiz = Quiz::create([
            'class_subject_id' => $classSubject->id,
            'question'         => $request->question,
            'options'          => $options, // ✅ use transformed options
            'corr_ans'         => $request->correct_answer,
            'expl'             => $request->explanation,
            'level'            => $request->level,
            'entry_id'         => Auth::id(),
            'entry_ts'         => now(),
        ]);

        return response()->json([
            'success' => true,
            'message' => 'Question submitted successfully!',
            'quiz_id' => $quiz->id,
        ]);
    }
    public function FetchallQuiz()
    {
        $quizzes = Quiz::with(['classSubject.class', 'classSubject.subject'])->get();

        return view('admin.Quiz.quizlist', compact('quizzes'));
    }
}
