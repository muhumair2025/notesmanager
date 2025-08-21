<?php

namespace App\Http\Controllers;

use App\Models\Order;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\RateLimiter;

class TrackingController extends Controller
{
    public function index()
    {
        // Get recent orders for marquee (last 10 orders)
        $recentOrders = Order::orderBy('created_at', 'desc')
                            ->take(10)
                            ->get()
                            ->map(function ($order) {
                                return [
                                    'name' => $this->maskName($order->name),
                                    'semesters' => $order->semesters,
                                    'time_ago' => $order->created_at->diffForHumans()
                                ];
                            });
        
        return view('tracking.index', compact('recentOrders'));
    }
    
    private function maskName($name)
    {
        $words = explode(' ', trim($name));
        $maskedWords = [];
        
        foreach ($words as $word) {
            if (strlen($word) <= 2) {
                $maskedWords[] = $word;
            } else {
                $firstChar = substr($word, 0, 1);
                $lastChar = substr($word, -1);
                $middle = str_repeat('*', strlen($word) - 2);
                $maskedWords[] = $firstChar . $middle . $lastChar;
            }
        }
        
        return implode(' ', $maskedWords);
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
