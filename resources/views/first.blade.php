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

        .content {
            text-align: left;
            margin: 50;
        }

        .title {
            font-size: 44px;
        }

        .err {
            color: #ff6666;
            padding: 0 25px;
            letter-spacing: .1rem;
            text-decoration: none;
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

        .m-b-md {
            margin-bottom: 30px;
        }
    </style>
</head>
<body><div class="content">
    <b class="title">Bowhead initial setup:</b>
    <p>Welcome to Bowhead, this setup with help you set up Bowhead so you can get up to speed quickly.</p>

    <p>If you are seeing this message, you need to set up your .env file or your .env file is incorrectly set up</p>
    <p>This will set up your database for use with Bowhead.</p>
    <p>
        <b>First:</b> copy the .env.example to .env
        <pre>cp .env.example .env</pre>

        <b>Second:</b> edit the .env file using vim or whatever editor you use. And change this to your database.
        <pre>
DB_HOST=localhost
DB_PORT=3306
DB_DATABASE=bowhead
DB_USERNAME=root
DB_PASSWORD=password
        </pre>
        <b>CURRENT ERROR:</b>
        <pre class="err">
           {{ $db_msg }}
        </pre>

    </p>


</div>
</body>
</html>
