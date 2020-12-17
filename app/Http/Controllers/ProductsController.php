<?php

namespace App\Http\Controllers;

use App\Components\CollectionPaginator\CollectionPaginator;
use App\Models\Category;
use App\Models\Product;
use Illuminate\Http\Request;

class ProductsController extends Controller
{
    public function api(Request $request)
    {
        $category = $request->input('category');
        $page = $request->input('page', 1);

        $products_per_page = 55;

        if ($category) {
            $searched_category = Category::where('alias', $category)->first();

            foreach ($searched_category->products as $product) {
                $ready_products[] = $product;
            }


            if ($searched_category->parent_id === 0) {

                $children_categories = Category::where('parent_id', $searched_category->id)->get();

                foreach ($children_categories as $children_category) {

                    foreach ($children_category->products as $product) {
                        $ready_products[] = $product;
                    }

                }

            }


            $output = CollectionPaginator::paginate($ready_products, $products_per_page, $page)->toArray()['data'];
        } else {
            $output = Product::paginate($products_per_page)->toArray()['data'];
        }


        return json_encode($output);
    }
}
