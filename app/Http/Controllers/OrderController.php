<?php

namespace App\Http\Controllers;

use App\Mail\OrderCreated;
use App\Models\Order;
use App\Models\OrderProduct;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Mail;

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
        }

        Mail::to('roman.nikolyuk@gmail.com')->send(new OrderCreated());




        return new OrderCreated();
    }

    public function sendMail()
    {
        /*Mail::send('mail', ['data' => ''], function ($message) {
            $message->to('roman.nikolyuk@gmail.com', 'Сайт Дзвін');
            $message->from('dzvin.orders@gmail.com', 'Николюк');
            $message->subject('Нове замовлення!');
        });*/





    }
}
