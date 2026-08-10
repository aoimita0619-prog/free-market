<?php

namespace Database\Seeders;

use App\Models\Category;
use Illuminate\Database\Seeder;
use Illuminate\Support\Facades\DB;

class CategorySeeder extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {
         DB::table('categories')->insert([
            ['content' => 'ファッション'],
            ['content' => '家電'],
            ['content' => 'インテリア'],
            ['content' => 'レディース'],
            ['content' => 'コスメ'],
            ['content' => 'メンズ'],
            ['content' => '本'],
            ['content' => 'ゲーム'],
            ['content' => 'スポーツ'],
            ['content' => 'キッチン'],
            ['content' => 'ハンドメイド'],
            ['content' => 'アクセサリー'],
            ['content' => 'おもちゃ'],
            ['content' => 'ベビー・キッズ'],
         ]);

      
    }
    
}
