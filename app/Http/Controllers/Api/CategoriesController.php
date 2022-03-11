<?php

namespace App\Http\Controllers\Api;

use App\Http\Controllers\Controller;
use App\Models\Category;
use App\Models\MainPageCategory;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Cache;

class CategoriesController extends Controller
{
    /*
     * Returns Main Page categories in json
     */
    public function api()
    {
        return Cache::rememberForever('mainPageCategories', function () {
            $output = [];
            $mainPageCategories = MainPageCategory::all();

            foreach ($mainPageCategories as $categoryId) {
                $category = $categoryId->category;

                if ($category->parent_id !== 0) {
                    $parentCategory = Category::findOrFail($category->parent_id);

                    $category->url = 'catalog/' . $parentCategory->alias . '/' . $category->alias;
                } else {
                    $category->url = 'catalog/' . $category->alias;
                }

                $category->img = $category->image->title ?? '';

                $output[] = $categoryId->category;
            }

            return $output;
        });
    }

    /*
     * Returns categories in catalog in json
     */

    public function getChildren(Request $request)
    {
        $parentCategoryAlias = $request->input('parent_category');

        if ($parentCategoryAlias) {
            $parentCategoryId = Category::where('alias', $parentCategoryAlias)->first()->id;

            $output = Category::where('parent_id', $parentCategoryId)->get();
        } else {
            $output = Category::where('parent_id', 0)->get();
        }

        return $output;
    }
}
