<!DOCTYPE html>
<html>

<head>
    <title>Joyeux Anniversaire 🎉</title>
</head>

<body>
    <h3>Bonjour {{ $user->firstname . ' ' . $user->name }} !</h3>
    <p>Toute l'équipe de l'ONFP vous souhaite un très joyeux anniversaire ! 🎉🎂</p>
    <p>Que cette journée spéciale soit remplie de bonheur, de réussite et de belles surprises. 🥳✨</p>
    <p>Profitez pleinement de votre journée !</p>
    <p>Cordialement,</p>
    <p><strong>L'équipe de l'ONFP</strong></p>
    @include('emails.footer_mail')
</body>

</html>
