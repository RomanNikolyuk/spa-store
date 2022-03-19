<?php

namespace App\Http\Controllers\Api;

use App\Http\Controllers\Controller;
use App\Http\Resources\ProductsResource;
use App\Models\Category;
use App\Models\Product;
use App\Models\RecommendedProducts;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Cache;

class ProductsController extends Controller
{
    public int $maxProductPerPage = 55;

    public function catalog(Request $request)
    {
        $category = $request->input('category');
        $page = $request->input('page', 1);
        $search = $request->input('q');
        $orderBy = $request->input('order_by');

        return $this->getOutput($category, $page, $search, $orderBy);
    }

    protected function getOutput(
        string|null $category,
        int|null $page,
        string|null $search,
        string|null $orderBy,
    ) {
        if (is_null($search)) {
            $products = $this->getCategoryProducts($category, $page, $orderBy);
        } else {
            $products = $this->getSearchedProducts($search, $page);
        }

        return $products;
    }

    public function viewOne(Request $request)
    {
        return Cache::rememberForever('product-' . $request->id, function () use ($request) {
            $product = Product::find($request->id);

            // Getting Related Products
            $related = Product::where('category_id', $product->category_id)
                ->where('id', 'NOT LIKE', $product->id)
                ->limit(4)
                ->get()
                ->reduce(function ($arr, $item) {
                    if (!empty($item->images)) {
                        $item->image = $item->images[0];
                    }

                    $arr[] = $item;
                    return $arr;
                });

            if (is_null($related)) {
                $related = Product::all()->random(4);

                foreach ($related as $value) {
                    if (!empty($value->images)) {
                        $value->image = $value->images[0];
                    }
                }
            }

            $product->related = $related;
            $category = $product->category;

            // Creating Categories string
            if ($category->parent_id !== 0) {
                $parent_category = Category::find($category->parent_id);

                $categories = $parent_category->title . ' -> ' . $category->title;
            } else {
                $categories = $category->title;
            }

            $product->categories = $categories;
            $product->reviews = [];

            return ProductsResource::collection(collect($product)->paginate($this->maxProductPerPage));
        });
    }

    public function mainPage()
    {
        return Cache::rememberForever('mainPageProducts', function () {
            $products = [];

            if (RecommendedProducts::count() < 8 && Product::count() < 8) {
                return [];
            }

            // Recommended Products
            $recommendedIds = RecommendedProducts::limit(8)->get();
            foreach ($recommendedIds as $productId) {
                $product = $productId->product;

                if (is_null($product)) {
                    $productId->delete();
                    continue;
                }

                $product->type = 'recommended';
                $products[] = $product;
            }

            // New products
            $newProducts = Product::limit(8)->orderBy('id', 'DESC')->get();
            foreach ($newProducts as $newProduct) {
                $newProduct->image = $newProduct->images ? $newProduct->images[0] : null;

                $newProduct->type = 'new';

                $products[] = $newProduct;
            }

            return ProductsResource::collection($products);
        });
    }

    /****** PRIVATE METHODS ******/

    private function getCategoryProducts(string|null $category, int $page, string|null $orderBy)
    {
        $return = [];
        if (!is_null($category)) {
            $searched_category = Category::where('alias', $category)->first();

            array_push($return, ...$searched_category->products);

            if ($searched_category->parent_id === 0) {
                $children_categories = Category::where('parent_id', $searched_category->id)->get();

                foreach ($children_categories as $children_category) {
                    array_push($return, ...$children_category->products);
                }
            }
        } else {
            if (!is_null($orderBy)) {
                $products = Product::orderBy('price', $orderBy)->paginate($this->maxProductPerPage);
            } else {
                $products = Product::paginate($this->maxProductPerPage);
            }

            array_push($return, ...$products);
        }

        return ProductsResource::collection(collect($return)->paginate($this->maxProductPerPage));
    }

    private function getSearchedProducts(string $search, int $page)
    {
        $products = Product::where('title', 'LIKE', "%$search%")->get();

        foreach ($products as $product) {
            $product->image = $product->images;

            if (!empty($product->image)) {
                $product->image = $product->image[0];
            }

            $ready_products[] = $product;
        }

        return ProductsResource::collection($ready_products ?? []);
    }
}
