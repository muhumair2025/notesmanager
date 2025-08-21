<?php

namespace App\Http\Controllers;

use App\Models\Order;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\RateLimiter;
use Illuminate\Support\Str;

class UserController extends Controller
{
    public function index()
    {
        return view('user.order-form');
    }

    public function store(Request $request)
    {
        // Rate limiting - max 3 orders per IP per hour
        $key = 'order-submission:' . $request->ip();
        
        if (RateLimiter::tooManyAttempts($key, 3)) {
            $seconds = RateLimiter::availableIn($key);
            $minutes = ceil($seconds / 60);
            
            return redirect()->back()
                ->withErrors(['rate_limit' => "Too many orders submitted. Please wait {$minutes} minutes before submitting another order."])
                ->withInput();
        }
        
        // Rate limiting by phone number - max 5 orders per phone per day
        $fullPhoneNumber = $request->phone_country_code . $request->phone_number;
        $phoneKey = 'order-phone:' . preg_replace('/[^0-9]/', '', $fullPhoneNumber);
        
        if (RateLimiter::tooManyAttempts($phoneKey, 5)) {
            $seconds = RateLimiter::availableIn($phoneKey);
            $hours = ceil($seconds / 3600);
            
            return redirect()->back()
                ->withErrors(['rate_limit' => "Maximum daily orders reached for this phone number. Please wait {$hours} hours or contact support."])
                ->withInput();
        }
        
        $request->validate([
            'name' => 'required|string|max:255',
            'phone_country_code' => 'required|string|max:10',
            'phone_number' => 'required|string|max:20',
            'secondary_phone_country_code' => 'nullable|string|max:10',
            'secondary_phone_number' => 'nullable|string|max:20',
            'full_address' => 'required|string',
            'city' => 'required|string|max:255',
            'country' => 'required|string|max:255',
            'semesters' => 'required|array|min:1',
            'semesters.*' => 'in:sem 1 notes,sem 2 notes,sem 3 notes,sem 4 notes,sem 5 notes,sem 6 notes,sem 7 notes',
            'remarks' => 'nullable|string',
            'fees_paid' => 'required|in:0,1'
        ]);

        // Combine country code with phone number
        $fullPhoneNumber = $request->phone_country_code . $request->phone_number;
        $fullSecondaryPhoneNumber = null;
        if ($request->secondary_phone_number && $request->secondary_phone_country_code) {
            $fullSecondaryPhoneNumber = $request->secondary_phone_country_code . $request->secondary_phone_number;
        }

        $order = Order::create([
            'name' => $request->name,
            'phone_number' => $fullPhoneNumber,
            'secondary_phone_number' => $fullSecondaryPhoneNumber,
            'full_address' => $request->full_address,
            'city' => $request->city,
            'country' => $request->country,
            'semesters' => $request->semesters,
            'remarks' => $request->remarks,
            'fees_paid' => $request->fees_paid == '1'
        ]);

        // Hit the rate limiters after successful order creation
        RateLimiter::hit($key, 3600); // 1 hour for IP-based limiting
        RateLimiter::hit($phoneKey, 86400); // 24 hours for phone-based limiting

        return redirect()->route('user.order-form')->with([
            'success' => 'Shukria, Ap Ka Form Kamyabi Sy Fill Ho Gia Hai, Ab Aap Kuch Din ( 1 sy 3 Hafty) Wait Karyn, Jald Hee Notes Print Ho Kar Apko Ponch Jayengy, Apna Dia Gia Number Open Rakhyn, Aor Active, Kionky Baz Dafa Post Office Waly Call Na Othany Ki Surat Me Notes Wapis Hamy Bhej Dety Hen.',
            'order_id' => $order->id,
            'show_track_button' => true
        ]);
    }

    public function orderHistory($phone)
    {
        // Rate limiting for order history - max 5 views per phone per minute
        $key = 'order-history:' . preg_replace('/[^0-9]/', '', $phone);
        
        if (RateLimiter::tooManyAttempts($key, 5)) {
            $seconds = RateLimiter::availableIn($key);
            
            return redirect()->route('tracking.index')
                ->withErrors(['rate_limit' => "Too many order history requests. Please wait {$seconds} seconds before trying again."]);
        }
        
        // Clean phone number for search
        $cleanPhone = preg_replace('/[^0-9]/', '', $phone);
        
        // Find orders for this phone number
        $orders = Order::where('phone_number', 'LIKE', '%' . $cleanPhone . '%')
                      ->orderBy('created_at', 'desc')
                      ->paginate(10);
        
        // Hit the rate limiter
        RateLimiter::hit($key, 60); // 1 minute
        
        return view('user.order-history', compact('orders', 'phone'));
    }

    public function cancelOrder(Request $request, $id)
    {
        // Rate limiting for cancellation - max 3 attempts per IP per hour
        $key = 'cancel-order:' . $request->ip();
        
        if (RateLimiter::tooManyAttempts($key, 3)) {
            $seconds = RateLimiter::availableIn($key);
            $minutes = ceil($seconds / 60);
            
            return redirect()->back()
                ->withErrors(['rate_limit' => "Too many cancellation attempts. Please wait {$minutes} minutes before trying again."]);
        }
        
        $request->validate([
            'phone_number' => 'required|string|max:20',
            'reason' => 'nullable|string|max:500'
        ]);
        
        $order = Order::findOrFail($id);
        
        // Verify phone number matches
        $cleanInputPhone = preg_replace('/[^0-9]/', '', $request->phone_number);
        $cleanOrderPhone = preg_replace('/[^0-9]/', '', $order->phone_number);
        
        if ($cleanInputPhone !== $cleanOrderPhone) {
            return redirect()->back()
                ->withErrors(['phone_number' => 'Phone number does not match the order record.']);
        }
        
        // Check if order can be cancelled (within 2 hours and status is pending)
        $canCancel = $order->created_at->diffInHours(now()) <= 2 && $order->status === 'pending';
        
        if (!$canCancel) {
            $message = $order->status !== 'pending' 
                ? 'This order cannot be cancelled as it is already being processed.'
                : 'This order cannot be cancelled as the 2-hour cancellation window has expired.';
                
            return redirect()->back()
                ->withErrors(['cancellation' => $message]);
        }
        
        // Cancel the order
        $order->update([
            'status' => 'cancelled',
            'remarks' => ($order->remarks ? $order->remarks . ' | ' : '') . 'Cancelled by customer. Reason: ' . ($request->reason ?: 'No reason provided')
        ]);
        
        // Hit the rate limiter
        RateLimiter::hit($key, 3600); // 1 hour
        
        return redirect()->back()->with('success', 'Your order has been successfully cancelled.');
    }
}
