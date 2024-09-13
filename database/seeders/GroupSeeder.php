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
        DB::table(GroupConstants::TABLE_NAME)->insert([
            'name' => 'Động vật',
        ]);
    }
}
