<?php

namespace Bowhead\Http\Controllers;

use Bowhead\Models;
use Bowhead\Traits;
use Bowhead\Util\Coinigy;
use GuzzleHttp as Coingy_GuzzleHttp;
use Illuminate\Foundation\Auth\Access\AuthorizesRequests;
use Illuminate\Foundation\Bus\DispatchesJobs;
use Illuminate\Foundation\Validation\ValidatesRequests;
use Illuminate\Http\Request;
use Illuminate\Routing\Controller as BaseController;
use Illuminate\Support\Facades\Artisan;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Schema;

/**
 * Class Controller.
 */
class Controller extends BaseController
{
    /* traits */
    use AuthorizesRequests, DispatchesJobs, ValidatesRequests, Traits\DataCcxt;

    /**
     * @return \Illuminate\Contracts\View\Factory|\Illuminate\View\View
     */
    public function setup()
    {
        $vars = [];
        $vars['notice'] = '';
        $notice = '';
        $tscale = 0;

        if (!Schema::hasTable('bh_configs')) {
            $connection_name = config('database.default');
            if ($connection_name == 'mysql') {
                foreach (@DB::select("SHOW TABLES LIKE 'bh%'") as $table) {
                    $table_array = get_object_vars($table);
                    Schema::drop($table_array[key($table_array)]);
                }
            }
            Artisan::call('migrate:refresh');

            /*
             *  We need to check for pgsql and Timescale
             *  Timescale requires that the timestamp column is the primary key for a table and cannot index across
             *  partitions so we need to strip out the indexes, make the auto-increment fields SERIAL fiels but not
             *  PRIMARY fields and then create the hypertables.
             *
             *  Complicated, yes, worth it, most definitely.
             */
            if ($connection_name == 'pgsql') {
                $test = DB::select("SELECT * FROM pg_available_extensions where name ='timescaledb'");
                if (!empty($test)) {
                    DB::select('DROP TABLE IF EXISTS bh_ohlcvs_old, bh_tickers_old CASCADE');

                    DB::select('CREATE EXTENSION IF NOT EXISTS timescaledb CASCADE');
                    DB::select('ALTER TABLE bh_ohlcvs RENAME TO bh_ohlcvs_old');
                    DB::select('CREATE TABLE bh_ohlcvs (LIKE bh_ohlcvs_old INCLUDING DEFAULTS INCLUDING CONSTRAINTS EXCLUDING INDEXES)');
                    DB::select('ALTER TABLE bh_ohlcvs DROP COLUMN id');
                    DB::select('ALTER TABLE bh_ohlcvs ADD COLUMN id SERIAL');

                    DB::select('ALTER TABLE bh_tickers RENAME TO bh_tickers_old');
                    DB::select('CREATE TABLE bh_tickers (LIKE bh_tickers_old INCLUDING DEFAULTS INCLUDING CONSTRAINTS EXCLUDING INDEXES)');
                    DB::select('ALTER TABLE bh_tickers DROP COLUMN id');
                    DB::select('ALTER TABLE bh_tickers ADD COLUMN id SERIAL');

                    DB::select('DROP TABLE IF EXISTS bh_ohlcvs_old, bh_tickers_old CASCADE');

                    DB::select("SELECT create_hypertable('bh_ohlcvs', 'created_at')");
                    DB::select("SELECT create_hypertable('bh_tickers', 'created_at')");
                    $tscale = 1;
                    $notice .= "Postgres Timescale hypertables created and will be used for timeseries data.<br>\n";
                } else {
                    $notice .= "Postgres Timescale not installed. You won't be able to make use of hypertables.<br>\n";
                }
            }

            Artisan::call('db:seed');

            $notice .= "Noticed missing tables: Ran migrate:refresh and db:seed (you should only see this message once)<br>\n";
            $vars['notice'] = $notice;
        }

        Models\bh_configs::updateOrCreate(['item' => 'TIMESCALEDB'], ['value' => $tscale]);

        $configs = new Models\bh_configs();
        $coinigy = Traits\Config::bowhead_config('COINIGY');
        $vars['coinigy'] = $coinigy;

        return view('setup', $vars);
    }

    /**
     * @param \Illuminate\Http\Request $request
     *
     * @return \Illuminate\Http\RedirectResponse|\Illuminate\Routing\Redirector
     */
    public function setup2b(Request $request)
    {
        $input = $request->all();
        $preferred_exchanges = Models\bh_popular_exchanges::where('exch_id', $input['ex'])->get()->first();

        return redirect($preferred_exchanges->link);
    }

