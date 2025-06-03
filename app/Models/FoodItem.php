<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class FoodItem extends Model
{
    use HasFactory;

    protected $fillable = [
        'vendor_id',
        'name',
        'description',
        'quantity',
        'pickup_location',
        'pickup_start_time',
        'pickup_end_time',
        'status', // 'available', 'claimed', 'completed', 'unavailable', 'expired'
        'claimed_by_recipient_id',
        'image_url', // Optional: path to an image for the food item
    ];

    protected $casts = [
        'pickup_start_time' => 'datetime',
        'pickup_end_time' => 'datetime',
    ];

    // Relationship: Belongs to a vendor
    public function vendor()
    {
        return $this->belongsTo(User::class, 'vendor_id');
    }

    // Relationship: Can be claimed by a recipient
    public function claimedByRecipient()
    {
        return $this->belongsTo(User::class, 'claimed_by_recipient_id');
    }
}