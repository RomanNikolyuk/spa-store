<?php

namespace App\Http\Controllers;

use App\Models\Order;
use Illuminate\Http\Request;

class OrderController extends Controller
{
    public function api(Request $request)
    {
        $this->validate($request, [
            'first_name' => 'required|min:3',
            'last_name' => 'required|min:3',
            'delivery_address' => 'required|min:5',
            'telephone' => 'required|min:8',
            'email' => 'required|email'
        ]);

        Order::create($request->except('_token'));

        return 'Okay';
    }
}
