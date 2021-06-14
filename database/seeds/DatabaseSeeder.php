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
        \App\User::create([
            'name' => 'Mateus Durval',
            'email' => 'mateus@email.com',
            'cpf' => '863.243.165-05',
            'isAdmin' => true,
            'password' => bcrypt('10203040'),
        ]);

        \App\Category::create([
            'category' => 'Alimentos',
        ]);

        \App\Category::create([
            'category' => 'Limpeza',
        ]);

        \App\Category::create([
            'category' => 'Hortifruti',
        ]);

        \App\Category::create([
            'category' => 'Gourmet',
        ]);

        \App\Category::create([
            'category' => 'Bebida',
        ]);

        \App\Product::create([
            'name' => 'Açúcar',
            'brand' => 'União',
            'description' => 'Cristal',
            'amount' => '244',
            'price' => '4,37',
            'sale' => true,
            'image' => 'products/A1dJc11aebovOeMpVrcQjm7Z6JWs4Ce7LfAwHVRv.jpg'
        ]);

        \App\Product::create([
            'name' => 'Massa',
            'brand' => 'Talharim',
            'description' => 'Com ovos',
            'amount' => '167',
            'price' => '5,28',
            'sale' => true,
            'image' => 'products/GjtLGAHgSugEWIVsKVG5ReMetKw524XtY0iWkKHm.png'
        ]);

        \App\Product::create([
            'name' => 'Arroz',
            'brand' => 'Tio Urbano',
            'description' => 'Parboilizado - Tipo A',
            'amount' => '134',
            'price' => '4,14',
            'sale' => false,
            'image' => 'products/hXebFNa0cb8cnU7wZkQjZj8GXyNnupcLy6QDW0y3.jpg'
        ]);

        \App\Product::create([
            'name' => 'Massa',
            'brand' => 'Dona Benta',
            'description' => 'Seco instantâneo',
            'amount' => '87',
            'price' => '5,21',
            'sale' => true,
            'image' => 'products/HLNDGgJKpn7Fzlsp3jFS6RqTVArdaELpOFBfg2ha.jpg'
        ]);

        \App\Product::create([
            'name' => 'Sal',
            'brand' => 'Lebre',
            'description' => 'Refinado Iodado',
            'amount' => '144',
            'price' => '1,81',
            'sale' => false,
            'image' => 'products/yH0D4K7nxkq8wmHlh2DqBQz23srvsnzHbYe7pnjy.jpg'
        ]);

        \App\Product::create([
            'name' => 'Margarina',
            'brand' => 'Qualy',
            'description' => 'Cremosa, com sal',
            'amount' => '267',
            'price' => '3,89',
            'sale' => true,
            'image' => 'products/weGyhCCZqXLfaGntEpC2zcHCDVqGOeJg5GLObDwu.png'
        ]);

        \App\Product::create([
            'name' => 'Água Sanitário',
            'brand' => 'Qboa',
            'description' => 'Cloro Ativo',
            'amount' => '132',
            'price' => '3,67',
            'sale' => false,
            'image' => 'products/8UAwEmbDjniRfpoItPPizOpSAdXTIurzjPeXux8Q.png'
        ]);
    }
}
