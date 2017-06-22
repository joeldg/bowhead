<?php

namespace Bowhead\Http\Controllers;

use Bowhead\Traits\Mapper;
use Illuminate\Http\Request;
use Dingo\Api\Routing\Helpers;
use Illuminate\Routing\Controller;



/**
 * Class Accounts
 * @package Bowhead\Http\Controllers
 */
class Accounts extends Controller
{
    /**
     * @var
     */
    protected $dataArray;

    protected $broker_list;

    use Mapper;

    public function __construct(Request $request)
    {
        $this->dataArray = $request->all();
        $this->broker_list = $this->mapped_brokers_list; // from Mapper...
    }

    function __debugInfo()
    {
        // TODO: Implement __debugInfo() method.
    }

    public function getAccountsAction()
    {
        $data = $this->dataArray;
        return array('test'=>1);
    }

    /** retrieve orders and accounts */
    public function getAccountAction()
    {
        $data = $this->dataArray;

        return [];
    }

    /**
     * place orders and such
     */
    public function posttAccountAction()
    {

    }

    /** modify orders */
    public function patchAccountAction()
    {

    }

    /** close positions */
    public function deleteAccountAction()
    {

    }

}
