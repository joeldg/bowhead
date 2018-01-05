<!doctype html>
<html lang="{{ app()->getLocale() }}">
<head>
    <meta charset="utf-8">
    <meta http-equiv="X-UA-Compatible" content="IE=edge">
    <meta name="viewport" content="width=device-width, initial-scale=1">

    <title>Bowhead</title>

    <!-- Fonts -->
    <link href="https://fonts.googleapis.com/css?family=Raleway:100,600" rel="stylesheet" type="text/css">

    <!-- Styles -->
    <style>
        html, body {
            background-color: #fff;
            color: #636b6f;
            font-family: 'Raleway', sans-serif;
            font-weight: 100;
            height: 100vh;
            margin: 50;
        }

        .full-height {
            height: 100vh;
        }

        .flex-center {
            align-items: center;
            display: flex;
            justify-content: center;
        }

        .position-ref {
            position: relative;
        }

        .top-right {
            position: absolute;
            right: 10px;
            top: 18px;
        }

        .err {
            color: #ff6666;
            padding: 0 25px;
            letter-spacing: .1rem;
        }

        .content {
            text-align: left;
            margin: 50;
        }

        .title {
            font-size: 44px;
        }

        .links > a {
            color: #636b6f;
            padding: 0 25px;
            font-size: 12px;
            font-weight: 600;
            letter-spacing: .1rem;
            text-decoration: none;
            text-transform: uppercase;
        }

        a:hover + div {
            display: block;
        }​

        .m-b-md {
            margin-bottom: 30px;
        }
    </style>
</head>
<body>
<div class="content">
    <p class="err">{{ $notice }}</p>
    <b class="title">Bowhead setup part 1:</b>
    <p>
        Welcome to Bowhead, this setup with help you set up Bowhead so you can get up to speed quickly.
        <br>
        <br>Setup is just a few steps:
        <li><strong>select primary data sources for cryptocurrency</strong></li>
        <li>select cryptocurrency exchanges to use</li>
        <li>select currency pairs</li>
        <li>optional: set up exchange api keys</li>
    </p>


    <p><strong>OPTION #1</strong></p>
    <p>
        The fastest start up is to use <a onclick="x=window.open('https://www.coinigy.com/?r=32d4c701')" href="#coinigy">Coinigy</a> for data.
        <i>Coinigy is a service that with one unified API, we can get data from and manage multiple Cryptocurrency exchanges.<br>
        Currently Coinigy claims to support 45+ exchanges, however via their API it only has live trading on about 12 exchanges.<br>
        You STILL have to manually sign up, get verified and collect API keys for any exchanges you want to use for trading, this is a time consuming process no matter what.
        <br><strong>But</strong> you can get data for all 45 exchanges, and they have a free month trial so if you just want to get quickly started, this is the way to go.</i>
    </p>
    @isset($coinigy_error)
    <p class="err">ERROR: You need to provide an api key and an api secret for coinigy.</p>
    @endisset
    <p>
        <form method="post" action="setup2">
        <input type="hidden" name="coinigy" value="1">
        Sign up on <a onclick="x=window.open('https://www.coinigy.com/?r=32d4c701')" href="#coinigy">Coinigy</a> and go to "Settings"->"My Account" and
        click on "Generate new key", then enter it here.<br>
        Coinigy ApiKey:<br>
        <input type="text" name="apikey" size="60"><br>
        Coinigy Secret:<br>
        <input type="text" name="apisecret" size="60"><br>
        <input type="hidden" name="_token" value="{{ csrf_token() }}">
        <input type="submit">
        </form>
    </p>


    <p><strong>OPTION #2</strong></p>
    <p>
       Manually setting up Bowhead with the built-in <a href="https://github.com/ccxt/ccxt" target="_new">CCXT</a> library which supports 95 exchanges, however few provide
        public data gathering endpoints, so you are going to have to enter in all your account data.<br> It's similar to what you need to do with Option #1 but
        we have more data and more trading options (arb opportunities etc) down the road.
    </p>
    <p>
    <form method="post" action="setup2">
        <input type="hidden" name="coinigy" value="0">
        <input type="hidden" name="_token" value="{{ csrf_token() }}">
        <input type="submit" value="continue">
    </form>
    </p>

</div>
</body>
</html>
