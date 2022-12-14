<?php

namespace Database\Seeders;

use App\Models\Product;
use App\Models\ProductImage;
use Illuminate\Database\Console\Seeds\WithoutModelEvents;
use Illuminate\Database\Seeder;

class ProductImageSeeder extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {
        for ($i = 1; $i < 15; $i++) {
            $product = Product::factory()->create();
            $product->categories()->id=rand(1,3);
            ProductImage::factory(rand(1, 3))->create([
                'product_id' => $product->id,
            ]);
        }
    }
}
