<?php

namespace Database\Seeders;

use Core\Features\Group\Constants\GroupConstants;
use Illuminate\Database\Seeder;
use Illuminate\Support\Facades\DB;

class GroupSeeder extends Seeder
{
    /**
     * Run the database seeds.
     */
    public function run(): void
    {
        DB::statement('ALTER TABLE users AUTO_INCREMENT=1');
        DB::table(GroupConstants::TABLE_NAME)->insert([
            'id' => 1,
            'name' => 'Động vật',
        ]);
    }
}
