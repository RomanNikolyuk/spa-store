<?php

namespace App\Http\Controllers;

use App\Models\Product;
use Illuminate\Http\Request;

class ProductController extends Controller
{
    public function api(Request $request)
    {
        $id = $request->input('id');

        $output = Product::find($id);

        return json_encode($output);
    }
}
