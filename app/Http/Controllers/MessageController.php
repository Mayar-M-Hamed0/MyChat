<?php

namespace App\Http\Controllers;

use App\Models\Message;
use App\Models\Conversation;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;

class MessageController extends Controller
{
    /**
     * Display a listing of the resource.
     */
    public function index($conversation_id)
    {
        $user = Auth::user();
        $conversation = $user->conversations()->findOrFail($conversation_id);
        return $conversation->messages()->paginate();
    }

    /**
     * Store a newly created resource in storage.
     */
    public function store(Request $request)
    {
        $request->validate([
            'conversation_id' => 'required|exists:conversations,id',
            'user_id' => 'nullable|exists:users,id',
            'message' => 'required|string',
            'file_path' => 'nullable|string',
            'type' => 'required|in:text,attachment',
        ]);

        $message = Message::create($request->all());

        return response()->json($message, 201);
    }

    /**
     * Display the specified resource.
     */
    public function show($id)
    {
        $message = Message::findOrFail($id);
        return response()->json($message);
    }

    /**
     * Update the specified resource in storage.
     */
    public function update(Request $request, $id)
    {
        $message = Message::findOrFail($id);

        $request->validate([
            'conversation_id' => 'required|exists:conversations,id',
            'user_id' => 'nullable|exists:users,id',
            'message' => 'required|string',
            'file_path' => 'nullable|string',
            'type' => 'required|in:text,attachment',
        ]);

        $message->update($request->all());

        return response()->json($message);
    }

    /**
     * Remove the specified resource from storage.
     */
    public function destroy($id)
    {
        $message = Message::findOrFail($id);
        $message->delete();

        return response()->json(null, 204);
    }
}
