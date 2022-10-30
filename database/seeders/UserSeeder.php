<?php

namespace Database\Seeders;

use Illuminate\Support\Facades\DB;
use Illuminate\Database\Seeder;
use Illuminate\Support\Facades\Hash;
use Illuminate\Support\Str;
use App\Models\User;

class UserSeeder extends Seeder {

    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run() {
        User::insert([
            'name' => 'admin',
            'email' => 'levitsky.v.n@gmail.com',
            'password' => Hash::make('1111'),
        ]);
        User::factory()
        ->count(5)->create();
    }

}
