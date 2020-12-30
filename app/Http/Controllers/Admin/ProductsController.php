<?php

namespace App\Http\Controllers\Admin;

use App\Components\Helpers;
use App\Components\ImageTable;
use App\Http\Controllers\Controller;
use App\Http\Requests\ProductRequest;
use App\Models\Category;
use App\Models\Product;
use Illuminate\Http\Request;
use Illuminate\Support\Str;

class ProductsController extends Controller
{
    public function products()
    {
        $products = Product::orderBy('updated_at', 'desc')->paginate(25);

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

        if ($request->hasFile('image')) {
            $image = $request->file('image');

            Product::create($data);

            $inserted_id = Product::latest()->first()->id;

            ImageTable::save($image, $inserted_id, 'product');
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

        return redirect()->route('products');
    }

    public function delete($id)
    {
        $product = Product::find($id);

        $product->delete();

        return redirect()->route('products');

    }

}
