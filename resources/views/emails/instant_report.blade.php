<html xmlns="http://www.w3.org/1999/xhtml">
<head>
    <meta http-equiv="Content-Type" content="text/html; charset=utf-8" />
    <style type="text/css">
        body {margin: 0; padding: 0; min-width: 100%!important;}
        .content {width: 100%; max-width: 600px;}
        table.patient_data tr td {
            padding-top: 15px;
        }
        tr { border-bottom: 1px solid black; }

    </style>
</head>
<body>
<header style="background-color: rgba(79, 164, 218, 0.61);height: 60px;">
    <p style="text-align: center;padding-top: 7px;color: #21527d;font-size: 20px;">
        <b>CARDIF C.T.A.R</b>
        <br>
        <b>APPELS PATIENTS - MESSAGERIE SIMPLIFY</b></p>
</header>
<div class="urgent">
    <p style='color: red'><b>
            <?php
            if(isset($emergency_id)) {
                echo "URGENT<br/>";
                if($attempt == 2) {
                    echo "Premier Rappel<br/>";
                }if ($attempt == 3){
                    echo "Deuxième Rappel<br/>";
                }if($attempt == 4){
                    echo "Troisième Rappel<br/>";
                }if ($status == \App\Report::STATUS_CALL) {
                    echo "APPEL RACCROCHE PAR LE PATIENT<br/>";
                }/*else{
                    echo "[RAPPLE]";
                }*/
            }else{
                if($attempt == 2) {
                    echo "Premier Rappel<br/>";
                }if ($attempt == 3){
                    echo "Deuxième Rappel<br/>";
                }if($attempt == 4){
                    echo "Troisième Rappel<br/>";
                }if ($status == \App\Report::STATUS_CALL) {
                    echo "APPEL RACCROCHE PAR LE PATIENT<br/>";
                }/*else{
                    echo "[RAPPLE]";
                }*/
            }
            ?>
        </b></p>
</div>
<table name="patient_table" border="0" cellpadding="0" cellspacing="0" height="100%" width="100%" class="patient_data">
    <tr>
        <td width="20%" style="padding-top: 15px;font-weight:bold;border-top: 1px solid #000;">Centre appelé:</td>
        <td width="80%" style="padding-top: 15px;border-top: 1px solid #000;">{{ \App\Report::getCenterOptions($center_id) }}</td>
    </tr>

    <tr>
        <td width="20%" style="padding-top: 15px;font-weight:bold;">Date:</td>
        <td width="80%" style="padding-top: 15px;">{{ date('d-m-Y') }} </td>
    </tr>
    <tr>
        <td width="20%" style="padding-bottom: 15px;padding-top: 15px;font-weight:bold;border-bottom: 1px solid #000;">Heure:</td>
        <td width="80%" style="padding-bottom: 15px;padding-top: 15px;border-bottom: 1px solid #000;">{{ date('H:i',time()) }}</td>

    </tr>

    <tr>
        <td width="20%" style="padding-top: 15px;font-weight:bold;">Nom et Prénom :</td>
        <td width="80%" style="padding-top: 15px;">{{ \App\Report::getCivilOptions($civil_id) }} {{$name}} {{$first_name}}</td>
    </tr>

    <tr>
        <td width="20%" style="padding-top: 15px;font-weight:bold;">Société:</td>
        <td width="80%" style="padding-top: 15px;">{{$company}}</td>
    </tr>
    <tr>
        <td width="20%" style="padding-top: 15px;font-weight:bold;">Date de naissance:</td>
        <td width="80%" style="padding-top: 15px;">{{$dob}}</td>
    </tr>
    <tr>
        <td width="20%" style="padding-top: 15px;font-weight:bold;">Adresse:</td>
        <td width="80%" style="padding-top: 15px;">{{$address}}</td>
    </tr>
    <tr>
        <td width="20%" style="padding-top: 15px;font-weight:bold;">Ville:</td>
        <td width="80%" style="padding-top: 15px;">{{$city}}</td>
    </tr>
    <tr>
        <td width="20%" style="padding-top: 15px;font-weight:bold;">Code postal:</td>
        <td width="80%" style="padding-top: 15px;">{{$postal_code}}</td>
    </tr>
    <tr>
        <td width="20%" style="padding-top: 15px;font-weight:bold;">Adresse email:</td>
        <td width="80%" style="padding-top: 15px;">{{$email}}</td>
    </tr>
    <tr>
        <td width="20%" style="padding-top: 15px;font-weight:bold;">Téléphone mobile:</td>
        <td width="80%" style="padding-top: 15px;">{{$mobile}}</td>
    </tr>

    <tr>
        <td width="20%" style="padding-bottom: 15px;padding-top: 15px;font-weight:bold;border-bottom: 1px solid #000;">Téléphone fixe:</td>
        <td width="80%" style="padding-bottom: 15px;padding-top: 15px;border-bottom: 1px solid #000;">{{$phone}}</td>
    </tr>

    <tr>
        <td width="20%" style="padding-top: 15px;font-weight:bold;">Médecin concerné:</td>
        <td width="80%" style="padding-top: 15px;">{{ \App\Report::getPhysicianOptions($physician_id) }}</td>
    </tr>
    <tr>
        <td width="20%" style="padding-top: 15px;font-weight:bold;">Type d'examen:</td>
        <td width="80%" style="padding-top: 15px;">{{ \App\Report::getExamOptions($exam_id) }}</td>
    </tr>
    <tr>
        <td width="20%" style="padding-bottom: 15px;padding-top: 15px;font-weight:bold;border-bottom: 1px solid #000;">Message:</td>
        <td width="80%" style="padding-bottom: 15px;padding-top: 15px;border-bottom: 1px solid #000;">{{$reason}}</td>
    </tr>

    <tr>
        <td style="padding-top: 40px;">Cordialement,</td>
    </tr>
    <tr>
        <td style="padding-bottom: 40px;">Messagerie Simplify</td>
    </tr>
</table>

<footer style="padding-bottom: 50px;border-top: 1px solid #000;">
    <div>
        <p class="logo_footer" style="float:left;"><img src="{{asset('images/whiteLogo.jpeg')}}" width="165px"></p>
        <p class="info_email" style="float: left;padding: 25px 0 0 150px;">Email: contact@simplify.fr</p>
        <p class="info_phone" style="float: left;padding: 25px 0 0 130px;">Phone:+33 (0)1 30432277</p>
    </div>
</footer>
</body>
</html>
