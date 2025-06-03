<?php

namespace App\Http\Controllers;

use App\Models\FoodItem;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Storage; // If handling image uploads

class FoodItemController extends Controller
{
    /**
     * Display a listing of the resource for the vendor.
     */
    public function index()
    {
        // This is typically handled by VendorDashboardController,
        // but if you want a dedicated route for /vendor/food-items
        $vendorId = Auth::id();
        $foodItems = FoodItem::where('vendor_id', $vendorId)
                             ->orderBy('created_at', 'desc')
                             ->paginate(10);
        return view('vendor.food-items.index', compact('foodItems'));
    }

    /**
     * Show the form for creating a new resource.
     */
    public function create()
    {
        return view('vendor.food-items.create');
    }

    /**
     * Store a newly created resource in storage.
     */
    public function store(Request $request)
    {
        $request->validate([
            'name' => 'required|string|max:255',
            'description' => 'nullable|string',
            'quantity' => 'required|string|max:100',
            'pickup_location' => 'required|string',
            'pickup_start_time' => 'required|date|after_or_equal:now',
            'pickup_end_time' => 'required|date|after:pickup_start_time',
            'image' => 'nullable|image|mimes:jpeg,png,jpg,gif,svg|max:2048', // Optional image upload
        ]);

        $data = $request->all();
        $data['vendor_id'] = Auth::id();
        $data['status'] = 'available';

        if ($request->hasFile('image')) {
            $path = $request->file('image')->store('food_items_images', 'public');
            $data['image_url'] = Storage::url($path); // Store the public URL
        }

        FoodItem::create($data);

        return redirect()->route('vendor.dashboard')->with('success', 'Food item listed successfully!');
    }


    /**
     * Show the form for editing the specified resource.
     */
    public function edit(FoodItem $foodItem)
    {
        // Authorization: Ensure the vendor owns this food item
        if ($foodItem->vendor_id !== Auth::id()) {
            return redirect()->route('vendor.dashboard')->with('error', 'Unauthorized action.');
        }
        return view('vendor.food-items.edit', compact('foodItem'));
    }

    /**
     * Update the specified resource in storage.
     */
    public function update(Request $request, FoodItem $foodItem)
    {
        // Authorization: Ensure the vendor owns this food item
        if ($foodItem->vendor_id !== Auth::id()) {
            return redirect()->route('vendor.dashboard')->with('error', 'Unauthorized action.');
        }

        $request->validate([
            'name' => 'required|string|max:255',
            'description' => 'nullable|string',
            'quantity' => 'required|string|max:100',
            'pickup_location' => 'required|string',
            'pickup_start_time' => 'required|date',
            'pickup_end_time' => 'required|date|after:pickup_start_time',
            'status' => 'sometimes|required|in:available,unavailable', // Vendor can only set these initially
            'image' => 'nullable|image|mimes:jpeg,png,jpg,gif,svg|max:2048',
        ]);

        $data = $request->except(['_token', '_method', 'image']); // Exclude token, method, and image for now

        if ($request->hasFile('image')) {
            // Delete old image if exists
            if ($foodItem->image_url) {
                $oldImagePath = str_replace(Storage::url(''), '', $foodItem->image_url);
                if (Storage::disk('public')->exists($oldImagePath)) {
                    Storage::disk('public')->delete($oldImagePath);
                }
            }
            $path = $request->file('image')->store('food_items_images', 'public');
            $data['image_url'] = Storage::url($path);
        }


        $foodItem->update($data);

        return redirect()->route('vendor.dashboard')->with('success', 'Food item updated successfully!');
    }

    /**
     * Remove the specified resource from storage.
     */
    public function destroy(FoodItem $foodItem)
    {
        // Authorization: Ensure the vendor owns this food item
        if ($foodItem->vendor_id !== Auth::id()) {
            return redirect()->route('vendor.dashboard')->with('error', 'Unauthorized action.');
        }

        // Delete image if exists
        if ($foodItem->image_url) {
            $imagePath = str_replace(Storage::url(''), '', $foodItem->image_url);
            if (Storage::disk('public')->exists($imagePath)) {
                Storage::disk('public')->delete($imagePath);
            }
        }

        $foodItem->delete();
        return redirect()->route('vendor.dashboard')->with('success', 'Food item deleted successfully!');
    }

    /**
     * Vendor updates the status of their food item (e.g., to completed, unavailable).
     */
    public function updateStatus(Request $request, FoodItem $foodItem)
    {
        // Authorization: Ensure the vendor owns this food item
        if ($foodItem->vendor_id !== Auth::id()) {
            return redirect()->route('vendor.dashboard')->with('error', 'Unauthorized action.');
        }

        $request->validate([
            'status' => 'required|in:available,unavailable,completed,expired',
        ]);

        // If marking as 'available', ensure it's not already claimed by someone else
        if ($request->status === 'available' && $foodItem->status === 'claimed') {
             return redirect()->back()->with('error', 'Cannot mark as available. Item is already claimed.');
        }

        $foodItem->status = $request->status;
        // If completed, it implies it was claimed. If unavailable/expired, clear claimant.
        if (in_array($request->status, ['unavailable', 'expired'])) {
            $foodItem->claimed_by_recipient_id = null;
        }
        $foodItem->save();

        return redirect()->route('vendor.dashboard')->with('success', 'Food item status updated.');
    }


    // --- Methods for Recipients ---

    /**
     * Display the specified resource for a recipient.
     */
    public function showRecipientView(FoodItem $foodItem)
    {
        // Ensure item is available or if claimed by current user
        if ($foodItem->status !== 'available' && $foodItem->claimed_by_recipient_id !== Auth::id()) {
             // If item is claimed by someone else, or not available, don't show details broadly
             if ($foodItem->claimed_by_recipient_id !== null && $foodItem->claimed_by_recipient_id !== Auth::id()){
                return redirect()->route('recipient.dashboard')->with('error', 'Item is already claimed by someone else or no longer available.');
             }
             if ($foodItem->status !== 'claimed') { // e.g. completed, expired
                return redirect()->route('recipient.dashboard')->with('error', 'Item is no longer available.');
             }
        }
        if ($foodItem->pickup_end_time < now() && $foodItem->status === 'available') {
             // Optionally mark as expired here or via a scheduled task
             // $foodItem->update(['status' => 'expired']);
             // return redirect()->route('recipient.dashboard')->with('error', 'This food item listing has expired.');
        }

        return view('recipient.food-items.show', compact('foodItem'));
    }

    /**
     * Allow a recipient to claim a food item.
     */
    public function claim(Request $request, FoodItem $foodItem)
    {
        if ($foodItem->status !== 'available') {
            return redirect()->back()->with('error', 'This item is no longer available or already claimed.');
        }
        if ($foodItem->pickup_end_time < now()) {
            // Optionally mark as expired
            // $foodItem->update(['status' => 'expired']);
            return redirect()->back()->with('error', 'This food item listing has expired and cannot be claimed.');
        }

        $foodItem->status = 'claimed';
        $foodItem->claimed_by_recipient_id = Auth::id();
        $foodItem->save();

        // TODO: Add notification to vendor (e.g., email, in-app notification)

        return redirect()->route('recipient.my-claims')->with('success', 'Food item claimed successfully! Please arrange pickup.');
    }
}