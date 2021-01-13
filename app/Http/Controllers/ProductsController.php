<?php

namespace App\Http\Controllers;

use App\Components\CollectionPaginator;
use App\Models\Category;
use App\Models\Product;
use App\Models\RecommendedProducts;
use Illuminate\Http\Request;

class ProductsController extends Controller
{
    public function catalog(Request $request)
    {
        $category = $request->input('category');
        $page = $request->input('page', 1);
        $search = $request->input('q');
        $order_by = $request->input('order_by');

        $products_per_page = 55;


        if (is_null($search)) {
            if ($category) {
                $searched_category = Category::where('alias', $category)->first();

                foreach ($searched_category->products as $product) {
                    $product->image = $product->images;

                    if (!empty($product->image)) {
                        $product->image = $product->image[0];
                    }

                    $ready_products[] = $product;
                }


                if ($searched_category->parent_id === 0) {

                    $children_categories = Category::where('parent_id', $searched_category->id)->get();

                    foreach ($children_categories as $children_category) {

                        foreach ($children_category->products as $product) {
                            $product->image = $product->images;

                            if (!empty($product->image)) {
                                $product->image = $product->image[0];
                            }

                            $ready_products[] = $product;
                        }

                    }

                }


                $output = CollectionPaginator::paginate($ready_products ?? [], $products_per_page, $page)->toArray()['data'];

            } else {
                if (!is_null($order_by)) {
                    $products = Product::orderBy('price', $order_by)->paginate($products_per_page);
                } else {
                    $products = Product::paginate($products_per_page);
                }


                foreach ($products as $product) {

                    $product->image = $product->images;

                    if (!empty($product->image)) {
                        $product->image = $product->image[0];
                    }
                    $output[] = $product;
                }
            }


        } else {
            $products = Product::where('title', 'LIKE', "%$search%")->get();

            foreach ($products as $product) {
                $product->image = $product->images;

                if (!empty($product->image)) {
                    $product->image = $product->image[0];
                }

                $ready_products[] = $product;
            }

            $output = CollectionPaginator::paginate($ready_products ?? [], $products_per_page, $page)->toArray()['data'];
        }

        return json_encode($output);
    }


    public function viewOne(Request $request)
    {
        $id = $request->input('id');

        $product = Product::find($id);

        $product->images = $product->images;

        $related = Product::where('category_id', $product->category_id)
            ->where('id', 'NOT LIKE', $product->id)
            ->limit(4)
            ->get()
            ->reduce(function ($arr, $item) {
                $item->image = $item->images;

                if (!empty($item->image)) {
                    $item->image = [$item->image[0]];
                }

                $arr[] = $item;
                return $arr;
            });

        if (is_null($related)) {
            $related = Product::all()->random(4);

            foreach ($related as $value) {
                $value->image = $value->images;

                if (!empty($value->image)) {
                    $value->image = $value->image[0];
                }

            }

        }

        $product->related = !is_null($related) ? $related : [];

        $category = $product->category;

        if ($category->parent_id !== 0) {
            $parent_category = Category::find($category->parent_id);

            $categories = $parent_category->title . ' -> ' . $category->title;
        } else {
            $categories = $category->title;
        }

        $product->categories = $categories;


        $product->reviews = [];

        return json_encode($product);
    }


    public function mainPage()
    {
        if (RecommendedProducts::count() >= 8 && Product::count() >= 8) {

            $recommended_ids = RecommendedProducts::limit(8)->get();

            /* OBJECT */
            foreach ($recommended_ids as $product_id) {
                $product = $product_id->product;

                // Якщо продукту за id не існує - удалить запис нахуй
                if (!is_null($product)) {

                    $product->image = $product->images;

                    if (!empty($product->image)) {
                        $product->image = $product->image[0];
                    }


                    $product->type = 'recommended';

                    $output[] = $product;
                } else {
                    $product_id->delete();
                }

            }

            $new_products = Product::limit(8)->orderBy('id', 'DESC')->get();

            foreach ($new_products as $new_product) {
                $new_product->image = $new_product->images ?? null;

                if (!empty($new_product->image)) {
                    $new_product->image = $new_product->image[0];
                }

                $new_product->type = 'new';

                $output[] = $new_product;
            }

        } else {
            $output = [];
        }

        return json_encode($output);
    }

}
