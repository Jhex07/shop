<?php

namespace Database\Seeders;

// use Illuminate\Database\Console\Seeds\WithoutModelEvents;
use App\Models\User;
use App\Models\Product;
use Illuminate\Database\Seeder;
use Database\Seeders\UserSeeder;

class DatabaseSeeder extends Seeder
{

    public function run()
    {
        $this->call(UserSeeder::class);
        $this->call(CategorySeeder::class);

        Product::factory(30)->create();
        User::factory(10)->create();
    }
}
