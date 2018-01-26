<!doctype html>
<html lang="{{ app()->getLocale() }}">
<head>
    <meta charset="utf-8">
    <meta http-equiv="X-UA-Compatible" content="IE=edge">
    <meta name="viewport" content="width=device-width, initial-scale=1">

    <title>Bowhead</title>

    <!-- Fonts -->
    <link href="/css/camphor.scss" rel="stylesheet" type="text/css">
    <link href="/css/button.scss" rel="stylesheet" type="text/css">
    <link href="/css/lit.css" rel="stylesheet" type="text/css">

    <!-- Styles -->
    <style>
        body {
            font-family: Camphor, Open Sans, Segoe UI, sans-serif;
            text-rendering: optimizeLegibility;
            -webkit-font-smoothing: antialiased;
            -moz-osx-font-smoothing: grayscale;
            background-color: #8eb4cb;
        }
        .err {
            color: #ff6666;
            padding: 0 25px;
            letter-spacing: .1rem;
        }
        .c {
            background-color: #f5f5f5;
        }
        a { color: #FF0000; }
    </style>
</head>
<body>
<div class="c">
<tr class="content">
    <p class="err">{{ $notice }}</p>
    <h1>Bowhead setup part 2:</h1>
    <p>
        Welcome to Bowhead, this setup with help you set up Bowhead so you can get up to speed quickly.
        <br>
        <br>Setup is just a few steps:
    <ul>
    <li>select primary data sources for cryptocurrency</li>
    <li><strong>select cryptocurrency exchanges to use with {{$datasource}}</strong></li>
    <li>select currency pairs</li>
    <li>optional: set up exchange api keys</li>
    </ul>
    </p>

    <div>
    @if($datasource == 'Coinigy')
        @if(!empty($coinigy_accounts))
            <strong style="color: #2ca02c">CURRENT ACTIVE COINIGY ACCOUNTS:</strong> {{ join(', ', $coinigy_accounts) }} <br>
            <i>your coinigy accounts have been selected automatically below, along with suggested exchanges.</i>
        @else
            <strong style="color: #133d55">CURRENT COINIGY ACCOUNTS:</strong> *** you have no active accounts on Coinigy, sign up and add some with the links below ***<br>
        @endif
    @endif
    </div>

    <p>Select the exchanges you want to use. <br></bre><i>If you are unsure, go with the defaults.</i><br>
        Selecting ones not used can slow things down, and you will need to add in accounts for them.</p>
    <div class="row card">
    <p><strong>TIP: Use this page to open up windows to the various exchanges and sign up accounts to use.</strong></p>
    </div>
    <i>NOTE: several exchanges do not allow signups from USA-based customers and/or will flag accounts of customers from the US. (Bitfinex, okcoin etc)
        Others such as 1Broker are "<a href="https://www.investopedia.com/university/electronictrading/trading3.asp" target="_new">Market Maker</a>" sites and not true exchanges. Market makers get their price quotes from major exchanges.
        <br>For best results sign up for at least four or five of the defaults from this page and get API access set up, uncheck the others.
        Some of the sites that are really slow to grant access to their exchanges *cough* Gemini *cough* are not recommended at this time.
    </i>
    <form method="post" action="setup3">
        <div class="row card">
    <table class="w-100">
    @foreach (array_chunk($exchanges, 6, true) as $exchange)
        <tr>
        @foreach ($exchange as $id => $exch)
            <td><input type="checkbox" name="{{ $exch }}" value="{{ $id }}"
                @if(in_array($id, array_keys($preferred) ))
                CHECKED> <a onclick="x=window.open('{{ $preferred[$id] }}')" href="?ex={{ $id }}" target="_new"><strong>{{ $exch }}</strong></a></td>
                @else
                    > {{ $exch }} <sub><a href="{{ $exhange_links[$id] }}" target="_new">>></a></sub></td>
                @endif
        @endforeach
        </tr>
    @endforeach
    </table>
        </div>
    <p>
        <input type="hidden" name="coinigy" value="0">
        <input type="hidden" name="_token" value="{{ csrf_token() }}">
        <input class="btn primary" type="submit" value="continue">
    </form>
    </p>

</div>
</body>
</html>
