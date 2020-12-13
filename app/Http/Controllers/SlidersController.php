<?php

namespace App\Http\Controllers;

use App\Models\Slider;

class SlidersController extends Controller
{
    public function index()
    {
        $sliders = Slider::all();

        $output = [];
        foreach ($sliders as $slider) {

            $slider_img = $slider->image;
            // Тільки якщо має картинку
            if (is_object($slider_img)) {
                $slider->img = $slider->image->title;

                $output[] = $slider;
            }
        }

        $output = json_encode($output);

        return $output;
    }
}
