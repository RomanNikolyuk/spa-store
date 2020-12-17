<?php

namespace App\Http\Controllers;

use App\Models\MainPageCategory;
use Illuminate\Http\Request;

class MainPageCategoriesController extends Controller
{
    public function api()
    {
        $categories_ids = MainPageCategory::all();
        $output = [];

        foreach ($categories_ids as $id) {
            $target_category = $id->category;
            $target_category->url = 'catalog/'.$target_category->alias;

            $output[] = $id->category;
        }

        return json_encode($output);
    }
}
