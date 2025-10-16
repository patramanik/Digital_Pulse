<?php

namespace App\Http\Controllers;

use App\Models\career;
use Illuminate\Http\Request;

class CareerController extends Controller
{
    // Show all careers
    public function index()
    {
        $careers = career::latest()->get();
        return view('admin.careers.careers', compact('careers'));
    }

    // Show form to add new career (optional for non-modal)
    public function create()
    {
        return view('admin.careers.create');
    }

    // Store new career via AJAX
    public function store(Request $request)
    {
        $validated = $request->validate([
            'career_title' => 'required|string|max:255',
            'career_desc' => 'required|string|max:1000',
        ]);

        $career = career::create($validated);

        return response()->json([
            'success' => true,
            'message' => 'Career added successfully!',
            'career' => $career
        ]);
    }

    // Return JSON data to edit modal
    public function edit($id)
    {
        $career = career::find($id);
        if ($career) {
            return response()->json(['success' => true, 'data' => $career]);
        }
        return response()->json(['success' => false, 'message' => 'Career not found.']);
    }

    // Update career via AJAX
    public function update(Request $request, $id)
    {
        $request->validate([
            'career_title' => 'required|string|max:255',
            'career_desc' => 'required|string'
        ]);

        $career = career::findOrFail($id);
        $career->career_title = $request->career_title;
        $career->career_desc = $request->career_desc;
        $career->save();

        return response()->json(['success' => true]);
    }

    // Delete existing career
    public function destroy($id)
    {
        $career = career::find($id);
        if ($career) {
            $career->delete();
            return response()->json(['success' => true, 'message' => 'Career deleted successfully!']);
        }

        return response()->json(['success' => false, 'message' => 'Career not found.']);
    }
}
