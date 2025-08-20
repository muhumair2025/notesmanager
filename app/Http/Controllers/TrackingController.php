<?php

namespace App\Http\Controllers;

use App\Models\Order;
use Illuminate\Http\Request;

class TrackingController extends Controller
{
    public function index()
    {
        return view('tracking.index');
    }

    public function track(Request $request)
    {
        $request->validate([
            'name' => 'required|string|max:255',
            'phone_number' => 'required|string|max:20'
        ]);

        $orders = Order::where('name', 'LIKE', '%' . $request->name . '%')
                      ->where('phone_number', $request->phone_number)
                      ->orderBy('created_at', 'desc')
                      ->get();

        return view('tracking.results', compact('orders', 'request'));
    }
}
