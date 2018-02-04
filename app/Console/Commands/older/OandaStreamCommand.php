<?php

namespace Bowhead\Console\Commands;

use Bowhead\Traits\OHLC;
use Bowhead\Util\Console;
use Illuminate\Console\Command;

class OandaStreamCommand extends Command
{
    use OHLC;

    /**
     * The console command name.
     *
     * @var string
     */
    protected $name = 'bowhead:oanda_stream';

    /**
     * The console command description.
     *
     * @var string
     */
    protected $description = 'The Oanda stream processor.';

    public function zmarkOHLC($ticker)
    {
        $last_price = $ticker['tick']['bid'];
        $instrument = $ticker['tick']['instrument'];
        $timeid = date('YmdHi'); // 201705301522 unique for date
        $volume = 0;
        \DB::insert("
            INSERT INTO bowhead_ohlc 
            (`instrument`, `timeid`, `open`, `high`, `low`, `close`, `volume`)
            VALUES
            ('$instrument', $timeid, $last_price, $last_price, $last_price, $last_price, 0)
            ON DUPLICATE KEY UPDATE 
            `high`   = CASE WHEN `high` < VALUES(`high`) THEN VALUES(`high`) ELSE `high` END,
            `low`    = CASE WHEN `low` > VALUES(`low`) THEN VALUES(`low`) ELSE `low` END,
            `volume` = VALUES(`volume`),
            `close`  = VALUES(`close`)
        ");

        return true;
    }

    /**
     * Execute the console command.
     *
     * @return void
     */
    public function handle()
    {
        $console = new Console();

        //echo "PRESS 'q' TO QUIT AND CLOSE ALL POSITIONS\n\n\n";
        stream_set_blocking(STDIN, 0);
        $last = [];
        while (1) {
            $curr = [];
            if (ord(fgetc(STDIN)) == 113) {
                echo 'QUIT detected...';

                return;
            }

            $pipeB = fopen('quotes', 'r');
            $line = fgets($pipeB);
            $results = json_decode($line);

            if (empty($results)) {
                continue;
            }

            foreach ($results as $result) {
                if (is_array($result)) {
                    foreach ($result as $price) {
                        $ticker = [];
                        $ticker['tick']['bid'] = round(((float) $price->bids[0]->price + (float) $price->asks[0]->price) / 2, 5);
                        $ticker['tick']['instrument'] = $price->instrument;
                        $this->markOHLC($ticker);
                        $ins = $ticker['tick']['instrument'];
                        $curr[$ins] = (($price->bids[0]->price + $price->asks[0]->price) / 2);
                    }
                }
            }

            $output = [];
            foreach ($curr as $instrument => $bid) {
                if ($curr[$instrument] > ($last[$instrument] ?? 0)) {
                    $output[$instrument] = $console->colorize(str_pad($instrument.' '.round($curr[$instrument], 3), 14), 'green', 'bold');
                } elseif ($curr[$instrument] < ($last[$instrument] ?? 0)) {
                    $output[$instrument] = $console->colorize(str_pad($instrument.' '.round($curr[$instrument], 3), 14), 'bg_red', 'bold');
                } else {
                    $output[$instrument] = $console->colorize(str_pad($instrument.' '.round($curr[$instrument], 3), 14), 'none');
                }
            }
            $last = $curr;

            // for cool output uncomment
            //echo join(' | ', $output) ."\n";
        }
    }
}
