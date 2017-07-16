<?php

namespace Bowhead\Console\Commands;

use Bowhead\Traits\OHLC;
use Bowhead\Util\Console;
use Bowhead\Util\Indicators;
use Illuminate\Console\Command;

class TestTrendsCommand extends Command
{
    use OHLC;
    /**
     * The name and signature of the console command.
     *
     * @var string
     */
    protected $signature = 'bowhead:test_trends';

    /**
     * The console command description.
     *
     * @var string
     */
    protected $description = 'Test the trends.';

    /**
     * Create a new command instance.
     *
     * @return void
     */
    public function __construct()
    {
        parent::__construct();
    }

    /**
     * Execute the console command.
     *
     * @return mixed
     */
    public function handle()
    {
        $console = new Console();
        $ind = new Indicators();
        $instruments = ['USD_JPY','NZD_USD','EUR_GBP','USD_CAD','USD_CNH','USD_MXN','USD_TRY','AUD_USD','EUR_USD','USD_CHF'];

        while(1) {
            $all = ['httc','htl','hts','mmi'];
            foreach($instruments as $instrument) {
                $data = $this->getRecentData($instrument,200);
                $trends[$instrument]['httc'] = $ind->httc($instrument, $data);      # Hilbert Transform - Trend vs Cycle Mode
                $trends[$instrument]['htl']  = $ind->htl($instrument, $data);       # Hilbert Transform - Instantaneous Trendline
                $trends[$instrument]['hts']  = $ind->hts($instrument, $data, true); # Hilbert Transform - Sinewave
                $trends[$instrument]['mmi']  = $ind->mmi($instrument, $data);       # market meanness
            }
            $lines = [];
            $lines['top'] = '';
            $output = '';
            foreach ($instruments as $instrument) {
                $lines['top'] .= str_pad($instrument, 17);
                foreach ($trends[$instrument] as $key => $val) {
                    if (!isset($lines[$key])) {
                        $lines[$key] = '';
                    }
                    $color = ($val > 0 ? 'green' : ($val < 0 ? 'red' : 'bg_black'));
                    $lines[$key] .= $console->colorize(str_pad($key, 17), $color, 'bold');
                }
            }
            echo "\n\n" . $console->colorize(@$lines['top']);
            foreach ($all as $val) {
                echo "\n" . $lines[$val];
            }
            echo "\n\n";
            sleep(5);
        }
    }
}
