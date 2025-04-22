<?php
namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Factories\HasFactory;

class Produce extends Model
{
    use HasFactory;

    protected $fillable = [
        'user_id','category_id', 'name', 'price', 'quantity', 'image_path'
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
