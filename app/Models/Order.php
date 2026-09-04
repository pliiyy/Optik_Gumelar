<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Order extends Model
{
    use HasFactory;

    protected $fillable = [
        'user_id',
        'product_type',
        'product_id',
        'quantity',
        'notes',
        'status',
        'total_price',
    ];

    public function user()
    {
        return $this->belongsTo(User::class);
    }

    public function lens()
    {
        return $this->belongsTo(Lens::class, 'product_id');
    }

    public function frame()
    {
        return $this->belongsTo(Frame::class, 'product_id');
    }
}
