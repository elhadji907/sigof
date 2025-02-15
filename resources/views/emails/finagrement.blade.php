<!DOCTYPE html>
<html lang="fr">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Renouvellement agrément</title>
</head>
<body>
    <h3>Bonjour {{ $operateur?->user?->username }} !</h3>
    <p>Nous vous informons que le moment est venu de renouveler votre agrément. <br>
        Afin d'éviter toute interruption, nous vous invitons à vous connecter à votre compte et à soumettre votre demande dès maintenant. ⏳📜</p>
    <p>Nous restons à votre disposition pour toute assistance.</p>
    <p>Merci pour votre confiance.</p>
    <p>Cordialement,</p>
    <p>L'équipe de la DEC</p>  
    @include('emails.footer_mail')
</body>
</html>
