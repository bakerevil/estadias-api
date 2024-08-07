<?php

namespace Database\Seeders;

use Illuminate\Database\Seeder;

class DatabaseSeeder extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {
        // $this->call('UsersTableSeeder');
        $this->call(StatusSeeder::class);
        $this->call(CompanySeeder::class);
        $this->call(LeadSeeder::class);
    }
}
