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

    <h3>Please sign up for the Bowhead mailing list.</h3>
    The mailing list will be for updates on the project, new tutorials, new videos and related crypto news.
    <!-- Begin MailChimp Signup Form -->
    <link href="//cdn-images.mailchimp.com/embedcode/horizontal-slim-10_7.css" rel="stylesheet" type="text/css">
    <style type="text/css">
        #mc_embed_signup{background:#fff; clear:left; font:14px Helvetica,Arial,sans-serif; width:100%;}
        /* Add your own MailChimp form style overrides in your site stylesheet or in this style block.
           We recommend moving this block and the preceding CSS link to the HEAD of your HTML file. */
    </style>
    <div id="mc_embed_signup">
        <form action="https://youangetcreditcard.us9.list-manage.com/subscribe/post?u=17eddce79bb6ec325b6025b3f&amp;id=f6486a472b" method="post" id="mc-embedded-subscribe-form" name="mc-embedded-subscribe-form" class="validate" target="_blank" novalidate>
            <div id="mc_embed_signup_scroll">
                <label for="mce-EMAIL">Subscribe to Bowhead updates</label>
                <input type="email" value="" name="EMAIL" class="email" id="mce-EMAIL" placeholder="email address" required>
                <!-- real people should not fill this in and expect good things - do not remove this or risk form bot signups-->
                <div style="position: absolute; left: -5000px;" aria-hidden="true"><input type="text" name="b_17eddce79bb6ec325b6025b3f_f6486a472b" tabindex="-1" value=""></div>
                <div class="clear"><input type="submit" value="Subscribe" name="subscribe" id="mc-embedded-subscribe" class="button"></div>
            </div>
        </form>
    </div>

    <!--End mc_embed_signup-->


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
