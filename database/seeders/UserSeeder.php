<?php

namespace Database\Seeders;

use App\Models\User;
use Illuminate\Support\Str;
use Illuminate\Database\Seeder;
use Illuminate\Database\Console\Seeds\WithoutModelEvents;

class UserSeeder extends Seeder
{

    public function run()
    {
        User::create([
            'number_id' => '1193099858',
            'name' => 'Jhon',
            'last_name' => 'Montes',
            'email' => 'jhonalejandro25montes@gmail.com',
            'password' => bcrypt(123456789),
            'remember_token' => Str::random(10),
        ]);
    }
}
