<html xmlns="http://www.w3.org/1999/xhtml">
<head>
    <meta http-equiv="Content-Type" content="text/html; charset=utf-8" />
    <style type="text/css">
        body {margin: 0; padding: 0; min-width: 100%!important;}
        .content {width: 100%; max-width: 600px;}

    </style>
</head>
<body>
<header style="background-color: #00abf3;height: 50px;">
    <p style="text-align: center;padding-top: 15px;"><b>DAILY PATIENT REPORT</b></p>
</header>

<div class="daily_report">
    <p>Nombre total d’appels traités: <b>{{$total}}</b> appels</p>
    <ul style="
            display: block;
            list-style-type: lower-roman;
            margin-top: 1em;
            margin-bottom: 1 em;
            margin-left: 0;
            margin-right: 0;
            padding-left: 40px;
        ">
        <li>Nombre d’appels traités CARDIF 1:  <b>{{$centerOne}}</b> appels</li>
        <li>Nombre d’appels traités CARDIF 2:  <b>{{$centerTwo}}</b> appels</li>
    </ul>
</div>

<footer style="padding-top: 25px;">
    <div>
        <p class="logo_footer"><img src="{{asset('images/logo.png')}}" width="165px"></p>
        <p class="info_email">Email: contact@simplify.fr</p>
        <p class="info_phone">Phone:+33 (0)1 30432277</p>
    </div>
</footer>
</body>
</html>
