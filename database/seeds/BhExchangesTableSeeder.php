<?php

use Illuminate\Database\Seeder;

class BhExchangesTableSeeder extends Seeder
{

    /**
     * Auto generated seed file
     *
     * @return void
     */
    public function run()
    {
        

        \DB::table('bh_exchanges')->delete();
        
        \DB::table('bh_exchanges')->insert(array (
            0 => 
            array (
                'id' => 1,
                'exchange' => '_1broker',
                'use' => -1,
                'updated_at' => '2017-12-22 05:31:32',
                'created_at' => '2017-12-22 05:31:32',
                'deleted_at' => NULL,
            ),
            1 => 
            array (
                'id' => 2,
                'exchange' => '_1btcxe',
                'use' => 0,
                'updated_at' => '2017-12-22 05:31:32',
                'created_at' => '2017-12-22 05:31:32',
                'deleted_at' => NULL,
            ),
            2 => 
            array (
                'id' => 3,
                'exchange' => 'acx',
                'use' => 0,
                'updated_at' => '2017-12-22 05:31:32',
                'created_at' => '2017-12-22 05:31:32',
                'deleted_at' => NULL,
            ),
            3 => 
            array (
                'id' => 4,
                'exchange' => 'allcoin',
                'use' => 0,
                'updated_at' => '2017-12-22 05:31:32',
                'created_at' => '2017-12-22 05:31:32',
                'deleted_at' => NULL,
            ),
            4 => 
            array (
                'id' => 5,
                'exchange' => 'anxpro',
                'use' => 0,
                'updated_at' => '2017-12-22 05:31:32',
                'created_at' => '2017-12-22 05:31:32',
                'deleted_at' => NULL,
            ),
            5 => 
            array (
                'id' => 6,
                'exchange' => 'binance',
                'use' => 0,
                'updated_at' => '2017-12-22 05:31:32',
                'created_at' => '2017-12-22 05:31:32',
                'deleted_at' => NULL,
            ),
            6 => 
            array (
                'id' => 7,
                'exchange' => 'bit2c',
                'use' => 0,
                'updated_at' => '2017-12-22 05:31:32',
                'created_at' => '2017-12-22 05:31:32',
                'deleted_at' => NULL,
            ),
            7 => 
            array (
                'id' => 8,
                'exchange' => 'bitbay',
                'use' => 0,
                'updated_at' => '2017-12-22 05:31:32',
                'created_at' => '2017-12-22 05:31:32',
                'deleted_at' => NULL,
            ),
            8 => 
            array (
                'id' => 9,
                'exchange' => 'bitcoincoid',
                'use' => 0,
                'updated_at' => '2017-12-22 05:31:32',
                'created_at' => '2017-12-22 05:31:32',
                'deleted_at' => NULL,
            ),
            9 => 
            array (
                'id' => 10,
                'exchange' => 'bitfinex',
                'use' => 1,
                'updated_at' => '2017-12-22 05:31:32',
                'created_at' => '2017-12-22 05:31:32',
                'deleted_at' => NULL,
            ),
            10 => 
            array (
                'id' => 11,
                'exchange' => 'bitfinex2',
                'use' => 0,
                'updated_at' => '2017-12-22 05:31:32',
                'created_at' => '2017-12-22 05:31:32',
                'deleted_at' => NULL,
            ),
            11 => 
            array (
                'id' => 12,
                'exchange' => 'bitflyer',
                'use' => 0,
                'updated_at' => '2017-12-22 05:31:32',
                'created_at' => '2017-12-22 05:31:32',
                'deleted_at' => NULL,
            ),
            12 => 
            array (
                'id' => 13,
                'exchange' => 'bithumb',
                'use' => 0,
                'updated_at' => '2017-12-22 05:31:32',
                'created_at' => '2017-12-22 05:31:32',
                'deleted_at' => NULL,
            ),
            13 => 
            array (
                'id' => 14,
                'exchange' => 'bitlish',
                'use' => 0,
                'updated_at' => '2017-12-22 05:31:32',
                'created_at' => '2017-12-22 05:31:32',
                'deleted_at' => NULL,
            ),
            14 => 
            array (
                'id' => 15,
                'exchange' => 'bitmarket',
                'use' => 0,
                'updated_at' => '2017-12-22 05:31:32',
                'created_at' => '2017-12-22 05:31:32',
                'deleted_at' => NULL,
            ),
            15 => 
            array (
                'id' => 16,
                'exchange' => 'bitmex',
                'use' => 0,
                'updated_at' => '2017-12-22 05:31:32',
                'created_at' => '2017-12-22 05:31:32',
                'deleted_at' => NULL,
            ),
            16 => 
            array (
                'id' => 17,
                'exchange' => 'bitso',
                'use' => 0,
                'updated_at' => '2017-12-22 05:31:32',
                'created_at' => '2017-12-22 05:31:32',
                'deleted_at' => NULL,
            ),
            17 => 
            array (
                'id' => 18,
                'exchange' => 'bitstamp',
                'use' => 1,
                'updated_at' => '2017-12-22 05:31:32',
                'created_at' => '2017-12-22 05:31:32',
                'deleted_at' => NULL,
            ),
            18 => 
            array (
                'id' => 19,
                'exchange' => 'bitstamp1',
                'use' => 0,
                'updated_at' => '2017-12-22 05:31:32',
                'created_at' => '2017-12-22 05:31:32',
                'deleted_at' => NULL,
            ),
            19 => 
            array (
                'id' => 20,
                'exchange' => 'bittrex',
                'use' => 0,
                'updated_at' => '2017-12-22 05:31:32',
                'created_at' => '2017-12-22 05:31:32',
                'deleted_at' => NULL,
            ),
            20 => 
            array (
                'id' => 21,
                'exchange' => 'bl3p',
                'use' => 0,
                'updated_at' => '2017-12-22 05:31:32',
                'created_at' => '2017-12-22 05:31:32',
                'deleted_at' => NULL,
            ),
            21 => 
            array (
                'id' => 22,
                'exchange' => 'bleutrade',
                'use' => 0,
                'updated_at' => '2017-12-22 05:31:32',
                'created_at' => '2017-12-22 05:31:32',
                'deleted_at' => NULL,
            ),
            22 => 
            array (
                'id' => 23,
                'exchange' => 'btcbox',
                'use' => 0,
                'updated_at' => '2017-12-22 05:31:32',
                'created_at' => '2017-12-22 05:31:32',
                'deleted_at' => NULL,
            ),
            23 => 
            array (
                'id' => 24,
                'exchange' => 'btcchina',
                'use' => 0,
                'updated_at' => '2017-12-22 05:31:32',
                'created_at' => '2017-12-22 05:31:32',
                'deleted_at' => NULL,
            ),
            24 => 
            array (
                'id' => 25,
                'exchange' => 'btcexchange',
                'use' => 0,
                'updated_at' => '2017-12-22 05:31:32',
                'created_at' => '2017-12-22 05:31:32',
                'deleted_at' => NULL,
            ),
            25 => 
            array (
                'id' => 26,
                'exchange' => 'btcmarkets',
                'use' => 0,
                'updated_at' => '2017-12-22 05:31:32',
                'created_at' => '2017-12-22 05:31:32',
                'deleted_at' => NULL,
            ),
            26 => 
            array (
                'id' => 27,
                'exchange' => 'btctradeua',
                'use' => 0,
                'updated_at' => '2017-12-22 05:31:32',
                'created_at' => '2017-12-22 05:31:32',
                'deleted_at' => NULL,
            ),
            27 => 
            array (
                'id' => 28,
                'exchange' => 'btcturk',
                'use' => 0,
                'updated_at' => '2017-12-22 05:31:32',
                'created_at' => '2017-12-22 05:31:32',
                'deleted_at' => NULL,
            ),
            28 => 
            array (
                'id' => 29,
                'exchange' => 'btcx',
                'use' => 0,
                'updated_at' => '2017-12-22 05:31:32',
                'created_at' => '2017-12-22 05:31:32',
                'deleted_at' => NULL,
            ),
            29 => 
            array (
                'id' => 30,
                'exchange' => 'bter',
                'use' => -1,
                'updated_at' => '2017-12-22 05:31:32',
                'created_at' => '2017-12-22 05:31:32',
                'deleted_at' => NULL,
            ),
            30 => 
            array (
                'id' => 31,
                'exchange' => 'bxinth',
                'use' => 0,
                'updated_at' => '2017-12-22 05:31:32',
                'created_at' => '2017-12-22 05:31:32',
                'deleted_at' => NULL,
            ),
            31 => 
            array (
                'id' => 32,
                'exchange' => 'ccex',
                'use' => 0,
                'updated_at' => '2017-12-22 05:31:32',
                'created_at' => '2017-12-22 05:31:32',
                'deleted_at' => NULL,
            ),
            32 => 
            array (
                'id' => 33,
                'exchange' => 'cex',
                'use' => 0,
                'updated_at' => '2017-12-22 05:31:32',
                'created_at' => '2017-12-22 05:31:32',
                'deleted_at' => NULL,
            ),
            33 => 
            array (
                'id' => 34,
                'exchange' => 'chbtc',
                'use' => 0,
                'updated_at' => '2017-12-22 05:31:32',
                'created_at' => '2017-12-22 05:31:32',
                'deleted_at' => NULL,
            ),
            34 => 
            array (
                'id' => 35,
                'exchange' => 'chilebit',
                'use' => 0,
                'updated_at' => '2017-12-22 05:31:32',
                'created_at' => '2017-12-22 05:31:32',
                'deleted_at' => NULL,
            ),
            35 => 
            array (
                'id' => 36,
                'exchange' => 'coincheck',
                'use' => 0,
                'updated_at' => '2017-12-22 05:31:32',
                'created_at' => '2017-12-22 05:31:32',
                'deleted_at' => NULL,
            ),
            36 => 
            array (
                'id' => 37,
                'exchange' => 'coinfloor',
                'use' => 0,
                'updated_at' => '2017-12-22 05:31:32',
                'created_at' => '2017-12-22 05:31:32',
                'deleted_at' => NULL,
            ),
            37 => 
            array (
                'id' => 38,
                'exchange' => 'coingi',
                'use' => 0,
                'updated_at' => '2017-12-22 05:31:32',
                'created_at' => '2017-12-22 05:31:32',
                'deleted_at' => NULL,
            ),
            38 => 
            array (
                'id' => 39,
                'exchange' => 'coinmarketcap',
                'use' => 0,
                'updated_at' => '2017-12-22 05:31:32',
                'created_at' => '2017-12-22 05:31:32',
                'deleted_at' => NULL,
            ),
            39 => 
            array (
                'id' => 40,
                'exchange' => 'coinmate',
                'use' => 0,
                'updated_at' => '2017-12-22 05:31:32',
                'created_at' => '2017-12-22 05:31:32',
                'deleted_at' => NULL,
            ),
            40 => 
            array (
                'id' => 41,
                'exchange' => 'coinsecure',
                'use' => 0,
                'updated_at' => '2017-12-22 05:31:32',
                'created_at' => '2017-12-22 05:31:32',
                'deleted_at' => NULL,
            ),
            41 => 
            array (
                'id' => 42,
                'exchange' => 'coinspot',
                'use' => 0,
                'updated_at' => '2017-12-22 05:31:32',
                'created_at' => '2017-12-22 05:31:32',
                'deleted_at' => NULL,
            ),
            42 => 
            array (
                'id' => 43,
                'exchange' => 'cryptopia',
                'use' => 0,
                'updated_at' => '2017-12-22 05:31:32',
                'created_at' => '2017-12-22 05:31:32',
                'deleted_at' => NULL,
            ),
            43 => 
            array (
                'id' => 44,
                'exchange' => 'dsx',
                'use' => 0,
                'updated_at' => '2017-12-22 05:31:32',
                'created_at' => '2017-12-22 05:31:32',
                'deleted_at' => NULL,
            ),
            44 => 
            array (
                'id' => 45,
                'exchange' => 'exmo',
                'use' => 0,
                'updated_at' => '2017-12-22 05:31:32',
                'created_at' => '2017-12-22 05:31:32',
                'deleted_at' => NULL,
            ),
            45 => 
            array (
                'id' => 46,
                'exchange' => 'flowbtc',
                'use' => -1,
                'updated_at' => '2017-12-22 05:31:32',
                'created_at' => '2017-12-22 05:31:32',
                'deleted_at' => NULL,
            ),
            46 => 
            array (
                'id' => 47,
                'exchange' => 'foxbit',
                'use' => 0,
                'updated_at' => '2017-12-22 05:31:32',
                'created_at' => '2017-12-22 05:31:32',
                'deleted_at' => NULL,
            ),
            47 => 
            array (
                'id' => 48,
                'exchange' => 'fybse',
                'use' => 0,
                'updated_at' => '2017-12-22 05:31:32',
                'created_at' => '2017-12-22 05:31:32',
                'deleted_at' => NULL,
            ),
            48 => 
            array (
                'id' => 49,
                'exchange' => 'fybsg',
                'use' => 0,
                'updated_at' => '2017-12-22 05:31:32',
                'created_at' => '2017-12-22 05:31:32',
                'deleted_at' => NULL,
            ),
            49 => 
            array (
                'id' => 50,
                'exchange' => 'gatecoin',
                'use' => 0,
                'updated_at' => '2017-12-22 05:31:32',
                'created_at' => '2017-12-22 05:31:32',
                'deleted_at' => NULL,
            ),
            50 => 
            array (
                'id' => 51,
                'exchange' => 'gateio',
                'use' => 0,
                'updated_at' => '2017-12-22 05:31:32',
                'created_at' => '2017-12-22 05:31:32',
                'deleted_at' => NULL,
            ),
            51 => 
            array (
                'id' => 52,
                'exchange' => 'gdax',
                'use' => 1,
                'updated_at' => '2017-12-22 05:31:32',
                'created_at' => '2017-12-22 05:31:32',
                'deleted_at' => NULL,
            ),
            52 => 
            array (
                'id' => 53,
                'exchange' => 'gemini',
                'use' => 0,
                'updated_at' => '2017-12-22 05:31:32',
                'created_at' => '2017-12-22 05:31:32',
                'deleted_at' => NULL,
            ),
            53 => 
            array (
                'id' => 54,
                'exchange' => 'getbtc',
                'use' => 0,
                'updated_at' => '2017-12-22 05:31:32',
                'created_at' => '2017-12-22 05:31:32',
                'deleted_at' => NULL,
            ),
            54 => 
            array (
                'id' => 55,
                'exchange' => 'hitbtc',
                'use' => 0,
                'updated_at' => '2017-12-22 05:31:32',
                'created_at' => '2017-12-22 05:31:32',
                'deleted_at' => NULL,
            ),
            55 => 
            array (
                'id' => 56,
                'exchange' => 'hitbtc2',
                'use' => 0,
                'updated_at' => '2017-12-22 05:31:32',
                'created_at' => '2017-12-22 05:31:32',
                'deleted_at' => NULL,
            ),
            56 => 
            array (
                'id' => 57,
                'exchange' => 'huobi',
                'use' => 0,
                'updated_at' => '2017-12-22 05:31:32',
                'created_at' => '2017-12-22 05:31:32',
                'deleted_at' => NULL,
            ),
            57 => 
            array (
                'id' => 58,
                'exchange' => 'huobicny',
                'use' => 0,
                'updated_at' => '2017-12-22 05:31:32',
                'created_at' => '2017-12-22 05:31:32',
                'deleted_at' => NULL,
            ),
            58 => 
            array (
                'id' => 59,
                'exchange' => 'huobipro',
                'use' => 0,
                'updated_at' => '2017-12-22 05:31:32',
                'created_at' => '2017-12-22 05:31:32',
                'deleted_at' => NULL,
            ),
            59 => 
            array (
                'id' => 60,
                'exchange' => 'independentreserve',
                'use' => 0,
                'updated_at' => '2017-12-22 05:31:32',
                'created_at' => '2017-12-22 05:31:32',
                'deleted_at' => NULL,
            ),
            60 => 
            array (
                'id' => 61,
                'exchange' => 'itbit',
                'use' => 0,
                'updated_at' => '2017-12-22 05:31:32',
                'created_at' => '2017-12-22 05:31:32',
                'deleted_at' => NULL,
            ),
            61 => 
            array (
                'id' => 62,
                'exchange' => 'jubi',
                'use' => 0,
                'updated_at' => '2017-12-22 05:31:32',
                'created_at' => '2017-12-22 05:31:32',
                'deleted_at' => NULL,
            ),
            62 => 
            array (
                'id' => 63,
                'exchange' => 'kraken',
                'use' => 1,
                'updated_at' => '2017-12-22 05:31:32',
                'created_at' => '2017-12-22 05:31:32',
                'deleted_at' => NULL,
            ),
            63 => 
            array (
                'id' => 64,
                'exchange' => 'kucoin',
                'use' => 0,
                'updated_at' => '2017-12-22 05:31:32',
                'created_at' => '2017-12-22 05:31:32',
                'deleted_at' => NULL,
            ),
            64 => 
            array (
                'id' => 65,
                'exchange' => 'kuna',
                'use' => 0,
                'updated_at' => '2017-12-22 05:31:32',
                'created_at' => '2017-12-22 05:31:32',
                'deleted_at' => NULL,
            ),
            65 => 
            array (
                'id' => 66,
                'exchange' => 'lakebtc',
                'use' => 0,
                'updated_at' => '2017-12-22 05:31:32',
                'created_at' => '2017-12-22 05:31:32',
                'deleted_at' => NULL,
            ),
            66 => 
            array (
                'id' => 67,
                'exchange' => 'liqui',
                'use' => 0,
                'updated_at' => '2017-12-22 05:31:32',
                'created_at' => '2017-12-22 05:31:32',
                'deleted_at' => NULL,
            ),
            67 => 
            array (
                'id' => 68,
                'exchange' => 'livecoin',
                'use' => 0,
                'updated_at' => '2017-12-22 05:31:32',
                'created_at' => '2017-12-22 05:31:32',
                'deleted_at' => NULL,
            ),
            68 => 
            array (
                'id' => 69,
                'exchange' => 'luno',
                'use' => 0,
                'updated_at' => '2017-12-22 05:31:32',
                'created_at' => '2017-12-22 05:31:32',
                'deleted_at' => NULL,
            ),
            69 => 
            array (
                'id' => 70,
                'exchange' => 'mercado',
                'use' => 0,
                'updated_at' => '2017-12-22 05:31:32',
                'created_at' => '2017-12-22 05:31:32',
                'deleted_at' => NULL,
            ),
            70 => 
            array (
                'id' => 71,
                'exchange' => 'mixcoins',
                'use' => 0,
                'updated_at' => '2017-12-22 05:31:32',
                'created_at' => '2017-12-22 05:31:32',
                'deleted_at' => NULL,
            ),
            71 => 
            array (
                'id' => 72,
                'exchange' => 'nova',
                'use' => 0,
                'updated_at' => '2017-12-22 05:31:32',
                'created_at' => '2017-12-22 05:31:32',
                'deleted_at' => NULL,
            ),
            72 => 
            array (
                'id' => 73,
                'exchange' => 'okcoincny',
                'use' => 0,
                'updated_at' => '2017-12-22 05:31:32',
                'created_at' => '2017-12-22 05:31:32',
                'deleted_at' => NULL,
            ),
            73 => 
            array (
                'id' => 74,
                'exchange' => 'okcoinusd',
                'use' => 0,
                'updated_at' => '2017-12-22 05:31:32',
                'created_at' => '2017-12-22 05:31:32',
                'deleted_at' => NULL,
            ),
            74 => 
            array (
                'id' => 75,
                'exchange' => 'okex',
                'use' => 0,
                'updated_at' => '2017-12-22 05:31:32',
                'created_at' => '2017-12-22 05:31:32',
                'deleted_at' => NULL,
            ),
            75 => 
            array (
                'id' => 76,
                'exchange' => 'paymium',
                'use' => 0,
                'updated_at' => '2017-12-22 05:31:32',
                'created_at' => '2017-12-22 05:31:32',
                'deleted_at' => NULL,
            ),
            76 => 
            array (
                'id' => 77,
                'exchange' => 'poloniex',
                'use' => 0,
                'updated_at' => '2017-12-22 05:31:32',
                'created_at' => '2017-12-22 05:31:32',
                'deleted_at' => NULL,
            ),
            77 => 
            array (
                'id' => 78,
                'exchange' => 'qryptos',
                'use' => 0,
                'updated_at' => '2017-12-22 05:31:32',
                'created_at' => '2017-12-22 05:31:32',
                'deleted_at' => NULL,
            ),
            78 => 
            array (
                'id' => 79,
                'exchange' => 'quadrigacx',
                'use' => 0,
                'updated_at' => '2017-12-22 05:31:32',
                'created_at' => '2017-12-22 05:31:32',
                'deleted_at' => NULL,
            ),
            79 => 
            array (
                'id' => 80,
                'exchange' => 'quoine',
                'use' => 0,
                'updated_at' => '2017-12-22 05:31:32',
                'created_at' => '2017-12-22 05:31:32',
                'deleted_at' => NULL,
            ),
            80 => 
            array (
                'id' => 81,
                'exchange' => 'southxchange',
                'use' => 0,
                'updated_at' => '2017-12-22 05:31:32',
                'created_at' => '2017-12-22 05:31:32',
                'deleted_at' => NULL,
            ),
            81 => 
            array (
                'id' => 82,
                'exchange' => 'surbitcoin',
                'use' => 0,
                'updated_at' => '2017-12-22 05:31:32',
                'created_at' => '2017-12-22 05:31:32',
                'deleted_at' => NULL,
            ),
            82 => 
            array (
                'id' => 83,
                'exchange' => 'therock',
                'use' => 0,
                'updated_at' => '2017-12-22 05:31:32',
                'created_at' => '2017-12-22 05:31:32',
                'deleted_at' => NULL,
            ),
            83 => 
            array (
                'id' => 84,
                'exchange' => 'tidex',
                'use' => 0,
                'updated_at' => '2017-12-22 05:31:32',
                'created_at' => '2017-12-22 05:31:32',
                'deleted_at' => NULL,
            ),
            84 => 
            array (
                'id' => 85,
                'exchange' => 'urdubit',
                'use' => 0,
                'updated_at' => '2017-12-22 05:31:32',
                'created_at' => '2017-12-22 05:31:32',
                'deleted_at' => NULL,
            ),
            85 => 
            array (
                'id' => 86,
                'exchange' => 'vaultoro',
                'use' => 0,
                'updated_at' => '2017-12-22 05:31:32',
                'created_at' => '2017-12-22 05:31:32',
                'deleted_at' => NULL,
            ),
            86 => 
            array (
                'id' => 87,
                'exchange' => 'vbtc',
                'use' => 0,
                'updated_at' => '2017-12-22 05:31:32',
                'created_at' => '2017-12-22 05:31:32',
                'deleted_at' => NULL,
            ),
            87 => 
            array (
                'id' => 88,
                'exchange' => 'virwox',
                'use' => 0,
                'updated_at' => '2017-12-22 05:31:32',
                'created_at' => '2017-12-22 05:31:32',
                'deleted_at' => NULL,
            ),
            88 => 
            array (
                'id' => 89,
                'exchange' => 'wex',
                'use' => 0,
                'updated_at' => '2017-12-22 05:31:32',
                'created_at' => '2017-12-22 05:31:32',
                'deleted_at' => NULL,
            ),
            89 => 
            array (
                'id' => 90,
                'exchange' => 'xbtce',
                'use' => -1,
                'updated_at' => '2017-12-22 05:31:32',
                'created_at' => '2017-12-22 05:31:32',
                'deleted_at' => NULL,
            ),
            90 => 
            array (
                'id' => 91,
                'exchange' => 'yobit',
                'use' => 0,
                'updated_at' => '2017-12-22 05:31:32',
                'created_at' => '2017-12-22 05:31:32',
                'deleted_at' => NULL,
            ),
            91 => 
            array (
                'id' => 92,
                'exchange' => 'yunbi',
                'use' => -1,
                'updated_at' => '2017-12-22 05:31:32',
                'created_at' => '2017-12-22 05:31:32',
                'deleted_at' => NULL,
            ),
            92 => 
            array (
                'id' => 93,
                'exchange' => 'zaif',
                'use' => 0,
                'updated_at' => '2017-12-22 05:31:32',
                'created_at' => '2017-12-22 05:31:32',
                'deleted_at' => NULL,
            ),
            93 => 
            array (
                'id' => 94,
                'exchange' => 'zb',
                'use' => 0,
                'updated_at' => '2017-12-22 05:31:32',
                'created_at' => '2017-12-22 05:31:32',
                'deleted_at' => NULL,
            ),
        ));
        
        
    }
}