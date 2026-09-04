<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class Lens extends Model
{
    protected $fillable = [
        'name',
        'category',
        'description',
        'price',
        'stock',
    ];
}
