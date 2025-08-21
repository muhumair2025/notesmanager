<?php

namespace App\Http\Controllers;

use App\Models\Order;
use App\Models\User;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Hash;

class AdminController extends Controller
{
    public function index(Request $request)
    {
        // Authentication and session refresh handled by AdminAuth middleware
        
        $query = Order::query();
        
        // Handle search functionality
        if ($request->filled('search')) {
            $searchTerm = $request->get('search');
            
            $query->where(function ($q) use ($searchTerm) {
                $q->where('name', 'LIKE', "%{$searchTerm}%")
                  ->orWhere('phone_number', 'LIKE', "%{$searchTerm}%")
                  ->orWhere('secondary_phone_number', 'LIKE', "%{$searchTerm}%")
                  ->orWhere('email', 'LIKE', "%{$searchTerm}%")
                  ->orWhere('city', 'LIKE', "%{$searchTerm}%")
                  ->orWhere('full_address', 'LIKE', "%{$searchTerm}%")
                  ->orWhere('tracking_id', 'LIKE', "%{$searchTerm}%")
                  ->orWhere('id', 'LIKE', "%{$searchTerm}%")
                  ->orWhere('remarks', 'LIKE', "%{$searchTerm}%");
            });
        }
        
        // Handle combined status and fees filter
        if ($request->filled('status_filter')) {
            $filterValue = $request->get('status_filter');
            
            if ($filterValue === 'fees_paid') {
                $query->where('fees_paid', true);
            } elseif ($filterValue === 'fees_not_paid') {
                $query->where('fees_paid', false);
            } else {
                // Regular status filter
                $query->where('status', $filterValue);
            }
        }
        
        // Handle date range filter
        if ($request->filled('date_from')) {
            $query->whereDate('created_at', '>=', $request->get('date_from'));
        }
        
        if ($request->filled('date_to')) {
            $query->whereDate('created_at', '<=', $request->get('date_to'));
        }
        
        $orders = $query->latest()->get();
        $searchTerm = $request->get('search');
        $statusFilter = $request->get('status_filter');
        $dateFrom = $request->get('date_from');
        $dateTo = $request->get('date_to');
        
        return view('admin.dashboard', compact('orders', 'searchTerm', 'statusFilter', 'dateFrom', 'dateTo'));
    }

    public function showLogin()
    {
        return view('admin.login');
    }

    public function login(Request $request)
    {
        $request->validate([
            'email' => 'required|email',
            'password' => 'required'
        ]);

        // Attempt to authenticate user
        if (Auth::attempt($request->only('email', 'password'), true)) { // true = remember me
            $user = Auth::user();
            
            // Check if user is admin
            if (!$user->isAdmin()) {
                Auth::logout();
                return back()->withErrors(['You do not have admin privileges']);
            }

            // Set admin session data
            session([
                'admin_login_time' => now(),
                'admin_last_activity' => now()
            ]);
            
            // Extend session lifetime for admin users (30 days)
            config(['session.lifetime' => 43200]);
            
            return redirect()->route('admin.dashboard')->with('success', 'Welcome back, ' . $user->name . '!');
        }

        return back()->withErrors(['Invalid email or password']);
    }

    public function logout()
    {
        Auth::logout();
        session()->invalidate();
        session()->regenerateToken();
        
        return redirect()->route('admin.login')->with('success', 'You have been logged out successfully');
    }

    public function markCompleted(Request $request)
    {
        // Authentication handled by AdminAuth middleware
        
        $request->validate([
            'order_ids' => 'required|array',
            'order_ids.*' => 'exists:orders,id'
        ]);

        Order::whereIn('id', $request->order_ids)->update(['is_completed' => true]);

        return redirect()->route('admin.dashboard')->with('success', 'Selected orders marked as completed!');
    }

    public function printInvoices(Request $request)
    {
        // Authentication handled by AdminAuth middleware
        
        $request->validate([
            'order_ids' => 'required|array',
            'order_ids.*' => 'exists:orders,id'
        ]);

        $orders = Order::whereIn('id', $request->order_ids)->get();

        return view('admin.print-invoices', compact('orders'));
    }