    /**
     * @param \Illuminate\Http\Request $request
     *
     * @return \Illuminate\Contracts\View\Factory|\Illuminate\View\View
     */
    public function setup2(Request $request)
    {
        // we set some preferred exchanges in our seeds
        /**$_preferred_exchanges = explode(',', Traits\Config::bowhead_config('EXCHANGES'));
        $preferred_exchanges = Models\bh_exchanges::whereIn('exchange', $_preferred_exchanges)->get();
        foreach($preferred_exchanges as $pe) {
            $preferred[] = $pe->id;
        }//*/
        $vars = $exhange_links = [];
        $_exhange_links = Models\bh_exchanges::get();
        foreach ($_exhange_links as $exlink) {
            $exhange_links[$exlink->id] = $exlink->url;
        }

        $input = $request->all();
        /* COINIGY */
        if ($input['coinigy']) {
            $vars['datasource'] = 'Coinigy';
            $preferred_exchanges = Models\bh_popular_exchanges::where('coinigy', 1)->get();
            foreach ($preferred_exchanges as $pe) {
                $preferred[$pe->exch_id] = $pe->link;
            }
            if (empty($input['apikey']) || empty($input['apisecret'])) {
                return view('setup', ['notice' => '', 'coinigy_error' => 1]);
            }
            Models\bh_configs::updateOrCreate(['item' => 'COINIGY'], ['value' => 1]);
            Models\bh_configs::updateOrCreate(['item' => 'COINIGY_API'], ['value' => $input['apikey']]);
            Models\bh_configs::updateOrCreate(['item' => 'COINIGY_SEC'], ['value' => $input['apisecret']]);

            /**
             *  We need to connect to Coinigy and verify the API keys are working before we continue.
             *  This is important as we actually pull a list of Exchanges 'FROM" them to display.
             */
            $base_url = 'https://api.coinigy.com/api/v1/';
            $headers['X-API-KEY'] = $input['apikey'];
            $headers['X-API-SECRET'] = $input['apisecret'];
            $client = new Coingy_GuzzleHttp\Client([
                'base_uri' => $base_url, 'headers' => $headers,
            ]);
            $response = $client->post('exchanges'); // the endpoint https://api.coinigy.com/api/v1/exchanges
            $code = $response->getStatusCode();
            $response = json_decode($response->getBody(), 1); // our list of exchanges
            if ($code != '200') {
                $reason = $response->getReasonPhrase();

                return view('setup', ['notice' => $reason, 'coinigy_error' => 1]);
            }
            if (!empty($response['err_num'])) {
                return view('setup', ['notice' => $response['err_msg'], 'coinigy_error' => 1]);
            }

            $coinigy_accounts = [];
            $coinigy = new Coinigy();
            $accounts = $coinigy->accounts();
            $accounts = $accounts['data'];
            foreach ($accounts as $acct) {
                $coinigy_accounts[] = $acct['exch_name'];
                $exhange_model = Models\bh_exchanges::where('exchange', '=', $acct['exch_name'])->get()->first();
                if ($exhange_model) {
                    $preferred[$exhange_model->id] = $exhange_model->url;
                }
            }

            $exchdata = [];
            foreach ($response['data'] as $exch) {
                $exhange_model = Models\bh_exchanges::where('exchange', '=', $exch['exch_name'])->get()->first();
                $exchdata[$exhange_model->id] = $exch['exch_name'];
            }

            /* CCXT */
        } else {
            $vars['datasource'] = 'CCXT';
            $preferred_exchanges = Models\bh_popular_exchanges::where('ccxt', 1)->get();
            foreach ($preferred_exchanges as $pe) {
                $preferred[$pe->exch_id] = $pe->link;
            }
            Models\bh_configs::updateOrCreate(['item' => 'COINIGY'], ['value' => 0]);
            $exchanges = $this->get_exchanges(); // via trait
            $all_ccxt = Models\bh_exchanges::whereIn('exchange', $exchanges)->get();
            foreach ($all_ccxt as $each_exch) {
                $exchdata[$each_exch->id] = $each_exch->exchange;
            }
        }

        $vars['coinigy_accounts'] = $coinigy_accounts ?? '';
        $vars['exhange_links'] = $exhange_links;
        $vars['exchanges'] = $exchdata;
        $vars['notice'] = '';
        $vars['preferred'] = $preferred;

        return view('setup2', $vars);
    }

