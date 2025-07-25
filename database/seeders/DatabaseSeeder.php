<?php

namespace Database\Seeders;

use App\Models\User;
// use Illuminate\Database\Console\Seeds\WithoutModelEvents;
use Illuminate\Database\Seeder;
use Illuminate\Support\Facades\Hash;

class DatabaseSeeder extends Seeder
{
    /**
     * Seed the application's database.
     */
    public function run(): void
    {
        // User::factory(10)->create();


        User::factory()->create([
            'name' => 'Admin',
            'email' => 'admin@sistemasautomatizados.net',
            'password' =>Hash::make('Th3m0771205.L'),
            'active'=> "S",
            'role'=>1,
            'language'=>2,
            'status'=>1,
        ]);


    }
}
