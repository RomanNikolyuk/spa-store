<?php

namespace App\Http\Controllers;

use App\Models\Slider;

class SlidersController extends Controller
{
    public function api()
    {
        $sliders = Slider::all();

        $output = [];
        foreach ($sliders as $slider) {
            $slider->image = $slider->image;

            $output[] = $slider;
        }

        $output = json_encode($output);

        return $output;
    }
}
