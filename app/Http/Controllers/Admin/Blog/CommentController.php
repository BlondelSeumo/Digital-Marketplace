<?php

namespace App\Http\Controllers\Admin\Blog;

use App\Http\Controllers\Controller;
use App\Models\BlogComment;
use Illuminate\Http\Request;

class CommentController extends Controller
{
    public function index()
    {
        $comments = BlogComment::query();
        if (request()->filled('article')) {
            $comments->where('blog_article_id', request()->input('article'));
        }
        $comments = $comments->orderbyDesc('id')->with('article')->get();
        return view('admin.blog.comments', ['comments' => $comments]);
    }

    public function viewComment(BlogComment $comment)
    {
        return response()->json([
            'success' => true,
            'comment' => $comment->body,
            'publish_link' => route('admin.blog.comments.update', $comment->id),
            'delete_link' => route('admin.blog.comments.destroy', $comment->id),
            'status' => $comment->status,
        ]);
    }

    public function updateComment(Request $request, BlogComment $comment)
    {
        $comment->update(['status' => true]);
        toastr()->success(translate('Published Successfully'));
        return back();
    }

    public function destroy(BlogComment $comment)
    {
        $comment->delete();
        toastr()->success(translate('Deleted Successfully'));
        return back();
    }
}
