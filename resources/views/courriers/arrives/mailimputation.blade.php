<!DOCTYPE html>
<html lang="fr">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>{{ __('ONFP | Notification') }}</title>
    <style>
        body {
            font-family: Arial, sans-serif;
            background-color: #f4f4f4;
            margin: 0;
            padding: 0;
        }

        .email-container {
            max-width: 600px;
            margin: 20px auto;
            background: #ffffff;
            padding: 20px;
            border-radius: 8px;
            box-shadow: 0 2px 10px rgba(0, 0, 0, 0.1);
        }

        .header {
            text-align: center;
            padding-bottom: 10px;
            border-bottom: 2px solid #007bff;
        }

        .header img {
            max-width: 120px;
        }

        .header h2 {
            color: #007bff;
            margin: 10px 0 0;
        }

        .content {
            padding: 20px 0;
            color: #333;
            line-height: 1.6;
        }

        .content h3 {
            color: #333;
        }

        .content p {
            font-size: 16px;
            margin: 10px 0;
        }

        .footer {
            text-align: center;
            padding-top: 15px;
            border-top: 1px solid #ddd;
            font-size: 14px;
            color: #666;
        }

        .footer a {
            color: #007bff;
            text-decoration: none;
        }

        .footer a:hover {
            text-decoration: underline;
        }
    </style>
</head>

<body>
    <div class="email-container">
        <!-- En-tête -->
        <div class="header">
            <img src="cid:logo.png" alt="ONFP Logo" style="max-width: 20%;" class="w-25">
            {{-- <h2>ONFP | Notification</h2> --}}
        </div>

        <!-- Contenu -->
        <div class="content">
            <h3>{{ $toUserName }}</h3>
            <p>{!! $mailMessage !!}</p>
        </div>

        <!-- Pied de page -->
        <div class="footer">
            <p>&copy; ONFP {{ date('Y') }}. Tous droits réservés.</p>
            <p><a href="https://sigof.onfp.sn">Visitez notre site</a> | <a href="mailto:onfp@onfp.sn">Contactez-nous</a>
            </p>
        </div>
    </div>
</body>

</html>
