<?php
namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use App\Models\OrderItem;  // Add this
class OrderItem extends Model
{
    use HasFactory;

    protected $fillable = [
        'order_id',
        'produce_id',
        'quantity',
        'unit_price',
        'total_price'
    ];
    protected $model = OrderItem::class;  // Add this
    public function order()
    {
        return $this->belongsTo(Order::class);
    }

    public function produce()
    {
        return $this->belongsTo(Produce::class);
    }
}