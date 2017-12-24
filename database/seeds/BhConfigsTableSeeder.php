<?php

use Illuminate\Database\Seeder;

class BhConfigsTableSeeder extends Seeder
{

    /**
     * Auto generated seed file
     *
     * @return void
     */
    public function run()
    {
        

        \DB::table('bh_configs')->delete();
        
        \DB::table('bh_configs')->insert(array (
            0 => 
            array (
                'id' => 1,
                'item' => 'trading_pairs',
                'value' => 'BTC/USD,ETH/USD,LTC/USD',
            ),
        ));
        
        
    }
}