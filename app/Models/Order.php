<?php
namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use App\Models\Order;  // Add this import
class Order extends Model
{
    
    use HasFactory;
    protected $model = Order::class;  // Add this line to specify the model
    protected $fillable = [
        'buyer_id',
        'order_number',
        'total_amount',
        'status',
        'payment_status',
        'shipping_address',
        'billing_address'
    ];

    public function buyer()
    {
        return $this->belongsTo(User::class, 'buyer_id');
    }

    public function items()
    {
        return $this->hasMany(OrderItem::class);
    }

    protected static function boot()
    {
        parent::boot();
        
        static::creating(function ($order) {
            $order->order_number = 'ORD-' . now()->format('Ymd') . '-' . strtoupper(uniqid());
        });
    }
}