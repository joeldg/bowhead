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

        #container {
            display: table;
        }

        #row  {
            display: table-row;
        }

        #left, #right, #middle {
            display: table-cell;
        }
    </style>
</head>
<body>
<tr class="content">
    <p class="err">{{ $notice }}</p>
    <b class="title">Bowhead setup part 2:</b>
    <p>
        Welcome to Bowhead, this setup with help you set up Bowhead so you can get up to speed quickly.
        <br>
        <br>Setup is just a few steps:
    <li>select primary data sources for cryptocurrency</li>
    <li><strong>select cryptocurrency exchanges to use with {{$datasource}}</strong></li>
    <li>select currency pairs</li>
    <li>optional: set up exchange api keys</li>
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
    <p><strong>TIP: Use this page to open up windows to the various exchanges and sign up accounts to use.</strong></p>
    <p>NOTE: several exchanges do not allow signups from USA-based customers and/or will flag accounts of customers from the US. (Bitfinex, okcoin etc)<br>
        Others such as 1Broker are "<a href="https://www.investopedia.com/university/electronictrading/trading3.asp" target="_new">Market Maker</a>" sites and not true exchanges. Market makers get their price quotes from major exchanges.
        <br>For best results sign up for at least four or five of the defaults from this page and get API access set up, uncheck the others.
        Some of the sites that are really slow to grant access to their exchanges *cough* Gemini *cough* are not recommended at this time.
    </p>
    <form method="post" action="setup3">
    <table>
    @foreach (array_chunk($exchanges, 8, true) as $exchange)
        <tr>
        @foreach ($exchange as $id => $exch)
            <td><input type="checkbox" name="{{ $exch }}" value="{{ $id }}"
                @if(in_array($id, array_keys($preferred) ))
                CHECKED> <a onclick="x=window.open('{{ $preferred[$id] }}')" href="?ex={{ $id }}" target="_new">{{ $exch }}</a></td>
                @else
                    > {{ $exch }} <sub><a href="{{ $exhange_links[$id] }}" target="_new">>></a></sub></td>
                @endif
        @endforeach
        </tr>
    @endforeach
    </table>
    <p>
        <input type="hidden" name="coinigy" value="0">
        <input type="hidden" name="_token" value="{{ csrf_token() }}">
        <input type="submit" value="continue">
    </form>
    </p>

</div>
</body>
</html>
