<?php

namespace Database\Seeders;

use App\Models\Role;
use App\Models\User;
use Illuminate\Database\Console\Seeds\WithoutModelEvents;
use Illuminate\Database\Seeder;
use Illuminate\Support\Facades\Hash;

class AdminSeeder extends Seeder
{
    /**
     * Run the database seeds.
     */
    public function run(): void
    {  
        $admin =  User::create([
        'name' => 'admin',
        'email' => 'admin@gmail.com',
        'location' => 'Damascus',
        'phone' => '1234567890',
        'password' => Hash::make('12345678'),
    ]);
    $role = Role::where('name', 'admin')->first();
    $admin->addRole($role);

    }
}
