<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\FoodItem;
use Illuminate\Support\Facades\Auth;

class RecipientDashboardController extends Controller
{
    public function index()
    {
        // Show items that are available and pickup time hasn't passed (or is within a reasonable window)
        $availableFoodItems = FoodItem::where('status', 'available')
                                      ->where('pickup_end_time', '>', now()) // Ensure pickup time hasn't fully passed
                                      ->orderBy('pickup_start_time', 'asc')
                                      ->paginate(10);

        return view('recipient.dashboard', compact('availableFoodItems'));
    }

    public function myClaims()
    {
        $recipientId = Auth::id();
        $claimedItems = FoodItem::where('claimed_by_recipient_id', $recipientId)
                                ->whereIn('status', ['claimed', 'completed']) // Show items they claimed or completed pickup
                                ->orderBy('updated_at', 'desc')
                                ->paginate(10);
        return view('recipient.my-claims', compact('claimedItems'));
    }
}