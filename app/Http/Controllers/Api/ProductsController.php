<?php

namespace App\Http\Controllers\Api;

use Illuminate\Http\Request;
use Illuminate\Support\Facades\Cache;

use App\{
    Models\Category,
    Models\Product,
    Models\RecommendedProducts
};
use App\Http\{
    Controllers\Controller,
    Resources\ProductsResource
};

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
        if (!is_null($search)) {
            $products = $this->getSearchedProducts($search, $page);
        } else {
            $products = $this->getCategoryProducts($category, $page, $orderBy);
        }

        return $products;
    }

    public function viewOne(Request $request)
    {
        return Cache::rememberForever('product-' . $request->id, function () use ($request) {
            $product = Product::whereId($request->id)->firstOr(function () {
                abort(response()->json(new \stdClass()));
            });

            // Getting Related Products
            $related = Product::where('category_id', $product->category_id)
                ->where('id', 'NOT LIKE', $product->id)
                ->limit(4)
                ->get();

            if (is_null($related)) {
                $related = Product::inRandomOrder()->limit(4)->get();
            }

            $related = ProductsResource::collection($related);

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

            return new ProductsResource($product);
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
            $newProducts = Product::limit(8)->latest()->get();
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

        return ProductsResource::collection($return);
    }

    private function getSearchedProducts(string $search, int $page)
    {
        $products = Product::where('title', 'LIKE', "%$search%")->get();

        return ProductsResource::collection($products);
    }
}
