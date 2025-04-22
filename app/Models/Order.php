<?php
namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Factories\HasFactory;

class Order extends Model
{
    use HasFactory;

    protected $fillable = [
        'buyer_id', 'produce_id', 'quantity', 'status', 'delivery_status'
    ];

    public function buyer() { return $this->belongsTo(User::class, 'buyer_id'); }
    public function user()
    {
        return $this->belongsTo(User::class);
    }
    public function produce() { return $this->belongsTo(Produce::class); }
}
