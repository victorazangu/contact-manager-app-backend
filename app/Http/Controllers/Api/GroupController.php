<?php

namespace App\Http\Controllers\Api;

use App\Http\Controllers\Controller;
use App\Models\Contact;
use App\Models\Groups;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;

class GroupController extends Controller
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
        $groups = Groups::with('contacts', 'user')->get();
        if (!$groups) {
            abort(404, 'No groups found.');
        }
        return response()->json($groups);
    }

    /**
     * Store a newly created resource in storage.
     */
    public function store(Request $request)
    {
        $validatedData = $request->validate([
            'name' => 'required',
        ]);
        $user = Auth::user();
        $group = $user->groups()->create($validatedData);

        return response()->json([
            "message" => "Group created successfully",
            "data" => $group
        ], 201);
    }

    /**
     * Display the specified resource.
     */
    public function show($id)
    {
        if (Auth::check()) {
            $user = Auth::user();
            $group = $user->groups()->with('contacts')->find($id);

            if (!$group) {
                return response()->json([
                    "message" => "The group with the ID of " . $id . " could not be found for the authenticated user."
                ], 404);
            }
            return response()->json($group);
        } else {
            return response()->json([
                "message" => "You must be authenticated to access this resource."
            ], 401);
        }
    }

    /**
     * Update the specified resource in storage.
     */
    public function update(Request $request, Groups $group)
    {
        $request->validate([
            'name' => 'required',
        ]);

        if (Auth::user()->id !== $group->user_id) {
            return response()->json(['error' => 'Unauthorized'], 401);
        }


        $group = Group::find($group->id);

        if (!$group) {
            return response()->json(['message' => 'The group with the ID of ' . $group->id . ' could not be found.'], 404);
        }

        $group->update($request->all());
        return response()->json($group, 200);
    }

    /**
     * Remove the specified resource from storage.
     */
    public function destroy($id)
    {
        $group = Groups::find($id);
        if (!$group) {
            return response()->json([
                "message" => "The group with the ID of " . $id . " could not be found."
            ], 404);
        }

        if (Auth::user()->id !== $group->user_id) {
            return response()->json(['error' => 'Unauthorized'], 401);
        }

        $group->delete();
        return response()->json(null, 204);
    }


    public function addContact(Request $request, $groupId, $contactId)
    {
        $group = Auth::user()->groups()->find($groupId);

        if (!$group) {
            return response()->json(['message' => 'The group with the ID of ' . $groupId . ' could not be found for the authenticated user.'], 404);
        }

        $contact = Contact::find($contactId);

        if (!$contact) {
            return response()->json(['message' => 'The contact with the ID of ' . $contactId . ' could not be found.'], 404);
        }
        if (!$group->contacts->contains($contactId)) {
            $group->contacts()->attach($contactId);
            return response()->json(['message' => 'Contact added to the group successfully'], 201);
        }

        return response()->json(['message' => 'Contact is already in the group'], 200);
    }

    /**
     * Remove a contact from the group.
     */
    public function removeContact(Request $request, $groupId, $contactId)
    {
        $group = Auth::user()->groups()->find($groupId);

        if (!$group) {
            return response()->json(['message' => 'The group with the ID of ' . $groupId . ' could not be found for the authenticated user.'], 404);
        }

        $contact = Contact::find($contactId);

        if (!$contact) {
            return response()->json(['message' => 'The contact with the ID of ' . $contactId . ' could not be found.'], 404);
        }
        if ($group->contacts->contains($contactId)) {
            $group->contacts()->detach($contactId);
            return response()->json(['message' => 'Contact removed from the group successfully'], 200);
        }

        return response()->json(['message' => 'Contact is not in the group'], 200);
    }
}
