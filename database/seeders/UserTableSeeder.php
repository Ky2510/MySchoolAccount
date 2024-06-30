<?php

namespace Database\Seeders;

use Illuminate\Database\Seeder;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Hash;
use Illuminate\Database\Console\Seeds\WithoutModelEvents;

class UserTableSeeder extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {
        DB::table('users')->insert([
            'name' => 'operator',
            'email' => 'operator1@contoh.com',
            'password' => Hash::make('operator'),
            'akses' => 'operator',
            'nohp' => '081234567890',
            'nohp_verified_at' => now(),
            'email_verified_at' => now(),
        ]);

        DB::table('users')->insert([
            'name' => 'budi wali',
            'email' => 'wali@contoh.com',
            'password' => Hash::make('wali'),
            'akses' => 'wali',
            'nohp' => '081234567890',
            'nohp_verified_at' => now(),
            'email_verified_at' => now(),
        ]);
    }
}
