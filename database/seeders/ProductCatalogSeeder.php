<?php

namespace Database\Seeders;

use App\Services\CatalogProductService;
use Illuminate\Database\Seeder;

class ProductCatalogSeeder extends Seeder
{
    public function run(CatalogProductService $catalogProducts): void
    {
        $catalogProducts->seedDefaults();
    }
}
