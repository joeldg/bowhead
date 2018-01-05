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
                'item' => 'PAIRS',
                'value' => 'BTC/USD,ETH/USD,LTC/USD',
                'exchange_id' => NULL,
                'updated_at' => NULL,
                'created_at' => NULL,
                'deleted_at' => NULL,
            ),
            1 => 
            array (
                'id' => 2,
                'item' => 'EXCHANGES',
                'value' => 'binance,bitfinex,gdax,bitstamp',
                'exchange_id' => NULL,
                'updated_at' => '2018-01-03 19:13:00',
                'created_at' => '2018-01-03 19:13:00',
                'deleted_at' => NULL,
            ),
            2 => 
            array (
                'id' => 3,
                'item' => 'COINIGY',
                'value' => '1',
                'exchange_id' => NULL,
                'updated_at' => NULL,
                'created_at' => NULL,
                'deleted_at' => NULL,
            ),
            3 => 
            array (
                'id' => 4,
                'item' => 'COINIGY_API',
                'value' => NULL,
                'exchange_id' => NULL,
                'updated_at' => NULL,
                'created_at' => NULL,
                'deleted_at' => NULL,
            ),
            4 => 
            array (
                'id' => 5,
                'item' => 'COINIGY_SEC',
                'value' => NULL,
                'exchange_id' => NULL,
                'updated_at' => NULL,
                'created_at' => NULL,
                'deleted_at' => NULL,
            ),
            5 => 
            array (
                'id' => 6,
                'item' => 'RESERVED1',
                'value' => NULL,
                'exchange_id' => NULL,
                'updated_at' => '2018-01-03 19:17:01',
                'created_at' => '2018-01-03 19:17:01',
                'deleted_at' => NULL,
            ),
            6 => 
            array (
                'id' => 7,
                'item' => 'RESERVED2',
                'value' => NULL,
                'exchange_id' => NULL,
                'updated_at' => NULL,
                'created_at' => NULL,
                'deleted_at' => NULL,
            ),
            7 => 
            array (
                'id' => 8,
                'item' => 'RESERVED3',
                'value' => NULL,
                'exchange_id' => NULL,
                'updated_at' => '2018-01-03 19:18:00',
                'created_at' => '2018-01-03 19:18:00',
                'deleted_at' => NULL,
            ),
            8 => 
            array (
                'id' => 9,
                'item' => '_1BROKER_APIKEY',
                'value' => NULL,
                'exchange_id' => NULL,
                'updated_at' => '2018-01-03 19:20:30',
                'created_at' => '2018-01-03 19:20:30',
                'deleted_at' => NULL,
            ),
            9 => 
            array (
                'id' => 10,
                'item' => '_1BROKER_SECRET',
                'value' => NULL,
                'exchange_id' => NULL,
                'updated_at' => '2018-01-03 19:20:30',
                'created_at' => '2018-01-03 19:20:30',
                'deleted_at' => NULL,
            ),
            10 => 
            array (
                'id' => 11,
                'item' => '_1BROKER_UID',
                'value' => NULL,
                'exchange_id' => NULL,
                'updated_at' => '2018-01-03 19:20:30',
                'created_at' => '2018-01-03 19:20:30',
                'deleted_at' => NULL,
            ),
            11 => 
            array (
                'id' => 12,
                'item' => '_1BROKER_PASSWORD',
                'value' => NULL,
                'exchange_id' => NULL,
                'updated_at' => '2018-01-03 19:20:30',
                'created_at' => '2018-01-03 19:20:30',
                'deleted_at' => NULL,
            ),
            12 => 
            array (
                'id' => 13,
                'item' => '_1BTCXE_APIKEY',
                'value' => NULL,
                'exchange_id' => NULL,
                'updated_at' => '2018-01-03 19:20:30',
                'created_at' => '2018-01-03 19:20:30',
                'deleted_at' => NULL,
            ),
            13 => 
            array (
                'id' => 14,
                'item' => '_1BTCXE_SECRET',
                'value' => NULL,
                'exchange_id' => NULL,
                'updated_at' => '2018-01-03 19:20:30',
                'created_at' => '2018-01-03 19:20:30',
                'deleted_at' => NULL,
            ),
            14 => 
            array (
                'id' => 15,
                'item' => '_1BTCXE_UID',
                'value' => NULL,
                'exchange_id' => NULL,
                'updated_at' => '2018-01-03 19:20:30',
                'created_at' => '2018-01-03 19:20:30',
                'deleted_at' => NULL,
            ),
            15 => 
            array (
                'id' => 16,
                'item' => '_1BTCXE_PASSWORD',
                'value' => NULL,
                'exchange_id' => NULL,
                'updated_at' => '2018-01-03 19:20:30',
                'created_at' => '2018-01-03 19:20:30',
                'deleted_at' => NULL,
            ),
            16 => 
            array (
                'id' => 17,
                'item' => 'ACX_APIKEY',
                'value' => NULL,
                'exchange_id' => NULL,
                'updated_at' => '2018-01-03 19:20:30',
                'created_at' => '2018-01-03 19:20:30',
                'deleted_at' => NULL,
            ),
            17 => 
            array (
                'id' => 18,
                'item' => 'ACX_SECRET',
                'value' => NULL,
                'exchange_id' => NULL,
                'updated_at' => '2018-01-03 19:20:30',
                'created_at' => '2018-01-03 19:20:30',
                'deleted_at' => NULL,
            ),
            18 => 
            array (
                'id' => 19,
                'item' => 'ACX_UID',
                'value' => NULL,
                'exchange_id' => NULL,
                'updated_at' => '2018-01-03 19:20:30',
                'created_at' => '2018-01-03 19:20:30',
                'deleted_at' => NULL,
            ),
            19 => 
            array (
                'id' => 20,
                'item' => 'ACX_PASSWORD',
                'value' => NULL,
                'exchange_id' => NULL,
                'updated_at' => '2018-01-03 19:20:30',
                'created_at' => '2018-01-03 19:20:30',
                'deleted_at' => NULL,
            ),
            20 => 
            array (
                'id' => 21,
                'item' => 'ALLCOIN_APIKEY',
                'value' => NULL,
                'exchange_id' => NULL,
                'updated_at' => '2018-01-03 19:20:30',
                'created_at' => '2018-01-03 19:20:30',
                'deleted_at' => NULL,
            ),
            21 => 
            array (
                'id' => 22,
                'item' => 'ALLCOIN_SECRET',
                'value' => NULL,
                'exchange_id' => NULL,
                'updated_at' => '2018-01-03 19:20:30',
                'created_at' => '2018-01-03 19:20:30',
                'deleted_at' => NULL,
            ),
            22 => 
            array (
                'id' => 23,
                'item' => 'ALLCOIN_UID',
                'value' => NULL,
                'exchange_id' => NULL,
                'updated_at' => '2018-01-03 19:20:30',
                'created_at' => '2018-01-03 19:20:30',
                'deleted_at' => NULL,
            ),
            23 => 
            array (
                'id' => 24,
                'item' => 'ALLCOIN_PASSWORD',
                'value' => NULL,
                'exchange_id' => NULL,
                'updated_at' => '2018-01-03 19:20:30',
                'created_at' => '2018-01-03 19:20:30',
                'deleted_at' => NULL,
            ),
            24 => 
            array (
                'id' => 25,
                'item' => 'ANXPRO_APIKEY',
                'value' => NULL,
                'exchange_id' => NULL,
                'updated_at' => '2018-01-03 19:20:30',
                'created_at' => '2018-01-03 19:20:30',
                'deleted_at' => NULL,
            ),
            25 => 
            array (
                'id' => 26,
                'item' => 'ANXPRO_SECRET',
                'value' => NULL,
                'exchange_id' => NULL,
                'updated_at' => '2018-01-03 19:20:30',
                'created_at' => '2018-01-03 19:20:30',
                'deleted_at' => NULL,
            ),
            26 => 
            array (
                'id' => 27,
                'item' => 'ANXPRO_UID',
                'value' => NULL,
                'exchange_id' => NULL,
                'updated_at' => '2018-01-03 19:20:30',
                'created_at' => '2018-01-03 19:20:30',
                'deleted_at' => NULL,
            ),
            27 => 
            array (
                'id' => 28,
                'item' => 'ANXPRO_PASSWORD',
                'value' => NULL,
                'exchange_id' => NULL,
                'updated_at' => '2018-01-03 19:20:30',
                'created_at' => '2018-01-03 19:20:30',
                'deleted_at' => NULL,
            ),
            28 => 
            array (
                'id' => 29,
                'item' => 'BINANCE_APIKEY',
                'value' => NULL,
                'exchange_id' => NULL,
                'updated_at' => '2018-01-03 19:20:30',
                'created_at' => '2018-01-03 19:20:30',
                'deleted_at' => NULL,
            ),
            29 => 
            array (
                'id' => 30,
                'item' => 'BINANCE_SECRET',
                'value' => NULL,
                'exchange_id' => NULL,
                'updated_at' => '2018-01-03 19:20:30',
                'created_at' => '2018-01-03 19:20:30',
                'deleted_at' => NULL,
            ),
            30 => 
            array (
                'id' => 31,
                'item' => 'BINANCE_UID',
                'value' => NULL,
                'exchange_id' => NULL,
                'updated_at' => '2018-01-03 19:20:30',
                'created_at' => '2018-01-03 19:20:30',
                'deleted_at' => NULL,
            ),
            31 => 
            array (
                'id' => 32,
                'item' => 'BINANCE_PASSWORD',
                'value' => NULL,
                'exchange_id' => NULL,
                'updated_at' => '2018-01-03 19:20:30',
                'created_at' => '2018-01-03 19:20:30',
                'deleted_at' => NULL,
            ),
            32 => 
            array (
                'id' => 33,
                'item' => 'BIT2C_APIKEY',
                'value' => NULL,
                'exchange_id' => NULL,
                'updated_at' => '2018-01-03 19:20:30',
                'created_at' => '2018-01-03 19:20:30',
                'deleted_at' => NULL,
            ),
            33 => 
            array (
                'id' => 34,
                'item' => 'BIT2C_SECRET',
                'value' => NULL,
                'exchange_id' => NULL,
                'updated_at' => '2018-01-03 19:20:30',
                'created_at' => '2018-01-03 19:20:30',
                'deleted_at' => NULL,
            ),
            34 => 
            array (
                'id' => 35,
                'item' => 'BIT2C_UID',
                'value' => NULL,
                'exchange_id' => NULL,
                'updated_at' => '2018-01-03 19:20:30',
                'created_at' => '2018-01-03 19:20:30',
                'deleted_at' => NULL,
            ),
            35 => 
            array (
                'id' => 36,
                'item' => 'BIT2C_PASSWORD',
                'value' => NULL,
                'exchange_id' => NULL,
                'updated_at' => '2018-01-03 19:20:30',
                'created_at' => '2018-01-03 19:20:30',
                'deleted_at' => NULL,
            ),
            36 => 
            array (
                'id' => 37,
                'item' => 'BITBAY_APIKEY',
                'value' => NULL,
                'exchange_id' => NULL,
                'updated_at' => '2018-01-03 19:20:30',
                'created_at' => '2018-01-03 19:20:30',
                'deleted_at' => NULL,
            ),
            37 => 
            array (
                'id' => 38,
                'item' => 'BITBAY_SECRET',
                'value' => NULL,
                'exchange_id' => NULL,
                'updated_at' => '2018-01-03 19:20:30',
                'created_at' => '2018-01-03 19:20:30',
                'deleted_at' => NULL,
            ),
            38 => 
            array (
                'id' => 39,
                'item' => 'BITBAY_UID',
                'value' => NULL,
                'exchange_id' => NULL,
                'updated_at' => '2018-01-03 19:20:30',
                'created_at' => '2018-01-03 19:20:30',
                'deleted_at' => NULL,
            ),
            39 => 
            array (
                'id' => 40,
                'item' => 'BITBAY_PASSWORD',
                'value' => NULL,
                'exchange_id' => NULL,
                'updated_at' => '2018-01-03 19:20:30',
                'created_at' => '2018-01-03 19:20:30',
                'deleted_at' => NULL,
            ),
            40 => 
            array (
                'id' => 41,
                'item' => 'BITCOINCOID_APIKEY',
                'value' => NULL,
                'exchange_id' => NULL,
                'updated_at' => '2018-01-03 19:20:30',
                'created_at' => '2018-01-03 19:20:30',
                'deleted_at' => NULL,
            ),
            41 => 
            array (
                'id' => 42,
                'item' => 'BITCOINCOID_SECRET',
                'value' => NULL,
                'exchange_id' => NULL,
                'updated_at' => '2018-01-03 19:20:30',
                'created_at' => '2018-01-03 19:20:30',
                'deleted_at' => NULL,
            ),
            42 => 
            array (
                'id' => 43,
                'item' => 'BITCOINCOID_UID',
                'value' => NULL,
                'exchange_id' => NULL,
                'updated_at' => '2018-01-03 19:20:30',
                'created_at' => '2018-01-03 19:20:30',
                'deleted_at' => NULL,
            ),
            43 => 
            array (
                'id' => 44,
                'item' => 'BITCOINCOID_PASSWORD',
                'value' => NULL,
                'exchange_id' => NULL,
                'updated_at' => '2018-01-03 19:20:30',
                'created_at' => '2018-01-03 19:20:30',
                'deleted_at' => NULL,
            ),
            44 => 
            array (
                'id' => 45,
                'item' => 'BITFINEX_APIKEY',
                'value' => NULL,
                'exchange_id' => NULL,
                'updated_at' => '2018-01-03 19:20:30',
                'created_at' => '2018-01-03 19:20:30',
                'deleted_at' => NULL,
            ),
            45 => 
            array (
                'id' => 46,
                'item' => 'BITFINEX_SECRET',
                'value' => NULL,
                'exchange_id' => NULL,
                'updated_at' => '2018-01-03 19:20:30',
                'created_at' => '2018-01-03 19:20:30',
                'deleted_at' => NULL,
            ),
            46 => 
            array (
                'id' => 47,
                'item' => 'BITFINEX_UID',
                'value' => NULL,
                'exchange_id' => NULL,
                'updated_at' => '2018-01-03 19:20:30',
                'created_at' => '2018-01-03 19:20:30',
                'deleted_at' => NULL,
            ),
            47 => 
            array (
                'id' => 48,
                'item' => 'BITFINEX_PASSWORD',
                'value' => NULL,
                'exchange_id' => NULL,
                'updated_at' => '2018-01-03 19:20:30',
                'created_at' => '2018-01-03 19:20:30',
                'deleted_at' => NULL,
            ),
            48 => 
            array (
                'id' => 49,
                'item' => 'BITFINEX2_APIKEY',
                'value' => NULL,
                'exchange_id' => NULL,
                'updated_at' => '2018-01-03 19:20:30',
                'created_at' => '2018-01-03 19:20:30',
                'deleted_at' => NULL,
            ),
            49 => 
            array (
                'id' => 50,
                'item' => 'BITFINEX2_SECRET',
                'value' => NULL,
                'exchange_id' => NULL,
                'updated_at' => '2018-01-03 19:20:30',
                'created_at' => '2018-01-03 19:20:30',
                'deleted_at' => NULL,
            ),
            50 => 
            array (
                'id' => 51,
                'item' => 'BITFINEX2_UID',
                'value' => NULL,
                'exchange_id' => NULL,
                'updated_at' => '2018-01-03 19:20:30',
                'created_at' => '2018-01-03 19:20:30',
                'deleted_at' => NULL,
            ),
            51 => 
            array (
                'id' => 52,
                'item' => 'BITFINEX2_PASSWORD',
                'value' => NULL,
                'exchange_id' => NULL,
                'updated_at' => '2018-01-03 19:20:30',
                'created_at' => '2018-01-03 19:20:30',
                'deleted_at' => NULL,
            ),
            52 => 
            array (
                'id' => 53,
                'item' => 'BITFLYER_APIKEY',
                'value' => NULL,
                'exchange_id' => NULL,
                'updated_at' => '2018-01-03 19:20:30',
                'created_at' => '2018-01-03 19:20:30',
                'deleted_at' => NULL,
            ),
            53 => 
            array (
                'id' => 54,
                'item' => 'BITFLYER_SECRET',
                'value' => NULL,
                'exchange_id' => NULL,
                'updated_at' => '2018-01-03 19:20:30',
                'created_at' => '2018-01-03 19:20:30',
                'deleted_at' => NULL,
            ),
            54 => 
            array (
                'id' => 55,
                'item' => 'BITFLYER_UID',
                'value' => NULL,
                'exchange_id' => NULL,
                'updated_at' => '2018-01-03 19:20:30',
                'created_at' => '2018-01-03 19:20:30',
                'deleted_at' => NULL,
            ),
            55 => 
            array (
                'id' => 56,
                'item' => 'BITFLYER_PASSWORD',
                'value' => NULL,
                'exchange_id' => NULL,
                'updated_at' => '2018-01-03 19:20:30',
                'created_at' => '2018-01-03 19:20:30',
                'deleted_at' => NULL,
            ),
            56 => 
            array (
                'id' => 57,
                'item' => 'BITHUMB_APIKEY',
                'value' => NULL,
                'exchange_id' => NULL,
                'updated_at' => '2018-01-03 19:20:30',
                'created_at' => '2018-01-03 19:20:30',
                'deleted_at' => NULL,
            ),
            57 => 
            array (
                'id' => 58,
                'item' => 'BITHUMB_SECRET',
                'value' => NULL,
                'exchange_id' => NULL,
                'updated_at' => '2018-01-03 19:20:30',
                'created_at' => '2018-01-03 19:20:30',
                'deleted_at' => NULL,
            ),
            58 => 
            array (
                'id' => 59,
                'item' => 'BITHUMB_UID',
                'value' => NULL,
                'exchange_id' => NULL,
                'updated_at' => '2018-01-03 19:20:30',
                'created_at' => '2018-01-03 19:20:30',
                'deleted_at' => NULL,
            ),
            59 => 
            array (
                'id' => 60,
                'item' => 'BITHUMB_PASSWORD',
                'value' => NULL,
                'exchange_id' => NULL,
                'updated_at' => '2018-01-03 19:20:30',
                'created_at' => '2018-01-03 19:20:30',
                'deleted_at' => NULL,
            ),
            60 => 
            array (
                'id' => 61,
                'item' => 'BITLISH_APIKEY',
                'value' => NULL,
                'exchange_id' => NULL,
                'updated_at' => '2018-01-03 19:20:30',
                'created_at' => '2018-01-03 19:20:30',
                'deleted_at' => NULL,
            ),
            61 => 
            array (
                'id' => 62,
                'item' => 'BITLISH_SECRET',
                'value' => NULL,
                'exchange_id' => NULL,
                'updated_at' => '2018-01-03 19:20:30',
                'created_at' => '2018-01-03 19:20:30',
                'deleted_at' => NULL,
            ),
            62 => 
            array (
                'id' => 63,
                'item' => 'BITLISH_UID',
                'value' => NULL,
                'exchange_id' => NULL,
                'updated_at' => '2018-01-03 19:20:30',
                'created_at' => '2018-01-03 19:20:30',
                'deleted_at' => NULL,
            ),
            63 => 
            array (
                'id' => 64,
                'item' => 'BITLISH_PASSWORD',
                'value' => NULL,
                'exchange_id' => NULL,
                'updated_at' => '2018-01-03 19:20:30',
                'created_at' => '2018-01-03 19:20:30',
                'deleted_at' => NULL,
            ),
            64 => 
            array (
                'id' => 65,
                'item' => 'BITMARKET_APIKEY',
                'value' => NULL,
                'exchange_id' => NULL,
                'updated_at' => '2018-01-03 19:20:30',
                'created_at' => '2018-01-03 19:20:30',
                'deleted_at' => NULL,
            ),
            65 => 
            array (
                'id' => 66,
                'item' => 'BITMARKET_SECRET',
                'value' => NULL,
                'exchange_id' => NULL,
                'updated_at' => '2018-01-03 19:20:30',
                'created_at' => '2018-01-03 19:20:30',
                'deleted_at' => NULL,
            ),
            66 => 
            array (
                'id' => 67,
                'item' => 'BITMARKET_UID',
                'value' => NULL,
                'exchange_id' => NULL,
                'updated_at' => '2018-01-03 19:20:30',
                'created_at' => '2018-01-03 19:20:30',
                'deleted_at' => NULL,
            ),
            67 => 
            array (
                'id' => 68,
                'item' => 'BITMARKET_PASSWORD',
                'value' => NULL,
                'exchange_id' => NULL,
                'updated_at' => '2018-01-03 19:20:30',
                'created_at' => '2018-01-03 19:20:30',
                'deleted_at' => NULL,
            ),
            68 => 
            array (
                'id' => 69,
                'item' => 'BITMEX_APIKEY',
                'value' => NULL,
                'exchange_id' => NULL,
                'updated_at' => '2018-01-03 19:20:30',
                'created_at' => '2018-01-03 19:20:30',
                'deleted_at' => NULL,
            ),
            69 => 
            array (
                'id' => 70,
                'item' => 'BITMEX_SECRET',
                'value' => NULL,
                'exchange_id' => NULL,
                'updated_at' => '2018-01-03 19:20:30',
                'created_at' => '2018-01-03 19:20:30',
                'deleted_at' => NULL,
            ),
            70 => 
            array (
                'id' => 71,
                'item' => 'BITMEX_UID',
                'value' => NULL,
                'exchange_id' => NULL,
                'updated_at' => '2018-01-03 19:20:30',
                'created_at' => '2018-01-03 19:20:30',
                'deleted_at' => NULL,
            ),
            71 => 
            array (
                'id' => 72,
                'item' => 'BITMEX_PASSWORD',
                'value' => NULL,
                'exchange_id' => NULL,
                'updated_at' => '2018-01-03 19:20:30',
                'created_at' => '2018-01-03 19:20:30',
                'deleted_at' => NULL,
            ),
            72 => 
            array (
                'id' => 73,
                'item' => 'BITSO_APIKEY',
                'value' => NULL,
                'exchange_id' => NULL,
                'updated_at' => '2018-01-03 19:20:30',
                'created_at' => '2018-01-03 19:20:30',
                'deleted_at' => NULL,
            ),
            73 => 
            array (
                'id' => 74,
                'item' => 'BITSO_SECRET',
                'value' => NULL,
                'exchange_id' => NULL,
                'updated_at' => '2018-01-03 19:20:30',
                'created_at' => '2018-01-03 19:20:30',
                'deleted_at' => NULL,
            ),
            74 => 
            array (
                'id' => 75,
                'item' => 'BITSO_UID',
                'value' => NULL,
                'exchange_id' => NULL,
                'updated_at' => '2018-01-03 19:20:30',
                'created_at' => '2018-01-03 19:20:30',
                'deleted_at' => NULL,
            ),
            75 => 
            array (
                'id' => 76,
                'item' => 'BITSO_PASSWORD',
                'value' => NULL,
                'exchange_id' => NULL,
                'updated_at' => '2018-01-03 19:20:30',
                'created_at' => '2018-01-03 19:20:30',
                'deleted_at' => NULL,
            ),
            76 => 
            array (
                'id' => 77,
                'item' => 'BITSTAMP_APIKEY',
                'value' => NULL,
                'exchange_id' => NULL,
                'updated_at' => '2018-01-03 19:20:30',
                'created_at' => '2018-01-03 19:20:30',
                'deleted_at' => NULL,
            ),
            77 => 
            array (
                'id' => 78,
                'item' => 'BITSTAMP_SECRET',
                'value' => NULL,
                'exchange_id' => NULL,
                'updated_at' => '2018-01-03 19:20:30',
                'created_at' => '2018-01-03 19:20:30',
                'deleted_at' => NULL,
            ),
            78 => 
            array (
                'id' => 79,
                'item' => 'BITSTAMP_UID',
                'value' => NULL,
                'exchange_id' => NULL,
                'updated_at' => '2018-01-03 19:20:30',
                'created_at' => '2018-01-03 19:20:30',
                'deleted_at' => NULL,
            ),
            79 => 
            array (
                'id' => 80,
                'item' => 'BITSTAMP_PASSWORD',
                'value' => NULL,
                'exchange_id' => NULL,
                'updated_at' => '2018-01-03 19:20:30',
                'created_at' => '2018-01-03 19:20:30',
                'deleted_at' => NULL,
            ),
            80 => 
            array (
                'id' => 81,
                'item' => 'BITSTAMP1_APIKEY',
                'value' => NULL,
                'exchange_id' => NULL,
                'updated_at' => '2018-01-03 19:20:30',
                'created_at' => '2018-01-03 19:20:30',
                'deleted_at' => NULL,
            ),
            81 => 
            array (
                'id' => 82,
                'item' => 'BITSTAMP1_SECRET',
                'value' => NULL,
                'exchange_id' => NULL,
                'updated_at' => '2018-01-03 19:20:30',
                'created_at' => '2018-01-03 19:20:30',
                'deleted_at' => NULL,
            ),
            82 => 
            array (
                'id' => 83,
                'item' => 'BITSTAMP1_UID',
                'value' => NULL,
                'exchange_id' => NULL,
                'updated_at' => '2018-01-03 19:20:30',
                'created_at' => '2018-01-03 19:20:30',
                'deleted_at' => NULL,
            ),
            83 => 
            array (
                'id' => 84,
                'item' => 'BITSTAMP1_PASSWORD',
                'value' => NULL,
                'exchange_id' => NULL,
                'updated_at' => '2018-01-03 19:20:30',
                'created_at' => '2018-01-03 19:20:30',
                'deleted_at' => NULL,
            ),
            84 => 
            array (
                'id' => 85,
                'item' => 'BITTREX_APIKEY',
                'value' => NULL,
                'exchange_id' => NULL,
                'updated_at' => '2018-01-03 19:20:30',
                'created_at' => '2018-01-03 19:20:30',
                'deleted_at' => NULL,
            ),
            85 => 
            array (
                'id' => 86,
                'item' => 'BITTREX_SECRET',
                'value' => NULL,
                'exchange_id' => NULL,
                'updated_at' => '2018-01-03 19:20:30',
                'created_at' => '2018-01-03 19:20:30',
                'deleted_at' => NULL,
            ),
            86 => 
            array (
                'id' => 87,
                'item' => 'BITTREX_UID',
                'value' => NULL,
                'exchange_id' => NULL,
                'updated_at' => '2018-01-03 19:20:30',
                'created_at' => '2018-01-03 19:20:30',
                'deleted_at' => NULL,
            ),
            87 => 
            array (
                'id' => 88,
                'item' => 'BITTREX_PASSWORD',
                'value' => NULL,
                'exchange_id' => NULL,
                'updated_at' => '2018-01-03 19:20:30',
                'created_at' => '2018-01-03 19:20:30',
                'deleted_at' => NULL,
            ),
            88 => 
            array (
                'id' => 89,
                'item' => 'BL3P_APIKEY',
                'value' => NULL,
                'exchange_id' => NULL,
                'updated_at' => '2018-01-03 19:20:30',
                'created_at' => '2018-01-03 19:20:30',
                'deleted_at' => NULL,
            ),
            89 => 
            array (
                'id' => 90,
                'item' => 'BL3P_SECRET',
                'value' => NULL,
                'exchange_id' => NULL,
                'updated_at' => '2018-01-03 19:20:30',
                'created_at' => '2018-01-03 19:20:30',
                'deleted_at' => NULL,
            ),
            90 => 
            array (
                'id' => 91,
                'item' => 'BL3P_UID',
                'value' => NULL,
                'exchange_id' => NULL,
                'updated_at' => '2018-01-03 19:20:30',
                'created_at' => '2018-01-03 19:20:30',
                'deleted_at' => NULL,
            ),
            91 => 
            array (
                'id' => 92,
                'item' => 'BL3P_PASSWORD',
                'value' => NULL,
                'exchange_id' => NULL,
                'updated_at' => '2018-01-03 19:20:30',
                'created_at' => '2018-01-03 19:20:30',
                'deleted_at' => NULL,
            ),
            92 => 
            array (
                'id' => 93,
                'item' => 'BLEUTRADE_APIKEY',
                'value' => NULL,
                'exchange_id' => NULL,
                'updated_at' => '2018-01-03 19:20:30',
                'created_at' => '2018-01-03 19:20:30',
                'deleted_at' => NULL,
            ),
            93 => 
            array (
                'id' => 94,
                'item' => 'BLEUTRADE_SECRET',
                'value' => NULL,
                'exchange_id' => NULL,
                'updated_at' => '2018-01-03 19:20:30',
                'created_at' => '2018-01-03 19:20:30',
                'deleted_at' => NULL,
            ),
            94 => 
            array (
                'id' => 95,
                'item' => 'BLEUTRADE_UID',
                'value' => NULL,
                'exchange_id' => NULL,
                'updated_at' => '2018-01-03 19:20:30',
                'created_at' => '2018-01-03 19:20:30',
                'deleted_at' => NULL,
            ),
            95 => 
            array (
                'id' => 96,
                'item' => 'BLEUTRADE_PASSWORD',
                'value' => NULL,
                'exchange_id' => NULL,
                'updated_at' => '2018-01-03 19:20:30',
                'created_at' => '2018-01-03 19:20:30',
                'deleted_at' => NULL,
            ),
            96 => 
            array (
                'id' => 97,
                'item' => 'BTCBOX_APIKEY',
                'value' => NULL,
                'exchange_id' => NULL,
                'updated_at' => '2018-01-03 19:20:30',
                'created_at' => '2018-01-03 19:20:30',
                'deleted_at' => NULL,
            ),
            97 => 
            array (
                'id' => 98,
                'item' => 'BTCBOX_SECRET',
                'value' => NULL,
                'exchange_id' => NULL,
                'updated_at' => '2018-01-03 19:20:30',
                'created_at' => '2018-01-03 19:20:30',
                'deleted_at' => NULL,
            ),
            98 => 
            array (
                'id' => 99,
                'item' => 'BTCBOX_UID',
                'value' => NULL,
                'exchange_id' => NULL,
                'updated_at' => '2018-01-03 19:20:30',
                'created_at' => '2018-01-03 19:20:30',
                'deleted_at' => NULL,
            ),
            99 => 
            array (
                'id' => 100,
                'item' => 'BTCBOX_PASSWORD',
                'value' => NULL,
                'exchange_id' => NULL,
                'updated_at' => '2018-01-03 19:20:30',
                'created_at' => '2018-01-03 19:20:30',
                'deleted_at' => NULL,
            ),
            100 => 
            array (
                'id' => 101,
                'item' => 'BTCCHINA_APIKEY',
                'value' => NULL,
                'exchange_id' => NULL,
                'updated_at' => '2018-01-03 19:20:30',
                'created_at' => '2018-01-03 19:20:30',
                'deleted_at' => NULL,
            ),
            101 => 
            array (
                'id' => 102,
                'item' => 'BTCCHINA_SECRET',
                'value' => NULL,
                'exchange_id' => NULL,
                'updated_at' => '2018-01-03 19:20:30',
                'created_at' => '2018-01-03 19:20:30',
                'deleted_at' => NULL,
            ),
            102 => 
            array (
                'id' => 103,
                'item' => 'BTCCHINA_UID',
                'value' => NULL,
                'exchange_id' => NULL,
                'updated_at' => '2018-01-03 19:20:30',
                'created_at' => '2018-01-03 19:20:30',
                'deleted_at' => NULL,
            ),
            103 => 
            array (
                'id' => 104,
                'item' => 'BTCCHINA_PASSWORD',
                'value' => NULL,
                'exchange_id' => NULL,
                'updated_at' => '2018-01-03 19:20:30',
                'created_at' => '2018-01-03 19:20:30',
                'deleted_at' => NULL,
            ),
            104 => 
            array (
                'id' => 105,
                'item' => 'BTCEXCHANGE_APIKEY',
                'value' => NULL,
                'exchange_id' => NULL,
                'updated_at' => '2018-01-03 19:20:30',
                'created_at' => '2018-01-03 19:20:30',
                'deleted_at' => NULL,
            ),
            105 => 
            array (
                'id' => 106,
                'item' => 'BTCEXCHANGE_SECRET',
                'value' => NULL,
                'exchange_id' => NULL,
                'updated_at' => '2018-01-03 19:20:30',
                'created_at' => '2018-01-03 19:20:30',
                'deleted_at' => NULL,
            ),
            106 => 
            array (
                'id' => 107,
                'item' => 'BTCEXCHANGE_UID',
                'value' => NULL,
                'exchange_id' => NULL,
                'updated_at' => '2018-01-03 19:20:30',
                'created_at' => '2018-01-03 19:20:30',
                'deleted_at' => NULL,
            ),
            107 => 
            array (
                'id' => 108,
                'item' => 'BTCEXCHANGE_PASSWORD',
                'value' => NULL,
                'exchange_id' => NULL,
                'updated_at' => '2018-01-03 19:20:30',
                'created_at' => '2018-01-03 19:20:30',
                'deleted_at' => NULL,
            ),
            108 => 
            array (
                'id' => 109,
                'item' => 'BTCMARKETS_APIKEY',
                'value' => NULL,
                'exchange_id' => NULL,
                'updated_at' => '2018-01-03 19:20:30',
                'created_at' => '2018-01-03 19:20:30',
                'deleted_at' => NULL,
            ),
            109 => 
            array (
                'id' => 110,
                'item' => 'BTCMARKETS_SECRET',
                'value' => NULL,
                'exchange_id' => NULL,
                'updated_at' => '2018-01-03 19:20:30',
                'created_at' => '2018-01-03 19:20:30',
                'deleted_at' => NULL,
            ),
            110 => 
            array (
                'id' => 111,
                'item' => 'BTCMARKETS_UID',
                'value' => NULL,
                'exchange_id' => NULL,
                'updated_at' => '2018-01-03 19:20:30',
                'created_at' => '2018-01-03 19:20:30',
                'deleted_at' => NULL,
            ),
            111 => 
            array (
                'id' => 112,
                'item' => 'BTCMARKETS_PASSWORD',
                'value' => NULL,
                'exchange_id' => NULL,
                'updated_at' => '2018-01-03 19:20:30',
                'created_at' => '2018-01-03 19:20:30',
                'deleted_at' => NULL,
            ),
            112 => 
            array (
                'id' => 113,
                'item' => 'BTCTRADEUA_APIKEY',
                'value' => NULL,
                'exchange_id' => NULL,
                'updated_at' => '2018-01-03 19:20:30',
                'created_at' => '2018-01-03 19:20:30',
                'deleted_at' => NULL,
            ),
            113 => 
            array (
                'id' => 114,
                'item' => 'BTCTRADEUA_SECRET',
                'value' => NULL,
                'exchange_id' => NULL,
                'updated_at' => '2018-01-03 19:20:30',
                'created_at' => '2018-01-03 19:20:30',
                'deleted_at' => NULL,
            ),
            114 => 
            array (
                'id' => 115,
                'item' => 'BTCTRADEUA_UID',
                'value' => NULL,
                'exchange_id' => NULL,
                'updated_at' => '2018-01-03 19:20:30',
                'created_at' => '2018-01-03 19:20:30',
                'deleted_at' => NULL,
            ),
            115 => 
            array (
                'id' => 116,
                'item' => 'BTCTRADEUA_PASSWORD',
                'value' => NULL,
                'exchange_id' => NULL,
                'updated_at' => '2018-01-03 19:20:30',
                'created_at' => '2018-01-03 19:20:30',
                'deleted_at' => NULL,
            ),
            116 => 
            array (
                'id' => 117,
                'item' => 'BTCTURK_APIKEY',
                'value' => NULL,
                'exchange_id' => NULL,
                'updated_at' => '2018-01-03 19:20:30',
                'created_at' => '2018-01-03 19:20:30',
                'deleted_at' => NULL,
            ),
            117 => 
            array (
                'id' => 118,
                'item' => 'BTCTURK_SECRET',
                'value' => NULL,
                'exchange_id' => NULL,
                'updated_at' => '2018-01-03 19:20:30',
                'created_at' => '2018-01-03 19:20:30',
                'deleted_at' => NULL,
            ),
            118 => 
            array (
                'id' => 119,
                'item' => 'BTCTURK_UID',
                'value' => NULL,
                'exchange_id' => NULL,
                'updated_at' => '2018-01-03 19:20:30',
                'created_at' => '2018-01-03 19:20:30',
                'deleted_at' => NULL,
            ),
            119 => 
            array (
                'id' => 120,
                'item' => 'BTCTURK_PASSWORD',
                'value' => NULL,
                'exchange_id' => NULL,
                'updated_at' => '2018-01-03 19:20:30',
                'created_at' => '2018-01-03 19:20:30',
                'deleted_at' => NULL,
            ),
            120 => 
            array (
                'id' => 121,
                'item' => 'BTCX_APIKEY',
                'value' => NULL,
                'exchange_id' => NULL,
                'updated_at' => '2018-01-03 19:20:30',
                'created_at' => '2018-01-03 19:20:30',
                'deleted_at' => NULL,
            ),
            121 => 
            array (
                'id' => 122,
                'item' => 'BTCX_SECRET',
                'value' => NULL,
                'exchange_id' => NULL,
                'updated_at' => '2018-01-03 19:20:30',
                'created_at' => '2018-01-03 19:20:30',
                'deleted_at' => NULL,
            ),
            122 => 
            array (
                'id' => 123,
                'item' => 'BTCX_UID',
                'value' => NULL,
                'exchange_id' => NULL,
                'updated_at' => '2018-01-03 19:20:30',
                'created_at' => '2018-01-03 19:20:30',
                'deleted_at' => NULL,
            ),
            123 => 
            array (
                'id' => 124,
                'item' => 'BTCX_PASSWORD',
                'value' => NULL,
                'exchange_id' => NULL,
                'updated_at' => '2018-01-03 19:20:30',
                'created_at' => '2018-01-03 19:20:30',
                'deleted_at' => NULL,
            ),
            124 => 
            array (
                'id' => 125,
                'item' => 'BTER_APIKEY',
                'value' => NULL,
                'exchange_id' => NULL,
                'updated_at' => '2018-01-03 19:20:30',
                'created_at' => '2018-01-03 19:20:30',
                'deleted_at' => NULL,
            ),
            125 => 
            array (
                'id' => 126,
                'item' => 'BTER_SECRET',
                'value' => NULL,
                'exchange_id' => NULL,
                'updated_at' => '2018-01-03 19:20:30',
                'created_at' => '2018-01-03 19:20:30',
                'deleted_at' => NULL,
            ),
            126 => 
            array (
                'id' => 127,
                'item' => 'BTER_UID',
                'value' => NULL,
                'exchange_id' => NULL,
                'updated_at' => '2018-01-03 19:20:30',
                'created_at' => '2018-01-03 19:20:30',
                'deleted_at' => NULL,
            ),
            127 => 
            array (
                'id' => 128,
                'item' => 'BTER_PASSWORD',
                'value' => NULL,
                'exchange_id' => NULL,
                'updated_at' => '2018-01-03 19:20:30',
                'created_at' => '2018-01-03 19:20:30',
                'deleted_at' => NULL,
            ),
            128 => 
            array (
                'id' => 129,
                'item' => 'BXINTH_APIKEY',
                'value' => NULL,
                'exchange_id' => NULL,
                'updated_at' => '2018-01-03 19:20:30',
                'created_at' => '2018-01-03 19:20:30',
                'deleted_at' => NULL,
            ),
            129 => 
            array (
                'id' => 130,
                'item' => 'BXINTH_SECRET',
                'value' => NULL,
                'exchange_id' => NULL,
                'updated_at' => '2018-01-03 19:20:30',
                'created_at' => '2018-01-03 19:20:30',
                'deleted_at' => NULL,
            ),
            130 => 
            array (
                'id' => 131,
                'item' => 'BXINTH_UID',
                'value' => NULL,
                'exchange_id' => NULL,
                'updated_at' => '2018-01-03 19:20:30',
                'created_at' => '2018-01-03 19:20:30',
                'deleted_at' => NULL,
            ),
            131 => 
            array (
                'id' => 132,
                'item' => 'BXINTH_PASSWORD',
                'value' => NULL,
                'exchange_id' => NULL,
                'updated_at' => '2018-01-03 19:20:30',
                'created_at' => '2018-01-03 19:20:30',
                'deleted_at' => NULL,
            ),
            132 => 
            array (
                'id' => 133,
                'item' => 'CCEX_APIKEY',
                'value' => NULL,
                'exchange_id' => NULL,
                'updated_at' => '2018-01-03 19:20:30',
                'created_at' => '2018-01-03 19:20:30',
                'deleted_at' => NULL,
            ),
            133 => 
            array (
                'id' => 134,
                'item' => 'CCEX_SECRET',
                'value' => NULL,
                'exchange_id' => NULL,
                'updated_at' => '2018-01-03 19:20:31',
                'created_at' => '2018-01-03 19:20:31',
                'deleted_at' => NULL,
            ),
            134 => 
            array (
                'id' => 135,
                'item' => 'CCEX_UID',
                'value' => NULL,
                'exchange_id' => NULL,
                'updated_at' => '2018-01-03 19:20:31',
                'created_at' => '2018-01-03 19:20:31',
                'deleted_at' => NULL,
            ),
            135 => 
            array (
                'id' => 136,
                'item' => 'CCEX_PASSWORD',
                'value' => NULL,
                'exchange_id' => NULL,
                'updated_at' => '2018-01-03 19:20:31',
                'created_at' => '2018-01-03 19:20:31',
                'deleted_at' => NULL,
            ),
            136 => 
            array (
                'id' => 137,
                'item' => 'CEX_APIKEY',
                'value' => NULL,
                'exchange_id' => NULL,
                'updated_at' => '2018-01-03 19:20:31',
                'created_at' => '2018-01-03 19:20:31',
                'deleted_at' => NULL,
            ),
            137 => 
            array (
                'id' => 138,
                'item' => 'CEX_SECRET',
                'value' => NULL,
                'exchange_id' => NULL,
                'updated_at' => '2018-01-03 19:20:31',
                'created_at' => '2018-01-03 19:20:31',
                'deleted_at' => NULL,
            ),
            138 => 
            array (
                'id' => 139,
                'item' => 'CEX_UID',
                'value' => NULL,
                'exchange_id' => NULL,
                'updated_at' => '2018-01-03 19:20:31',
                'created_at' => '2018-01-03 19:20:31',
                'deleted_at' => NULL,
            ),
            139 => 
            array (
                'id' => 140,
                'item' => 'CEX_PASSWORD',
                'value' => NULL,
                'exchange_id' => NULL,
                'updated_at' => '2018-01-03 19:20:31',
                'created_at' => '2018-01-03 19:20:31',
                'deleted_at' => NULL,
            ),
            140 => 
            array (
                'id' => 141,
                'item' => 'CHBTC_APIKEY',
                'value' => NULL,
                'exchange_id' => NULL,
                'updated_at' => '2018-01-03 19:20:31',
                'created_at' => '2018-01-03 19:20:31',
                'deleted_at' => NULL,
            ),
            141 => 
            array (
                'id' => 142,
                'item' => 'CHBTC_SECRET',
                'value' => NULL,
                'exchange_id' => NULL,
                'updated_at' => '2018-01-03 19:20:31',
                'created_at' => '2018-01-03 19:20:31',
                'deleted_at' => NULL,
            ),
            142 => 
            array (
                'id' => 143,
                'item' => 'CHBTC_UID',
                'value' => NULL,
                'exchange_id' => NULL,
                'updated_at' => '2018-01-03 19:20:31',
                'created_at' => '2018-01-03 19:20:31',
                'deleted_at' => NULL,
            ),
            143 => 
            array (
                'id' => 144,
                'item' => 'CHBTC_PASSWORD',
                'value' => NULL,
                'exchange_id' => NULL,
                'updated_at' => '2018-01-03 19:20:31',
                'created_at' => '2018-01-03 19:20:31',
                'deleted_at' => NULL,
            ),
            144 => 
            array (
                'id' => 145,
                'item' => 'CHILEBIT_APIKEY',
                'value' => NULL,
                'exchange_id' => NULL,
                'updated_at' => '2018-01-03 19:20:31',
                'created_at' => '2018-01-03 19:20:31',
                'deleted_at' => NULL,
            ),
            145 => 
            array (
                'id' => 146,
                'item' => 'CHILEBIT_SECRET',
                'value' => NULL,
                'exchange_id' => NULL,
                'updated_at' => '2018-01-03 19:20:31',
                'created_at' => '2018-01-03 19:20:31',
                'deleted_at' => NULL,
            ),
            146 => 
            array (
                'id' => 147,
                'item' => 'CHILEBIT_UID',
                'value' => NULL,
                'exchange_id' => NULL,
                'updated_at' => '2018-01-03 19:20:31',
                'created_at' => '2018-01-03 19:20:31',
                'deleted_at' => NULL,
            ),
            147 => 
            array (
                'id' => 148,
                'item' => 'CHILEBIT_PASSWORD',
                'value' => NULL,
                'exchange_id' => NULL,
                'updated_at' => '2018-01-03 19:20:31',
                'created_at' => '2018-01-03 19:20:31',
                'deleted_at' => NULL,
            ),
            148 => 
            array (
                'id' => 149,
                'item' => 'COINCHECK_APIKEY',
                'value' => NULL,
                'exchange_id' => NULL,
                'updated_at' => '2018-01-03 19:20:31',
                'created_at' => '2018-01-03 19:20:31',
                'deleted_at' => NULL,
            ),
            149 => 
            array (
                'id' => 150,
                'item' => 'COINCHECK_SECRET',
                'value' => NULL,
                'exchange_id' => NULL,
                'updated_at' => '2018-01-03 19:20:31',
                'created_at' => '2018-01-03 19:20:31',
                'deleted_at' => NULL,
            ),
            150 => 
            array (
                'id' => 151,
                'item' => 'COINCHECK_UID',
                'value' => NULL,
                'exchange_id' => NULL,
                'updated_at' => '2018-01-03 19:20:31',
                'created_at' => '2018-01-03 19:20:31',
                'deleted_at' => NULL,
            ),
            151 => 
            array (
                'id' => 152,
                'item' => 'COINCHECK_PASSWORD',
                'value' => NULL,
                'exchange_id' => NULL,
                'updated_at' => '2018-01-03 19:20:31',
                'created_at' => '2018-01-03 19:20:31',
                'deleted_at' => NULL,
            ),
            152 => 
            array (
                'id' => 153,
                'item' => 'COINFLOOR_APIKEY',
                'value' => NULL,
                'exchange_id' => NULL,
                'updated_at' => '2018-01-03 19:20:31',
                'created_at' => '2018-01-03 19:20:31',
                'deleted_at' => NULL,
            ),
            153 => 
            array (
                'id' => 154,
                'item' => 'COINFLOOR_SECRET',
                'value' => NULL,
                'exchange_id' => NULL,
                'updated_at' => '2018-01-03 19:20:31',
                'created_at' => '2018-01-03 19:20:31',
                'deleted_at' => NULL,
            ),
            154 => 
            array (
                'id' => 155,
                'item' => 'COINFLOOR_UID',
                'value' => NULL,
                'exchange_id' => NULL,
                'updated_at' => '2018-01-03 19:20:31',
                'created_at' => '2018-01-03 19:20:31',
                'deleted_at' => NULL,
            ),
            155 => 
            array (
                'id' => 156,
                'item' => 'COINFLOOR_PASSWORD',
                'value' => NULL,
                'exchange_id' => NULL,
                'updated_at' => '2018-01-03 19:20:31',
                'created_at' => '2018-01-03 19:20:31',
                'deleted_at' => NULL,
            ),
            156 => 
            array (
                'id' => 157,
                'item' => 'COINGI_APIKEY',
                'value' => NULL,
                'exchange_id' => NULL,
                'updated_at' => '2018-01-03 19:20:31',
                'created_at' => '2018-01-03 19:20:31',
                'deleted_at' => NULL,
            ),
            157 => 
            array (
                'id' => 158,
                'item' => 'COINGI_SECRET',
                'value' => NULL,
                'exchange_id' => NULL,
                'updated_at' => '2018-01-03 19:20:31',
                'created_at' => '2018-01-03 19:20:31',
                'deleted_at' => NULL,
            ),
            158 => 
            array (
                'id' => 159,
                'item' => 'COINGI_UID',
                'value' => NULL,
                'exchange_id' => NULL,
                'updated_at' => '2018-01-03 19:20:31',
                'created_at' => '2018-01-03 19:20:31',
                'deleted_at' => NULL,
            ),
            159 => 
            array (
                'id' => 160,
                'item' => 'COINGI_PASSWORD',
                'value' => NULL,
                'exchange_id' => NULL,
                'updated_at' => '2018-01-03 19:20:31',
                'created_at' => '2018-01-03 19:20:31',
                'deleted_at' => NULL,
            ),
            160 => 
            array (
                'id' => 161,
                'item' => 'COINMARKETCAP_APIKEY',
                'value' => NULL,
                'exchange_id' => NULL,
                'updated_at' => '2018-01-03 19:20:31',
                'created_at' => '2018-01-03 19:20:31',
                'deleted_at' => NULL,
            ),
            161 => 
            array (
                'id' => 162,
                'item' => 'COINMARKETCAP_SECRET',
                'value' => NULL,
                'exchange_id' => NULL,
                'updated_at' => '2018-01-03 19:20:31',
                'created_at' => '2018-01-03 19:20:31',
                'deleted_at' => NULL,
            ),
            162 => 
            array (
                'id' => 163,
                'item' => 'COINMARKETCAP_UID',
                'value' => NULL,
                'exchange_id' => NULL,
                'updated_at' => '2018-01-03 19:20:31',
                'created_at' => '2018-01-03 19:20:31',
                'deleted_at' => NULL,
            ),
            163 => 
            array (
                'id' => 164,
                'item' => 'COINMARKETCAP_PASSWORD',
                'value' => NULL,
                'exchange_id' => NULL,
                'updated_at' => '2018-01-03 19:20:31',
                'created_at' => '2018-01-03 19:20:31',
                'deleted_at' => NULL,
            ),
            164 => 
            array (
                'id' => 165,
                'item' => 'COINMATE_APIKEY',
                'value' => NULL,
                'exchange_id' => NULL,
                'updated_at' => '2018-01-03 19:20:31',
                'created_at' => '2018-01-03 19:20:31',
                'deleted_at' => NULL,
            ),
            165 => 
            array (
                'id' => 166,
                'item' => 'COINMATE_SECRET',
                'value' => NULL,
                'exchange_id' => NULL,
                'updated_at' => '2018-01-03 19:20:31',
                'created_at' => '2018-01-03 19:20:31',
                'deleted_at' => NULL,
            ),
            166 => 
            array (
                'id' => 167,
                'item' => 'COINMATE_UID',
                'value' => NULL,
                'exchange_id' => NULL,
                'updated_at' => '2018-01-03 19:20:31',
                'created_at' => '2018-01-03 19:20:31',
                'deleted_at' => NULL,
            ),
            167 => 
            array (
                'id' => 168,
                'item' => 'COINMATE_PASSWORD',
                'value' => NULL,
                'exchange_id' => NULL,
                'updated_at' => '2018-01-03 19:20:31',
                'created_at' => '2018-01-03 19:20:31',
                'deleted_at' => NULL,
            ),
            168 => 
            array (
                'id' => 169,
                'item' => 'COINSECURE_APIKEY',
                'value' => NULL,
                'exchange_id' => NULL,
                'updated_at' => '2018-01-03 19:20:31',
                'created_at' => '2018-01-03 19:20:31',
                'deleted_at' => NULL,
            ),
            169 => 
            array (
                'id' => 170,
                'item' => 'COINSECURE_SECRET',
                'value' => NULL,
                'exchange_id' => NULL,
                'updated_at' => '2018-01-03 19:20:31',
                'created_at' => '2018-01-03 19:20:31',
                'deleted_at' => NULL,
            ),
            170 => 
            array (
                'id' => 171,
                'item' => 'COINSECURE_UID',
                'value' => NULL,
                'exchange_id' => NULL,
                'updated_at' => '2018-01-03 19:20:31',
                'created_at' => '2018-01-03 19:20:31',
                'deleted_at' => NULL,
            ),
            171 => 
            array (
                'id' => 172,
                'item' => 'COINSECURE_PASSWORD',
                'value' => NULL,
                'exchange_id' => NULL,
                'updated_at' => '2018-01-03 19:20:31',
                'created_at' => '2018-01-03 19:20:31',
                'deleted_at' => NULL,
            ),
            172 => 
            array (
                'id' => 173,
                'item' => 'COINSPOT_APIKEY',
                'value' => NULL,
                'exchange_id' => NULL,
                'updated_at' => '2018-01-03 19:20:31',
                'created_at' => '2018-01-03 19:20:31',
                'deleted_at' => NULL,
            ),
            173 => 
            array (
                'id' => 174,
                'item' => 'COINSPOT_SECRET',
                'value' => NULL,
                'exchange_id' => NULL,
                'updated_at' => '2018-01-03 19:20:31',
                'created_at' => '2018-01-03 19:20:31',
                'deleted_at' => NULL,
            ),
            174 => 
            array (
                'id' => 175,
                'item' => 'COINSPOT_UID',
                'value' => NULL,
                'exchange_id' => NULL,
                'updated_at' => '2018-01-03 19:20:31',
                'created_at' => '2018-01-03 19:20:31',
                'deleted_at' => NULL,
            ),
            175 => 
            array (
                'id' => 176,
                'item' => 'COINSPOT_PASSWORD',
                'value' => NULL,
                'exchange_id' => NULL,
                'updated_at' => '2018-01-03 19:20:31',
                'created_at' => '2018-01-03 19:20:31',
                'deleted_at' => NULL,
            ),
            176 => 
            array (
                'id' => 177,
                'item' => 'CRYPTOPIA_APIKEY',
                'value' => NULL,
                'exchange_id' => NULL,
                'updated_at' => '2018-01-03 19:20:31',
                'created_at' => '2018-01-03 19:20:31',
                'deleted_at' => NULL,
            ),
            177 => 
            array (
                'id' => 178,
                'item' => 'CRYPTOPIA_SECRET',
                'value' => NULL,
                'exchange_id' => NULL,
                'updated_at' => '2018-01-03 19:20:31',
                'created_at' => '2018-01-03 19:20:31',
                'deleted_at' => NULL,
            ),
            178 => 
            array (
                'id' => 179,
                'item' => 'CRYPTOPIA_UID',
                'value' => NULL,
                'exchange_id' => NULL,
                'updated_at' => '2018-01-03 19:20:31',
                'created_at' => '2018-01-03 19:20:31',
                'deleted_at' => NULL,
            ),
            179 => 
            array (
                'id' => 180,
                'item' => 'CRYPTOPIA_PASSWORD',
                'value' => NULL,
                'exchange_id' => NULL,
                'updated_at' => '2018-01-03 19:20:31',
                'created_at' => '2018-01-03 19:20:31',
                'deleted_at' => NULL,
            ),
            180 => 
            array (
                'id' => 181,
                'item' => 'DSX_APIKEY',
                'value' => NULL,
                'exchange_id' => NULL,
                'updated_at' => '2018-01-03 19:20:31',
                'created_at' => '2018-01-03 19:20:31',
                'deleted_at' => NULL,
            ),
            181 => 
            array (
                'id' => 182,
                'item' => 'DSX_SECRET',
                'value' => NULL,
                'exchange_id' => NULL,
                'updated_at' => '2018-01-03 19:20:31',
                'created_at' => '2018-01-03 19:20:31',
                'deleted_at' => NULL,
            ),
            182 => 
            array (
                'id' => 183,
                'item' => 'DSX_UID',
                'value' => NULL,
                'exchange_id' => NULL,
                'updated_at' => '2018-01-03 19:20:31',
                'created_at' => '2018-01-03 19:20:31',
                'deleted_at' => NULL,
            ),
            183 => 
            array (
                'id' => 184,
                'item' => 'DSX_PASSWORD',
                'value' => NULL,
                'exchange_id' => NULL,
                'updated_at' => '2018-01-03 19:20:31',
                'created_at' => '2018-01-03 19:20:31',
                'deleted_at' => NULL,
            ),
            184 => 
            array (
                'id' => 185,
                'item' => 'EXMO_APIKEY',
                'value' => NULL,
                'exchange_id' => NULL,
                'updated_at' => '2018-01-03 19:20:31',
                'created_at' => '2018-01-03 19:20:31',
                'deleted_at' => NULL,
            ),
            185 => 
            array (
                'id' => 186,
                'item' => 'EXMO_SECRET',
                'value' => NULL,
                'exchange_id' => NULL,
                'updated_at' => '2018-01-03 19:20:31',
                'created_at' => '2018-01-03 19:20:31',
                'deleted_at' => NULL,
            ),
            186 => 
            array (
                'id' => 187,
                'item' => 'EXMO_UID',
                'value' => NULL,
                'exchange_id' => NULL,
                'updated_at' => '2018-01-03 19:20:31',
                'created_at' => '2018-01-03 19:20:31',
                'deleted_at' => NULL,
            ),
            187 => 
            array (
                'id' => 188,
                'item' => 'EXMO_PASSWORD',
                'value' => NULL,
                'exchange_id' => NULL,
                'updated_at' => '2018-01-03 19:20:31',
                'created_at' => '2018-01-03 19:20:31',
                'deleted_at' => NULL,
            ),
            188 => 
            array (
                'id' => 189,
                'item' => 'FLOWBTC_APIKEY',
                'value' => NULL,
                'exchange_id' => NULL,
                'updated_at' => '2018-01-03 19:20:31',
                'created_at' => '2018-01-03 19:20:31',
                'deleted_at' => NULL,
            ),
            189 => 
            array (
                'id' => 190,
                'item' => 'FLOWBTC_SECRET',
                'value' => NULL,
                'exchange_id' => NULL,
                'updated_at' => '2018-01-03 19:20:31',
                'created_at' => '2018-01-03 19:20:31',
                'deleted_at' => NULL,
            ),
            190 => 
            array (
                'id' => 191,
                'item' => 'FLOWBTC_UID',
                'value' => NULL,
                'exchange_id' => NULL,
                'updated_at' => '2018-01-03 19:20:31',
                'created_at' => '2018-01-03 19:20:31',
                'deleted_at' => NULL,
            ),
            191 => 
            array (
                'id' => 192,
                'item' => 'FLOWBTC_PASSWORD',
                'value' => NULL,
                'exchange_id' => NULL,
                'updated_at' => '2018-01-03 19:20:31',
                'created_at' => '2018-01-03 19:20:31',
                'deleted_at' => NULL,
            ),
            192 => 
            array (
                'id' => 193,
                'item' => 'FOXBIT_APIKEY',
                'value' => NULL,
                'exchange_id' => NULL,
                'updated_at' => '2018-01-03 19:20:31',
                'created_at' => '2018-01-03 19:20:31',
                'deleted_at' => NULL,
            ),
            193 => 
            array (
                'id' => 194,
                'item' => 'FOXBIT_SECRET',
                'value' => NULL,
                'exchange_id' => NULL,
                'updated_at' => '2018-01-03 19:20:31',
                'created_at' => '2018-01-03 19:20:31',
                'deleted_at' => NULL,
            ),
            194 => 
            array (
                'id' => 195,
                'item' => 'FOXBIT_UID',
                'value' => NULL,
                'exchange_id' => NULL,
                'updated_at' => '2018-01-03 19:20:31',
                'created_at' => '2018-01-03 19:20:31',
                'deleted_at' => NULL,
            ),
            195 => 
            array (
                'id' => 196,
                'item' => 'FOXBIT_PASSWORD',
                'value' => NULL,
                'exchange_id' => NULL,
                'updated_at' => '2018-01-03 19:20:31',
                'created_at' => '2018-01-03 19:20:31',
                'deleted_at' => NULL,
            ),
            196 => 
            array (
                'id' => 197,
                'item' => 'FYBSE_APIKEY',
                'value' => NULL,
                'exchange_id' => NULL,
                'updated_at' => '2018-01-03 19:20:31',
                'created_at' => '2018-01-03 19:20:31',
                'deleted_at' => NULL,
            ),
            197 => 
            array (
                'id' => 198,
                'item' => 'FYBSE_SECRET',
                'value' => NULL,
                'exchange_id' => NULL,
                'updated_at' => '2018-01-03 19:20:31',
                'created_at' => '2018-01-03 19:20:31',
                'deleted_at' => NULL,
            ),
            198 => 
            array (
                'id' => 199,
                'item' => 'FYBSE_UID',
                'value' => NULL,
                'exchange_id' => NULL,
                'updated_at' => '2018-01-03 19:20:31',
                'created_at' => '2018-01-03 19:20:31',
                'deleted_at' => NULL,
            ),
            199 => 
            array (
                'id' => 200,
                'item' => 'FYBSE_PASSWORD',
                'value' => NULL,
                'exchange_id' => NULL,
                'updated_at' => '2018-01-03 19:20:31',
                'created_at' => '2018-01-03 19:20:31',
                'deleted_at' => NULL,
            ),
            200 => 
            array (
                'id' => 201,
                'item' => 'FYBSG_APIKEY',
                'value' => NULL,
                'exchange_id' => NULL,
                'updated_at' => '2018-01-03 19:20:31',
                'created_at' => '2018-01-03 19:20:31',
                'deleted_at' => NULL,
            ),
            201 => 
            array (
                'id' => 202,
                'item' => 'FYBSG_SECRET',
                'value' => NULL,
                'exchange_id' => NULL,
                'updated_at' => '2018-01-03 19:20:31',
                'created_at' => '2018-01-03 19:20:31',
                'deleted_at' => NULL,
            ),
            202 => 
            array (
                'id' => 203,
                'item' => 'FYBSG_UID',
                'value' => NULL,
                'exchange_id' => NULL,
                'updated_at' => '2018-01-03 19:20:31',
                'created_at' => '2018-01-03 19:20:31',
                'deleted_at' => NULL,
            ),
            203 => 
            array (
                'id' => 204,
                'item' => 'FYBSG_PASSWORD',
                'value' => NULL,
                'exchange_id' => NULL,
                'updated_at' => '2018-01-03 19:20:31',
                'created_at' => '2018-01-03 19:20:31',
                'deleted_at' => NULL,
            ),
            204 => 
            array (
                'id' => 205,
                'item' => 'GATECOIN_APIKEY',
                'value' => NULL,
                'exchange_id' => NULL,
                'updated_at' => '2018-01-03 19:20:31',
                'created_at' => '2018-01-03 19:20:31',
                'deleted_at' => NULL,
            ),
            205 => 
            array (
                'id' => 206,
                'item' => 'GATECOIN_SECRET',
                'value' => NULL,
                'exchange_id' => NULL,
                'updated_at' => '2018-01-03 19:20:31',
                'created_at' => '2018-01-03 19:20:31',
                'deleted_at' => NULL,
            ),
            206 => 
            array (
                'id' => 207,
                'item' => 'GATECOIN_UID',
                'value' => NULL,
                'exchange_id' => NULL,
                'updated_at' => '2018-01-03 19:20:31',
                'created_at' => '2018-01-03 19:20:31',
                'deleted_at' => NULL,
            ),
            207 => 
            array (
                'id' => 208,
                'item' => 'GATECOIN_PASSWORD',
                'value' => NULL,
                'exchange_id' => NULL,
                'updated_at' => '2018-01-03 19:20:31',
                'created_at' => '2018-01-03 19:20:31',
                'deleted_at' => NULL,
            ),
            208 => 
            array (
                'id' => 209,
                'item' => 'GATEIO_APIKEY',
                'value' => NULL,
                'exchange_id' => NULL,
                'updated_at' => '2018-01-03 19:20:31',
                'created_at' => '2018-01-03 19:20:31',
                'deleted_at' => NULL,
            ),
            209 => 
            array (
                'id' => 210,
                'item' => 'GATEIO_SECRET',
                'value' => NULL,
                'exchange_id' => NULL,
                'updated_at' => '2018-01-03 19:20:31',
                'created_at' => '2018-01-03 19:20:31',
                'deleted_at' => NULL,
            ),
            210 => 
            array (
                'id' => 211,
                'item' => 'GATEIO_UID',
                'value' => NULL,
                'exchange_id' => NULL,
                'updated_at' => '2018-01-03 19:20:31',
                'created_at' => '2018-01-03 19:20:31',
                'deleted_at' => NULL,
            ),
            211 => 
            array (
                'id' => 212,
                'item' => 'GATEIO_PASSWORD',
                'value' => NULL,
                'exchange_id' => NULL,
                'updated_at' => '2018-01-03 19:20:31',
                'created_at' => '2018-01-03 19:20:31',
                'deleted_at' => NULL,
            ),
            212 => 
            array (
                'id' => 213,
                'item' => 'GDAX_APIKEY',
                'value' => NULL,
                'exchange_id' => NULL,
                'updated_at' => '2018-01-03 19:20:31',
                'created_at' => '2018-01-03 19:20:31',
                'deleted_at' => NULL,
            ),
            213 => 
            array (
                'id' => 214,
                'item' => 'GDAX_SECRET',
                'value' => NULL,
                'exchange_id' => NULL,
                'updated_at' => '2018-01-03 19:20:31',
                'created_at' => '2018-01-03 19:20:31',
                'deleted_at' => NULL,
            ),
            214 => 
            array (
                'id' => 215,
                'item' => 'GDAX_UID',
                'value' => NULL,
                'exchange_id' => NULL,
                'updated_at' => '2018-01-03 19:20:31',
                'created_at' => '2018-01-03 19:20:31',
                'deleted_at' => NULL,
            ),
            215 => 
            array (
                'id' => 216,
                'item' => 'GDAX_PASSWORD',
                'value' => NULL,
                'exchange_id' => NULL,
                'updated_at' => '2018-01-03 19:20:31',
                'created_at' => '2018-01-03 19:20:31',
                'deleted_at' => NULL,
            ),
            216 => 
            array (
                'id' => 217,
                'item' => 'GEMINI_APIKEY',
                'value' => NULL,
                'exchange_id' => NULL,
                'updated_at' => '2018-01-03 19:20:31',
                'created_at' => '2018-01-03 19:20:31',
                'deleted_at' => NULL,
            ),
            217 => 
            array (
                'id' => 218,
                'item' => 'GEMINI_SECRET',
                'value' => NULL,
                'exchange_id' => NULL,
                'updated_at' => '2018-01-03 19:20:31',
                'created_at' => '2018-01-03 19:20:31',
                'deleted_at' => NULL,
            ),
            218 => 
            array (
                'id' => 219,
                'item' => 'GEMINI_UID',
                'value' => NULL,
                'exchange_id' => NULL,
                'updated_at' => '2018-01-03 19:20:31',
                'created_at' => '2018-01-03 19:20:31',
                'deleted_at' => NULL,
            ),
            219 => 
            array (
                'id' => 220,
                'item' => 'GEMINI_PASSWORD',
                'value' => NULL,
                'exchange_id' => NULL,
                'updated_at' => '2018-01-03 19:20:31',
                'created_at' => '2018-01-03 19:20:31',
                'deleted_at' => NULL,
            ),
            220 => 
            array (
                'id' => 221,
                'item' => 'GETBTC_APIKEY',
                'value' => NULL,
                'exchange_id' => NULL,
                'updated_at' => '2018-01-03 19:20:31',
                'created_at' => '2018-01-03 19:20:31',
                'deleted_at' => NULL,
            ),
            221 => 
            array (
                'id' => 222,
                'item' => 'GETBTC_SECRET',
                'value' => NULL,
                'exchange_id' => NULL,
                'updated_at' => '2018-01-03 19:20:31',
                'created_at' => '2018-01-03 19:20:31',
                'deleted_at' => NULL,
            ),
            222 => 
            array (
                'id' => 223,
                'item' => 'GETBTC_UID',
                'value' => NULL,
                'exchange_id' => NULL,
                'updated_at' => '2018-01-03 19:20:31',
                'created_at' => '2018-01-03 19:20:31',
                'deleted_at' => NULL,
            ),
            223 => 
            array (
                'id' => 224,
                'item' => 'GETBTC_PASSWORD',
                'value' => NULL,
                'exchange_id' => NULL,
                'updated_at' => '2018-01-03 19:20:31',
                'created_at' => '2018-01-03 19:20:31',
                'deleted_at' => NULL,
            ),
            224 => 
            array (
                'id' => 225,
                'item' => 'HITBTC_APIKEY',
                'value' => NULL,
                'exchange_id' => NULL,
                'updated_at' => '2018-01-03 19:20:31',
                'created_at' => '2018-01-03 19:20:31',
                'deleted_at' => NULL,
            ),
            225 => 
            array (
                'id' => 226,
                'item' => 'HITBTC_SECRET',
                'value' => NULL,
                'exchange_id' => NULL,
                'updated_at' => '2018-01-03 19:20:31',
                'created_at' => '2018-01-03 19:20:31',
                'deleted_at' => NULL,
            ),
            226 => 
            array (
                'id' => 227,
                'item' => 'HITBTC_UID',
                'value' => NULL,
                'exchange_id' => NULL,
                'updated_at' => '2018-01-03 19:20:31',
                'created_at' => '2018-01-03 19:20:31',
                'deleted_at' => NULL,
            ),
            227 => 
            array (
                'id' => 228,
                'item' => 'HITBTC_PASSWORD',
                'value' => NULL,
                'exchange_id' => NULL,
                'updated_at' => '2018-01-03 19:20:31',
                'created_at' => '2018-01-03 19:20:31',
                'deleted_at' => NULL,
            ),
            228 => 
            array (
                'id' => 229,
                'item' => 'HITBTC2_APIKEY',
                'value' => NULL,
                'exchange_id' => NULL,
                'updated_at' => '2018-01-03 19:20:31',
                'created_at' => '2018-01-03 19:20:31',
                'deleted_at' => NULL,
            ),
            229 => 
            array (
                'id' => 230,
                'item' => 'HITBTC2_SECRET',
                'value' => NULL,
                'exchange_id' => NULL,
                'updated_at' => '2018-01-03 19:20:31',
                'created_at' => '2018-01-03 19:20:31',
                'deleted_at' => NULL,
            ),
            230 => 
            array (
                'id' => 231,
                'item' => 'HITBTC2_UID',
                'value' => NULL,
                'exchange_id' => NULL,
                'updated_at' => '2018-01-03 19:20:31',
                'created_at' => '2018-01-03 19:20:31',
                'deleted_at' => NULL,
            ),
            231 => 
            array (
                'id' => 232,
                'item' => 'HITBTC2_PASSWORD',
                'value' => NULL,
                'exchange_id' => NULL,
                'updated_at' => '2018-01-03 19:20:31',
                'created_at' => '2018-01-03 19:20:31',
                'deleted_at' => NULL,
            ),
            232 => 
            array (
                'id' => 233,
                'item' => 'HUOBI_APIKEY',
                'value' => NULL,
                'exchange_id' => NULL,
                'updated_at' => '2018-01-03 19:20:31',
                'created_at' => '2018-01-03 19:20:31',
                'deleted_at' => NULL,
            ),
            233 => 
            array (
                'id' => 234,
                'item' => 'HUOBI_SECRET',
                'value' => NULL,
                'exchange_id' => NULL,
                'updated_at' => '2018-01-03 19:20:31',
                'created_at' => '2018-01-03 19:20:31',
                'deleted_at' => NULL,
            ),
            234 => 
            array (
                'id' => 235,
                'item' => 'HUOBI_UID',
                'value' => NULL,
                'exchange_id' => NULL,
                'updated_at' => '2018-01-03 19:20:31',
                'created_at' => '2018-01-03 19:20:31',
                'deleted_at' => NULL,
            ),
            235 => 
            array (
                'id' => 236,
                'item' => 'HUOBI_PASSWORD',
                'value' => NULL,
                'exchange_id' => NULL,
                'updated_at' => '2018-01-03 19:20:31',
                'created_at' => '2018-01-03 19:20:31',
                'deleted_at' => NULL,
            ),
            236 => 
            array (
                'id' => 237,
                'item' => 'HUOBICNY_APIKEY',
                'value' => NULL,
                'exchange_id' => NULL,
                'updated_at' => '2018-01-03 19:20:31',
                'created_at' => '2018-01-03 19:20:31',
                'deleted_at' => NULL,
            ),
            237 => 
            array (
                'id' => 238,
                'item' => 'HUOBICNY_SECRET',
                'value' => NULL,
                'exchange_id' => NULL,
                'updated_at' => '2018-01-03 19:20:31',
                'created_at' => '2018-01-03 19:20:31',
                'deleted_at' => NULL,
            ),
            238 => 
            array (
                'id' => 239,
                'item' => 'HUOBICNY_UID',
                'value' => NULL,
                'exchange_id' => NULL,
                'updated_at' => '2018-01-03 19:20:31',
                'created_at' => '2018-01-03 19:20:31',
                'deleted_at' => NULL,
            ),
            239 => 
            array (
                'id' => 240,
                'item' => 'HUOBICNY_PASSWORD',
                'value' => NULL,
                'exchange_id' => NULL,
                'updated_at' => '2018-01-03 19:20:31',
                'created_at' => '2018-01-03 19:20:31',
                'deleted_at' => NULL,
            ),
            240 => 
            array (
                'id' => 241,
                'item' => 'HUOBIPRO_APIKEY',
                'value' => NULL,
                'exchange_id' => NULL,
                'updated_at' => '2018-01-03 19:20:31',
                'created_at' => '2018-01-03 19:20:31',
                'deleted_at' => NULL,
            ),
            241 => 
            array (
                'id' => 242,
                'item' => 'HUOBIPRO_SECRET',
                'value' => NULL,
                'exchange_id' => NULL,
                'updated_at' => '2018-01-03 19:20:31',
                'created_at' => '2018-01-03 19:20:31',
                'deleted_at' => NULL,
            ),
            242 => 
            array (
                'id' => 243,
                'item' => 'HUOBIPRO_UID',
                'value' => NULL,
                'exchange_id' => NULL,
                'updated_at' => '2018-01-03 19:20:31',
                'created_at' => '2018-01-03 19:20:31',
                'deleted_at' => NULL,
            ),
            243 => 
            array (
                'id' => 244,
                'item' => 'HUOBIPRO_PASSWORD',
                'value' => NULL,
                'exchange_id' => NULL,
                'updated_at' => '2018-01-03 19:20:31',
                'created_at' => '2018-01-03 19:20:31',
                'deleted_at' => NULL,
            ),
            244 => 
            array (
                'id' => 245,
                'item' => 'INDEPENDENTRESERVE_APIKEY',
                'value' => NULL,
                'exchange_id' => NULL,
                'updated_at' => '2018-01-03 19:20:31',
                'created_at' => '2018-01-03 19:20:31',
                'deleted_at' => NULL,
            ),
            245 => 
            array (
                'id' => 246,
                'item' => 'INDEPENDENTRESERVE_SECRET',
                'value' => NULL,
                'exchange_id' => NULL,
                'updated_at' => '2018-01-03 19:20:31',
                'created_at' => '2018-01-03 19:20:31',
                'deleted_at' => NULL,
            ),
            246 => 
            array (
                'id' => 247,
                'item' => 'INDEPENDENTRESERVE_UID',
                'value' => NULL,
                'exchange_id' => NULL,
                'updated_at' => '2018-01-03 19:20:31',
                'created_at' => '2018-01-03 19:20:31',
                'deleted_at' => NULL,
            ),
            247 => 
            array (
                'id' => 248,
                'item' => 'INDEPENDENTRESERVE_PASSWORD',
                'value' => NULL,
                'exchange_id' => NULL,
                'updated_at' => '2018-01-03 19:20:31',
                'created_at' => '2018-01-03 19:20:31',
                'deleted_at' => NULL,
            ),
            248 => 
            array (
                'id' => 249,
                'item' => 'ITBIT_APIKEY',
                'value' => NULL,
                'exchange_id' => NULL,
                'updated_at' => '2018-01-03 19:20:31',
                'created_at' => '2018-01-03 19:20:31',
                'deleted_at' => NULL,
            ),
            249 => 
            array (
                'id' => 250,
                'item' => 'ITBIT_SECRET',
                'value' => NULL,
                'exchange_id' => NULL,
                'updated_at' => '2018-01-03 19:20:31',
                'created_at' => '2018-01-03 19:20:31',
                'deleted_at' => NULL,
            ),
            250 => 
            array (
                'id' => 251,
                'item' => 'ITBIT_UID',
                'value' => NULL,
                'exchange_id' => NULL,
                'updated_at' => '2018-01-03 19:20:31',
                'created_at' => '2018-01-03 19:20:31',
                'deleted_at' => NULL,
            ),
            251 => 
            array (
                'id' => 252,
                'item' => 'ITBIT_PASSWORD',
                'value' => NULL,
                'exchange_id' => NULL,
                'updated_at' => '2018-01-03 19:20:31',
                'created_at' => '2018-01-03 19:20:31',
                'deleted_at' => NULL,
            ),
            252 => 
            array (
                'id' => 253,
                'item' => 'JUBI_APIKEY',
                'value' => NULL,
                'exchange_id' => NULL,
                'updated_at' => '2018-01-03 19:20:31',
                'created_at' => '2018-01-03 19:20:31',
                'deleted_at' => NULL,
            ),
            253 => 
            array (
                'id' => 254,
                'item' => 'JUBI_SECRET',
                'value' => NULL,
                'exchange_id' => NULL,
                'updated_at' => '2018-01-03 19:20:31',
                'created_at' => '2018-01-03 19:20:31',
                'deleted_at' => NULL,
            ),
            254 => 
            array (
                'id' => 255,
                'item' => 'JUBI_UID',
                'value' => NULL,
                'exchange_id' => NULL,
                'updated_at' => '2018-01-03 19:20:31',
                'created_at' => '2018-01-03 19:20:31',
                'deleted_at' => NULL,
            ),
            255 => 
            array (
                'id' => 256,
                'item' => 'JUBI_PASSWORD',
                'value' => NULL,
                'exchange_id' => NULL,
                'updated_at' => '2018-01-03 19:20:31',
                'created_at' => '2018-01-03 19:20:31',
                'deleted_at' => NULL,
            ),
            256 => 
            array (
                'id' => 257,
                'item' => 'KRAKEN_APIKEY',
                'value' => NULL,
                'exchange_id' => NULL,
                'updated_at' => '2018-01-03 19:20:31',
                'created_at' => '2018-01-03 19:20:31',
                'deleted_at' => NULL,
            ),
            257 => 
            array (
                'id' => 258,
                'item' => 'KRAKEN_SECRET',
                'value' => NULL,
                'exchange_id' => NULL,
                'updated_at' => '2018-01-03 19:20:31',
                'created_at' => '2018-01-03 19:20:31',
                'deleted_at' => NULL,
            ),
            258 => 
            array (
                'id' => 259,
                'item' => 'KRAKEN_UID',
                'value' => NULL,
                'exchange_id' => NULL,
                'updated_at' => '2018-01-03 19:20:31',
                'created_at' => '2018-01-03 19:20:31',
                'deleted_at' => NULL,
            ),
            259 => 
            array (
                'id' => 260,
                'item' => 'KRAKEN_PASSWORD',
                'value' => NULL,
                'exchange_id' => NULL,
                'updated_at' => '2018-01-03 19:20:31',
                'created_at' => '2018-01-03 19:20:31',
                'deleted_at' => NULL,
            ),
            260 => 
            array (
                'id' => 261,
                'item' => 'KUCOIN_APIKEY',
                'value' => NULL,
                'exchange_id' => NULL,
                'updated_at' => '2018-01-03 19:20:31',
                'created_at' => '2018-01-03 19:20:31',
                'deleted_at' => NULL,
            ),
            261 => 
            array (
                'id' => 262,
                'item' => 'KUCOIN_SECRET',
                'value' => NULL,
                'exchange_id' => NULL,
                'updated_at' => '2018-01-03 19:20:31',
                'created_at' => '2018-01-03 19:20:31',
                'deleted_at' => NULL,
            ),
            262 => 
            array (
                'id' => 263,
                'item' => 'KUCOIN_UID',
                'value' => NULL,
                'exchange_id' => NULL,
                'updated_at' => '2018-01-03 19:20:31',
                'created_at' => '2018-01-03 19:20:31',
                'deleted_at' => NULL,
            ),
            263 => 
            array (
                'id' => 264,
                'item' => 'KUCOIN_PASSWORD',
                'value' => NULL,
                'exchange_id' => NULL,
                'updated_at' => '2018-01-03 19:20:32',
                'created_at' => '2018-01-03 19:20:32',
                'deleted_at' => NULL,
            ),
            264 => 
            array (
                'id' => 265,
                'item' => 'KUNA_APIKEY',
                'value' => NULL,
                'exchange_id' => NULL,
                'updated_at' => '2018-01-03 19:20:32',
                'created_at' => '2018-01-03 19:20:32',
                'deleted_at' => NULL,
            ),
            265 => 
            array (
                'id' => 266,
                'item' => 'KUNA_SECRET',
                'value' => NULL,
                'exchange_id' => NULL,
                'updated_at' => '2018-01-03 19:20:32',
                'created_at' => '2018-01-03 19:20:32',
                'deleted_at' => NULL,
            ),
            266 => 
            array (
                'id' => 267,
                'item' => 'KUNA_UID',
                'value' => NULL,
                'exchange_id' => NULL,
                'updated_at' => '2018-01-03 19:20:32',
                'created_at' => '2018-01-03 19:20:32',
                'deleted_at' => NULL,
            ),
            267 => 
            array (
                'id' => 268,
                'item' => 'KUNA_PASSWORD',
                'value' => NULL,
                'exchange_id' => NULL,
                'updated_at' => '2018-01-03 19:20:32',
                'created_at' => '2018-01-03 19:20:32',
                'deleted_at' => NULL,
            ),
            268 => 
            array (
                'id' => 269,
                'item' => 'LAKEBTC_APIKEY',
                'value' => NULL,
                'exchange_id' => NULL,
                'updated_at' => '2018-01-03 19:20:32',
                'created_at' => '2018-01-03 19:20:32',
                'deleted_at' => NULL,
            ),
            269 => 
            array (
                'id' => 270,
                'item' => 'LAKEBTC_SECRET',
                'value' => NULL,
                'exchange_id' => NULL,
                'updated_at' => '2018-01-03 19:20:32',
                'created_at' => '2018-01-03 19:20:32',
                'deleted_at' => NULL,
            ),
            270 => 
            array (
                'id' => 271,
                'item' => 'LAKEBTC_UID',
                'value' => NULL,
                'exchange_id' => NULL,
                'updated_at' => '2018-01-03 19:20:32',
                'created_at' => '2018-01-03 19:20:32',
                'deleted_at' => NULL,
            ),
            271 => 
            array (
                'id' => 272,
                'item' => 'LAKEBTC_PASSWORD',
                'value' => NULL,
                'exchange_id' => NULL,
                'updated_at' => '2018-01-03 19:20:32',
                'created_at' => '2018-01-03 19:20:32',
                'deleted_at' => NULL,
            ),
            272 => 
            array (
                'id' => 273,
                'item' => 'LIQUI_APIKEY',
                'value' => NULL,
                'exchange_id' => NULL,
                'updated_at' => '2018-01-03 19:20:32',
                'created_at' => '2018-01-03 19:20:32',
                'deleted_at' => NULL,
            ),
            273 => 
            array (
                'id' => 274,
                'item' => 'LIQUI_SECRET',
                'value' => NULL,
                'exchange_id' => NULL,
                'updated_at' => '2018-01-03 19:20:32',
                'created_at' => '2018-01-03 19:20:32',
                'deleted_at' => NULL,
            ),
            274 => 
            array (
                'id' => 275,
                'item' => 'LIQUI_UID',
                'value' => NULL,
                'exchange_id' => NULL,
                'updated_at' => '2018-01-03 19:20:32',
                'created_at' => '2018-01-03 19:20:32',
                'deleted_at' => NULL,
            ),
            275 => 
            array (
                'id' => 276,
                'item' => 'LIQUI_PASSWORD',
                'value' => NULL,
                'exchange_id' => NULL,
                'updated_at' => '2018-01-03 19:20:32',
                'created_at' => '2018-01-03 19:20:32',
                'deleted_at' => NULL,
            ),
            276 => 
            array (
                'id' => 277,
                'item' => 'LIVECOIN_APIKEY',
                'value' => NULL,
                'exchange_id' => NULL,
                'updated_at' => '2018-01-03 19:20:32',
                'created_at' => '2018-01-03 19:20:32',
                'deleted_at' => NULL,
            ),
            277 => 
            array (
                'id' => 278,
                'item' => 'LIVECOIN_SECRET',
                'value' => NULL,
                'exchange_id' => NULL,
                'updated_at' => '2018-01-03 19:20:32',
                'created_at' => '2018-01-03 19:20:32',
                'deleted_at' => NULL,
            ),
            278 => 
            array (
                'id' => 279,
                'item' => 'LIVECOIN_UID',
                'value' => NULL,
                'exchange_id' => NULL,
                'updated_at' => '2018-01-03 19:20:32',
                'created_at' => '2018-01-03 19:20:32',
                'deleted_at' => NULL,
            ),
            279 => 
            array (
                'id' => 280,
                'item' => 'LIVECOIN_PASSWORD',
                'value' => NULL,
                'exchange_id' => NULL,
                'updated_at' => '2018-01-03 19:20:32',
                'created_at' => '2018-01-03 19:20:32',
                'deleted_at' => NULL,
            ),
            280 => 
            array (
                'id' => 281,
                'item' => 'LUNO_APIKEY',
                'value' => NULL,
                'exchange_id' => NULL,
                'updated_at' => '2018-01-03 19:20:32',
                'created_at' => '2018-01-03 19:20:32',
                'deleted_at' => NULL,
            ),
            281 => 
            array (
                'id' => 282,
                'item' => 'LUNO_SECRET',
                'value' => NULL,
                'exchange_id' => NULL,
                'updated_at' => '2018-01-03 19:20:32',
                'created_at' => '2018-01-03 19:20:32',
                'deleted_at' => NULL,
            ),
            282 => 
            array (
                'id' => 283,
                'item' => 'LUNO_UID',
                'value' => NULL,
                'exchange_id' => NULL,
                'updated_at' => '2018-01-03 19:20:32',
                'created_at' => '2018-01-03 19:20:32',
                'deleted_at' => NULL,
            ),
            283 => 
            array (
                'id' => 284,
                'item' => 'LUNO_PASSWORD',
                'value' => NULL,
                'exchange_id' => NULL,
                'updated_at' => '2018-01-03 19:20:32',
                'created_at' => '2018-01-03 19:20:32',
                'deleted_at' => NULL,
            ),
            284 => 
            array (
                'id' => 285,
                'item' => 'MERCADO_APIKEY',
                'value' => NULL,
                'exchange_id' => NULL,
                'updated_at' => '2018-01-03 19:20:32',
                'created_at' => '2018-01-03 19:20:32',
                'deleted_at' => NULL,
            ),
            285 => 
            array (
                'id' => 286,
                'item' => 'MERCADO_SECRET',
                'value' => NULL,
                'exchange_id' => NULL,
                'updated_at' => '2018-01-03 19:20:32',
                'created_at' => '2018-01-03 19:20:32',
                'deleted_at' => NULL,
            ),
            286 => 
            array (
                'id' => 287,
                'item' => 'MERCADO_UID',
                'value' => NULL,
                'exchange_id' => NULL,
                'updated_at' => '2018-01-03 19:20:32',
                'created_at' => '2018-01-03 19:20:32',
                'deleted_at' => NULL,
            ),
            287 => 
            array (
                'id' => 288,
                'item' => 'MERCADO_PASSWORD',
                'value' => NULL,
                'exchange_id' => NULL,
                'updated_at' => '2018-01-03 19:20:32',
                'created_at' => '2018-01-03 19:20:32',
                'deleted_at' => NULL,
            ),
            288 => 
            array (
                'id' => 289,
                'item' => 'MIXCOINS_APIKEY',
                'value' => NULL,
                'exchange_id' => NULL,
                'updated_at' => '2018-01-03 19:20:32',
                'created_at' => '2018-01-03 19:20:32',
                'deleted_at' => NULL,
            ),
            289 => 
            array (
                'id' => 290,
                'item' => 'MIXCOINS_SECRET',
                'value' => NULL,
                'exchange_id' => NULL,
                'updated_at' => '2018-01-03 19:20:32',
                'created_at' => '2018-01-03 19:20:32',
                'deleted_at' => NULL,
            ),
            290 => 
            array (
                'id' => 291,
                'item' => 'MIXCOINS_UID',
                'value' => NULL,
                'exchange_id' => NULL,
                'updated_at' => '2018-01-03 19:20:32',
                'created_at' => '2018-01-03 19:20:32',
                'deleted_at' => NULL,
            ),
            291 => 
            array (
                'id' => 292,
                'item' => 'MIXCOINS_PASSWORD',
                'value' => NULL,
                'exchange_id' => NULL,
                'updated_at' => '2018-01-03 19:20:32',
                'created_at' => '2018-01-03 19:20:32',
                'deleted_at' => NULL,
            ),
            292 => 
            array (
                'id' => 293,
                'item' => 'NOVA_APIKEY',
                'value' => NULL,
                'exchange_id' => NULL,
                'updated_at' => '2018-01-03 19:20:32',
                'created_at' => '2018-01-03 19:20:32',
                'deleted_at' => NULL,
            ),
            293 => 
            array (
                'id' => 294,
                'item' => 'NOVA_SECRET',
                'value' => NULL,
                'exchange_id' => NULL,
                'updated_at' => '2018-01-03 19:20:32',
                'created_at' => '2018-01-03 19:20:32',
                'deleted_at' => NULL,
            ),
            294 => 
            array (
                'id' => 295,
                'item' => 'NOVA_UID',
                'value' => NULL,
                'exchange_id' => NULL,
                'updated_at' => '2018-01-03 19:20:32',
                'created_at' => '2018-01-03 19:20:32',
                'deleted_at' => NULL,
            ),
            295 => 
            array (
                'id' => 296,
                'item' => 'NOVA_PASSWORD',
                'value' => NULL,
                'exchange_id' => NULL,
                'updated_at' => '2018-01-03 19:20:32',
                'created_at' => '2018-01-03 19:20:32',
                'deleted_at' => NULL,
            ),
            296 => 
            array (
                'id' => 297,
                'item' => 'OKCOINCNY_APIKEY',
                'value' => NULL,
                'exchange_id' => NULL,
                'updated_at' => '2018-01-03 19:20:32',
                'created_at' => '2018-01-03 19:20:32',
                'deleted_at' => NULL,
            ),
            297 => 
            array (
                'id' => 298,
                'item' => 'OKCOINCNY_SECRET',
                'value' => NULL,
                'exchange_id' => NULL,
                'updated_at' => '2018-01-03 19:20:32',
                'created_at' => '2018-01-03 19:20:32',
                'deleted_at' => NULL,
            ),
            298 => 
            array (
                'id' => 299,
                'item' => 'OKCOINCNY_UID',
                'value' => NULL,
                'exchange_id' => NULL,
                'updated_at' => '2018-01-03 19:20:32',
                'created_at' => '2018-01-03 19:20:32',
                'deleted_at' => NULL,
            ),
            299 => 
            array (
                'id' => 300,
                'item' => 'OKCOINCNY_PASSWORD',
                'value' => NULL,
                'exchange_id' => NULL,
                'updated_at' => '2018-01-03 19:20:32',
                'created_at' => '2018-01-03 19:20:32',
                'deleted_at' => NULL,
            ),
            300 => 
            array (
                'id' => 301,
                'item' => 'OKCOINUSD_APIKEY',
                'value' => NULL,
                'exchange_id' => NULL,
                'updated_at' => '2018-01-03 19:20:32',
                'created_at' => '2018-01-03 19:20:32',
                'deleted_at' => NULL,
            ),
            301 => 
            array (
                'id' => 302,
                'item' => 'OKCOINUSD_SECRET',
                'value' => NULL,
                'exchange_id' => NULL,
                'updated_at' => '2018-01-03 19:20:32',
                'created_at' => '2018-01-03 19:20:32',
                'deleted_at' => NULL,
            ),
            302 => 
            array (
                'id' => 303,
                'item' => 'OKCOINUSD_UID',
                'value' => NULL,
                'exchange_id' => NULL,
                'updated_at' => '2018-01-03 19:20:32',
                'created_at' => '2018-01-03 19:20:32',
                'deleted_at' => NULL,
            ),
            303 => 
            array (
                'id' => 304,
                'item' => 'OKCOINUSD_PASSWORD',
                'value' => NULL,
                'exchange_id' => NULL,
                'updated_at' => '2018-01-03 19:20:32',
                'created_at' => '2018-01-03 19:20:32',
                'deleted_at' => NULL,
            ),
            304 => 
            array (
                'id' => 305,
                'item' => 'OKEX_APIKEY',
                'value' => NULL,
                'exchange_id' => NULL,
                'updated_at' => '2018-01-03 19:20:32',
                'created_at' => '2018-01-03 19:20:32',
                'deleted_at' => NULL,
            ),
            305 => 
            array (
                'id' => 306,
                'item' => 'OKEX_SECRET',
                'value' => NULL,
                'exchange_id' => NULL,
                'updated_at' => '2018-01-03 19:20:32',
                'created_at' => '2018-01-03 19:20:32',
                'deleted_at' => NULL,
            ),
            306 => 
            array (
                'id' => 307,
                'item' => 'OKEX_UID',
                'value' => NULL,
                'exchange_id' => NULL,
                'updated_at' => '2018-01-03 19:20:32',
                'created_at' => '2018-01-03 19:20:32',
                'deleted_at' => NULL,
            ),
            307 => 
            array (
                'id' => 308,
                'item' => 'OKEX_PASSWORD',
                'value' => NULL,
                'exchange_id' => NULL,
                'updated_at' => '2018-01-03 19:20:32',
                'created_at' => '2018-01-03 19:20:32',
                'deleted_at' => NULL,
            ),
            308 => 
            array (
                'id' => 309,
                'item' => 'PAYMIUM_APIKEY',
                'value' => NULL,
                'exchange_id' => NULL,
                'updated_at' => '2018-01-03 19:20:32',
                'created_at' => '2018-01-03 19:20:32',
                'deleted_at' => NULL,
            ),
            309 => 
            array (
                'id' => 310,
                'item' => 'PAYMIUM_SECRET',
                'value' => NULL,
                'exchange_id' => NULL,
                'updated_at' => '2018-01-03 19:20:32',
                'created_at' => '2018-01-03 19:20:32',
                'deleted_at' => NULL,
            ),
            310 => 
            array (
                'id' => 311,
                'item' => 'PAYMIUM_UID',
                'value' => NULL,
                'exchange_id' => NULL,
                'updated_at' => '2018-01-03 19:20:32',
                'created_at' => '2018-01-03 19:20:32',
                'deleted_at' => NULL,
            ),
            311 => 
            array (
                'id' => 312,
                'item' => 'PAYMIUM_PASSWORD',
                'value' => NULL,
                'exchange_id' => NULL,
                'updated_at' => '2018-01-03 19:20:32',
                'created_at' => '2018-01-03 19:20:32',
                'deleted_at' => NULL,
            ),
            312 => 
            array (
                'id' => 313,
                'item' => 'POLONIEX_APIKEY',
                'value' => NULL,
                'exchange_id' => NULL,
                'updated_at' => '2018-01-03 19:20:32',
                'created_at' => '2018-01-03 19:20:32',
                'deleted_at' => NULL,
            ),
            313 => 
            array (
                'id' => 314,
                'item' => 'POLONIEX_SECRET',
                'value' => NULL,
                'exchange_id' => NULL,
                'updated_at' => '2018-01-03 19:20:32',
                'created_at' => '2018-01-03 19:20:32',
                'deleted_at' => NULL,
            ),
            314 => 
            array (
                'id' => 315,
                'item' => 'POLONIEX_UID',
                'value' => NULL,
                'exchange_id' => NULL,
                'updated_at' => '2018-01-03 19:20:32',
                'created_at' => '2018-01-03 19:20:32',
                'deleted_at' => NULL,
            ),
            315 => 
            array (
                'id' => 316,
                'item' => 'POLONIEX_PASSWORD',
                'value' => NULL,
                'exchange_id' => NULL,
                'updated_at' => '2018-01-03 19:20:32',
                'created_at' => '2018-01-03 19:20:32',
                'deleted_at' => NULL,
            ),
            316 => 
            array (
                'id' => 317,
                'item' => 'QRYPTOS_APIKEY',
                'value' => NULL,
                'exchange_id' => NULL,
                'updated_at' => '2018-01-03 19:20:32',
                'created_at' => '2018-01-03 19:20:32',
                'deleted_at' => NULL,
            ),
            317 => 
            array (
                'id' => 318,
                'item' => 'QRYPTOS_SECRET',
                'value' => NULL,
                'exchange_id' => NULL,
                'updated_at' => '2018-01-03 19:20:32',
                'created_at' => '2018-01-03 19:20:32',
                'deleted_at' => NULL,
            ),
            318 => 
            array (
                'id' => 319,
                'item' => 'QRYPTOS_UID',
                'value' => NULL,
                'exchange_id' => NULL,
                'updated_at' => '2018-01-03 19:20:32',
                'created_at' => '2018-01-03 19:20:32',
                'deleted_at' => NULL,
            ),
            319 => 
            array (
                'id' => 320,
                'item' => 'QRYPTOS_PASSWORD',
                'value' => NULL,
                'exchange_id' => NULL,
                'updated_at' => '2018-01-03 19:20:32',
                'created_at' => '2018-01-03 19:20:32',
                'deleted_at' => NULL,
            ),
            320 => 
            array (
                'id' => 321,
                'item' => 'QUADRIGACX_APIKEY',
                'value' => NULL,
                'exchange_id' => NULL,
                'updated_at' => '2018-01-03 19:20:32',
                'created_at' => '2018-01-03 19:20:32',
                'deleted_at' => NULL,
            ),
            321 => 
            array (
                'id' => 322,
                'item' => 'QUADRIGACX_SECRET',
                'value' => NULL,
                'exchange_id' => NULL,
                'updated_at' => '2018-01-03 19:20:32',
                'created_at' => '2018-01-03 19:20:32',
                'deleted_at' => NULL,
            ),
            322 => 
            array (
                'id' => 323,
                'item' => 'QUADRIGACX_UID',
                'value' => NULL,
                'exchange_id' => NULL,
                'updated_at' => '2018-01-03 19:20:32',
                'created_at' => '2018-01-03 19:20:32',
                'deleted_at' => NULL,
            ),
            323 => 
            array (
                'id' => 324,
                'item' => 'QUADRIGACX_PASSWORD',
                'value' => NULL,
                'exchange_id' => NULL,
                'updated_at' => '2018-01-03 19:20:32',
                'created_at' => '2018-01-03 19:20:32',
                'deleted_at' => NULL,
            ),
            324 => 
            array (
                'id' => 325,
                'item' => 'QUOINE_APIKEY',
                'value' => NULL,
                'exchange_id' => NULL,
                'updated_at' => '2018-01-03 19:20:32',
                'created_at' => '2018-01-03 19:20:32',
                'deleted_at' => NULL,
            ),
            325 => 
            array (
                'id' => 326,
                'item' => 'QUOINE_SECRET',
                'value' => NULL,
                'exchange_id' => NULL,
                'updated_at' => '2018-01-03 19:20:32',
                'created_at' => '2018-01-03 19:20:32',
                'deleted_at' => NULL,
            ),
            326 => 
            array (
                'id' => 327,
                'item' => 'QUOINE_UID',
                'value' => NULL,
                'exchange_id' => NULL,
                'updated_at' => '2018-01-03 19:20:32',
                'created_at' => '2018-01-03 19:20:32',
                'deleted_at' => NULL,
            ),
            327 => 
            array (
                'id' => 328,
                'item' => 'QUOINE_PASSWORD',
                'value' => NULL,
                'exchange_id' => NULL,
                'updated_at' => '2018-01-03 19:20:32',
                'created_at' => '2018-01-03 19:20:32',
                'deleted_at' => NULL,
            ),
            328 => 
            array (
                'id' => 329,
                'item' => 'SOUTHXCHANGE_APIKEY',
                'value' => NULL,
                'exchange_id' => NULL,
                'updated_at' => '2018-01-03 19:20:32',
                'created_at' => '2018-01-03 19:20:32',
                'deleted_at' => NULL,
            ),
            329 => 
            array (
                'id' => 330,
                'item' => 'SOUTHXCHANGE_SECRET',
                'value' => NULL,
                'exchange_id' => NULL,
                'updated_at' => '2018-01-03 19:20:32',
                'created_at' => '2018-01-03 19:20:32',
                'deleted_at' => NULL,
            ),
            330 => 
            array (
                'id' => 331,
                'item' => 'SOUTHXCHANGE_UID',
                'value' => NULL,
                'exchange_id' => NULL,
                'updated_at' => '2018-01-03 19:20:32',
                'created_at' => '2018-01-03 19:20:32',
                'deleted_at' => NULL,
            ),
            331 => 
            array (
                'id' => 332,
                'item' => 'SOUTHXCHANGE_PASSWORD',
                'value' => NULL,
                'exchange_id' => NULL,
                'updated_at' => '2018-01-03 19:20:32',
                'created_at' => '2018-01-03 19:20:32',
                'deleted_at' => NULL,
            ),
            332 => 
            array (
                'id' => 333,
                'item' => 'SURBITCOIN_APIKEY',
                'value' => NULL,
                'exchange_id' => NULL,
                'updated_at' => '2018-01-03 19:20:32',
                'created_at' => '2018-01-03 19:20:32',
                'deleted_at' => NULL,
            ),
            333 => 
            array (
                'id' => 334,
                'item' => 'SURBITCOIN_SECRET',
                'value' => NULL,
                'exchange_id' => NULL,
                'updated_at' => '2018-01-03 19:20:32',
                'created_at' => '2018-01-03 19:20:32',
                'deleted_at' => NULL,
            ),
            334 => 
            array (
                'id' => 335,
                'item' => 'SURBITCOIN_UID',
                'value' => NULL,
                'exchange_id' => NULL,
                'updated_at' => '2018-01-03 19:20:32',
                'created_at' => '2018-01-03 19:20:32',
                'deleted_at' => NULL,
            ),
            335 => 
            array (
                'id' => 336,
                'item' => 'SURBITCOIN_PASSWORD',
                'value' => NULL,
                'exchange_id' => NULL,
                'updated_at' => '2018-01-03 19:20:32',
                'created_at' => '2018-01-03 19:20:32',
                'deleted_at' => NULL,
            ),
            336 => 
            array (
                'id' => 337,
                'item' => 'THEROCK_APIKEY',
                'value' => NULL,
                'exchange_id' => NULL,
                'updated_at' => '2018-01-03 19:20:32',
                'created_at' => '2018-01-03 19:20:32',
                'deleted_at' => NULL,
            ),
            337 => 
            array (
                'id' => 338,
                'item' => 'THEROCK_SECRET',
                'value' => NULL,
                'exchange_id' => NULL,
                'updated_at' => '2018-01-03 19:20:32',
                'created_at' => '2018-01-03 19:20:32',
                'deleted_at' => NULL,
            ),
            338 => 
            array (
                'id' => 339,
                'item' => 'THEROCK_UID',
                'value' => NULL,
                'exchange_id' => NULL,
                'updated_at' => '2018-01-03 19:20:32',
                'created_at' => '2018-01-03 19:20:32',
                'deleted_at' => NULL,
            ),
            339 => 
            array (
                'id' => 340,
                'item' => 'THEROCK_PASSWORD',
                'value' => NULL,
                'exchange_id' => NULL,
                'updated_at' => '2018-01-03 19:20:32',
                'created_at' => '2018-01-03 19:20:32',
                'deleted_at' => NULL,
            ),
            340 => 
            array (
                'id' => 341,
                'item' => 'TIDEX_APIKEY',
                'value' => NULL,
                'exchange_id' => NULL,
                'updated_at' => '2018-01-03 19:20:32',
                'created_at' => '2018-01-03 19:20:32',
                'deleted_at' => NULL,
            ),
            341 => 
            array (
                'id' => 342,
                'item' => 'TIDEX_SECRET',
                'value' => NULL,
                'exchange_id' => NULL,
                'updated_at' => '2018-01-03 19:20:32',
                'created_at' => '2018-01-03 19:20:32',
                'deleted_at' => NULL,
            ),
            342 => 
            array (
                'id' => 343,
                'item' => 'TIDEX_UID',
                'value' => NULL,
                'exchange_id' => NULL,
                'updated_at' => '2018-01-03 19:20:32',
                'created_at' => '2018-01-03 19:20:32',
                'deleted_at' => NULL,
            ),
            343 => 
            array (
                'id' => 344,
                'item' => 'TIDEX_PASSWORD',
                'value' => NULL,
                'exchange_id' => NULL,
                'updated_at' => '2018-01-03 19:20:32',
                'created_at' => '2018-01-03 19:20:32',
                'deleted_at' => NULL,
            ),
            344 => 
            array (
                'id' => 345,
                'item' => 'URDUBIT_APIKEY',
                'value' => NULL,
                'exchange_id' => NULL,
                'updated_at' => '2018-01-03 19:20:32',
                'created_at' => '2018-01-03 19:20:32',
                'deleted_at' => NULL,
            ),
            345 => 
            array (
                'id' => 346,
                'item' => 'URDUBIT_SECRET',
                'value' => NULL,
                'exchange_id' => NULL,
                'updated_at' => '2018-01-03 19:20:32',
                'created_at' => '2018-01-03 19:20:32',
                'deleted_at' => NULL,
            ),
            346 => 
            array (
                'id' => 347,
                'item' => 'URDUBIT_UID',
                'value' => NULL,
                'exchange_id' => NULL,
                'updated_at' => '2018-01-03 19:20:32',
                'created_at' => '2018-01-03 19:20:32',
                'deleted_at' => NULL,
            ),
            347 => 
            array (
                'id' => 348,
                'item' => 'URDUBIT_PASSWORD',
                'value' => NULL,
                'exchange_id' => NULL,
                'updated_at' => '2018-01-03 19:20:32',
                'created_at' => '2018-01-03 19:20:32',
                'deleted_at' => NULL,
            ),
            348 => 
            array (
                'id' => 349,
                'item' => 'VAULTORO_APIKEY',
                'value' => NULL,
                'exchange_id' => NULL,
                'updated_at' => '2018-01-03 19:20:32',
                'created_at' => '2018-01-03 19:20:32',
                'deleted_at' => NULL,
            ),
            349 => 
            array (
                'id' => 350,
                'item' => 'VAULTORO_SECRET',
                'value' => NULL,
                'exchange_id' => NULL,
                'updated_at' => '2018-01-03 19:20:32',
                'created_at' => '2018-01-03 19:20:32',
                'deleted_at' => NULL,
            ),
            350 => 
            array (
                'id' => 351,
                'item' => 'VAULTORO_UID',
                'value' => NULL,
                'exchange_id' => NULL,
                'updated_at' => '2018-01-03 19:20:32',
                'created_at' => '2018-01-03 19:20:32',
                'deleted_at' => NULL,
            ),
            351 => 
            array (
                'id' => 352,
                'item' => 'VAULTORO_PASSWORD',
                'value' => NULL,
                'exchange_id' => NULL,
                'updated_at' => '2018-01-03 19:20:32',
                'created_at' => '2018-01-03 19:20:32',
                'deleted_at' => NULL,
            ),
            352 => 
            array (
                'id' => 353,
                'item' => 'VBTC_APIKEY',
                'value' => NULL,
                'exchange_id' => NULL,
                'updated_at' => '2018-01-03 19:20:32',
                'created_at' => '2018-01-03 19:20:32',
                'deleted_at' => NULL,
            ),
            353 => 
            array (
                'id' => 354,
                'item' => 'VBTC_SECRET',
                'value' => NULL,
                'exchange_id' => NULL,
                'updated_at' => '2018-01-03 19:20:32',
                'created_at' => '2018-01-03 19:20:32',
                'deleted_at' => NULL,
            ),
            354 => 
            array (
                'id' => 355,
                'item' => 'VBTC_UID',
                'value' => NULL,
                'exchange_id' => NULL,
                'updated_at' => '2018-01-03 19:20:32',
                'created_at' => '2018-01-03 19:20:32',
                'deleted_at' => NULL,
            ),
            355 => 
            array (
                'id' => 356,
                'item' => 'VBTC_PASSWORD',
                'value' => NULL,
                'exchange_id' => NULL,
                'updated_at' => '2018-01-03 19:20:32',
                'created_at' => '2018-01-03 19:20:32',
                'deleted_at' => NULL,
            ),
            356 => 
            array (
                'id' => 357,
                'item' => 'VIRWOX_APIKEY',
                'value' => NULL,
                'exchange_id' => NULL,
                'updated_at' => '2018-01-03 19:20:32',
                'created_at' => '2018-01-03 19:20:32',
                'deleted_at' => NULL,
            ),
            357 => 
            array (
                'id' => 358,
                'item' => 'VIRWOX_SECRET',
                'value' => NULL,
                'exchange_id' => NULL,
                'updated_at' => '2018-01-03 19:20:32',
                'created_at' => '2018-01-03 19:20:32',
                'deleted_at' => NULL,
            ),
            358 => 
            array (
                'id' => 359,
                'item' => 'VIRWOX_UID',
                'value' => NULL,
                'exchange_id' => NULL,
                'updated_at' => '2018-01-03 19:20:32',
                'created_at' => '2018-01-03 19:20:32',
                'deleted_at' => NULL,
            ),
            359 => 
            array (
                'id' => 360,
                'item' => 'VIRWOX_PASSWORD',
                'value' => NULL,
                'exchange_id' => NULL,
                'updated_at' => '2018-01-03 19:20:32',
                'created_at' => '2018-01-03 19:20:32',
                'deleted_at' => NULL,
            ),
            360 => 
            array (
                'id' => 361,
                'item' => 'WEX_APIKEY',
                'value' => NULL,
                'exchange_id' => NULL,
                'updated_at' => '2018-01-03 19:20:32',
                'created_at' => '2018-01-03 19:20:32',
                'deleted_at' => NULL,
            ),
            361 => 
            array (
                'id' => 362,
                'item' => 'WEX_SECRET',
                'value' => NULL,
                'exchange_id' => NULL,
                'updated_at' => '2018-01-03 19:20:32',
                'created_at' => '2018-01-03 19:20:32',
                'deleted_at' => NULL,
            ),
            362 => 
            array (
                'id' => 363,
                'item' => 'WEX_UID',
                'value' => NULL,
                'exchange_id' => NULL,
                'updated_at' => '2018-01-03 19:20:32',
                'created_at' => '2018-01-03 19:20:32',
                'deleted_at' => NULL,
            ),
            363 => 
            array (
                'id' => 364,
                'item' => 'WEX_PASSWORD',
                'value' => NULL,
                'exchange_id' => NULL,
                'updated_at' => '2018-01-03 19:20:32',
                'created_at' => '2018-01-03 19:20:32',
                'deleted_at' => NULL,
            ),
            364 => 
            array (
                'id' => 365,
                'item' => 'XBTCE_APIKEY',
                'value' => NULL,
                'exchange_id' => NULL,
                'updated_at' => '2018-01-03 19:20:32',
                'created_at' => '2018-01-03 19:20:32',
                'deleted_at' => NULL,
            ),
            365 => 
            array (
                'id' => 366,
                'item' => 'XBTCE_SECRET',
                'value' => NULL,
                'exchange_id' => NULL,
                'updated_at' => '2018-01-03 19:20:32',
                'created_at' => '2018-01-03 19:20:32',
                'deleted_at' => NULL,
            ),
            366 => 
            array (
                'id' => 367,
                'item' => 'XBTCE_UID',
                'value' => NULL,
                'exchange_id' => NULL,
                'updated_at' => '2018-01-03 19:20:32',
                'created_at' => '2018-01-03 19:20:32',
                'deleted_at' => NULL,
            ),
            367 => 
            array (
                'id' => 368,
                'item' => 'XBTCE_PASSWORD',
                'value' => NULL,
                'exchange_id' => NULL,
                'updated_at' => '2018-01-03 19:20:32',
                'created_at' => '2018-01-03 19:20:32',
                'deleted_at' => NULL,
            ),
            368 => 
            array (
                'id' => 369,
                'item' => 'YOBIT_APIKEY',
                'value' => NULL,
                'exchange_id' => NULL,
                'updated_at' => '2018-01-03 19:20:32',
                'created_at' => '2018-01-03 19:20:32',
                'deleted_at' => NULL,
            ),
            369 => 
            array (
                'id' => 370,
                'item' => 'YOBIT_SECRET',
                'value' => NULL,
                'exchange_id' => NULL,
                'updated_at' => '2018-01-03 19:20:32',
                'created_at' => '2018-01-03 19:20:32',
                'deleted_at' => NULL,
            ),
            370 => 
            array (
                'id' => 371,
                'item' => 'YOBIT_UID',
                'value' => NULL,
                'exchange_id' => NULL,
                'updated_at' => '2018-01-03 19:20:32',
                'created_at' => '2018-01-03 19:20:32',
                'deleted_at' => NULL,
            ),
            371 => 
            array (
                'id' => 372,
                'item' => 'YOBIT_PASSWORD',
                'value' => NULL,
                'exchange_id' => NULL,
                'updated_at' => '2018-01-03 19:20:32',
                'created_at' => '2018-01-03 19:20:32',
                'deleted_at' => NULL,
            ),
            372 => 
            array (
                'id' => 373,
                'item' => 'YUNBI_APIKEY',
                'value' => NULL,
                'exchange_id' => NULL,
                'updated_at' => '2018-01-03 19:20:32',
                'created_at' => '2018-01-03 19:20:32',
                'deleted_at' => NULL,
            ),
            373 => 
            array (
                'id' => 374,
                'item' => 'YUNBI_SECRET',
                'value' => NULL,
                'exchange_id' => NULL,
                'updated_at' => '2018-01-03 19:20:32',
                'created_at' => '2018-01-03 19:20:32',
                'deleted_at' => NULL,
            ),
            374 => 
            array (
                'id' => 375,
                'item' => 'YUNBI_UID',
                'value' => NULL,
                'exchange_id' => NULL,
                'updated_at' => '2018-01-03 19:20:32',
                'created_at' => '2018-01-03 19:20:32',
                'deleted_at' => NULL,
            ),
            375 => 
            array (
                'id' => 376,
                'item' => 'YUNBI_PASSWORD',
                'value' => NULL,
                'exchange_id' => NULL,
                'updated_at' => '2018-01-03 19:20:32',
                'created_at' => '2018-01-03 19:20:32',
                'deleted_at' => NULL,
            ),
            376 => 
            array (
                'id' => 377,
                'item' => 'ZAIF_APIKEY',
                'value' => NULL,
                'exchange_id' => NULL,
                'updated_at' => '2018-01-03 19:20:32',
                'created_at' => '2018-01-03 19:20:32',
                'deleted_at' => NULL,
            ),
            377 => 
            array (
                'id' => 378,
                'item' => 'ZAIF_SECRET',
                'value' => NULL,
                'exchange_id' => NULL,
                'updated_at' => '2018-01-03 19:20:32',
                'created_at' => '2018-01-03 19:20:32',
                'deleted_at' => NULL,
            ),
            378 => 
            array (
                'id' => 379,
                'item' => 'ZAIF_UID',
                'value' => NULL,
                'exchange_id' => NULL,
                'updated_at' => '2018-01-03 19:20:32',
                'created_at' => '2018-01-03 19:20:32',
                'deleted_at' => NULL,
            ),
            379 => 
            array (
                'id' => 380,
                'item' => 'ZAIF_PASSWORD',
                'value' => NULL,
                'exchange_id' => NULL,
                'updated_at' => '2018-01-03 19:20:32',
                'created_at' => '2018-01-03 19:20:32',
                'deleted_at' => NULL,
            ),
            380 => 
            array (
                'id' => 381,
                'item' => 'ZB_APIKEY',
                'value' => NULL,
                'exchange_id' => NULL,
                'updated_at' => '2018-01-03 19:20:32',
                'created_at' => '2018-01-03 19:20:32',
                'deleted_at' => NULL,
            ),
            381 => 
            array (
                'id' => 382,
                'item' => 'ZB_SECRET',
                'value' => NULL,
                'exchange_id' => NULL,
                'updated_at' => '2018-01-03 19:20:32',
                'created_at' => '2018-01-03 19:20:32',
                'deleted_at' => NULL,
            ),
            382 => 
            array (
                'id' => 383,
                'item' => 'ZB_UID',
                'value' => NULL,
                'exchange_id' => NULL,
                'updated_at' => '2018-01-03 19:20:32',
                'created_at' => '2018-01-03 19:20:32',
                'deleted_at' => NULL,
            ),
            383 => 
            array (
                'id' => 384,
                'item' => 'ZB_PASSWORD',
                'value' => NULL,
                'exchange_id' => NULL,
                'updated_at' => '2018-01-03 19:20:32',
                'created_at' => '2018-01-03 19:20:32',
                'deleted_at' => NULL,
            ),
        ));
        
        
    }
}