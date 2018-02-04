<?php

namespace Bowhead\Http\Middleware;

use Closure;
use Illuminate\Support\Facades\DB;

class Before
{
    /**
     * Handle an incoming request.
     *
     * @param \Illuminate\Http\Request $request
     * @param \Closure                 $next
     *
     * @return mixed
     */
    public function handle($request, Closure $next)
    {
        $username = env('DB_USERNAME');
        if (empty($username)) {
            return view('first', ['db_msg'=>'No database configured, set up the .env file']);
        }

        try {
            DB::connection()->getPdo();
        } catch (\Exception $e) {
            return view('first', ['db_msg'=>"Could not connect to the database.  Please check your configuration.\n".$e->getMessage()]);
        }

        return $next($request);
    }
}
