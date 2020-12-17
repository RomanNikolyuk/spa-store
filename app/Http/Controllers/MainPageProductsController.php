<?php

namespace App\Http\Controllers;

use App\Models\Product;
use App\Models\RecommendedProducts;
use Illuminate\Http\Request;

class MainPageProductsController extends Controller
{
    public function api()
    {
        if (RecommendedProducts::count() >= 8 && Product::count() >= 8) {

            $recommended_ids = RecommendedProducts::limit(8)->get();

                                      /* OBJECT */
            foreach ($recommended_ids as $product_id) {
                $product = $product_id->product;

                // Якщо продукту за id не існує - удалить запис нахуй
                if (! is_null($product)) {

                    $product->image = $product->images->first()->title ?? null;

                    $product->type = 'recommended';

                    $output[] = $product;
                } else {
                    $product_id->delete();
                }

            }

            $new_products = Product::limit(8)->orderBy('id', 'DESC')->get();

            foreach ($new_products as $new_product) {
                $new_product->image = $new_product->images->first()->title ?? null;

                $new_product->type = 'new';

                $output[] = $new_product;
            }

        } else {
            $output = [];
        }

        return json_encode($output);
    }
}
