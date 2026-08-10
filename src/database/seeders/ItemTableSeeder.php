<?php

namespace Database\Seeders;
use Illuminate\Support\Facades\DB;

use App\Models\Item;
use Illuminate\Database\Seeder;

class ItemTableSeeder extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {
        DB::table('items')->insert([[
            'name' => '腕時計',
            'price' => '15000',
            'brand' =>'Rolax',
            'detail' => 'スタイリッシュなデザインのメンズ腕時計',
            'img' => 'img/clock.jpg',
            'condition_id' => '1',
            'user_id' => '1',
        ],
        [
            'name' => 'HDD',
            'price' => '5000',
            'brand' =>'西芝',
            'detail' => '高速で信頼性の高いハードディスク',
            'img' => 'img/harddisk.jpg',
            'condition_id' => '2',
            'user_id' => '2',
        ],
        [
            'name' => '玉ねぎ3束',
            'price' => '300',
            'brand' =>'なし',
            'detail' => '新鮮な玉ねぎ3束のセット',
            'img' => 'img/onion.jpg',
            'condition_id' => '3',
            'user_id' => '3',
        ],
        [
            'name' => '革靴',
            'price' => '4000',
            'brand' =>'なし',
            'detail' => 'クラシックなデザインの革靴',
            'img' => 'img/shoes.jpg',
            'condition_id' => '4',
            'user_id' => '4',
        ],
        [
            'name' => 'ノートPC',
            'price' => '45000',
            'bland' =>'なし',
            'detail' => '高性能なノートパソコン',
            'img' => 'img/laptop.jpg',
            'condition_id' => '1',
            'user_id' => '1',
        ],
        [
            'name' => 'マイク',
            'price' => '8000',
            'brand' =>'なし',
            'detail' => '高音質のレコーディング用マイク',
            'img' => 'img/mic.jpg',
            'condition_id' => '2',
            'user_id' => '2',
        ],
        [
            'name' => 'ショルダーバック',
            'price' => '3500',
            'brand' =>'なし',
            'detail' => 'おしゃれなショルダーバッグ',
            'img' => 'img/fashion-bag.jpg',
            'condition_id' => '3',
            'user_id' => '3',
        ],
        [
            'name' => 'タンブラー',
            'price' => '500',
            'brand' =>'なし',
            'detail' => '使いやすいタンブラー',
            'img' => 'img/tumbrer.jpg',
            'condition_id' => '4',
            'user_id' => '4',
        ],
        [
            'name' => 'コーヒーミル',
            'price' => '4000',
            'brand' =>'Starbacks',
            'detail' => '手動のコーヒーミル',
            'img' => 'img/coffee.jpg',
            'condition_id' => '1',
            'user_id' => '1',
        ],
        [
            'name' => 'メイクセット',
            'price' => '2500',
            'brand' =>'なし',
            'detail' => '便利なメイクアップセット',
            'img' => 'img/makeup.jpg',
            'condition_id' => '2',
            'user_id' => '2',
        ]]);

    }
}

