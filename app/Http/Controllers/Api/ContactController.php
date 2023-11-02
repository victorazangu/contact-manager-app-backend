<?php

namespace App\Http\Controllers\Api;

use App\Http\Controllers\Controller;
use App\Models\Contact;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;

class ContactController extends Controller
{
    public function __construct()
    {
        $this->middleware('auth:api');
    }
    /**
     * Display a listing of the resource.
     */
    public function index()
    {
        $contacts = Contact::with('groups', 'user')->get();
        if (!$contacts) {
            abort(404, 'No contacts found.');
        }

        return response()->json($contacts);
    }

    /**
     * Store a newly created resource in storage.
     */
    public function store(Request $request)
    {
        $validatedData = $request->validate([
            'name' => 'required',
            'contact' => 'required',

        ]);
        $user = Auth::user();
        if ($request->hasFile('image')) {
            $image = $request->file('image');
            $imagePath = $image->store('contacts', 'public');
            $validatedData['image'] = $imagePath;
        }
        $contact = $user->contacts()->create($validatedData);

        return response()->json([
            "message" => "Contact created successfully",
            "data" => $contact
        ], 201);
    }

    /**
     * Display the specified resource.
     */
    public function show($id)
    {
        $contact = Contact::find($id);

        if (!$contact) {
            return response()->json([
                "message" => "The contact with the ID of " . $id . " could not be found."
            ], 404);
        }

        return response()->json($contact);
    }


    /**
     * Update the specified resource in storage.
     */
    public function update(Request $request, Contact $contact)
    {
        $request->validate([
            'name' => 'required',
            'contact' => 'required',
        ]);

        if (Auth::user()->id !== $contact->user_id) {
            return response()->json(['error' => 'Unauthorized'], 401);
        }

        try {
            $contact = Contact::find($contact->id);

            if (!$contact) {
                return response()->json(['message' => 'The contact with the ID of ' . $contact->id . ' could not be found.'], 404);
            }

            $contact->update($request->all());
            return response()->json($contact, 200);
        } catch (\Exception $e) {
            return response()->json(['error' => $e->getMessage()], 400);
        }
    }

    /**
     * Remove the specified resource from storage.
     */
    public function destroy($id)
    {

        $contact = Contact::find($id);

        if (!$contact) {
            return response()->json([
                "message" => "The contact with the ID of " . $id . " could not be found."
            ], 404);
        }
        $contact->delete();
        return response()->json(null, 204);
    }
}
