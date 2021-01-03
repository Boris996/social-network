<?php

namespace App\Http\Controllers;

use App\Helpers\Utils;
use App\Models\Post;
use App\Models\User;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;

class PostsController extends Controller
{

    /**
     * Creates new post
     * @param Request $request
     * @return \Illuminate\Http\JsonResponse
     */
    public function post(Request $request) {
        $userid = $request->get('user');
        $user = User::find($userid);
        $authId = Auth::id();

        if(!Auth::user()->isFriend($user)) {
            Utils::returnUnauthorizedResponse();
        }

        $post = new Post();
        $post->sender_id = $authId;
        $post->receiver_id = $user->id;
        $post->value = $request->get('value');
        $post->save();
        return response()->json(['success' => true]);
    }
}
