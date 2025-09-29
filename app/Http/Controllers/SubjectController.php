<?php

namespace App\Http\Controllers;

use App\Http\Controllers\Controller;
use App\Models\Classes;
use App\Models\ClassSubjectModel;
use App\Models\SubjectModel;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;

class SubjectController extends Controller
{
    public function index()
    {
        $subjects = SubjectModel::orderBy('id', 'desc')->get();
        return view('admin.subjects.index', compact('subjects'));
    }

    // Show create form
    // public function create()
    // {
    //     return view('subjects.create');
    // }

    // Store new subject
    public function store(Request $request)
    {
        $request->validate([
            'subject_name' => 'required|string|max:255',
        ]);

        $subject = SubjectModel::create([
            'subject_name' => $request->subject_name,
            'entry_ts' => now(),
            'entry_id' => Auth::id() ?? null,
        ]);

        // Return JSON response for AJAX
        return response()->json([
            'success' => true,
            'subject' => $subject,
            'message' => 'Subject created successfully!',
        ]);
    }

    public function ClassSubjView()
    {
        $classSubjects = ClassSubjectModel::with('class', 'subject')->get();
        $classes = Classes::all();
        $subjects = SubjectModel::all();
        return view('admin.subjects.class_subject', compact('classSubjects', 'classes', 'subjects'));
    }

    public function ClassSubjStore(Request $request)
    {
        $request->validate([
            'class_id' => 'required|exists:class,id',
            'subject_id' => 'required|exists:subject,id',
        ]);

        $entry = ClassSubjectModel::create([
            'class_id' => $request->class_id,
            'subject_id' => $request->subject_id,
        ]);

        return response()->json([
            'success' => true,
            'message' => 'Subject assigned to class successfully!',
            'entry' => $entry->load('class', 'subject')
        ]);
    }
    public function filter(Request $request)
    {
        $query = ClassSubjectModel::query()->with(['class', 'subject']);

        if ($request->class_id) {
            $query->where('class_id', $request->class_id);
        }
        if ($request->subject_id) {
            $query->where('subject_id', $request->subject_id);
        }

        $entries = $query->get();

        return response()->json(['entries' => $entries]);
    }
}
