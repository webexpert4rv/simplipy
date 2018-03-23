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
    <p>{{ $client_name }},</p>
    <br/>
    <p>{{ $message_body }}</p>
    <br/>
</div>
<table name="patient_table" border="0" cellpadding="0" cellspacing="0" height="100%" width="100%" class="patient_data">
    @if(isset($civil_id))
        <tr>
            <td width="20%" style="padding-top: 15px;font-weight:bold;">Civilité:</td>
            <td width="80%" style="padding-top: 15px;">{{ @$civil_id }}</td>
        </tr>
    @endif
    @if(isset($name))
        <tr>
            <td width="20%" style="padding-top: 15px;font-weight:bold;">Nom et prénom:</td>
            <td width="80%" style="padding-top: 15px;">{{ @$name }}</td>
        </tr>
    @endif
    @if(isset($dob))
        <tr>
            <td width="20%" style="padding-top: 15px;font-weight:bold;">Date de naissance:</td>
            <td width="80%" style="padding-top: 15px;">{{ @$dob }}</td>
        </tr>
    @endif
    @if(isset($address))
        <tr>
            <td width="20%" style="padding-top: 15px;font-weight:bold;">Adresse postale:</td>
            <td width="80%" style="padding-top: 15px;">{{ @$address }}, {{ @$postal_code }}</td>
        </tr>
    @endif
    @if(isset($mobile))
        <tr>
            <td width="20%" style="padding-top: 15px;font-weight:bold;">Numéro de téléphone:</td>
            <td width="80%" style="padding-top: 15px;">{{ @$mobile }}</td>
        </tr>
    @endif
    @if(isset($to_email))
        <tr>
            <td width="20%" style="padding-top: 15px;font-weight:bold;">Adresse mail:</td>
            <td width="80%" style="padding-top: 15px;">{{ @$to_email }}</td>
        </tr>
    @endif
    <tr>
        <td style="padding-top: 40px;">Cordialement,</td>
    </tr>
    <tr>
        <td style="padding-bottom: 40px;">Votre télésecretariat Simplify</td>
    </tr>
</table>
</body>
</html>
