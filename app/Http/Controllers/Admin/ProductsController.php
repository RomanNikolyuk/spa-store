<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Models\Category;
use App\Models\Product;
use Illuminate\Http\Request;

class ProductsController extends Controller
{
    public function products()
    {
        $products = Product::orderBy('updated_at', 'desc')->paginate(25);

        return view('products.products')->with('products', $products);
    }

    public function view($id)
    {
        $product = Product::find($id);

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


        return view('products.view_product')->with('product', $product)->with('categories', $categories_result);

    }
}
