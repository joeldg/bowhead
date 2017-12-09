<?php

use Illuminate\Http\Request;

/*
|--------------------------------------------------------------------------
| API Routes
|--------------------------------------------------------------------------
|
| Here is where you can register API routes for your application. These
| routes are loaded by the RouteServiceProvider within a group which
| is assigned the "api" middleware group. Enjoy building your API!
|
*/

$api = app('Dingo\Api\Routing\Router');

$api->version(['v1','v2'], [], function ($api) {
    /** accounts
     * list accounts + balances, transfers, deposit, withdrawal etc
    //*/
    $api->get('accounts/', '\Bowhead\Http\Controllers\Accounts@getAccountsAction');  // get all accounts

    $api->get('account/{id}', 'Bowhead\Http\Controllers\Accounts@getAccountAction'); // get specific account
    $api->post('account/', 'Bowhead\Http\Controllers\Accounts@posttAccountAction');
    $api->patch('account/{id}', 'Bowhead\Http\Controllers\Accounts@patchAccountAction');
    $api->delete('account/{id}', 'Bowhead\Http\Controllers\Accounts@deleteAccountAction');

    /**
     * markets
     * list of instruments, prices etc
    //*/

    $api->get('markets/', 'Bowhead\Http\Controllers\Markets@getMarketsAction');

    $api->get('market/{id}', 'Bowhead\Http\Controllers\Markets@getMarketAction');
    $api->post('market/', 'Bowhead\Http\Controllers\Markets@postMarketAction\'');
    $api->patch('market/{id}', 'Bowhead\Http\Controllers\Markets@patchMarketAction\'');
    $api->delete('market/{id}', 'Bowhead\Http\Controllers\Markets@deleteMarketAction\'');
    //*/

    /**
     * positions
     * new/open/close/pending/cancel
    //*/

    $api->get('positions/', 'Bowhead\Http\Controllers\Positions@getPositionsAction');

    $api->get('position/{id}', 'Bowhead\Http\Controllers\Positions@getPositionAction');
    $api->post('position/', 'Bowhead\Http\Controllers\Positions@postPositionAction');
    $api->patch('position/{id}', 'Bowhead\Http\Controllers\Positions@patchPositionAction');
    $api->delete('position/{id}', 'Bowhead\Http\Controllers\Positions@deletePositionAction');
    //*/

    /**
     * transactions
     * deposits, withdrawls etc.
    //*/

    $api->get('transaction/', 'Bowhead\Http\Controllers\Transactions@getTransactionsAction');
    $api->get('transaction/{id}', 'Bowhead\Http\Controllers\Transactions@getTransactionAction');
    //*/

});

#Route::middleware('auth:api')->get('/user', function (Request $request) {
#    return $request->user();
#});
