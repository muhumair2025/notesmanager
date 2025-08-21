<?php

namespace App\Http\Controllers;

use App\Models\Order;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\RateLimiter;

class TrackingController extends Controller
{
    public function index()
    {
        return view('tracking.index');
    }

    public function track(Request $request)
    {
        // Rate limiting for tracking - max 10 searches per IP per minute
        $key = 'track-search:' . $request->ip();
        
        if (RateLimiter::tooManyAttempts($key, 10)) {
            $seconds = RateLimiter::availableIn($key);
            
            return redirect()->back()
                ->withErrors(['rate_limit' => "Too many search attempts. Please wait {$seconds} seconds before searching again."])
                ->withInput();
        }
        
        $request->validate([
            'name' => 'required|string|max:255',
            'phone_number' => 'required|string|max:20'
        ]);
        
        // Hit the rate limiter after validation
        RateLimiter::hit($key, 60); // 1 minute

        // Clean phone number for search (remove any non-digit characters)
        $cleanPhone = preg_replace('/[^0-9]/', '', $request->phone_number);
        
        $orders = Order::where('name', 'LIKE', '%' . $request->name . '%')
                      ->where('phone_number', 'LIKE', '%' . $cleanPhone . '%')
                      ->orderBy('created_at', 'desc')
                      ->get();

        return view('tracking.results', compact('orders', 'request'));
    }
}
