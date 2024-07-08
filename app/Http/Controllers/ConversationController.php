<?php

namespace App\Http\Controllers;

use App\Models\Conversation;
use App\Models\User;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;

class ConversationController extends Controller
{
    /**
     * Display a listing of the resource.
     */
    public function index()
    {
        $user = Auth::user();
        return $user->conversations; // Assuming you have a relationship defined in the User model
    }

    /**
     * Store a newly created resource in storage.
     */
    public function store(Request $request)
    {
        $request->validate([
            'name' => 'nullable|string|max:255',
            'type' => 'required|in:private,group',
            'created_by' => 'required|exists:users,id',
            'participants' => 'required|array|min:2',
            'participants.*' => 'exists:users,id',
        ]);

        if ($request->type == 'private' && count($request->participants) != 2) {
            return response()->json(['error' => 'Private conversation must have exactly 2 participants.'], 422);
        }

        $conversation = Conversation::create([
            'name' => $request->name,
            'type' => $request->type,
            'created_by' => $request->created_by,
        ]);

        $conversation->participants()->attach($request->participants);

        return response()->json($conversation, 201);
    }

    /**
     * Display the specified resource.
     */
    public function show(Conversation $conversation)
    {
        return response()->json($conversation);
    }

    /**
     * Update the specified resource in storage.
     */
    public function update(Request $request, Conversation $conversation)
    {
        $request->validate([
            'name' => 'nullable|string|max:255',
            'type' => 'required|in:private,group',
            'created_by' => 'required|exists:users,id',
        ]);

        $conversation->update($request->all());

        return response()->json($conversation);
    }

    /**
     * Remove the specified resource from storage.
     */
    public function destroy(Conversation $conversation)
    {
        $conversation->delete();

        return response()->json(null, 204);
    }
}
