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

    public function sendMail($products, $order_id)
    {
        $mgClient = Mailgun::create('e6c65b078ad6f235dcab946d18e4b5ff-28d78af2-7dcc0424', 'https://api.mailgun.net/v3/sandbox9e8fb193bfd947f8ac2848fe77995e58.mailgun.org');

        $mgClient->messages()->send('sandbox9e8fb193bfd947f8ac2848fe77995e58.mailgun.org', [
            'from' => 'orders@dzvin.com.ua',
            'to' => 'roman.nikolyuk@gmail.com',
            'subject' => 'Нове замовлення (⌐■_■)',
            'html' => view('mail', ['products' => $products, 'order_id' => $order_id])->render()
        ]);

    }
}
