<?php

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
        // $this->call(UsersTableSeeder::class);
        $this->call(BhExchangesTableSeeder::class);
        $this->call(BhExchangePairsTableSeeder::class);
        $this->call(BhConfigsTableSeeder::class);
        $this->call(BhOhlcvsTableSeeder::class);
        $this->call(BhTickersTableSeeder::class);
    }
}
