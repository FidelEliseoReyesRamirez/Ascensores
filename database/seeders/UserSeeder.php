<?php

namespace Database\Seeders;

use Illuminate\Database\Seeder;
use App\Models\User;
use Illuminate\Support\Facades\Hash;

class UserSeeder extends Seeder
{
    /**
     * Run the database seeds.
     */
    public function run(): void
    {
        User::create([
            'name' => 'Usuario Admin',
            'email' => 'fidelrey000@gmail.com',
            'password' => Hash::make('Litoral1352Mora#'),
            'bloqueado'  => false,
            'eliminado'  => false,
        ]);
    }
}
