<?php

namespace Database\Seeders;

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
        // Add any seeder classes you want to run
        $this->call([
            UserSeeder::class,
            // Add other seeders here if necessary
        ]);
    }
}
