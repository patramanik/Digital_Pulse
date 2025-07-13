<?php

namespace App\Http\Controllers;

use App\Models\career;
use Illuminate\Http\Request;

class CareerController extends Controller
{
    // Show all careers
    public function index()
    {
        $careers = Career::all();
        return view('admin.careers.index', compact('careers'));
    }

    // Show form to add new career
    public function create()
    {
        return view('admin.careers.create');
    }

    // Store new career
    public function store(Request $request)
    {
        $validated = $request->validate([
            'career_title' => 'required|string|max:255',
            'career_desc' => 'required|string|max:1000',
        ]);

        career::create($validated);

        return redirect()->route('admin.careers.list')
                         ->with('success', 'Career added successfully.');
    }

    // Show form to edit existing career
    public function edit($id)
    {
        $career = career::findOrFail($id);
        return view('admin.careers.edit', compact('career'));
    }

    // Update existing career
    public function update(Request $request, $id)
    {
        $validated = $request->validate([
            'career_title' => 'required|string|max:255',
            'career_desc' => 'required|string|max:1000',
        ]);

        $career = career::findOrFail($id);
        $career->update($validated);

        return redirect()->route('admin.careers.list')
                         ->with('success', 'Career updated successfully.');
    }

    // Delete existing career
    public function destroy($id)
    {
        $career = career::findOrFail($id);
        $career->delete();

        return redirect()->route('admin.careers.list')
                         ->with('success', 'Career deleted successfully.');
    }
}
