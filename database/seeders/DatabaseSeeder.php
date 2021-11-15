<?php

namespace Database\Seeders;

use Database\Seeders\Admin\AdminSeeder;
use Database\Seeders\Category\CategorySeeder;
use Illuminate\Database\Seeder;

class DatabaseSeeder extends Seeder
{
    /**
     * Seed the application's database.
     *
     * @return void
     */
    public function run()
    {
        $this->call([
            // CategorySeeder::class,
            AdminSeeder::class,
        ]);
    }
}
