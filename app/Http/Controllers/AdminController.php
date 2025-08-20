<?php

namespace App\Http\Controllers;

use App\Models\Order;
use Illuminate\Http\Request;

class AdminController extends Controller
{
    public function index(Request $request)
    {
        // Simple authentication check
        if (!session('admin_authenticated')) {
            return redirect()->route('admin.login');
        }
        
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
        
        // Handle status filter
        if ($request->filled('status_filter')) {
            $query->where('status', $request->get('status_filter'));
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

        // Simple hardcoded authentication
        if ($request->email === 'ssatechs1220@gmail.com' && $request->password === 'ssatechs1220') {
            session(['admin_authenticated' => true]);
            return redirect()->route('admin.dashboard');
        }

        return back()->withErrors(['Invalid credentials']);
    }

    public function logout()
    {
        session()->forget('admin_authenticated');
        return redirect()->route('admin.login');
    }

    public function markCompleted(Request $request)
    {
        $request->validate([
            'order_ids' => 'required|array',
            'order_ids.*' => 'exists:orders,id'
        ]);

        Order::whereIn('id', $request->order_ids)->update(['is_completed' => true]);

        return redirect()->route('admin.dashboard')->with('success', 'Selected orders marked as completed!');
    }

    public function printInvoices(Request $request)
    {
        $request->validate([
            'order_ids' => 'required|array',
            'order_ids.*' => 'exists:orders,id'
        ]);

        $orders = Order::whereIn('id', $request->order_ids)->get();

        return view('admin.print-invoices', compact('orders'));
    }

    public function updateStatus(Request $request)
    {
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
}
