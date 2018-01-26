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
        <p class="err">{{ $notice }}</p>
        <h1>Bowhead setup - exchanges:</h1>
        <p>
            <br>We are done with the basic setup, your database is set up and seeded with data and you selected your data sources.
            <br>Bowhead is now attempting to pull in data for pairs you selected on the exchanges you specified. This will not always work as not all the
            <br>exchanges have public API endpoints, so you really need to sign up for these changes you selected and add in the API keys for them
            <br>
        <div class="card">Before entering in API keys, you should make sure this webserver is locked down, especially if this is run in the cloud.
            <br>Here are tutorials for <a href="https://www.digitalocean.com/community/tutorials/how-to-set-up-basic-http-authentication-with-nginx-on-ubuntu-14-04" target="_new">nginx</a>, and <a href="https://linode.com/docs/web-servers/apache/how-to-set-up-htaccess-on-apache/">apache</a> (if you must use Apache).
            <br><br><i>NOTE: You can come back to this page from the main page.</i>
        </div>
            <form method="post">
            <table>
                <thead>
                    <th>EXCHANGE</th>
                    <th>API Key</th>
                    <th>API Secret</th>
                    <th>password (seldom needed)</th>
                    <th>uuid (seldom needed)</th>
                </thead>
                @foreach ($exchanges as $exchange)
                    @if(in_array($exchange->id, array_keys($preferred)))
                    <tr>
                        <td><a onclick="x=window.open('{{ $preferred[$exchange->id] }}')" href="/setup2?ex={{ $exchange->id }}" target="_new"><strong>{{$exchange->exchange}}</strong></a></td>
                        <td><input class="card w-100" type="text" size="30" name="{{$config_names[$exchange->exchange][0]}}" value="{{$config_values[$exchange->exchange][0]}}"></td>
                        <td><input class="card w-100" type="text" size="30" name="{{$config_names[$exchange->exchange][1]}}" value="{{$config_values[$exchange->exchange][1]}}"></td>
                        <td><input class="card w-100" type="text" size="20" name="{{$config_names[$exchange->exchange][2]}}" value="{{$config_values[$exchange->exchange][2]}}"></td>
                        <td><input class="card w-100" type="text" size="20" name="{{$config_names[$exchange->exchange][3]}}" value="{{$config_values[$exchange->exchange][3]}}"></td>
                    </tr>
                    @else
                    <tr>
                        <td><a href="{{$exchange->url}}" target="_new">{{$exchange->exchange}}</a></td>
                        <td><input class="card w-100" type="text" size="30" name="{{$config_names[$exchange->exchange][0]}}" value="{{$config_values[$exchange->exchange][0]}}"></td>
                        <td><input class="card w-100" type="text" size="30" name="{{$config_names[$exchange->exchange][1]}}" value="{{$config_values[$exchange->exchange][1]}}"></td>
                        <td><input class="card w-100" type="text" size="20" name="{{$config_names[$exchange->exchange][2]}}" value="{{$config_values[$exchange->exchange][2]}}"></td>
                        <td><input class="card w-100" type="text" size="20" name="{{$config_names[$exchange->exchange][3]}}" value="{{$config_values[$exchange->exchange][3]}}"></td>
                    </tr>
                    @endif
                @endforeach
            </table>
            <input type="hidden" name="_token" value="{{ csrf_token() }}">
            &nbsp;&nbsp;&nbsp;<input type="submit" class="btn primary" value="Save keys and continue to enter - don't lose your work">
        </form>
<br><br><br>
        <form method="get" action="main">
        <input type="hidden" name="_token" value="{{ csrf_token() }}">
        &nbsp;&nbsp;&nbsp;<input class="btn primary"type="submit" value="Go to main page.">
        </form>
</p>
</div>

</div>
</body>
</html>
