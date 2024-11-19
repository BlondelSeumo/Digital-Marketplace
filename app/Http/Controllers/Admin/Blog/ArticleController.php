<?php

namespace App\Http\Controllers\Admin\Blog;

use App\Http\Controllers\Controller;
use App\Models\BlogArticle;
use App\Models\BlogCategory;
use Cviebrock\EloquentSluggable\Services\SlugService;
use Illuminate\Http\Request;
use Validator;

class ArticleController extends Controller
{
    public function index(Request $request)
    {
        $categories = BlogCategory::all();

        $articles = BlogArticle::query();

        if (request()->filled('search')) {
            $searchTerm = '%' . request('search') . '%';
            $articles->where(function ($query) use ($searchTerm) {
                $query->where('title', 'like', $searchTerm)
                    ->orWhere('slug', 'like', $searchTerm)
                    ->orWhere('body', 'like', $searchTerm)
                    ->orWhere('short_description', 'like', $searchTerm);
            });
        }

        if (request()->filled('category')) {
            $articles->where('blog_category_id', request('category'));
        }

        $articles = $articles->with('category')->withCount('comments')
            ->orderbyDesc('ID')->paginate(20);
        $articles->appends(request()->only(['search']));

        return view('admin.blog.articles.index', [
            'categories' => $categories,
            'articles' => $articles,
        ]);
    }

    public function slug(Request $request)
    {
        $slug = null;
        if ($request->content != null) {
            $slug = SlugService::createSlug(BlogArticle::class, 'slug', $request->content);
        }
        return response()->json(['slug' => $slug]);
    }

    public function create()
    {
        $categories = BlogCategory::all();
        return view('admin.blog.articles.create', ['categories' => $categories]);
    }

    public function store(Request $request)
    {
        $validator = Validator::make($request->all(), [
            'title' => ['required', 'string', 'max:255', 'min:2'],
            'slug' => ['required', 'unique:blog_articles', 'alpha_dash'],
            'body' => ['required', 'string'],
            'category' => ['required', 'integer', 'exists:blog_categories,id'],
            'image' => ['required', 'mimes:png,jpg,jpeg,webp', 'max:2048'],
            'short_description' => ['required', 'string', 'max:200', 'min:2'],
        ]);

        if ($validator->fails()) {
            foreach ($validator->errors()->all() as $error) {
                toastr()->error($error);
            }
            return back()->withInput();
        }

        try {
            $image = imageUpload($request->file('image'), 'images/blog/');
            $article = BlogArticle::create([
                'title' => $request->title,
                'slug' => $request->slug,
                'body' => $request->body,
                'image' => $image,
                'short_description' => $request->short_description,
                'blog_category_id' => $request->category,
            ]);

            toastr()->success(translate('Created Successfully'));
            return redirect()->route('admin.blog.articles.edit', $article->id);

        } catch (\Exception $e) {
            toastr()->error($e->getMessage());
            return back()->withInput();
        }
    }

    public function edit(BlogArticle $article)
    {
        $categories = BlogCategory::all();
        return view('admin.blog.articles.edit', ['article' => $article, 'categories' => $categories]);
    }

    public function update(Request $request, BlogArticle $article)
    {
        $validator = Validator::make($request->all(), [
            'title' => ['required', 'string', 'max:255', 'min:2'],
            'slug' => ['required', 'alpha_dash', 'unique:blog_categories,slug,' . $article->id],
            'body' => ['required', 'string'],
            'category' => ['required', 'integer', 'exists:blog_categories,id'],
            'image' => ['nullable', 'mimes:png,jpg,jpeg,webp', 'max:2048'],
            'short_description' => ['required', 'string', 'max:200', 'min:2'],
        ]);

        if ($validator->fails()) {
            foreach ($validator->errors()->all() as $error) {
                toastr()->error($error);
            }
            return back();
        }

        try {
            $image = ($request->has('image')) ? imageUpload($request->file('image'), 'images/blog/', null, null, $article->image) : $article->image;
            $article->update([
                'title' => $request->title,
                'slug' => $request->slug,
                'body' => $request->body,
                'image' => $image,
                'short_description' => $request->short_description,
                'blog_category_id' => $request->category,
            ]);

            toastr()->success(translate('Updated Successfully'));
            return back();

        } catch (\Exception $e) {
            toastr()->error($e->getMessage());
            return back()->withInput();
        }

    }

    public function destroy(BlogArticle $article)
    {
        removeFile(public_path($article->image));
        $article->delete();
        toastr()->success(translate('Deleted Successfully'));
        return back();
    }
}
