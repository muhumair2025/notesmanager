<?php

namespace App\Http\Controllers;

use App\Models\Order;
use Illuminate\Http\Request;

class UserController extends Controller
{
    public function index()
    {
        return view('user.order-form');
    }

    public function store(Request $request)
    {
        $request->validate([
            'name' => 'required|string|max:255',
            'phone_number' => 'required|string|max:20',
            'secondary_phone_number' => 'nullable|string|max:20',
            'full_address' => 'required|string',
            'city' => 'required|string|max:255',
            'country' => 'required|string|max:255',
            'semesters' => 'required|array|min:1',
            'semesters.*' => 'in:Semester 1,Semester 2,Semester 3,Semester 4,Semester 5,Semester 6,Semester 7',
            'remarks' => 'nullable|string',
            'fees_paid' => 'required|in:0,1'
        ]);

        $order = Order::create([
            'name' => $request->name,
            'phone_number' => $request->phone_number,
            'secondary_phone_number' => $request->secondary_phone_number,
            'full_address' => $request->full_address,
            'city' => $request->city,
            'country' => $request->country,
            'semesters' => $request->semesters,
            'remarks' => $request->remarks,
            'fees_paid' => $request->fees_paid == '1'
        ]);

        return redirect()->route('user.order-form')->with([
            'success' => 'Shukria, Ap Ka Form Kamyabi Sy Fill Ho Gia Hai, Ab Aap Kuch Din ( 1 sy 3 Hafty) Wait Karyn, Jald Hee Notes Print Ho Kar Apko Ponch Jayengy, Apna Dia Gia Number Open Rakhyn, Aor Active, Kionky Baz Dafa Post Office Waly Call Na Othany Ki Surat Me Notes Wapis Hamy Bhej Dety Hen.',
            'order_id' => $order->id,
            'show_track_button' => true
        ]);
    }
}
