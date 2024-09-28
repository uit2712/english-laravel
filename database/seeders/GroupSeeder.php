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
        $tableName = GroupConstants::TABLE_NAME;
        DB::statement("ALTER TABLE $tableName AUTO_INCREMENT=1");
        DB::table($tableName)->insert([
            'id' => 1,
            'name' => 'Động vật',
        ]);
    }
}
