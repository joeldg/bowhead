<?php
namespace Bowhead\Console\Commands;

use Bowhead\Console\Kernel;
use Bowhead\Traits\Signals;
use Illuminate\Console\Command;
use Bowhead\Util;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Cache;
use AndreasGlaser\PPC\PPC; // https://github.com/andreas-glaser/poloniex-php-client

/**
 * Class ExampleCommand
 * @package Bowhead\Console\Commands
 */
class SignalsExampleCommand extends Command {

    use Signals;

    /**
     * The console command name.
     *
     * @var string
     */
    protected $name = 'bowhead:example_signals';

    /**
     * The console command description.
     *
     * @var string
     */
    protected $description = 'Forex signals example';


    public function doColor($val)
    {
        if ($val == 0){ return 'none'; }
        if ($val == 1){ return 'green'; }
        if ($val == -1){ return 'magenta'; }
        return 'none';
    }

    /**
     * @return null
     *
     *  this is the part of the command that executes.
     */
    public function handle()
    {
        echo "PRESS 'q' TO QUIT AND CLOSE ALL POSITIONS\n\n\n";
        stream_set_blocking(STDIN, 0);

        $instruments = ['BTC/USD'];
        $util        = new Util\BrokersUtil();
        $console     = new \Bowhead\Util\Console();
        $indicators  = new \Bowhead\Util\Indicators();


        $this->signals();

        $back = $this->signals(1,2);
        print_r($back);

        return null;
    }


}
