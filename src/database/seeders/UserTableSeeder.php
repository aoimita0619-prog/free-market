<?php

namespace Database\Seeders;

use Illuminate\Database\Seeder;
use App\Models\User;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Hash;

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
            ['name' => 'テストユーザー',
             'email' => 'test@example.com',
             'email_verified_at' => now(),
             'password' => Hash::make('password'),
             'post_code' => '111-1111',
             'address' => '東京都新宿区西新宿1-1-1',
             'building' => 'テストビル101',
            ],
            ['name' => '山田太郎',
             'email' => 'user@example.com',
             'email_verified_at' => now(),
             'password' => Hash::make('password'),
             'post_code' => '222-2222',
             'address' => '大阪府堺市堺区2-2-2',
             'building' => '',
            ],
            ['name' => '高橋花子',
             'email' => 'usera@example.com',
             'email_verified_at' => now(),
             'password' => Hash::make('password'),
             'post_code' => '333-3333',
             'address' => '愛知県名古屋市中区錦3-3',
             'building' => 'テストハウス303',
             ],
            ['name' => '田中次郎',
             'email' => 'userb@example.com',
             'email_verified_at' => now(),
             'password' => Hash::make('password'),
             'post_code' => '444-4444',
             'address' => '福岡県福岡市中央区天神44',
             'building' => '天神テストビル444',
             ],
     
         ]);

      
    }
    
}
