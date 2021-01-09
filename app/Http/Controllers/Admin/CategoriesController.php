<?php

namespace App\Http\Controllers\Admin;

use App\Components\Helpers;
use App\Components\ImageTable;
use App\Http\Controllers\Controller;
use App\Models\Category;
use App\Models\MainPageCategory;
use Illuminate\Http\Request;
use Illuminate\Support\Str;

class CategoriesController extends Controller
{
    public function categories()
    {
        $categories = Category::all();


        return view('categories.categories')->with('categories', $categories);
    }


    public function new()
    {
        $categories = Category::all();

        $categories_result[0] = '';

        foreach ($categories as $category) {

            $categories_result[$category->id] = $category->title;

        }

        return view('categories.view_category')->with('categories', $categories_result);
    }

    public function edit($id)
    {
        $category = Category::find($id);

        $all_categories = Category::all();

        $categories_result[0] = '';

        foreach ($all_categories as $value) {

            $categories_result[$value->id] = $value->title;
        }

        return view('categories.view_category')->with('category', $category)->with('categories', $categories_result);
    }

    public function save_new(Request $request)
    {
        $data = $request->except('_method', '_token');

        $data['alias'] = Str::slug($data['title']);

        Category::create($data);

        $inserted_id = Category::latest()->first()->id;

        $this->insertIntoMainPageProducts($inserted_id);

        return redirect()->route('categories');
    }

    public function save_edit(Request $request, $id)
    {
        $data = $request->except('_method', '_token');

        $category = Category::find($id);


        $data['alias'] = Str::slug($data['title']);

        $category->update($data);

        $this->insertIntoMainPageProducts($id);

        return redirect()->route('categories');

    }

    public function insertIntoMainPageProducts($category_id)
    {
        $row = MainPageCategory::where('category_id', $category_id)->first();

        if (\request()->hasFile('image')) {
            ImageTable::save(\request()->file('image'), $category_id, 'category');
        }

        if (\request('mainpage_category')) {
            if (is_null($row))
                MainPageCategory::create(['category_id' => $category_id]);
        } else {

            if (!is_null($row)) {
                $row->delete();
            }

        }


    }


    public function delete($id)
    {
        $category = Category::find($id);

        $category->products()->delete();

        $category->delete();

        return redirect()->route('categories');
    }
}
