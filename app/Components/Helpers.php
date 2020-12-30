<?php


namespace App\Components;


use App\Models\Category;

class Helpers
{
    // Генерує готовий масив для вставлення у Form::select
    public static function get_categories_arr(): array
    {
        $categories = Category::all();

        foreach ($categories as $category) {
            if ($category->parent_id === 0) {

                $children_categories = Category::where('parent_id', $category->id)->get();

                if (!$children_categories->isEmpty()) {

                    foreach ($children_categories as $children_category) {
                        $categories_result[$category->title][$children_category->id] = $children_category->title;
                    }

                } else {
                    $categories_result[$category->id] = $category->title;
                }

            }

        }

        return $categories_result ?? [];
    }
}
