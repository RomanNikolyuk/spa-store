<?php

namespace App\Http\Controllers;

use App\Models\Slider;

class SlidersController extends Controller
{
    // TODO: переписати логіку картинок!!!!
    public function api()
    {
        $sliders = Slider::get();

        foreach ($sliders as $slider) {
            $slider->image = $slider->img->title;
        }

        return $sliders;
    }
}
