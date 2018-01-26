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
    <script>
        function toggleAll() {
            var blnChecked = document.getElementById("select_all_pairs").checked;
            var check_pairs = document.getElementsByClassName("check_pair");
            var intLength = check_pairs.length;
            for(var i = 0; i < intLength; i++) {
                var check_pair = check_pairs[i];
                check_pair.checked = blnChecked;
            }
        }
        function toggleDefault() {
            var blnChecked = document.getElementById("select_all_defaults").checked;
            var check_pairs = document.getElementsByClassName("check_default");
            var intLength = check_pairs.length;
            for(var i = 0; i < intLength; i++) {
                var check_pair = check_pairs[i];
                check_pair.checked = blnChecked;
            }
        }
    </script>
</head>
<body>
<div class="c">
<tr class="content">
    <p class="err">{{ $notice }}</p>
    <h1>Bowhead setup part 3:</h1>
    <p>
        Welcome to Bowhead, this setup with help you set up Bowhead so you can get up to speed quickly.
        <br>
        <br>Setup is just a few steps:
    <ul>
    <li>select primary data sources for cryptocurrency</li>
    <li>select cryptocurrency exchanges</li>
    <li><strong>select currency pairs</strong></li>
    <li>optional: set up exchange api keys</li>
    </ul>
    </p>

    <p>Select cryptocurrency pairs that you want to monitor.
        The number in superscript<sup>like this</sup> is the number of exchanges -- selected on the previous page -- that the
        pair is traded on.
        <br>
        If a currency pair is in <strong>bold</strong>, that means it is traded on all {{ $num_selelected }} exchanged you selected, it is automatically checked.
    </p>
    <p>We are interested in trading pair coverage for a few reasons, primarily so that we can move currency around. Currencies like Ripple (XMR) and Dash are fast transaction vessels.
    So, if you need to move BTC from Exchange A to Exchange B and both support Dash, you buy Dash with BTC on Exchange A and deposit it into Exchange B and then sell
        the Dash for BTC.
    </p>
    <input type='checkbox' id='select_all_pairs' onclick="toggleAll()" CHECKED> TOGGLE ALL
    <input type='checkbox' id='select_all_defaults' onclick="toggleDefault()" CHECKED> TOGGLE DEFAULTS
    <br><br>
    <div class="row card">
    <form method="post" action="setup4">
        <table class="w-100">
            @foreach (array_chunk($pair_output, 6, true) as $pairs)
                <tr>
                    @foreach ($pairs as $pair => $count)
                        <td><input type="checkbox" name="{{ $pair }}" value="{{ $pair }}"
                            @if(in_array($pair, $preferred))
                                class='check_pair check_default' CHECKED>
                                @if(in_array($pair, $pair_all))
                                <strong>{{ $pair }}</strong>
                                @else
                                {{ $pair }}
                                @endif
                                <sup>{{ $count }}</sup></td>
                            @else
                            class='check_pair'>
                            @if(in_array($pair, $pair_all))
                                <strong>{{ $pair }}</strong>
                            @else
                                {{ $pair }}
                            @endif
                            <sup>{{ $count }}</sup></td>
                        @endif
                    @endforeach
                </tr>
            @endforeach
        </table>
        <p>
            <input type="hidden" name="_token" value="{{ csrf_token() }}">
            <input class="btn primary" type="submit" value="continue">
    </form>
    </div>
    </p>

    </div>
</body>
</html>
