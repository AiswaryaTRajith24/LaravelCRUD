<?php

namespace Database\Seeders;

use Illuminate\Database\Console\Seeds\WithoutModelEvents;
use Illuminate\Database\Seeder;
use App\Models\Products;

class ProductsTableSeeder extends Seeder
{
    /**
     * Run the database seeds.
     */
    public function run(): void
    {
        Products::create([
            'name' => 'MacBook Pro',
            'description' => 'Apple M2 chip with 16GB RAM and 512GB SSD.',
            'price' => 1999.99,
            'stock' => 10,
            'image' => 'assets/MacBookPro.jpg',
        ]);

        Products::create([
            'name' => 'Dell XPS 15',
            'description' => 'Intel Core i7, 16GB RAM, 1TB SSD, NVIDIA RTX 3050 Ti.',
            'price' => 1899.99,
            'stock' => 5,
            'image' => 'assets/Dell-XPS-15.jpg',
        ]);

        Products::create([
           'name' => 'iPhone 14 Pro',
            'description' => '6.1-inch Super Retina XDR display, A16 Bionic chip, 128GB storage.',
            'price' => 1099.99,
            'stock' => 20,
            'image' => 'assets/iPhone-14-Pro.jpg',
        ]);

        Products::create([
            'name' => 'Samsung Galaxy S23 Ultra',
            'description' => '6.8-inch QHD+ AMOLED, Snapdragon 8 Gen 2, 256GB storage.',
            'price' => 1199.99,
            'stock' => 18,
            'image' => 'assets/Samsung-Galaxy-S23-Ultra.jpg',
        ]);

        Products::create([
            'name' => 'Sony WH-1000XM5',
            'description' => 'Wireless noise-canceling headphones with 30-hour battery life.',
            'price' => 399.99,
            'stock' => 30,
            'image' => 'assets/Sony-WH-1000XM5.jpg',
        ]);

        Products::create([
            'name' => 'Apple iPad Pro 12.9"',
            'description' => 'M2 chip, 128GB storage, Liquid Retina XDR display.',
            'price' => 1199.99,
            'stock' => 12,
            'image' => 'assets/Apple-iPad-Pro-12.9.jpg',
        ]);
    }
}
