<!DOCTYPE html>
<html lang="fr">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Erreur 500 - Erreur Interne du Serveur</title>
    <style>
        body {
            font-family: Arial, sans-serif;
            background-color: #f8f9fa;
            text-align: center;
            padding: 50px;
        }
        .container {
            max-width: 600px;
            margin: auto;
            padding: 20px;
            background: white;
            box-shadow: 0px 0px 10px rgba(0, 0, 0, 0.1);
            border-radius: 8px;
        }
        h1 {
            color: #dc3545;
        }
        p {
            color: #6c757d;
        }
        a {
            display: inline-block;
            margin-top: 20px;
            padding: 10px 20px;
            background: #007bff;
            color: white;
            text-decoration: none;
            border-radius: 5px;
        }
        a:hover {
            background: #0056b3;
        }
    </style>
</head>
<body>

    <div class="container">
        <h1>Erreur 500</h1>
        <p>Oups ! Une erreur interne est survenue sur le serveur.</p>
        <p>Nos équipes ont été informées et travaillent à résoudre ce problème.</p>
        <a href="{{ url('/') }}">Retour à l'accueil</a>
    </div>

</body>
</html>
