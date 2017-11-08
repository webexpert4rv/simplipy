<html xmlns="http://www.w3.org/1999/xhtml">
<head>
    <meta http-equiv="Content-Type" content="text/html; charset=utf-8" />
    <style type="text/css">
        body {margin: 0; padding: 0; min-width: 100%!important;}
        .content {width: 100%; max-width: 600px;}

    </style>
</head>
<body>
<header style="background-color: rgba(79, 164, 218, 0.61);height: 60px;">
    <p style="text-align: center;padding-top: 7px;color: #21527d;font-size: 20px;">
        <b>CARDIF C.T.A.R</b>
        <br>
        <b>Rapport​ Quotidien​ Messagerie​ Simplify {{\Carbon\Carbon::setLocale('fr')->now()->format('d F Y')}}</b></p>
</header>

<div class="daily_report">
    <p>Nombre total de messages envoyés: <b>{{$total}}</b> messages</p>
    <ul style="
            display: block;
            list-style-type: lower-roman;
            margin-top: 1em;
            margin-bottom: 1em;
            margin-left: 0;
            margin-right: 0;
            padding-left: 40px;
        ">
        <li>Nombre de messages envoyés CARDIF 1:  <b>{{$centerOne}}</b> messages</li>
        <li>Nombre de messages envoyés CARDIF 2:  <b>{{$centerTwo}}</b> messages</li>
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
