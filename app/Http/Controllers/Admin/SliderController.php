<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Http\Requests\SliderRequest;
use App\Models\Image;
use App\Models\Slider;
use Illuminate\Http\Request;

class SliderController extends Controller
{
    public function slider()
    {
        $slides = Slider::all();

        return view('sliders.sliders')->with(compact('slides'));
    }

    public function new()
    {
        return view('sliders.view_slide');
    }

    public function save_new(SliderRequest $request)
    {
        $data = $request->except('_token');

        $insertedId = Slider::create($data)->id;

        if ($request->hasFile('image')) {
            $img = $request->file('image');

            Image::put($img, $insertedId, 'slider');
        } else {
            return back()->with('error', 'Картинку не завантажено!');
        }

        return redirect()->route('slider')->with(['success' => 'Слайд додано']);
    }

    public function edit($id)
    {
        $slide = Slider::find($id);

        return view('sliders.view_slide')->with(compact('slide'));
    }

    public function save_edit(SliderRequest $request, $id)
    {
        $slide = Slider::find($id);
        $data = $request->except('_token', '_method');

        if ($request->hasFile('image')) {
            $img = $request->file('image');
            Image::put($img, $slide->id, 'slider');
        }

        $slide->update($data);

        return redirect()->route('slider')->with(['success' => 'Успішно змінено']);
    }

    public function delete($id)
    {
        Slider::find($id)->delete();

        return redirect()->route('slider')->with(['success' => 'Слайд видалено 🤗']);
    }
}
