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
    <p style="text-align: center;padding-top: 15px;"><b>APPELS PATIENTS - DATA REPORT</b></p>
</header>
<div class="urgent">
    <p style='color: red'><b>
            <?php
            if(isset($emergency_id)) {
                echo "[URGENT]";
                if($attempt == 2) {
                    echo "[Premier Rappel]";
                }elseif ($attempt == 3){
                    echo "[Deuxième Rappel]";
                }elseif($attempt == 4){
                    echo "[Troisième Rappel]";
                }/*else{
                    echo "[RAPPLE]";
                }*/
            }else{
                if($attempt == 2) {
                    echo "[Premier Rappel]";
                }elseif ($attempt == 3){
                    echo "[Deuxième Rappel]";
                }elseif($attempt == 4){
                    echo "[Troisième Rappel]";
                }elseif (isset($status_call)) {
                    echo "[Données incomplètes]";
                }/*else{
                    echo "[RAPPLE]";
                }*/
            }
            if (isset($status_call)) {
                echo "[Données incomplètes]";
            }
            ?>
        </b></p>
</div>
<table name="patient_table" border="0" cellpadding="0" cellspacing="0" height="100%" width="100%" >
    <tr>
        <td width="20%">Date:</td>
        <td width="80%">{{ date('d-m-Y') }} </td>
    </tr>
    <tr>
        <td width="20%">Heure:</td>
        <td width="80%">{{ date('H:i',time() + 3600) }}</td>
    </tr>
    <tr>
        <td width="20%">Centre appelé:</td>
        <td width="80%">{{ \App\Report::getCenterOptions($center_id) }}</td>
    </tr>
    <tr>
        <td width="20%">Etat civil:</td>
        <td width="80%">{{ \App\Report::getCivilOptions($civil_id) }}</td>
    </tr>
    <tr>
        <td width="20%">Nom:</td>
        <td width="80%">{{$name}}</td>
    </tr>
    <tr>
        <td width="20%">Prénom:</td>
        <td width="80%">{{$first_name}}</td>
    </tr>
    <tr>
        <td width="20%">Société:</td>
        <td width="80%">{{$company}}</td>
    </tr>
    <tr>
        <td width="20%">Date de naissance:</td>
        <td width="80%">{{$dob}}</td>
    </tr>
    <tr>
        <td width="20%">Adresse:</td>
        <td width="80%">{{$address}}</td>
    </tr>
    <tr>
        <td width="20%">Ville:</td>
        <td width="80%">{{$city}}</td>
    </tr>
    <tr>
        <td width="20%">Code postal:</td>
        <td width="80%">{{$postal_code}}</td>
    </tr>
    <tr>
        <td width="20%">Adresse email:</td>
        <td width="80%">{{$email}}</td>
    </tr>
    <tr>
        <td width="20%">Téléphone mobile:</td>
        <td width="80%">{{$mobile}}</td>
    </tr>
    <tr>
        <td width="20%">Médecin concerné:</td>
        <td width="80%">{{ \App\Report::getPhysicianOptions($physician_id) }}</td>
    </tr>
    <tr>
        <td width="20%">Message:</td>
        <td width="80%">{{$reason}}</td>
    </tr>
    <tr>
        <td width="20%">Type d'examen:</td>
        <td width="80%">{{ \App\Report::getExamOptions($exam_id) }}</td>
    </tr>
</table>

<footer>
    <div>
        <p class="logo_footer"><img src="{{asset('images/logo.png')}}" width="165px"></p>
        <p class="info_email">Email: contact@simplify.fr</p>
        <p class="info_phone">Phone:+33 (0)1 30432277</p>
    </div>
</footer>
</body>
</html>
