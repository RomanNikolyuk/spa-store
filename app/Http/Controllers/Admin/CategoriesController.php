<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Http\Requests\CategoryRequest;
use App\Models\Category;
use App\Models\Image;
use App\Models\MainPageCategory;
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
        $allCategories = Category::all();

        $categories[0] = '';
        foreach ($allCategories as $category) {
            $categories[$category->id] = $category->title;
        }

        return view('categories.view_category')
            ->with(compact('categories'));
    }

    public function edit($id)
    {
        $category = Category::find($id);
        $allCategories = Category::all();
        $categories[0] = '';

        foreach ($allCategories as $cat) {
            $categories[$cat->id] = $cat->title;
        }

        return view('categories.view_category')
            ->with('category', $category)
            ->with(compact('categories'));
    }

    public function save_new(CategoryRequest $request)
    {
        $data = $request->except('_method', '_token');
        $data['alias'] = Str::slug($data['title']);

        $insertedId = Category::create($data)->id;
        $this->insertIntoMainPageProducts($insertedId);

        return redirect()->route('categories')->with(['success' => 'Категорію додано']);
    }

    public function save_edit(CategoryRequest $request, $id)
    {
        $data = $request->except('_method', '_token');
        $category = Category::find($id);

        $data['alias'] = Str::slug($data['title']);

        $category->update($data);
        $this->insertIntoMainPageProducts($id);

        return redirect()->route('categories')->with(['success' => 'Успішно змінено 😎']);
    }

    public function insertIntoMainPageProducts($categoryId)
    {
        $row = MainPageCategory::where('category_id', $categoryId)->first();

        if (request()->hasFile('image')) {
            Image::put(request()->file('image'), $categoryId, 'category');
        }

        if (request('mainpage_category')) {
            if (is_null($row)) {
                MainPageCategory::create(['category_id' => $categoryId]);
            }
        } else {
            !is_null($row) ? $row->delete() : null;
        }
    }


    public function delete($id)
    {
        $category = Category::find($id);

        $category->products()->delete();
        MainPageCategory::where('category_id', $id)->delete();

        $category->delete();

        return redirect()->route('categories')->with(['success' => 'Категорію видалено ☺']);
    }
}
