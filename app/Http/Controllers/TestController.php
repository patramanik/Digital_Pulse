<?php

namespace App\Http\Controllers;

use App\Http\Controllers\Controller;
use App\Models\Classes;
use App\Models\ClassSubjectModel;
use App\Models\Quiz;
use App\Models\Test;
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
            ->map(function ($quiz) {
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

    public function scheduleTest(Request $request)
    {
        $quizIds = $request->input('quiz_ids', []);
        $classId = $request->input('class_id');
        $subjectId = $request->input('subject_id');
        $title = $request->input('title');

        if (empty($quizIds)) {
            return response()->json(['message' => 'No quizzes selected'], 400);
        }

        if (empty($title)) {
            return response()->json(['message' => 'Title is required'], 400);
        }

        $test = Test::create([
            'title'        => $title,
            'class_id'     => $classId,
            'subject_id'   => $subjectId,
            'quiz_ids'     => $quizIds,
            'status'       => 'draft',
            'scheduled_at' => now(),
        ]);

        return response()->json([
            'success' => 'Test set created successfully!',
            'test_id' => $test->id,
        ]);
    }
   public function getTestQuizzes(Request $request)
    {
        $request->validate([
            'class_id' => 'required|integer|exists:class,id',
            'subject_id' => 'required|integer|exists:subject,id',
        ]);

        $classId = $request->class_id;
        $subjectId = $request->subject_id;

        // ✅ Fetch test sets for this class & subject
        $tests = Test::where('class_id', $classId)
            ->where('subject_id', $subjectId)
            ->get();

        if ($tests->isEmpty()) {
            return response()->json(['message' => 'No tests found for this class and subject.'], 404);
        }

        // ✅ Combine all quiz IDs from all tests
        $quizIds = $tests->pluck('quiz_ids')
            ->flatten() // merge nested arrays
            ->unique()
            ->toArray();

        // ✅ Fetch quiz details
        $quizzes = Quiz::whereIn('id', $quizIds)
            ->with(['classSubject.class', 'classSubject.subject'])
            ->get()
            ->map(function ($quiz) {
                return [
                    'id' => $quiz->id,
                    'question' => $quiz->question,
                    'level' => $quiz->level,
                    'corr_ans' => $quiz->corr_ans,
                    'expl' => $quiz->expl,
                    // 'formatted_options' => json_decode($quiz->options, true),
                    'formatted_options' => is_array($quiz->options)
    ? $quiz->options
    : json_decode($quiz->options, true),

                    'class_subject' => [
                        'class' => ['class_name' => $quiz->classSubject->class->class_name],
                        'subject' => ['subject_name' => $quiz->classSubject->subject->subject_name],
                    ],
                ];
            });

        return response()->json([
            'tests' => $tests->map(fn($test) => [
                'id' => $test->id,
                'title' => $test->title,
                'scheduled_at' => $test->scheduled_at,
            ]),
            'quizzes' => $quizzes,
        ]);
    }
}
