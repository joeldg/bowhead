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
    <h1>Bowhead setup final:</h1>
    <p>
        <br>We are done with the basic setup, your database is set up and seeded with data and you selected your data sources.
        <br>Now we need to finalize and get the schedules set up to keep your data up to date, we do this with the schedule runner
        <br>
        <br>
        We have attemped to set the following preserved full crontab for user {{get_current_user()}} who is running the webserver:<br>
        <pre>{{$cronlist}}</pre>
        <pre class="err">{{$output}}</pre>
        <br>
        <br>If you see an error then continue below the button, otherwise you can use Bowhead as it is now, though you cannot do trades until this part
        is done. If you are using Coinigy then you will need to add the API keys on the Coinigy site (It would be a good idea to add them to Bowhead as well
        so that you can swap to using CCXT if you wish).
        <br>Continue to the next section where you can enter the API information for each of the Exchanges you selected.
    <form method="post" action="exchanges">

        <input type="hidden" name="_token" value="{{ csrf_token() }}">
        <input class="btn primary" type="submit" value="continue to enter exchange api key">
    </form>

    <br><br>
    If you need to change the user crontab.
    <div class="text-indent: 150px;">
        <p>If you need this cron to run as a different user than {{get_current_user()}} you will need to remove this crontab entry
            and set it for the user of your choice, for most cases, the web user should be fine.
        <br><strong>{{$cronstring}}</strong>
        <br>if you are familiar with cron then add this to your existing crontab.
            <br>If you are not, you can use the following command in a terminal.
        <i>NOTE: This command will wipe any existing crontab entries you have.</i>
            <br>
            <br><strong>echo "{{ $cronstring }}" | crontab -</strong><br>
        </p>
        <br>
    </div>

</div>
</body>
</html>
