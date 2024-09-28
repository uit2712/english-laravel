<?php

namespace Database\Seeders;

use Core\Features\Topic\Constants\TopicConstants;
use Illuminate\Database\Seeder;
use Illuminate\Support\Facades\DB;

class TopicSeeder extends Seeder
{
    /**
     * Run the database seeds.
     */
    public function run(): void
    {
        $tableName = TopicConstants::TABLE_NAME;
        DB::statement("ALTER TABLE $tableName AUTO_INCREMENT=1");
        DB::table($tableName)->insert([
            [
                'id' => 1,
                'name' => 'Thú cưng',
                'group_id' => 1,
            ],
            [
                'id' => 2,
                'name' => 'Các loài chim',
                'group_id' => 1,
            ],
            [
                'id' => 3,
                'name' => 'Các động vật biển/dưới nước',
                'group_id' => 1,
            ],
            [
                'id' => 4,
                'name' => 'Động vật hoang dã',
                'group_id' => 1,
            ],
            [
                'id' => 5,
                'name' => 'Con vật nuôi/trang trại',
                'group_id' => 1,
            ],
            [
                'id' => 6,
                'name' => 'Lưỡng cư',
                'group_id' => 1,
            ],
            [
                'id' => 7,
                'name' => 'Côn trùng không có cánh',
                'group_id' => 1,
            ],
            [
                'id' => 8,
                'name' => 'Côn trùng có cánh',
                'group_id' => 1,
            ],
        ]);
    }
}
