<?php

namespace App\Http\Controllers;

use App\Models\FoodItem;
use App\Models\User;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Gate;

class AdminDashboardController extends Controller
{
    /**
     * Display the admin dashboard with statistics.
     */
    public function index()
    {
        if (! Gate::allows('access-admin')) {
            abort(403);
        }

        $stats = [
            'total_users' => User::count(),
            'total_vendors' => User::where('role', 'vendor')->count(),
            'total_recipients' => User::where('role', 'recipient')->count(),
            'total_food_items' => FoodItem::count(),
            'available_items' => FoodItem::where('status', 'available')->count(),
            'claimed_items' => FoodItem::where('status', 'claimed')->count(),
        ];

        return view('admin.dashboard', compact('stats'));
    }

    /**
     * Display a listing of all users.
     */
    public function manageUsers()
    {
        if (! Gate::allows('access-admin')) {
            abort(403);
        }

        $users = User::orderBy('created_at', 'desc')->paginate(15);
        return view('admin.users.index', compact('users'));
    }

    /**
     * Show the profile for the specified user.
     */
    public function showUserProfile(User $user)
    {
        if (! Gate::allows('access-admin')) {
            abort(403);
        }
        return view('admin.users.profile', compact('user'));
    }

    /**
     * Show the form for editing the specified user.
     */
    public function editUser(User $user)
    {
        if (! Gate::allows('access-admin')) {
            abort(403);
        }
        return view('admin.users.edit', compact('user'));
    }

    /**
     * Update the specified user in storage.
     */
    public function updateUser(Request $request, User $user)
    {
        if (! Gate::allows('access-admin')) {
            abort(403);
        }

        $request->validate([
            'name' => 'required|string|max:255',
            'email' => 'required|string|email|max:255|unique:users,email,' . $user->id,
            'role' => 'required|in:vendor,recipient,admin',
            'shop_name' => 'nullable|string|max:255',
            'address' => 'nullable|string',
            'phone_number' => 'nullable|string|max:20',
        ]);

        $user->update($request->all());

        return redirect()->route('admin.users.index')->with('success', 'User updated successfully.');
    }

    /**
     * Remove the specified user from storage.
     */
    public function destroyUser(User $user)
    {
        if (! Gate::allows('access-admin')) {
            abort(403);
        }
        $user->delete();
        return redirect()->route('admin.users.index')->with('success', 'User deleted successfully.');
    }

    /**
     * Display a listing of all food items.
     */
    public function manageFoodItems()
    {
        if (! Gate::allows('access-admin')) {
            abort(403);
        }

        $foodItems = FoodItem::with('vendor', 'claimedByRecipient')->orderBy('created_at', 'desc')->paginate(15);
        return view('admin.food-items.index', compact('foodItems'));
    }

    /**
     * Remove the specified food item from storage.
     */
    public function destroyFoodItem(FoodItem $foodItem)
    {
        if (! Gate::allows('access-admin')) {
            abort(403);
        }
        $foodItem->delete();
        return redirect()->route('admin.food-items.index')->with('success', 'Food item deleted successfully.');
    }
}
