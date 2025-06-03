<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use App\Models\FoodItem;

class VendorDashboardController extends Controller
{
    public function index()
    {
        $vendorId = Auth::id();
        $foodItems = FoodItem::where('vendor_id', $vendorId)
                             ->orderBy('created_at', 'desc')
                             ->paginate(10); // Paginate for better display

        return view('vendor.dashboard', compact('foodItems'));
    }
}