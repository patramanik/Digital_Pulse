<?php

namespace App\Http\Controllers;

use App\Models\services;
use Illuminate\Http\Request;

class ServicesController extends Controller
{
    /**
     * Display the services page with data.
     */
    public function index()
    {
        $services = services::latest()->get();;
        return view('admin.services.services', compact('services'));
    }

    /**
     * Store a new service.
     */
    public function store(Request $request)
    {
        $validated = $request->validate([
            'service_title' => 'required|string|max:255',
            'service_desc'  => 'required|string',
        ]);

        $service = services::create($validated);

        return response()->json([
            'success' => true,
            'message' => 'Service added successfully!',
            'data' => $service
        ], 201);
    }

    /**
     * Return service data for editing.
     */
    public function show($id)
    {
        $service = services::find($id);

        if (!$service) {
            return response()->json([
                'success' => false,
                'message' => 'Service not found!'
            ], 404);
        }

        return response()->json([
            'success' => true,
            'data' => $service
        ]);
    }

    /**
     * Update a service.
     */
    public function update(Request $request, $id)
    {
        $validated = $request->validate([
            'service_title' => 'required|string|max:255',
            'service_desc'  => 'required|string',
        ]);

        $service = services::find($id);

        if (!$service) {
            return response()->json([
                'success' => false,
                'message' => 'Service not found!'
            ], 404);
        }

        $service->update($validated);

        return response()->json([
            'success' => true,
            'message' => 'Service updated successfully!',
            'data' => $service
        ]);
    }

    /**
     * Delete a service.
     */
    public function destroy($id)
    {
        $service = services::find($id);

        if (!$service) {
            return response()->json([
                'success' => false,
                'message' => 'Service not found!'
            ], 404);
        }

        $service->delete();

        return response()->json([
            'success' => true,
            'message' => 'Service deleted successfully!'
        ]);
    }
}
