<!DOCTYPE html>
<html>

<head>
    <img src="cid:logo.png" alt="ONFP Logo" style="max-width: 20%;" class="w-25">
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
