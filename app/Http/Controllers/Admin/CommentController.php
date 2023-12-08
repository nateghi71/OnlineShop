<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Models\Comment;
use App\Models\ProductRate;
use Illuminate\Http\Request;

class CommentController extends Controller
{

    public function index()
    {
        $comments = Comment::paginate(10);
        return view('admin.comments.index' ,compact('comments'));
    }

    public function show(Comment $comment)
    {
        return view('admin.comments.show' ,compact('comment'));
    }

    public function destroy(Comment $comment)
    {
        $comment->delete();
        return back();
    }

    public function changeApprove(Comment $comment)
    {
        if ($comment->getRawOriginal('approved')) {
            $comment->update([
                'approved' => 0
            ]);
        } else {
            $comment->update([
                'approved' => 1
            ]);
        }

        return back();
    }
}
