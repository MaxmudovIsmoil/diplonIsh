<?php

namespace Database\Seeders;

use Illuminate\Database\Console\Seeds\WithoutModelEvents;
use Illuminate\Database\Seeder;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Hash;

class UserSeeder extends Seeder
{
    /**
     * Run the database seeds.
     */
    public function run(): void
    {
        DB::table('users')->insert([
            [
                "name" => 'Administrator',
                "phone" => '911234567',
                "username" => 'admin',
                "photo" => 'Admin.png',
                "rule" => 1,
                "password" => Hash::make(123),
            ],
            [
                "name" => 'Maxmudov Yaxyobek',
                "phone" => '911234567',
                "username" => 'yaxyo',
                'photo' => "",
                "rule" => '2',
                "password" => Hash::make(123),
            ],
            [
                "name" => 'Aliyev Olimjon',
                "phone" => '911234567',
                "username" => 'olim',
                'photo' => "",
                "rule" => '3',
                "password" => Hash::make(123),
            ]
        ]);
    }
}
