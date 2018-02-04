<?php

namespace Bowhead\Console\Commands;

use Bowhead\Traits\OHLC;
use Bowhead\Util\Console;
use Bowhead\Util\KrakenAPI;
use Bowhead\Util\KrakenAPIException;
use Illuminate\Console\Command;

/**
 * Command for Kraken Stream.
 *
 * This class is filling the Database with data from the Kraken API
 *
 * @author    Lukas Kremsmayr
 * @copyright 2017 Lukas Kremsmayr
 * @license   http://www.gnu.org/licenses/ GNU General Public License, Version 3
 */
class KrakenStreamCommand extends Command
{
    use OHLC;
    /**
     * The name and signature of the console command.
     *
     * @var string
     */
    protected $signature = 'bowhead:kraken_stream';

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
        $this->console = $util = new Console();

        $instruments = ['XXBTZEUR', 'XETHZEUR', 'BCHEUR', 'XXRPZEUR', 'XETCZEUR', 'XLTCZEUR', 'XXMRZEUR', 'DASHEUR'];

        $key = ''; //Don't need a key or secret for Public calls
        $secret = '';
        $url = 'https://api.kraken.com';
        $version = 0;
        $sslVerify = true;

        $krakenApi = new KrakenAPI($key, $secret, $url, $version, $sslVerify);

        stream_set_blocking(STDIN, 0);
        while (1) {
            if (ord(fgetc(STDIN)) == 113) {
                echo 'QUIT detected...';

                return;
            }

            try {
                $res = $krakenApi->QueryPublic('Ticker', ['pair' => implode(',', $instruments)]);

                foreach ($res->result as $instrument => $data) {
                    $ticker = [];
                    $ticker[7] = $data->c[0];
                    $ticker[8] = $data->c[1];
                    $this->markOHLC($ticker, true, $instrument);
                }
            } catch (KrakenAPIException $e) {
                sleep(1);
                continue;
            }

            sleep(30);
        }
    }
}
