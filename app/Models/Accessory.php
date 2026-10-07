<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class Accessory extends Model
{
    protected $fillable = [
        'catalog_key',
        'name',
        'category',
        'description',
        'price',
        'stock',
    ];
}
