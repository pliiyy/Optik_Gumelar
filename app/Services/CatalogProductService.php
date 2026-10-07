<?php

namespace App\Services;

use App\Models\Accessory;
use App\Models\Frame;
use App\Models\Lens;
use Illuminate\Database\Eloquent\Model;

class CatalogProductService
{
    public function ensureExists(array $item): Model
    {
        $modelClass = match ($item['product_type']) {
            'lens' => Lens::class,
            'frame' => Frame::class,
            'accessory' => Accessory::class,
        };

        $product = $modelClass::query()
            ->where('catalog_key', $item['product_key'])
            ->first();

        if (! $product) {
            $product = $modelClass::query()
                ->where('name', $item['name'])
                ->where('category', $item['category'])
                ->first();
        }

        if ($product) {
            if (! $product->catalog_key) {
                $product->catalog_key = $item['product_key'];
                $product->save();
            }

            return $product;
        }

        return $modelClass::firstOrCreate(
            ['catalog_key' => $item['product_key']],
            [
                'name' => $item['name'],
                'category' => $item['category'],
                'description' => null,
                'price' => $item['price'],
                'stock' => 0,
            ]
        );
    }
}
