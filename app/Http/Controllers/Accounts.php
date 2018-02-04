<?php

namespace Bowhead\Http\Controllers;

use Bowhead\Traits\Mapper;
use Illuminate\Http\Request;
use Illuminate\Routing\Controller;

/**
 * Class Accounts.
 */
class Accounts extends Controller
{
    /**
     * @var
     */
    protected $dataArray;

    /**
     * @var array
     */
    protected $broker_list;

    /**
     * @var
     */
    protected $errors = [];

    use Mapper;

    public function __construct(Request $request)
    {
        $this->dataArray = $request->all();
        $this->broker_list = $this->mapped_brokers_list; // from Mapper...

        $brokers = implode(', ', $this->broker_list);
        if (empty($this->dataArray['source'])) {
            $this->errors[] = "'source' cannot be empty, select a brokerage: [$brokers]";
        }
    }

    public function __debugInfo()
    {
        // TODO: Implement __debugInfo() method.
    }

    public function getAccountsAction()
    {
        if (!empty($this->errors)) {
            return $this->errors;
        }

        $data = $this->dataArray;
        $action = 'accounts_all';

        $ret = $this->mapperAccounts($data['source'], ['action' => $action]);

        return $ret;
    }

    /** retrieve orders and accounts */
    public function getAccountAction()
    {
        $data = $this->dataArray;
        if (empty($data['id'])) {
            $this->errors[] = 'id is a requried field for getting an account';
        }
        if (!empty($this->errors)) {
            return $this->errors;
        }

        return [];
    }

    /**
     * place orders and such.
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
