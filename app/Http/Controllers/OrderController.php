<?php

namespace App\Http\Controllers;

use App\Models\Order;
use App\Models\OrderProduct;
use App\Models\Product;
use Illuminate\Http\Request;
use Mailgun\Mailgun;

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

        $data = $request->except('products');
        $data['status'] = 1;

        Order::create($data);

        $created_order_id = Order::latest()->first()->id;

        $products = json_decode($request->input('products'));

        foreach ($products as $product) {
            OrderProduct::create(['order_id' => $created_order_id, 'product_id' => $product]);

            $ready_products[] = Product::findOrFail($product);
        }

        $this->sendMail($ready_products ?? [], $created_order_id);
    }

    /*
     *  Увага! Цей метод надсилав лист, проте github не дозволяє цього запушити
     */
    public function sendMail($products, $order_id)
    {

    }
}
