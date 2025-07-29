<?php

namespace Database\Seeders;

use App\Models\User;
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

        User::truncate();
        User::insert([
            [
                'first_name' => 'Ryan Vergel',
                'last_name' => 'Hojilla',
                'email' => 'yanz.sytian@gmail.com',
                'password' => Hash::make('admin123'),
                'type' => User::TYPE_ADMIN,
                'created_by' => '1'
            ],
            [
                'first_name' => 'King Bon',
                'last_name' => 'Racimo',
                'email' => 'pay.sytian@gmail.com',
                'password' => Hash::make('admin123'),
                'type' => User::TYPE_ADMIN,
                'created_by' => '1'
            ],
            [
                'first_name' => 'Kits',
                'last_name' => 'Perez',
                'email' => 'pay.sytian@gmail.com',
                'password' => Hash::make('admin123'),
                'type' => User::TYPE_ADMIN,
                'created_by' => '1'
            ],
            [
                'first_name' => 'Barlaw Kenneth',
                'last_name' => 'Sytian',
                'email' => 'kenneth@sytian-productions.com',
                'password' => Hash::make('admin123'),
                'type' => User::TYPE_ADMIN,
                'created_by' => '1'
            ],
            [
                'first_name' => 'Rona Faye',
                'last_name' => 'Agaton',
                'email' => 'pay.sytian@gmail.com',
                'password' => Hash::make('admin123'),
                'type' => User::TYPE_ADMIN,
                'created_by' => '1'
            ],
            [
                'first_name' => 'Regular',
                'last_name' => 'Admin',
                'email' => 'regular.sytian@gmail.com',
                'password' => Hash::make('admin123'),
                'type' => User::TYPE_REGULAR_ADMIN,
                'created_by' => '1'
            ]
        ]);
    }
}
