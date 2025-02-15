<!DOCTYPE html>
<html>
<head>
    <title>Rappel de formation</title>
</head>
<body>
    <h1>Bonjour {{ $notifiable->firstname }} {{ $notifiable->name }} !</h1>
    <p>Votre formation <strong>{{ $formation->module->name }}</strong> commence bientôt.</p>
    <p>📍 Lieu : {{ $formation->lieu }}</p>
    <p>📅 Date : du {{ $formation->date_debut->format('d/m/Y') }} au {{ $formation->date_fin->format('d/m/Y') }}</p>
    <p>🎓 Opérateur : {{ $formation->operateur->user->operateur }}</p>
    {{-- <a href="{{ url('/formations/' . $formation->id) }}">Voir les détails</a> --}}
    <p>Cordialement,</p>
    <p>L'équipe de l'ONFP</p>
    @include('emails.footer_mail')
</body>
</html>
