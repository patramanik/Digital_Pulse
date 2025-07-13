<?php

namespace App\Http\Controllers;

use App\Models\work;
use Illuminate\Http\Request;

class WorkController extends Controller
{
    public function index()
    {
        $works = work::all();
        return response()->json($works);
    }

    public function store(Request $request)
    {
        $validated = $request->validate([
            'work_title' => 'required|string|max:255',
            'work_desc' => 'required|string',
        ]);

        $work = work::create($validated);
        return response()->json($work, 201);
    }

    public function show($id)
    {
        $work = work::findOrFail($id);
        return response()->json($work);
    }

    public function update(Request $request, $id)
    {
        $validated = $request->validate([
            'work_title' => 'sometimes|required|string|max:255',
            'work_desc' => 'sometimes|required|string',
        ]);

        $work = work::findOrFail($id);
        $work->update($validated);

        return response()->json($work);
    }

    public function destroy($id)
    {
        $work = work::findOrFail($id);
        $work->delete();

        return response()->json(['message' => 'Work deleted successfully']);
    }
}
