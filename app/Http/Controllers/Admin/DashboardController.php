<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Models\Order;
use Illuminate\Http\Request;

class DashboardController extends Controller
{
    public function dashboard()
    {
        $orders = Order::orderBy('updated_at', 'desc')->paginate(15);
        $orders->newCount = Order::where('status', 1)->count();

        return view('dashboard.dashboard')->with('orders', $orders);
    }

    public function view($id)
    {
        $order = Order::find($id);

        return view('dashboard.view_order')->with('order', $order);
    }

    public function changeStatus(Request $request, $id)
    {
        $order = Order::find($id);

        // Form Listener
        if ($request->isMethod('post')) {
            if ($order->status == 1 || $order->status == 0) {
                $order->status = 2;
            } else {
                $order->status = 0;
            }
        }
        // Cancel link listener
        $request->has('cancel') ? $order->status = 0 : null;

        $order->update();

        return redirect()->route('dashboard')->with(['success' => 'Збережено 🧠']);
    }
}