    /**
     * @param \Illuminate\Http\Request $request
     *
     * @return \Illuminate\Contracts\View\Factory|\Illuminate\View\View
     */
    public function setup3(Request $request)
    {
        $selected = [];
        $input = $request->all();
        foreach ($input as $id) {
            if (is_numeric($id) && !empty($id)) {
                $selected[] = $id;
            }
        }
        Models\bh_configs::updateOrCreate(['item' => 'EXCHANGES'], ['value' => implode(',', $selected)]);

        /**
         * ONLY_FULL_GROUP_BY has issues with single tables indexed like this..  we have to turn it off
         * SET sql_mode=(SELECT REPLACE(@@sql_mode, 'ONLY_FULL_GROUP_BY', ''));
         * when using regular tools otherwise you have to do the following:
         * $newArray = array_values(call_user_func_array("array_intersect", $aggregate_copy));
         * and then keep track of counts.. bleh.. not doing that.
         *
         * This works via the DB Facade but, in SequelPro this will fail with ONLY_FULL_GROUP_BY error
         */
        $sql = 'SELECT exchange_pair, count(exchange_id) AS exchange_count 
                FROM bh_exchange_pairs 
                WHERE exchange_id IN ('.implode(',', $selected).')
                GROUP BY exchange_pair
                ORDER BY exchange_count DESC';

        $pairs = DB::select($sql);
        $pair_all = $pair_output = [];
        foreach ($pairs as $pair) {
            if ($pair->exchange_count > 2 || (count($selected) <= 2 && $pair->exchange_count > 0)) {
                $pair_output[$pair->exchange_pair] = $pair->exchange_count;
            }
            if ($pair->exchange_count == count($selected)) {
                $pair_all[] = $pair->exchange_pair;
            }
        }
        ksort($pair_output);
        $vars['notice'] = '';
        $vars['pair_output'] = $pair_output;
        $vars['pair_all'] = $pair_all;
        $vars['num_selelected'] = count($selected);
        // just some basic preferrences for currency pairs, also make sure to add in pairs that are shared on all exchanges selected.
        $vars['preferred'] = array_merge(['BTC/USD', 'BCH/USD', 'DASH/USD', 'DASH/BTC', 'ETH/USD', 'LTC/USD', 'DGB/BTC', 'XRP/BTC', 'XRP/USD', 'XMR/USD', 'XMR/BTC'], $pair_all);

        return view('setup3', $vars);
    }

    /**
     * @param \Illuminate\Http\Request $request
     *
     * @return \Illuminate\Contracts\View\Factory|\Illuminate\View\View
     */
    public function setup4(Request $request)
    {
        $vars = $selected = [];
        $input = $request->all();
        $selected = [];
        foreach ($input as $k => $id) {
            if (strpos($k, '/') > 0 && !empty($id)) {
                $selected[] = $id;
            }
        }
        Models\bh_configs::updateOrCreate(['item' => 'PAIRS'], ['value' => implode(',', $selected)]);

        // why is postgres having an issue with this?
        //Models\bh_configs::updateOrCreate(['item' => 'SETUP'], ['value' => 1]);

        // * * * * * /usr/local/bin//php /Users/joeldg/Projects/bowhead/artisan schedule:run >> /dev/null 2>&1
        $php_binary = (defined('PHP_BINARY') && PHP_BINARY ? PHP_BINDIR.'/' : '').'php';
        $base = base_path();
        $cuser = get_current_user();
        $windows = (strtoupper(substr(PHP_OS, 0, 3)) === 'WIN' ? true : false);
        $cronstring = "* * * * *  $php_binary $base".'/artisan schedule:run >> /dev/null 2>&1';
        if (!$windows) {
            $cronlist = `crontab -l`;
            $cronlist = explode("\n", $cronlist);
            $cronlist[] = $cronstring;
            $cronlist = array_unique($cronlist);
            file_put_contents('/tmp/cron_bh_tmp', implode("\n", $cronlist)."\n");
            $output = `crontab '/tmp/cron_bh_tmp'`;
            unlink('/tmp/cron_bh_tmp');
        }

        $vars['notice'] = '';
        $vars['cronlist'] = implode("\n", $cronlist) ?? '';
        $vars['output'] = $output ?? '';
        $vars['cronstring'] = $cronstring;

        return view('setup4', $vars);
    }

    /**
     * @param \Illuminate\Http\Request $request
     *
     * @return \Illuminate\Contracts\View\Factory|\Illuminate\View\View
     */
    public function exchanges(Request $request)
    {
        $input = $request->all();
        foreach ($input as $key => $inp) {
            if ($key[0] != '_') {
                Models\bh_configs::updateOrCreate(['item' => $key], ['value' => $inp]);
            }
        }

        $config_names = [];
        $exchange_list = explode(',', Traits\Config::bowhead_config('EXCHANGES'));
        $exchanges = Models\bh_exchanges::whereIn('id', $exchange_list)->get();
        foreach ($exchanges as $ex) {
            $orig = $name = $ex->exchange;
            $name = str_replace('.', '_', $name);
            $name = str_replace(' ', '_', strtoupper($name));
            $config_values[$orig][0] = Traits\Config::bowhead_config($name.'_APIKEY');
            $config_values[$orig][1] = Traits\Config::bowhead_config($name.'_SECRET');
            $config_values[$orig][2] = Traits\Config::bowhead_config($name.'_UID');
            $config_values[$orig][3] = Traits\Config::bowhead_config($name.'_PASSWORD');

            $config_names[$orig][0] = $name.'_APIKEY';
            $config_names[$orig][1] = $name.'_SECRET';
            $config_names[$orig][2] = $name.'_UID';
            $config_names[$orig][3] = $name.'_PASSWORD';
        }

        $preferred_exchanges = Models\bh_popular_exchanges::get();
        foreach ($preferred_exchanges as $pe) {
            $preferred[$pe->exch_id] = $pe->link;
        }
        $vars['notice'] = '';
        $vars['config_names'] = $config_names;
        $vars['config_values'] = $config_values;
        $vars['preferred'] = $preferred;
        $vars['exchanges'] = $exchanges;

        return view('setup_exchanges', $vars);
    }
}
