<?php

namespace App\Http\Controllers;

use App\Http\Requests\CommentRequest;
use App\Models\Comment;
use App\Models\Item;
use Illuminate\Support\Facades\Auth;

class CommentController extends Controller
{
    public function store(CommentRequest $request, $item_id)
    {
        $item = Item::findOrFail($item_id);

        // コメントを作成
        $comment = new Comment();
        $comment->user_id = Auth::id();
        $comment->item_id = $item->id;
        $comment->content = $request->input('content'); // 修正: 'content'を取得
        $comment->save();

        // コメントカウントの取得
        $commentsCount = Comment::where('item_id', $item->id)->count();

        // 作成したコメントのデータを取得
        $commentData = [
            'user_image' => asset('storage/' . $comment->user->profile_image),
            'user_name' => $comment->user->name,
            'content' => $comment->content,
            'created_at' => $comment->created_at->diffForHumans(),
        ];

        // JSON形式で応答を返す
        return response()->json([
            'success' => true,
            'comments_count' => $commentsCount,
            'comment' => $commentData,
        ]);
    }
}