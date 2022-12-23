<?php

namespace Database\Seeders;

use Illuminate\Database\Seeder;
use Database\Seeders\UsersSeeder;
// use Database\Seeders\RequestsSeeder;
// use Database\Seeders\ConnectionsInCommonSeeder;

use Illuminate\Database\Console\Seeds\WithoutModelEvents;

class DatabaseSeeder extends Seeder
{
    /**
     * Seed the application's database.
     *
     * @return void
     */
    public function run()
    {

        $this->call(UsersSeeder::class);
        $this->call(RequestsSeeder::class);
        // $this->call(ConnectionsInCommonSeeder::class);

    }
}
