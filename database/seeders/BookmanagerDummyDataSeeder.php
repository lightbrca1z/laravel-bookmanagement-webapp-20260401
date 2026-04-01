<?php

namespace Database\Seeders;

use Illuminate\Database\Seeder;
use Illuminate\Support\Facades\DB;
use RuntimeException;

class BookmanagerDummyDataSeeder extends Seeder
{
    /**
     * Loads data from database/seeders/sql/bookmanager_dummy_seed.sql (export of bookmanager.sql).
     * MySQL only (TRUNCATE / FOREIGN_KEY_CHECKS).
     */
    public function run(): void
    {
        if (DB::getDriverName() !== 'mysql') {
            throw new RuntimeException('BookmanagerDummyDataSeeder requires mysql. Current driver: '.DB::getDriverName());
        }

        $path = database_path('seeders/sql/bookmanager_dummy_seed.sql');
        if (! is_readable($path)) {
            throw new RuntimeException("Missing or unreadable: {$path}");
        }

        $sql = file_get_contents($path);
        if ($sql === false) {
            throw new RuntimeException("Could not read: {$path}");
        }

        DB::unprepared($sql);
    }
}
