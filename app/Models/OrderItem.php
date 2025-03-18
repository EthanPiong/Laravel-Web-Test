<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class OrderItem extends Model
{
    protected $fillable = [ 'order_id', 'menu_item_id', 'quantity', 'price_per_unit', 
        'subtotal', 'special_instructions'];
    
    public function order()
    {
        return $this->belongsTo(Order::class);
    }

    public function menuItem()
    {
        return $this->belongsTo(MenuItem::class);
    }

    public static function boot()
    {
        parent::boot();
        static::creating(function ($orderItem) {
            $orderItem->subtotal = $orderItem->quantity * $orderItem->price_per_unit;
        });
    }
}

