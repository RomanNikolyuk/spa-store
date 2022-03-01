<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Http\Requests\ProductRequest;
use App\Models\Category;
use App\Models\Image;
use App\Models\Product;
use App\Models\RecommendedProducts;
use Illuminate\Http\Request;

class ProductsController extends Controller
{
    public function products(Request $request)
    {
        $products = Product::orderBy('updated_at', 'desc')->paginate(25);

        if ($request->has('search')) {
            $products = Product::where('title', 'LIKE', "%{$request->input('search')}%")
                ->orderBy('updated_at', 'desc')
                ->paginate(35);
        }

        return view('products.products')->with('products', $products);
    }

    public function edit($id)
    {
        $product = Product::find($id);
        $categories = $this->getCategoriesArr();

        return view('products.view_product')->with('product', $product)->with('categories', $categories);
    }


    public function new()
    {
        return view('products.view_product')->with('categories', $this->getCategoriesArr());
    }


    public function save_new(ProductRequest $request)
    {
        $data = $request->except('_method', '_token', 'image');

        if (!$request->has('image')) {
            return redirect()->back()->withErrors(['image' => 'Картинка обов\'язкова']);
        }

        Product::create($data);

        $inserted_id = Product::latest()->first()->id;

        foreach ($request->file('image') as $image) {
            Image::put($image, $inserted_id, 'product');
        }

        $this->insertIntoRecommended($inserted_id);

        return redirect()->route('products')->with(['success' => 'Новий продукт створено 🔥']);
    }

    public function save_edit(ProductRequest $request, $id)
    {
        $data = $request->except('_method', '_token', 'image');
        $product = Product::find($id);

        if (request()->hasFile('image')) {
            $images = $request->file('image');
            foreach ($images as $image) {
                Image::put($image, $id, 'product');
            }
        }

        $product->update($data);

        $this->insertIntoRecommended($id);

        return redirect()->route('products')->with(['success' => 'Продукт оновлено 🍻']);
    }

    public function insertIntoRecommended($product_id)
    {
        $row = RecommendedProducts::where('product_id', $product_id)->first();

        if (request()->has('recommended')) {
            if (is_null($row)) {
                RecommendedProducts::create(['product_id' => $product_id]);
            }
        } else {
            !is_null($row) ? $row->delete() : null;
        }
    }

    public function delete($id)
    {
        $product = Product::find($id);

        $product->recommended()->delete();
        $product->delete();

        return redirect()->route('products')->with(['success' => 'Успішно Видалено']);
    }

    protected function getCategoriesArr(): array
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
