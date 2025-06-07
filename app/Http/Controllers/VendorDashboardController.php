<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use App\Models\FoodItem;
use App\Models\User; // Import the User model

class VendorDashboardController extends Controller
{
    public function index()
    {
        $vendorId = Auth::id();
        $foodItems = FoodItem::where('vendor_id', $vendorId)
                             ->with('claimedByRecipient') // Eager load the recipient
                             ->orderBy('created_at', 'desc')
                             ->paginate(10); 

        return view('vendor.dashboard', compact('foodItems'));
    }

    /**
     * Show the public profile of a recipient.
     */
    public function showRecipientProfile(User $recipient)
    {
        // Ensure the user being viewed is a recipient
        if ($recipient->role !== 'recipient') {
            abort(404, 'User is not a recipient.');
        }

        return view('vendor.recipients.show', compact('recipient'));
    }
}
