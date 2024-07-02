<?php

namespace App\Http\Controllers;

use App\Models\friendship;
use Illuminate\Http\Request;

class FriendshipController extends Controller{
    public function sendRequest(Request $request)
    {
        $friendship = Friendship::create([
            'user_id' => auth()->id(),
            'friend_id' => $request->friend_id,
            'status' => 'pending',
        ]);

        return response()->json($friendship, 201);
    }

    public function acceptRequest($id)
    {
        $friendship = Friendship::where('id', $id)
                                ->where('friend_id', auth()->id())
                                ->firstOrFail();
        $friendship->update(['status' => 'accepted']);
        return response()->json($friendship);
    }

    public function declineRequest($id)
    {
        $friendship = Friendship::where('id', $id)
                                ->where('friend_id', auth()->id())
                                ->firstOrFail();
        $friendship->update(['status' => 'declined']);
        return response()->json($friendship);
    }

    public function removeFriend($id)
    {
        $friendship = Friendship::where(function ($query) use ($id) {
                                    $query->where('user_id', auth()->id())
                                          ->where('friend_id', $id);
                                })->orWhere(function ($query) use ($id) {
                                    $query->where('user_id', $id)
                                          ->where('friend_id', auth()->id());
                                })->firstOrFail();

        $friendship->delete();
        return response()->json(null, 204);
    }

    public function friends()
    {
        $friends = auth()->user()->friends;
        return response()->json($friends);
    }

    public function friendRequests()
    {
        $friendRequests = auth()->user()->friendRequests;
        return response()->json($friendRequests);
    }
}
