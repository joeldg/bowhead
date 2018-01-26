<?php

namespace Bowhead\Console;

use Bowhead\Console\Commands\FxStreamCommand;
use Illuminate\Console\Scheduling\Schedule;
use Illuminate\Foundation\Console\Kernel as ConsoleKernel;

class Kernel extends ConsoleKernel
{
    /**
     * The Artisan commands provided by your application.
     *
     * @var array
     */
    protected $commands = [
        Commands\A_SetupCommand::class,
        Commands\DataRunnerCcxtCommand::class,
        Commands\DataRunnerCoinigyCommand::class,
        Commands\BitfinexWebsocketCommand::class,
        Commands\CoinbaseWebsocketCommand::class,
        Commands\OandaStreamCommand::class,
        Commands\ExampleUsageCommand::class,
        Commands\ExampleCommand::class,
        Commands\ExampleForexStrategyCommand::class,
        Commands\BitfinexWebsocketETHCommand::class,
        Commands\WebsocketCoinbaseTestCommand::class,
        Commands\SignalsExampleCommand::class,
        Commands\TestStrategiesCommand::class,
        Commands\GdaxScalperCommand::class,
        Commands\TestCandlesCommand::class,
        Commands\TestTrendsCommand::class,
        Commands\RandomWalkCommand::class,
        Commands\FxStreamCommand::class,
		Commands\KrakenStreamCommand::class,
    ];

    /**
     * Define the application's command schedule.
     *
     * @param  \Illuminate\Console\Scheduling\Schedule  $schedule
     * @return void
     */
    protected function schedule(Schedule $schedule)
    {
        #$schedule->command('bowhead:fx_stream')->withoutOverlapping()->everyMinute();
        $schedule->command('bowhead:datarunner_coinigy')->withoutOverlapping()->everyMinute();
        $schedule->command('bowhead:datarunner_ccxt')->withoutOverlapping()->everyMinute();
    }

    /**
     * Register the Closure based commands for the application.
     *
     * @return void
     */
    protected function commands()
    {
        require base_path('routes/console.php');
    }
}
