<?php

namespace Database\Seeders;

use Illuminate\Database\Console\Seeds\WithoutModelEvents;
use Illuminate\Database\Seeder;
use App\Models\User;
use Spatie\Permission\Models\Role;
use Illuminate\Support\Facades\Hash;

class UserSeeder extends Seeder
{
    /**
     * Run the database seeds.
     */
    public function run(): void
    {

        Role::firstOrCreate(['name' => 'manager']);
        Role::firstOrCreate(['name' => 'user']);

        // managers
        $manager = User::create([
            'name' => 'Ahmed Manager',
            'email' => 'ahmed.manager@example.com',
            'password' => Hash::make('password'),
        ]);

        $manager->assignRole('manager');

        // users
        $user1 = User::create([
            'name' => 'Ahmed User',
            'email' => 'ahmed.user@example.com',
            'password' => Hash::make('password'),
        ]);

        $user2 = User::create([
            'name' => 'Omar User',
            'email' => 'omar.user@example.com',
            'password' => Hash::make('password'),
        ]);

        $user1->assignRole('user');
        $user2->assignRole('user');
    }
}
