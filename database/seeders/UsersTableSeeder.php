<?php

namespace Database\Seeders;

use Illuminate\Database\Seeder;
use App\Models\User;
use Illuminate\Support\Facades\Hash;
class UsersTableSeeder extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {
        $pass = '123456';
        $users = [
            [
                'name' => 'Andi Adinata',
                'email' => 'andi.adinata@example.com',
                'username' => 'andi.adinata',
                'password' => Hash::make($pass)
            ],
            [
                'name' => 'Bimo Satria',
                'email' => 'bimo.satria@example.com',
                'username' => 'bimo.satria',
                'password' => Hash::make($pass)
            ],
            [
                'name' => 'Caca Marica',
                'email' => 'cacaa@example.com',
                'username' => 'caca',
                'password' => Hash::make($pass)
            ],
            [
                'name' => 'Joko Anwar',
                'email' => 'joko@example.com',
                'username' => 'jowar',
                'password' => Hash::make($pass)
            ]
        ];

        foreach ($users as $user) {
            User::firstOrCreate($user);
        }
    }
}
