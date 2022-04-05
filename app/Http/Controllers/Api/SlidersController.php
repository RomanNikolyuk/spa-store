<?php

namespace App\Http\Controllers\Api;

use App\Http\Controllers\Controller;
use App\Http\Resources\SlidersResource;
use App\Models\Slider;

class SlidersController extends Controller
{
    public function api()
    {
        $sliders = Slider::get();

        return SlidersResource::collection($sliders);
    }
}
