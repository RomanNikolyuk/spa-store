<?php

namespace App\Http\Controllers;

use App\Components\CollectionPaginator;
use App\Models\Category;
use App\Models\Product;
use App\Models\RecommendedProducts;
use Illuminate\Http\Request;

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
    ): array {
        if (is_null($search)) {
            $products = $this->getCategoryProducts($category, $page, $orderBy);
        } else {
            $products = $this->getSearchedProducts($search, $page);
        }

        return $products;
    }

    public function viewOne(Request $request)
    {
        $product = Product::where('id', $request->input('id'))->first();

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
        // ???????????? TODO: убрати
        $product->images = $product->images;

        // Creating Categories string
        if ($category->parent_id !== 0) {
            $parent_category = Category::find($category->parent_id);

            $categories = $parent_category->title . ' -> ' . $category->title;
        } else {
            $categories = $category->title;
        }

        $product->categories = $categories;
        $product->reviews = [];

        return $product;
    }

    public function mainPage()
    {
        $products = [];

        // Recommended Products
        if (RecommendedProducts::count() >= 8 && Product::count() >= 8) {
            $recommendedIds = RecommendedProducts::limit(8)->get();

            foreach ($recommendedIds as $productId) {
                $product = $productId->product;

                if (is_null($product)) {
                    $productId->delete();
                    continue;
                }

                $product->image = $product->images ? $product->images[0] : null;

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
        }

        return $products;
    }

    /****** PRIVATE METHODS ******/

    private function getCategoryProducts(string|null $category, int $page, string|null $orderBy): array
    {
        if (!is_null($category)) {
            $searched_category = Category::where('alias', $category)->first();

            foreach ($searched_category->products as $product) {
                if (!empty($product->images)) {
                    $product->image = $product->images[0];
                }

                $return[] = $product;
            }


            if ($searched_category->parent_id === 0) {
                $children_categories = Category::where('parent_id', $searched_category->id)->get();

                foreach ($children_categories as $children_category) {
                    foreach ($children_category->products as $product) {
                        $product->image = $product->images;

                        if (!empty($product->image)) {
                            $product->image = $product->image[0];
                        }

                        $return[] = $product;
                    }
                }
            }
        } else {
            if (!is_null($orderBy)) {
                $products = Product::orderBy('price', $orderBy)->paginate($this->maxProductPerPage);
            } else {
                $products = Product::paginate($this->maxProductPerPage);
            }

            foreach ($products as $product) {
                if (!empty($product->images)) {
                    $product->image = $product->images[0];
                }
                $return[] = $product;
            }
        }

        return CollectionPaginator::paginate(
            $return ?? [],
            $this->maxProductPerPage,
            $page
        )->toArray()['data'];
    }

    private function getSearchedProducts(string $search, int $page): array
    {
        $products = Product::where('title', 'LIKE', "%$search%")->get();

        foreach ($products as $product) {
            $product->image = $product->images;

            if (!empty($product->image)) {
                $product->image = $product->image[0];
            }

            $ready_products[] = $product;
        }

        return CollectionPaginator::paginate(
            $ready_products ?? [],
            $this->maxProductPerPage,
            $page
        )
            ->toArray()['data'];
    }
}
