<?php

namespace Bowhead\Console\Commands;

use Bowhead\Traits\Config;
use Bowhead\Traits\DataCoinigy;
use Illuminate\Console\Command;
use Bowhead\Util\Coinigy;
use Bowhead\Models;

/**
 * Class DataRunnerCoinigyCommand
 * @package Bowhead\Console\Commands
 *
 *          KEEP IN MIND THAT COINIGY HAS A RATE LIMIT
 *          https://coinigy.docs.apiary.io/#introduction/rate-limiting:
 */
class DataRunnerCoinigyCommand extends Command
{
    use DataCoinigy, Config;

    /**
     * @var string
     */
    protected $name = 'bowhead:datarunner_coinigy';

    /**
     * The name and signature of the console command.
     *
     * @var string
     */
    protected $signature = 'bowhead:datarunner_coinigy';

    /**
     * The console command description.
     *
     * @var string
     */
    protected $description = 'Command description';

    /**
     * Create a new command instance.
     *
     * @return void
     */
    #public function __construct()
    #{
        #parent::__construct();
    #}

    /**
     * Execute the console command.
     *
     * @return mixed
     */
    public function handle()
    {
        /**
         *  DON'T RUN IF WE ARE CURRENTLY USING CCXT
         *  Ccxt data runner will be working in the other scheduled process.
         */
        if ($this->bowhead_config('COINIGY') == 0){
            exit(1);
        }

        $coinigy = new Coinigy();
        while (1) {
            $exchanges = $tick = $bh_exchanges = [];
            $c_exchanges = $this->bowhead_config('EXCHANGES');
            $ex_arr = explode(',', $c_exchanges);
            $all_coinigy = Models\bh_exchanges::whereIn('id', $ex_arr)->get()->toArray();
            foreach($all_coinigy as $list_coinigy) {
                $exchanges[$list_coinigy['coinigy_exch_code']] = $list_coinigy['exchange'];
                $bh_exchanges[$list_coinigy['coinigy_exch_code']] = $list_coinigy['id'];
            }
            $trading_pairs = explode(',', $this->bowhead_config('PAIRS'));

            foreach ($exchanges as $code => $ex) {
                /**
                 *  We need to make a best effort here to not try to get a ticker
                 *  which does not exist.
                 */
                $_pairs = Models\bh_exchange_pairs::where('exchange_id', '=', $bh_exchanges[$code])->get()->toArray(); // get current list of pairs for exchange
                $pairs = array_pluck($_pairs,'exchange_pair');      // only select the pair name
                $looping_pairs = array_intersect($trading_pairs, $pairs); // get intersection of the exchanges pairs with the users selected pairs.

                foreach ($looping_pairs as $pair) {
                    $ticker = $this->get_ticker($code, $pair);
                    if (!empty($ticker['err_msg'])) {
                        continue;
                    } else {
                        $ticker = $ticker['data'][0];
                    }
                    $tick['high']            = $ticker['high_trade'];
                    $tick['low']             = $ticker['low_trade'];
                    $tick['bid']             = $ticker['bid'];
                    $tick['ask']             = $ticker['ask'];
                    $tick['basevolume']      = $ticker['current_volume'];
                    $tick['last']            = $ticker['last_trade'];
                    $tick['symbol']          = $ticker['market'];
                    $tick['timestamp']       = time();
                    $tick['bh_exchanges_id'] = $bh_exchanges[$code];
                    $tick['datetime']        = $ticker['timestamp'];
                    $tickers_model           = new Models\bh_tickers();
                    $tickers_model::updateOrCreate(
                        ['bh_exchanges_id' => $tick['bh_exchanges_id'], 'symbol' => $pair, 'timestamp' => $tick['timestamp']]
                        , $tick);
                }
            }

            // TODO Do OHLC here. Not really needed, but could be nice
            // TODO https://coinigy.docs.apiary.io/#reference/market-data/market-data/data-{type:all}

            sleep(5);
        }
    }
}
