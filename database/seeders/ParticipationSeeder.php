<?php

namespace Database\Seeders;

use Illuminate\Database\Console\Seeds\WithoutModelEvents;
use Illuminate\Database\Seeder;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Schema;
use Illuminate\Support\Carbon;

class ParticipationSeeder extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {
        // categoriesテーブルを指定
        $table = DB::table('participations');

        // 一時的に外部キー制約を外す→truncateする前にこれを実行しないと、seeder実行が失敗するため。(具体的には、postsのcategory_id_foreignのエラーがでる)
        Schema::disableForeignKeyConstraints();

        // シーダー実行前にcategoriesテーブルの中身を空にする
        $table->truncate();

        $now = Carbon::now();

        // データ
        $data = [
            [
                'user_id'     => 3,
                'post_id'     => 1,
                'status'      => '参加',
                'created_at'  => $now,
                'updated_at'  => $now
            ],
        ];

        // categoriesテーブルにデータをinsert
        $table->insert($data);

        // 外していた外部キー制約を戻す
        Schema::enableForeignKeyConstraints();
    }
}
