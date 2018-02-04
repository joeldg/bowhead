<?php

namespace Bowhead\Console\Commands;

use Illuminate\Console\Command;
use Illuminate\Support\Facades\DB;

class A_SetupCommand extends Command
{
    /**
     * The name and signature of the console command.
     *
     * @var string
     */
    protected $signature = 'bowhead:1_setup';

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
        $z = DB::select("SELECT * FROM pg_available_extensions where name ='timescaledb'");
        print_r($z[0]);
        //DB::connection()->getPDO()->getAttribute(PDO::ATTR_DRIVER_NAME)
        die();

        echo "\n\n";
        $this->line('Setup should be done through your web browser, this is for resetting Bowhead:');
        `open http:///setup`;

        if ($this->confirm('Do you wish to refresh migration before seeding, it will clear all old data ?')) {
            // Call the php artisan migrate:refresh using Artisan
            $this->call('migrate:refresh');
            $this->line('Data cleared, starting from blank database.');
        }

        if (DB::connection()->getData) {
        }

        if ($this->confirm('Seed the database?')) {
            $this->call('db:seed');
            $this->line('Data seeded....');
        }
    }
}
