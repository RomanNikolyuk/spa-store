<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Http\Requests\ProductRequest;
use App\Models\Category;
use App\Models\Image;
use App\Models\Product;
use App\Models\RecommendedProducts;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\File;

class ProductsController extends Controller
{
    public string $saveTmpDirectory = '/images/products/tmp/';
    public string $saveFileDirectory = '/images/products/';

    public function products(Request $request)
    {
        $products = Product::orderBy('updated_at', 'desc')->with('category')->paginate(25);

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

        $inserted_id = Product::create($data)->id;

        $this->attachPhoto($inserted_id, $request);

        $this->insertIntoRecommended($inserted_id, $request->has('recommended'));

        return redirect()->route('products')->with(['success' => 'Новий продукт створено 🔥']);
    }

    public function upload(Request $request)
    {
        abort_if(!$request->hasFile('image'), 400);

        $folder = $this->saveTmpDirectory . now()->timestamp;

        $request->image->move(public_path($folder), uniqid() . '.' . $request->image->getClientOriginalExtension());

        return $folder;
    }

    public function save_edit(ProductRequest $request, $id)
    {
        $data = $request->except('_method', '_token', 'image');
        $product = Product::find($id);

        if (request()->has('image')) {
            $this->attachPhoto($id, $request);
        }

        $product->update($data);

        $this->insertIntoRecommended($id, $request->has('recommended'));

        return redirect()->route('products')->with(['success' => 'Продукт оновлено 🍻']);
    }

    private function attachPhoto(int $productId, ProductRequest $request) : void
    {
        $previousImages = Image::whereProductId($productId);
        foreach ($previousImages->get() as $image) {
            File::delete(public_path($image->title));
        }
        $previousImages->delete();

        foreach (File::files(public_path($request->image)) as $file) {
            $filePath = public_path($this->saveFileDirectory.$file->getFilename());
            File::move($file, $filePath);
            Image::create(['title' => $this->saveFileDirectory.$file->getFilename(), 'product_id' => $productId]);
        }

        rmdir(public_path($request->image));
    }

    public function insertIntoRecommended(int $product_id, bool $recommended)
    {
        $row = RecommendedProducts::where('product_id', $product_id)->first();

        if ($recommended) {
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
