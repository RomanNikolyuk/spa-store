<?php

namespace App\Http\Controllers;

use App\Http\Requests\OrderRequest;
use App\Models\Order;
use App\Models\OrderProduct;
use App\Models\Product;
use Illuminate\Http\Response;
use Mailgun\Mailgun;

class OrderController extends Controller
{
    public function api(OrderRequest $request): Response
    {
        $data = $request->except('products');
        $data['status'] = 1;

        $createdOrderId = Order::create($data)->id;

        $productsIds = json_decode($request->input('products'));

        foreach ($productsIds as $productId) {
            OrderProduct::create(['order_id' => $createdOrderId, 'product_id' => $productId]);

            $products[] = Product::findOrFail($productId);
        }

        $this->sendMail($products ?? [], $createdOrderId);

        return response('Нове замовлення створено', 200);
    }

    public function sendMail($products, $order_id)
    {
    }
}
