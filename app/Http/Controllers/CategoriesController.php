<?php

namespace App\Http\Controllers;

use App\Models\Category;
use App\Models\MainPageCategory;
use Illuminate\Http\Request;

class CategoriesController extends Controller
{
    public function api()
    {
        $categories_ids = MainPageCategory::all();
        $output = [];

        foreach ($categories_ids as $id) {
            $target_category = $id->category;

            if ($target_category->parent_id !== 0) {
                $parent_cat = Category::find($target_category->parent_id);

                $target_category->url = 'catalog/'.$parent_cat->alias.'/'.$target_category->alias;
            } else {
                $target_category->url = 'catalog/'.$target_category->alias;
            }


            $target_category->img = $target_category->image->title ?? '';


            $output[] = $id->category;
        }

        return json_encode($output);
    }

    public function getChildren(Request $request)
    {
        $parent_category_alias = $request->input('parent_category');

        if ($parent_category_alias) {
            $parent_category = Category::where('alias', $parent_category_alias)->first();

            $children = Category::where('parent_id', $parent_category->id)->get();

            $output = $children->toArray();

            return json_encode($output);
        } else {
            $parent_categories = Category::where('parent_id', 0)->get();

            $output = $parent_categories->toArray();

            return json_encode($output);
        }


    }
}
