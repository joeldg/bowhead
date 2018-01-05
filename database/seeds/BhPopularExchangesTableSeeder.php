<?php

use Illuminate\Database\Seeder;

class BhPopularExchangesTableSeeder extends Seeder
{

    /**
     * Auto generated seed file
     *
     * @return void
     */
    public function run()
    {
        

        \DB::table('bh_popular_exchanges')->delete();
        
        \DB::table('bh_popular_exchanges')->insert(array (
            0 => 
            array (
                'id' => 1,
                'exch_id' => 55,
                'exchange' => 'HitBTC',
                'public_api' => 0,
                'coinigy' => 1,
                'ccxt' => 1,
                'link' => 'https://hitbtc.com/?ref_id=5a4d829c58916',
                'about' => 'HitBTC - global trading platform with multi-currency support, operating since 2013. The exchange has markets for trading digital assets, tokens and ICOs and provides a wide range of tools as well as stable uptime.

The Platform development started with a 6 million euro venture investment agreement, as of the collaboration between software developers, finance professionals and experienced traders. The core matching engine is among the most advanced technological products in its class and implements innovative features such as real-time clearing, advanced order matching algorithms and has been acclaimed for its fault-tolerance, uptime and high availability',
                'updated_at' => NULL,
                'created_at' => NULL,
                'deleted_at' => NULL,
            ),
            1 => 
            array (
                'id' => 2,
                'exch_id' => 6,
                'exchange' => 'Binance',
                'public_api' => 0,
                'coinigy' => 1,
                'ccxt' => 1,
                'link' => 'https://www.binance.com/?ref=12325729',
                'about' => NULL,
                'updated_at' => NULL,
                'created_at' => NULL,
                'deleted_at' => NULL,
            ),
            2 => 
            array (
                'id' => 3,
                'exch_id' => 105,
                'exchange' => 'Coinbase/GDAX',
                'public_api' => 0,
                'coinigy' => 1,
                'ccxt' => 0,
                'link' => 'https://www.coinbase.com/join/51950ca286c21b84dd000021',
                'about' => NULL,
                'updated_at' => NULL,
                'created_at' => NULL,
                'deleted_at' => NULL,
            ),
            3 => 
            array (
                'id' => 4,
                'exch_id' => 98,
                'exchange' => 'CexIO',
                'public_api' => 0,
                'coinigy' => 1,
                'ccxt' => 0,
                'link' => 'https://cex.io/r/0/joeldg/0/',
                'about' => NULL,
                'updated_at' => NULL,
                'created_at' => NULL,
                'deleted_at' => NULL,
            ),
            4 => 
            array (
                'id' => 5,
                'exch_id' => 77,
                'exchange' => 'Poloniex',
                'public_api' => 0,
                'coinigy' => 1,
                'ccxt' => 1,
                'link' => 'https://poloniex.com',
                'about' => NULL,
                'updated_at' => NULL,
                'created_at' => NULL,
                'deleted_at' => NULL,
            ),
            5 => 
            array (
                'id' => 6,
                'exch_id' => 63,
                'exchange' => 'Kraken',
                'public_api' => 0,
                'coinigy' => 1,
                'ccxt' => 1,
                'link' => 'https://www.kraken.com',
                'about' => NULL,
                'updated_at' => NULL,
                'created_at' => NULL,
                'deleted_at' => NULL,
            ),
            6 => 
            array (
                'id' => 7,
                'exch_id' => 52,
                'exchange' => 'GDAX',
                'public_api' => 0,
                'coinigy' => 0,
                'ccxt' => 1,
                'link' => 'https://www.coinbase.com/join/51950ca286c21b84dd000021',
                'about' => NULL,
                'updated_at' => NULL,
                'created_at' => NULL,
                'deleted_at' => NULL,
            ),
            7 => 
            array (
                'id' => 8,
                'exch_id' => 96,
                'exchange' => 'C-Cex',
                'public_api' => 0,
                'coinigy' => 1,
                'ccxt' => 0,
                'link' => 'https://c-cex.com/?rf=2BE2ED2FD83B6FAE',
                'about' => NULL,
                'updated_at' => NULL,
                'created_at' => NULL,
                'deleted_at' => NULL,
            ),
            8 => 
            array (
                'id' => 9,
                'exch_id' => 32,
                'exchange' => 'C-Cex',
                'public_api' => 0,
                'coinigy' => 0,
                'ccxt' => 1,
                'link' => 'https://c-cex.com/?rf=2BE2ED2FD83B6FAE',
                'about' => NULL,
                'updated_at' => NULL,
                'created_at' => NULL,
                'deleted_at' => NULL,
            ),
            9 => 
            array (
                'id' => 10,
                'exch_id' => 33,
                'exchange' => 'CexIO',
                'public_api' => 0,
                'coinigy' => 0,
                'ccxt' => 1,
                'link' => 'https://cex.io/r/0/joeldg/0/',
                'about' => NULL,
                'updated_at' => NULL,
                'created_at' => NULL,
                'deleted_at' => NULL,
            ),
            10 => 
            array (
                'id' => 11,
                'exch_id' => 22,
                'exchange' => 'BleuTrade',
                'public_api' => 0,
                'coinigy' => 1,
                'ccxt' => 1,
                'link' => 'https://bleutrade.com/sign_up/148055',
                'about' => NULL,
                'updated_at' => NULL,
                'created_at' => NULL,
                'deleted_at' => NULL,
            ),
            11 => 
            array (
                'id' => 12,
                'exch_id' => 43,
                'exchange' => 'Cryptopia',
                'public_api' => 1,
                'coinigy' => 1,
                'ccxt' => 1,
                'link' => 'https://www.cryptopia.co.nz/Register?referrer=joeldg',
                'about' => NULL,
                'updated_at' => NULL,
                'created_at' => NULL,
                'deleted_at' => NULL,
            ),
            12 => 
            array (
                'id' => 13,
                'exch_id' => 91,
                'exchange' => 'YoBit',
                'public_api' => 0,
                'coinigy' => 1,
                'ccxt' => 1,
                'link' => 'https://yobit.io/?bonus=Vwnof',
                'about' => NULL,
                'updated_at' => NULL,
                'created_at' => NULL,
                'deleted_at' => NULL,
            ),
            13 => 
            array (
                'id' => 14,
                'exch_id' => 50,
                'exchange' => 'Gatecoin',
                'public_api' => 0,
                'coinigy' => 1,
                'ccxt' => 1,
                'link' => 'https://gatecoin.com/register?referralCode=WKBPME',
                'about' => NULL,
                'updated_at' => NULL,
                'created_at' => NULL,
                'deleted_at' => NULL,
            ),
            14 => 
            array (
                'id' => 15,
                'exch_id' => 45,
                'exchange' => 'Exmo',
                'public_api' => 0,
                'coinigy' => 1,
                'ccxt' => 1,
                'link' => 'https://exmo.com/?ref=778749',
                'about' => NULL,
                'updated_at' => NULL,
                'created_at' => NULL,
                'deleted_at' => NULL,
            ),
            15 => 
            array (
                'id' => 16,
                'exch_id' => 68,
                'exchange' => 'Livecoin',
                'public_api' => 0,
                'coinigy' => 1,
                'ccxt' => 1,
                'link' => 'https://livecoin.net/?from=Livecoin-KdJ73s2V',
                'about' => NULL,
                'updated_at' => NULL,
                'created_at' => NULL,
                'deleted_at' => NULL,
            ),
            16 => 
            array (
                'id' => 17,
                'exch_id' => 89,
                'exchange' => 'Wex',
                'public_api' => 1,
                'coinigy' => 0,
                'ccxt' => 1,
                'link' => 'https://wex.nz',
                'about' => NULL,
                'updated_at' => NULL,
                'created_at' => NULL,
                'deleted_at' => NULL,
            ),
            17 => 
            array (
                'id' => 18,
                'exch_id' => 66,
                'exchange' => 'LakeBTC',
                'public_api' => 0,
                'coinigy' => 1,
                'ccxt' => 1,
                'link' => 'https://www.lakebtc.com/?ref=qsvodu',
                'about' => NULL,
                'updated_at' => NULL,
                'created_at' => NULL,
                'deleted_at' => NULL,
            ),
        ));
        
        
    }
}