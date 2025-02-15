<!DOCTYPE html>
<html lang="fr">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Rappel de Formation</title>
</head>

<body>
    {{-- <h3>Bonjour {{ $notifiable?->firstname }} {{ $notifiable?->name }} !</h3>

    <p>Nous vous rappelons que votre formation en <strong>{{ $formation?->module?->name }}</strong> commence
        {{ $reminderType }}.</p>

    <p>📍 <strong>Lieu :</strong> {{ $formation?->lieu . ', ' . $formation?->departement?->nom }}</p>
    <table style="width: 20%; border-collapse: collapse;">
        <tr>
            <td style="padding: 5px; font-weight: bold; text-align: left;">📆 Date début :</td>
            <td style="padding: 5px; text-align: left;">{{ $formation?->date_debut?->format('d/m/Y') }}</td>
        </tr>
        <tr>
            <td style="padding: 5px; font-weight: bold; text-align: left;">🏁 Date fin :</td>
            <td style="padding: 5px; text-align: left;">{{ $formation?->date_fin?->format('d/m/Y') }}</td>
        </tr>
        <tr>
            <td style="padding: 5px; font-weight: bold; text-align: left;">⏳ Durée :</td>
            <td style="padding: 5px; text-align: left;">{{ $formation?->duree_formation . ' jours' }}</td>
        </tr>
    </table>

    <p>🎓 <strong>Opérateur :</strong> {{ $formation?->operateur?->user?->operateur }}</p> --}}
    <h3>Bonjour {{ $notifiable?->firstname }} {{ $notifiable?->name }} !</h3>

    <p>📢 Nous vous rappelons que votre formation en <strong>{{ $formation?->module?->name }}</strong> débutera
        <strong>{{ $reminderType }}</strong>.
    </p>

    <p>Cette formation se déroulera à <strong>{{ $formation?->lieu . ', ' . $formation?->departement?->nom }}</strong> du
        <strong>{{ $formation?->date_debut?->format('d/m/Y') }}</strong> au
        <strong>{{ $formation?->date_fin?->format('d/m/Y') }}</strong>, et sera animée par
        <strong>{{ $formation?->operateur?->user?->operateur }}
            ({{ $formation?->operateur?->user?->username }})</strong>.
    </p>

    <p>ℹ️ Pour bien vous préparer, nous vous recommandons de consulter <a href="sigof.onfp.sn">votre espace
            personnel</a>, où vous trouverez le calendrier détaillé de la formation ainsi que toutes les informations
        essentielles.</p>

    <p>📌 <strong>Important :</strong> Merci de confirmer votre présence, d’être ponctuel(le) et pleinement disponible
        tout au long de la formation.</p>

    <p>Nous vous souhaitons une excellente formation et une expérience d’apprentissage enrichissante ! 🚀</p>

    <p>💡 <em>Pour toute question ou information complémentaire, n’hésitez pas à nous contacter.</em></p>


    @include('emails.footer_mail')
</body>

</html>
