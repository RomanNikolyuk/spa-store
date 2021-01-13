<?php

namespace App\Http\Controllers\Admin;

use App\Components\Helpers;
use App\Components\ImageTable;
use App\Http\Controllers\Controller;
use App\Http\Requests\ProductRequest;
use App\Models\Product;
use App\Models\RecommendedProducts;
use Illuminate\Http\Request;

class ProductsController extends Controller
{
    public function products(Request $request)
    {
        $products = Product::orderBy('updated_at', 'desc')->paginate(25);

        if ($request->has('search')) {
            $products = Product::where('title', 'LIKE', "%{$request->input('search')}%")->orderBy('updated_at', 'desc')->paginate(35);
        }

        return view('products.products')->with('products', $products);
    }

    public function edit($id)
    {
        $product = Product::find($id);

        $categories = Helpers::get_categories_arr();

        return view('products.view_product')->with('product', $product)->with('categories', $categories);

    }


    public function new()
    {
        return view('products.view_product')->with('categories', Helpers::get_categories_arr());
    }


    public function save_new(ProductRequest $request)
    {
        $data = $request->except('_method', '_token', 'image');


        if ($request->has('image')) {

            Product::create($data);

            $inserted_id = Product::latest()->first()->id;

            foreach ($request->file('image') as $image) {
                ImageTable::save($image, $inserted_id, 'product');
            }

            $this->insertIntoRecommended($inserted_id);

        } else {
            return redirect()->back()->with('error', 'Картинку не вибрано');
        }

        return redirect()->route('products');
    }

    public function save_edit(ProductRequest $request, $id): \Illuminate\Http\RedirectResponse
    {
        $data = $request->except('_method', '_token', 'image');
        $product = Product::find($id);


        if ($request->hasFile('image')) {

            $image = $request->file('image');

            ImageTable::save($image, $id, 'product');
        }

        $product->update($data);

        $this->insertIntoRecommended($id);

        return redirect()->route('products');
    }

    public function insertIntoRecommended($product_id)
    {
        $row = RecommendedProducts::where('product_id', $product_id)->first();

        if (isset($_POST['recommended'])) {
            if (is_null($row))
                RecommendedProducts::create(['product_id' => $product_id]);
        } else {
            if (!is_null($row))
                $row->delete();
        }


    }

    public function delete($id)
    {
        $product = Product::find($id);

        $recommended = RecommendedProducts::where('product_id', $id);

        if (!is_null($recommended))
            $recommended->delete();

        $product->delete();

        return redirect()->route('products');

    }

}
