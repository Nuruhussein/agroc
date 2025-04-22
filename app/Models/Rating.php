<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Factories\HasFactory;

class Rating extends Model
{
    use HasFactory;

    protected $fillable = ['produce_id', 'buyer_id', 'stars', 'comment'];

    public function buyer() { return $this->belongsTo(User::class, 'buyer_id'); }
    public function produce() { return $this->belongsTo(Produce::class); }
}