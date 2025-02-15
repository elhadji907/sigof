<!DOCTYPE html>
<html lang="fr">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Renouvellement de votre agrément</title>
</head>
<body>
    <h3>Bonjour {{ $operateur?->user?->username }} !</h3>
    <p>Nous vous informons que votre agrément est arrivé à son terme après 4 ans.</p>
    <p>Pour poursuivre vos activités, nous vous invitons à soumettre une nouvelle demande de renouvellement dès que possible.</p>
    <p>Veuillez vous connecter à votre compte pour effectuer cette démarche.</p>
    <p>Merci pour votre confiance.</p>
    <p>Cordialement,</p>
    <p>L'équipe de la DEC</p>   
    @include('emails.footer_mail')
</body>
</html>
