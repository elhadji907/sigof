<!DOCTYPE html>
<html lang="fr">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>{{ __('ONFP E-MAIL') }}</title>
</head>

<body>
    <header>
    </header>

    <body>
        <h3>{{ $toUserName }}</h3>
        <h4> {!! $mailMessage !!}</h4>
    </body>
    <footer>
        <p>&copy; ONFP {{ date('Y') }}</p>
    </footer>
</body>

</html>
