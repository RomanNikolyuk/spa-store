<?php

namespace App\Http\Controllers\Api;

use App\Http\Controllers\Controller;
use App\Models\Slider;

class SlidersController extends Controller
{
    public function api()
    {
        $sliders = Slider::get();

        foreach ($sliders as $slider) {
            $slider->image = $slider->img->title;
        }

        return $sliders;
    }
}
