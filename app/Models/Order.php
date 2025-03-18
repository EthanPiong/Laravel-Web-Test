<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class Order extends Model
{
    protected $fillable = ['user_id', 'total_amount', 'status', 'payment_status', 
        'delivery_address', 'contact_phone'];
    
    public function user()
    {
        return $this->belongsTo(User::class);
    }

    public function items()
    {
        return $this->hasMany(OrderItem::class);
    }

    public function calculateTotal()
    {
        return $this->items->sum('subtotal');
    }

    public function updateStatus($status)
    {
        $this->status = $status;
        return $this->save();
    }
}
