<?php

namespace App\Services;

use App\Models\Accessory;
use App\Models\Frame;
use App\Models\Lens;
use Illuminate\Database\Eloquent\Model;

class CatalogProductService
{
    public function seedDefaults(int $stock = 10): void
    {
        foreach (ProductCatalog::items() as $type => $products) {
            foreach ($products as $key => $product) {
                $modelClass = $this->modelFor($type);
                $existing = $modelClass::query()
                    ->where('catalog_key', $key)
                    ->first();

                if (! $existing) {
                    $existing = $modelClass::query()
                        ->where('name', $product['name'])
                        ->where('category', $product['category'])
                        ->first();
                }

                if ($existing) {
                    if (! $existing->catalog_key) {
                        $existing->catalog_key = $key;
                        $existing->save();
                    }

                    continue;
                }

                $modelClass::firstOrCreate(
                    ['catalog_key' => $key],
                    [
                        'name' => $product['name'],
                        'category' => $product['category'],
                        'description' => $product['description'],
                        'price' => $product['price'],
                        'stock' => $stock,
                    ]
                );
            }
        }
    }

    public function ensureExists(array $item): Model
    {
        $modelClass = $this->modelFor($item['product_type']);

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

    private function modelFor(string $type): string
    {
        return match ($type) {
            'lens' => Lens::class,
            'frame' => Frame::class,
            'accessory' => Accessory::class,
        };
    }
}
