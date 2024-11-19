<?php

namespace App\Http\Controllers;

use App\Methods\ReCaptchaValidation;
use App\Models\BlogArticle;
use App\Models\BlogCategory;
use App\Models\BlogComment;
use Illuminate\Http\Request;
use Validator;

class BlogController extends Controller
{
    public function index()
    {
        $blogArticles = BlogArticle::query();
        if (request()->has('search')) {
            $searchTerm = '%' . request('search') . '%';
            $blogArticles->where('title', 'like', $searchTerm)
                ->OrWhere('slug', 'like', $searchTerm)
                ->OrWhere('body', 'like', $searchTerm)
                ->OrWhere('short_description', 'like', $searchTerm)
                ->orWhereHas('category', function ($query) use ($searchTerm) {
                    $query->where('name', 'like', $searchTerm);
                });
        }
        $blogArticles = $blogArticles->orderbyDesc('id')->paginate(12);
        $blogArticles->appends(request()->only(['search']));
        return theme_view('blog.index', ['blogArticles' => $blogArticles]);
    }

    public function category($slug)
    {
        $blogCategory = BlogCategory::where('slug', $slug)->firstOrFail();
        incrementViews($blogCategory, 'blog_categories');
        $blogArticles = BlogArticle::where('blog_category_id', $blogCategory->id)->orderbyDesc('id')->paginate(8);
        return theme_view('blog.category', ['blogCategory' => $blogCategory, 'blogArticles' => $blogArticles]);
    }

    public function article($slug)
    {
        $blogArticle = BlogArticle::where('slug', $slug)->firstOrFail();
        incrementViews($blogArticle, 'blog_articles');
        $blogArticleComments = BlogComment::where([['blog_article_id', $blogArticle->id], ['status', 1]])->get();
        return theme_view('blog.article', ['blogArticle' => $blogArticle, 'blogArticleComments' => $blogArticleComments]);
    }

    public function comment(Request $request, $slug)
    {
        $blogArticle = BlogArticle::where('slug', $slug)->firstOrFail();

        $validator = Validator::make($request->all(), [
            'comment' => ['required', 'string', 'block_patterns'],
        ] + app(ReCaptchaValidation::class)->validate());

        if ($validator->fails()) {
            foreach ($validator->errors()->all() as $error) {
                toastr()->error($error);
            }
            return back()->withInput();
        }

        $comment = BlogComment::create([
            'user_id' => authUser()->id,
            'blog_article_id' => $blogArticle->id,
            'body' => $request->comment,
        ]);

        if ($comment) {
            $title = translate('New Blog Comment Waiting Review');
            $image = asset('images/notifications/comment.png');
            $link = route('admin.blog.comments.index');
            adminNotify($title, $image, $link);
            toastr()->success(translate('Your comment is under review it will be published soon'));
            return back();
        }
    }
}