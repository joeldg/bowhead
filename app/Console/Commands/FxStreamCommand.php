<?php
namespace Bowhead\Console\Commands;

use Bowhead\Traits\OHLC;
use Bowhead\Util\Console;
use Illuminate\Console\Command;
use SimpleXMLElement;

class FxStreamCommand extends Command
{
    use OHLC;

    /**
     * The console command name.
     *
     * @var string
     */
    protected $name = 'bowhead:fx_stream';

    /**
     * The console command description.
     *
     * @var string
     */
    protected $description = 'The Fx stream processor.';

        /**
     * Execute the console command.
     *
     * @return void
     */
    public function handle()
    {
        $console = new Console();
        $oneforgekey = env('ONEFORGE_API');
        $instruments = ['USDJPY','EURUSD','AUDUSD','EURGBP','USDCAD','USDCHF','USDMXN','USDTRY','USDCNH','NZDUSD'];
        $trans = [
             'USDJPY' => 'USD_JPY'
            ,'EURUSD' => 'EUR_USD'
            ,'AUDUSD' => 'AUD_USD'
            ,'EURGBP' => 'EUR_GBP'
            ,'USDCAD' => 'USD_CAD'
            ,'USDCHF' => 'USD_CHF'
            ,'USDMXN' => 'USD_MXN'
            ,'USDTRY' => 'USD_TRY'
            ,'USDCNH' => 'USD_CNH'
            ,'NZDUSD' => 'NZD_USD'
        ];

        stream_set_blocking(STDIN, 0);
        $output = $last = [];
        while(1){
            if (ord(fgetc(STDIN)) == 113) {
                echo "QUIT detected...";
                return null;
            }

            $data = file_get_contents('http://rates.fxcm.com/RatesXML');
            $fixed = new SimpleXMLElement($data);
            foreach ($fixed as $fx) {
                $symbol = (string) $fx['Symbol'];
                $symbolt = $trans[$symbol] ?? null;
                if (!in_array($symbol, $instruments)) {
                    continue;
                }

                $ticker = [];
                $ticker['tick']['bid'] = round(((float) $fx->Bid + (float) $fx->Ask) / 2, 5);
                $ticker['tick']['instrument'] = $symbol;

                $this->markOHLC(json_encode($ticker));

                $ins = $ticker['tick']['instrument'];
                $curr[$ins] = $ticker['tick']['bid'];

                foreach ($curr as $instrument => $bid) {
                    if ($curr[$instrument] > ($last[$instrument] ?? 0)) {
                        $output[$instrument] = $console->colorize(str_pad($instrument . " " . round($curr[$instrument], 3), 14), 'green', 'bold');
                    } elseif ($curr[$instrument] < ($last[$instrument] ?? 0)) {
                        $output[$instrument] = $console->colorize(str_pad($instrument . " " . round($curr[$instrument], 3), 14), 'bg_red', 'bold');
                    } else {
                        $output[$instrument] = $console->colorize(str_pad($instrument . " " . round($curr[$instrument], 3), 14), 'none');
                    }
                }
                $last = $curr;
            }

            // for cool output uncomment
            echo join(' | ', $output) ."\n";
            sleep(15);
        }
    }
}
