<?php
namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Factories\HasFactory;

class Produce extends Model
{
    use HasFactory;

   protected $fillable = [
    'user_id',
    'name',
    'category_id',
    'location',
    'farm_name',
    'description',
    'price',
    'original_price',
    'discount',
    'organic',
    'quantity',
    'image_path',
    'unit', // Add this
];

// app/Models/Produce.php
protected $table = 'produce';
public function category()
{
    return $this->belongsTo(Category::class);
}
    public function user() { return $this->belongsTo(User::class); }
    public function orders() { return $this->hasMany(Order::class); }
    public function ratings() { return $this->hasMany(Rating::class); }
}
