<html xmlns="http://www.w3.org/1999/xhtml">
<head>
    <meta http-equiv="Content-Type" content="text/html; charset=utf-8"/>
    <style type="text/css">
        body {
            margin: 0;
            padding: 0;
            min-width: 100% !important;
        }

        .content {
            width: 100%;
            max-width: 600px;
        }

        table.patient_data tr td {
            padding-top: 15px;
        }

        /*tr { border-bottom: 1px solid black; }*/

    </style>
</head>
<body>
<div class="urgent">
    <p>Bonjour,</p>
    <br/>
    @if(isset($message_body))
        <p>{{ $message_body }}</p>
        <br/>
    @endif
</div>
<table name="patient_table" border="0" cellpadding="0" cellspacing="0" height="100%" class="patient_data">
    @if(isset($civil_id))
        <tr>
            <td style="padding-top: 15px;font-weight:bold;">Civilité:</td>
            <td style="padding-top: 15px;">{{ @$civil_id }}</td>
        </tr>
    @endif
    @if(isset($name))
        <tr>
            <td style="padding-top: 15px;font-weight:bold;">Nom:</td>
            <td style="padding-top: 15px;">{{ @$name }}</td>
        </tr>
    @endif
    @if(isset($last_name))
        <tr>
            <td style="padding-top: 15px;font-weight:bold;">Prénom:</td>
            <td style="padding-top: 15px;">{{ @$last_name }}</td>
        </tr>
    @endif
    @if(isset($dob))
        <tr>
            <td style="padding-top: 15px;font-weight:bold;">Date de naissance:</td>
            <td style="padding-top: 15px;">{{ @$dob }}</td>
        </tr>
    @endif
    @if(isset($address))
        <tr>
            <td style="padding-top: 15px;font-weight:bold;">Adresse postale:</td>
            <td style="padding-top: 15px;">{{ @$address }}</td>
        </tr>
    @endif
    @if(isset($complete_address))
        <tr>
            <td style="padding-top: 15px;font-weight:bold;">Complément d'adresse:</td>
            <td style="padding-top: 15px;">{{ @$complete_address }}</td>
        </tr>
    @endif
    @if(isset($mobile))
        <tr>
            <td style="padding-top: 15px;font-weight:bold;">Numéro de téléphone:</td>
            <td style="padding-top: 15px;">{{ @$mobile }}</td>
        </tr>
    @endif
    @if(isset($fax))
        <tr>
            <td style="padding-top: 15px;font-weight:bold;">Numéro de fax:</td>
            <td style="padding-top: 15px;">{{ @$fax }}</td>
        </tr>
    @endif
    @if(isset($to_email))
        <tr>
            <td style="padding-top: 15px;font-weight:bold;">Adresse mail:</td>
            <td style="padding-top: 15px;">{{ @$to_email }}</td>
        </tr>
    @endif
    @if(isset($security))
        <tr>
            <td style="padding-top: 15px;font-weight:bold;">Numéro de sécurité sociale:</td>
            <td style="padding-top: 15px;">{{ @$security }}</td>
        </tr>
    @endif
    @if(isset($exam))
        <tr>
            <td style="padding-top: 15px;font-weight:bold;">Type d'examen:</td>
            <td style="padding-top: 15px;">{{ @$exam }}</td>
        </tr>
    @endif
    @if(isset($dateexam))
        <tr>
            <td style="padding-top: 15px;font-weight:bold;">Date de l'examen:</td>
            <td style="padding-top: 15px;">{{ @$dateexam }}</td>
        </tr>
    @endif
    <tr>
        <td style="padding-top: 40px;">Cordialement,</td>
    </tr>
    <tr>
        <td style="padding-bottom: 40px;">Votre télésecrétariat Simplify</td>
    </tr>
</table>
</body>
</html>
