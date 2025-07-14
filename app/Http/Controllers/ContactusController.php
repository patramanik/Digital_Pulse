<?php

namespace App\Http\Controllers;

use App\Models\contactus;
use Illuminate\Http\Request;
use Illuminate\Validation\ValidationException;

class ContactusController extends Controller
{
    public function index()
    {
        // List all contact us entries
        // $contacts = Contactus::all();
        return response()->json(Contactus::all());
    }

    public function store(Request $request)
    {
        // Create a new contact us entry
        try {
            $validated = $request->validate([
                'full_name' => 'required|string|max:255',
                'email' => 'required|email|max:255',
                'message' => 'required|string',
            ]);

            $contact = contactus::create($validated);
            return response()->json([
                'message' => 'Contact submitted successfully.',
                'contact' => $contact
            ], 201);
        } catch (ValidationException $e) {
            return response()->json([
                'message' => $e->getMessage(),
                'errors' => $e->errors()
            ], 422);
        }
    }

    public function show($id)
    {
        // Show a specific contact us entry
        $contact = Contactus::findOrFail($id);
        return response()->json($contact);
    }

    public function update(Request $request, $id)
    {
        // Update a contact us entry
        $contact = Contactus::findOrFail($id);
        $validated = $request->validate([
            'name' => 'sometimes|required|string|max:255',
            'email' => 'sometimes|required|email|max:255',
            'message' => 'sometimes|required|string',
        ]);
        $contact->update($validated);
        return response()->json($contact);
    }

    public function destroy($id)
    {
        // Delete a contact us entry
        $contact = Contactus::findOrFail($id);
        $contact->delete();
        return response()->json(null, 204);
    }
}
