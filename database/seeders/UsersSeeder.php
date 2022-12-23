<?php

namespace Database\Seeders;

use App\Models\Request;
use Illuminate\Database\Console\Seeds\WithoutModelEvents;
use Illuminate\Database\Seeder;
use App\Models\User;

class UsersSeeder extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {
        // User::factory()->count(20)->create();
        // User::factory()->count(20)->has(Request::factory()->count(1), 'sentRequests')->create();
        // User::factory()->count(20)->has(Request::factory()->count(1), 'receivedRequests')->create();
    }
}
