<?php

namespace App\Http\Controllers\Admin;

use App\Components\ImageTable;
use App\Http\Controllers\Controller;
use App\Models\Slider;
use Illuminate\Http\Request;

class SliderController extends Controller
{
    public function slider()
    {
        $slides = Slider::all();

        return view('sliders.sliders')->with('slides', $slides);
    }

    public function new()
    {
        return view('sliders.view_slide');
    }

    public function save_new(Request $request): \Illuminate\Http\RedirectResponse
    {
        $data = $request->except('_token');

        Slider::create($data);

        $inserted_id = Slider::latest()->first()->id;

        if ($request->hasFile('image')) {
            $img = $request->file('image');

            ImageTable::save($img, $inserted_id, 'slider');
        } else {
            return back()->with('error', 'Картинку не завантажено!');
        }


        return redirect()->route('slider');
    }

    public function edit($id)
    {
        $slide = Slider::find($id);

        return view('sliders.view_slide')->with('slide', $slide);
    }

    public function save_edit(Request $request, $id): \Illuminate\Http\RedirectResponse
    {
        $slide = Slider::find($id);
        $data = $request->except('_token', '_method');


        if ($request->hasFile('image')) {
            $img = $request->file('image');
            ImageTable::save($img, $slide->id, 'slider');
        }

        $slide->update($data);

        return redirect()->route('slider');

    }

    public function delete($id): \Illuminate\Http\RedirectResponse
    {
        Slider::find($id)->delete();

        return redirect()->route('slider');
    }
}
