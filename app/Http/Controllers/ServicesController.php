<?php

namespace App\Http\Controllers;

use App\Models\services;
use Illuminate\Http\Request;

class ServicesController extends Controller
{
    public function index()
    {
        // $services = services::all();
        return view('admin.services.services');
    }

    public function store(Request $request)
    {
        $validated = $request->validate([
            'service_title' => 'required|string|max:255',
            'service_desc' => 'required|string',
        ]);

        $service = services::create($validated);
        return response()->json($service, 201);
    }

    public function show($id)
    {
        $service = services::findOrFail($id);
        return response()->json($service);
    }

    public function update(Request $request, $id)
    {
        $validated = $request->validate([
            'service_title' => 'sometimes|required|string|max:255',
            'service_desc' => 'sometimes|required|string',
        ]);

        $service = services::findOrFail($id);
        $service->update($validated);

        return response()->json($service);
    }

    public function destroy($id)
    {
        $service = services::findOrFail($id);
        $service->delete();

        return response()->json(['message' => 'Service deleted successfully']);
    }
}
