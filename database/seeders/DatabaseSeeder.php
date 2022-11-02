<?php

namespace Database\Seeders;

use App\Models\User;
use Ramsey\Uuid\Uuid;
use Illuminate\Database\Seeder;
use Illuminate\Support\Facades\Hash;
use Illuminate\Database\Console\Seeds\WithoutModelEvents;

class DatabaseSeeder extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {
        // $this->call('UsersTableSeeder');
        User::create([
            'id' => (string) Uuid::uuid4(),
            'first_name' => 'Admin',
            'last_name' => 'admin',
            'phone_number' => '8746666777',
            'address' => 'kantor',
            'username' => 'admin',
            'email' => 'admin@gmail.com',
            'password' => Hash::make('admin'),
            'role' => 'admin'
        ]);

        User::create([
            'id' => (string) Uuid::uuid4(),
            'first_name' => 'John',
            'last_name' => 'Doe',
            'phone_number' => '87494573723',
            'address' => 'griya peson praja',
            'username' => 'johndoe',
            'email' => 'johndoe@gmail.com',
            'password' => Hash::make('john'),
            'role' => 'seller'
        ]);

        User::create([
            'id' => (string) Uuid::uuid4(),
            'first_name' => 'Jane',
            'last_name' => 'Doe',
            'phone_number' => '874945737345',
            'address' => 'griya pesona praja',
            'username' => 'janedoe',
            'email' => 'janedoe@gmail.com',
            'password' => Hash::make('jane'),
            'role' => 'buyer'
        ]);
    }
}
