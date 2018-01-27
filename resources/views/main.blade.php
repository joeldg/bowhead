<!doctype html>
<html lang="{{ app()->getLocale() }}">
<head>
    <meta charset="utf-8">
    <meta http-equiv="X-UA-Compatible" content="IE=edge">
    <meta name="viewport" content="width=device-width, initial-scale=1">

    <title>Bowhead</title>
    <!-- scripts -->
    <script src="https://cdn.jsdelivr.net/npm/d3@4.12.2/build/d3.min.js"></script>
    <script src="https://cdn.jsdelivr.net/npm/epoch-charting@0.8.4/dist/js/epoch.min.js"></script>

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
        .contentB {
            text-align: left;
            margin: 150;
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
<div class="content">
    <p class="err">{{ $notice }}</p>
    <b class="title">Bowhead settings:</b>
    <p>
        TODO
    </p>
</div>

</div>
</body>
</html>
