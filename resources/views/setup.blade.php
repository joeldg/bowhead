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
    <p class="err">{!! $notice !!}</p>
    <h1>Bowhead setup part 1:</h1>
    <p>
        Welcome to Bowhead, this setup with help you set up Bowhead so you can get up to speed quickly.
        <br>
        <br>Setup is just a few steps:
        <ul>
            <li><strong>select primary data sources for cryptocurrency</strong></li>
            <li>select cryptocurrency exchanges to use</li>
            <li>select currency pairs</li>
            <li>optional: set up exchange api keys</li>
        </ul>
    </p>


    <h3>OPTION #1</h3>
    <div class="row card">
    <p>
        The fastest start up is to use <a onclick="x=window.open('https://www.coinigy.com/?r=32d4c701')" href="#coinigy">Coinigy</a> for data.
        <i>Coinigy is a service that with one unified API, we can get data from and manage multiple Cryptocurrency exchanges.<br>
        Currently Coinigy claims to support 45+ exchanges, however via their API it only has live trading on about 12 exchanges.<br>
        You STILL have to manually sign up, get verified and collect API keys for any exchanges you want to use for trading, this is a time consuming process no matter what.
        <br><strong>But</strong> you can get data for all 45 exchanges, and they have a free month trial so if you just want to get quickly started, this is the way to go.</i>
    </p>
    </div>
    @isset($coinigy_error)
    <h2 class="err">ERROR: You need to provide an api key and an api secret for coinigy.</h2>
    @endisset
    <p>
        <form method="post" action="setup2">
        <input type="hidden" name="coinigy" value="1">
        Sign up on <a onclick="x=window.open('https://www.coinigy.com/?r=32d4c701')" href="#coinigy">Coinigy</a> and go to "Settings"->"My Account" and
        click on "Generate new key", then enter it here.<br>
        Coinigy ApiKey:<br>
        <input class="card w-100" type="text" name="apikey" size="60"><br>
        Coinigy Secret:<br>
        <input class="card w-100" type="text" name="apisecret" size="60"><br>
        <input type="hidden" name="_token" value="{{ csrf_token() }}">
        <input type="submit" class="btn primary">
        </form>
    </p>


    <h3>OPTION #2</h3>
    <p>
       Manually setting up Bowhead with the built-in <a href="https://github.com/ccxt/ccxt" target="_new">CCXT</a> library which supports 95 exchanges, however few provide
        public data gathering endpoints, so you are going to have to enter in all your account data.<br> It's similar to what you need to do with Option #1 but
        we have more data and more trading options (arb opportunities etc) down the road.
    </p>
    <p>
    <form method="post" action="setup2">
        <input type="hidden" name="coinigy" value="0">
        <input type="hidden" name="_token" value="{{ csrf_token() }}">
        <input class="btn primary" type="submit" value="continue">
    </form>
    </p>

</div>
</body>
</html>
