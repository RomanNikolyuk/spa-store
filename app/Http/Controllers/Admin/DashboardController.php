<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Models\Order;
use Illuminate\Http\Request;

class DashboardController extends Controller
{
    public function dashboard()
    {
        $orders = Order::paginate(15);

        return view('dashboard.dashboard')->with('orders', $orders);
    }

    public function view($id)
    {
        $order = Order::find($id);

        return view('dashboard.view_order')->with('order', $order);
    }

    public function changeStatus($id)
    {
        $order = Order::find($id);

        if ($order->status == 1) {
            $order->status = 2;
        } else {
            $order->status = 0;
        }

        $order->update();

        return redirect()->route('dashboard');

    }
}

