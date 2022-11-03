<?php

namespace Database\Seeders;

use App\Models\User;
use Illuminate\Database\Console\Seeds\WithoutModelEvents;
use Illuminate\Database\Seeder;
use Illuminate\Support\Facades\Hash;

class UserSeeder extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {
        User::create([
            'name' => 'Rena',
            'email' => 'rena.silver@bigtincan.com',
            'password' => Hash::make('password'),
            'is_admin' => 1,
        ]);

        User::factory()->create();
    }
}
