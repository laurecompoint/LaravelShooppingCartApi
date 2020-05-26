<?php

use Illuminate\Database\Seeder;
use App\Product;
use App\Cart;
class DatabaseSeeder extends Seeder
{
    /**
     * Seed the application's database.
     *
     * @return void
     */
    public function run()
    {
        // $this->call(UserSeeder::class);
        $faker = Faker\Factory::create('fr_FR');
        for ($i = 1; $i < 6; $i++) {
            $product = new Product;
            $product->name = $faker->realText(10);
            $product->description = $faker->realText(140);
            $product->price = $faker->numberBetween(1, 900);
            $product->save();
        }
        for ($i = 1; $i < 6; $i++) {
            $product = new Cart;
            $product->quantity = $faker->numberBetween(1, 1);
            $product->product_id = $i;
            $product->save();
        }
    }
}
