<?php

use Illuminate\Database\Seeder;

class DatabaseSeeder extends Seeder
{
    /**
     * Seed the application's database.
     *
     * @return void
     */
    public function run()
    {
        \App\Product::create([
            'name' => 'Feijão',
            'category' => 'Alimentos',
            'description' => 'Fradinho tipo D',
            'brand' => 'Tio Minhoto',
            'amount' => '12',
            'price' => 4.82,
            'sale' => false,
            'image' => null
        ]);
    }
}
