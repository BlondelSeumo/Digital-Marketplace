<?php

namespace App\Http\Controllers;

use App\Http\Controllers\Controller;
use App\Http\Controllers\ItemController;
use App\Models\Category;
use App\Models\Item;
use App\Models\SubCategory;
use Illuminate\Http\Request;
use Illuminate\Support\Str;

class CategoryController extends Controller
{
    public function index()
    {
        $categories = Category::with(['subCategories' => function ($query) {
            $query->withCount('items');
        }])->withCount('items')->paginate(12);

        return theme_view('categories.index', ['categories' => $categories]);
    }

    public function category($category_slug)
    {
        $category = Category::where('slug', $category_slug)
            ->with(['subCategories', 'categoryOptions'])->firstOrFail();

        $items = $this->getItems($category);

        incrementViews($category, 'categories');

        return theme_view('categories.category', [
            'category' => $category,
            'items' => $items,
        ]);
    }

    public function subCategory($category_slug, $sub_category_slug)
    {
        $category = Category::where('slug', $category_slug)
            ->firstOrFail();

        $subCategory = SubCategory::where('category_id', $category->id)
            ->where('slug', $sub_category_slug)
            ->with(['category' => function ($query) {
                $query->with('categoryOptions');
            }])
            ->firstOrFail();

        $items = $this->getItems($category, $subCategory);

        incrementViews($subCategory, 'sub_categories');

        return theme_view('categories.sub-category', [
            'category' => $category,
            'subCategory' => $subCategory,
            'items' => $items,
        ]);
    }

    public function getItemsByOptions($items, $category)
    {
        foreach ($category->categoryOptions as $categoryOption) {
            $name = Str::slug($categoryOption->name, '_');
            if (request()->filled($name)) {
                $selectedOptions = request($name);
                if ($categoryOption->isMultiple()) {
                    $items->where(function ($query) use ($categoryOption, $selectedOptions) {
                        foreach ($selectedOptions as $selectedOption) {
                            $query->orWhere('options', 'like', '%' . $selectedOption . '%');
                        }
                    });

                } else {
                    $items->where('options', 'like', '%' . $selectedOptions . '%');
                }
            }
        }

        return $items;
    }

    public function getItems($category, $subCategory = null)
    {
        $items = Item::where('category_id', $category->id);

        if ($subCategory) {
            $items->where('sub_category_id', $subCategory->id);
        }

        $items = $this->getItemsByOptions($items, $category);

        $items = ItemController::getResultByParams($items);

        $items = $items->paginate(30);

        $categorySearchParams = [];
        foreach ($category->categoryOptions as $categoryOption) {
            $categorySearchParams[] = Str::slug($categoryOption->name, '_');
        }

        $items->appends(request()->only(['search', 'min_price', 'max_price',
            'free', 'premium', 'on_sale', 'best_selling', 'trending', 'featured', 'stars', 'date'] + $categorySearchParams));

        return $items;
    }
}