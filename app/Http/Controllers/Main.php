<?php

namespace Bowhead\Http\Controllers;

use Illuminate\Http\Request;

class Main extends Controller
{
    public function main(Request $request)
    {
        $vars['notice'] = '';
        return view('main', $vars);
    }
}