    public function updateStatus(Request $request)
    {
        // Authentication handled by AdminAuth middleware
        
        $request->validate([
            'order_ids' => 'required|array',
            'order_ids.*' => 'exists:orders,id',
            'status' => 'required|in:pending,printing,packaging,dispatched,completed'
        ]);

        // If status is dispatched, show tracking ID modal
        if ($request->status === 'dispatched') {
            $orders = Order::whereIn('id', $request->order_ids)->get();
            return view('admin.tracking-modal', compact('orders', 'request'));
        }

        Order::whereIn('id', $request->order_ids)->update(['status' => $request->status]);

        // Also update is_completed field for backward compatibility
        if ($request->status === 'completed') {
            Order::whereIn('id', $request->order_ids)->update(['is_completed' => true]);
        } else {
            Order::whereIn('id', $request->order_ids)->update(['is_completed' => false]);
        }

        $statusLabel = Order::getStatusOptions()[$request->status];
        $count = count($request->order_ids);

        return redirect()->route('admin.dashboard')->with('success', "{$count} order(s) status updated to {$statusLabel}!");
    }

    public function updateTrackingIds(Request $request)
    {
        // Authentication handled by AdminAuth middleware
        
        $request->validate([
            'order_ids' => 'required|array',
            'order_ids.*' => 'exists:orders,id',
            'tracking_ids' => 'required|array',
            'tracking_ids.*' => 'required|string|max:255'
        ]);

        foreach ($request->order_ids as $index => $orderId) {
            Order::where('id', $orderId)->update([
                'status' => 'dispatched',
                'tracking_id' => $request->tracking_ids[$index],
                'is_completed' => false
            ]);
        }

        $count = count($request->order_ids);
        return redirect()->route('admin.dashboard')->with('success', "{$count} order(s) marked as dispatched with tracking IDs!");
    }

    public function deleteOrders(Request $request)
    {
        // Authentication handled by AdminAuth middleware
        
        $request->validate([
            'order_ids' => 'required|array',
            'order_ids.*' => 'exists:orders,id'
        ]);

        // Delete the selected orders
        $deletedCount = Order::whereIn('id', $request->order_ids)->delete();

        return redirect()->route('admin.dashboard')->with('success', "{$deletedCount} order(s) deleted successfully!");
    }

    public function updateOrder(Request $request, Order $order)
    {
        // Authentication handled by AdminAuth middleware
        
        $request->validate([
            'name' => 'required|string|max:255',
            'email' => 'nullable|email|max:255',
            'phone_number' => 'required|string|max:20',
            'secondary_phone_number' => 'nullable|string|max:20',
            'full_address' => 'required|string',
            'city' => 'required|string|max:255',
            'country' => 'required|string|max:255',
            'semesters' => 'required|string',
            'remarks' => 'nullable|string',
            'status' => 'required|in:pending,printing,packaging,dispatched,completed,cancelled',
            'tracking_id' => 'nullable|string|max:255',
            'fees_paid' => 'required|boolean'
        ]);

        // Process semesters - convert comma-separated string to array
        $semesters = array_map('trim', explode(',', $request->semesters));
        $semesters = array_filter($semesters); // Remove empty values

        // Update the order
        $order->update([
            'name' => $request->name,
            'email' => $request->email,
            'phone_number' => $request->phone_number,
            'secondary_phone_number' => $request->secondary_phone_number,
            'full_address' => $request->full_address,
            'city' => $request->city,
            'country' => $request->country,
            'semesters' => $semesters,
            'remarks' => $request->remarks,
            'status' => $request->status,
            'tracking_id' => $request->tracking_id,
            'fees_paid' => $request->boolean('fees_paid'),
            'is_completed' => $request->status === 'completed'
        ]);

        return redirect()->route('admin.dashboard')->with('success', "Order #{$order->id} updated successfully!");
    }
}
