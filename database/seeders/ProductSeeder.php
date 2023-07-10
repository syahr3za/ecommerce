<?php

namespace Database\Seeders;

use Illuminate\Database\Seeder;
use App\Models\Product;
use Illuminate\Support\Str;

class ProductSeeder extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {
        for ($i = 1; $i <= 12; $i++) {
            Product::create([
                'category_id' => rand(1, 3),
                'subcategory_id' => rand(1, 4),
                'product_name' => 'Lorem Ipsum Dolor Sit Amet',
                'price' => rand(1000, 100000),
                'discount' => 0,
                'material' => 'Lorem Ipsum Dolor',
                'tags' => 'Lorem,Ipsum,Dolor,Sit,Amet',
                'sku' => Str::random(8),
                'size' => 'S,M,L,XL',
                'color' => 'Hitam,Biru,Kuning,Putih,Hijau',
                'image' => 'shop_item_' . $i . '.jpg',
                'description' => 'Lorem Ipsum Dolor Sit Amet'
            ]);
        }
    }
}
