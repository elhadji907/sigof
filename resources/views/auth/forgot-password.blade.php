<!DOCTYPE html>
<html lang="fr">

<head>
    <meta charset="utf-8">
    <meta content="width=device-width, initial-scale=1.0" name="viewport">

    <title>Réinitialisation du mot de passe | ONFP</title>
    <meta name="csrf-token" content="{{ csrf_token() }}">

    <!-- Favicons -->
    <link href="{{ asset('assets/img/favicon-onfp.png') }}" rel="icon">

    <!-- Google Fonts -->
    <link href="https://fonts.googleapis.com/css2?family=Poppins:wght@300;400;600&display=swap" rel="stylesheet">

    <!-- Vendor CSS Files -->
    <link href="{{ asset('assets/vendor/bootstrap/css/bootstrap.min.css') }}" rel="stylesheet">
    <link href="{{ asset('assets/vendor/bootstrap-icons/bootstrap-icons.css') }}" rel="stylesheet">
    <link href="{{ asset('assets/css/style.css') }}" rel="stylesheet">

    <style>
        body {
            font-family: 'Poppins', sans-serif;
            background: #f4f7fc;
        }

        .login-container {
            max-width: 450px;
            margin: auto;
            padding: 40px;
            background: #fff;
            border-radius: 10px;
            box-shadow: 0px 4px 10px rgba(0, 0, 0, 0.1);
        }

        .form-control {
            border-radius: 8px;
        }

        .btn-primary {
            background: #007bff;
            border: none;
            transition: 0.3s;
        }

        .btn-primary:hover {
            background: #0056b3;
        }

        .back-to-login {
            text-decoration: none;
            font-weight: 600;
            color: #007bff;
            transition: 0.3s;
        }

        .back-to-login:hover {
            color: #0056b3;
        }

        .credits {
            text-align: center;
            margin-top: 30px;
            font-size: 14px;
            color: #666;
        }
    </style>
</head>

<body>

    <main class="d-flex align-items-center min-vh-100">
        <div class="container">
            <div class="row justify-content-center">
                <div class="col-md-6">
                    <div class="login-container">
                        <div class="text-center">
                            <span class="d-none d-lg-block">ONFP</span>
                            <h4 class="mt-3">Réinitialisation du mot de passe</h4>
                            <p class="text-muted">Entrez votre adresse e-mail pour recevoir un lien de réinitialisation.
                            </p>
                        </div>

                        @if (session('status'))
                            <div class="alert alert-success text-center">
                                ✅ {{ session('status') }}
                            </div>
                        @endif

                        <form method="POST" action="{{ route('password.email') }}" class="mt-4">
                            @csrf

                            <div class="mb-3">
                                <label for="email" class="form-label">Adresse e-mail <span
                                        class="text-danger">*</span></label>
                                <div class="input-group">
                                    <span class="input-group-text"><i class="bi bi-envelope"></i></span>
                                    <input type="email" name="email"
                                        class="form-control @error('email') is-invalid @enderror" id="email"
                                        placeholder="Votre email" value="{{ old('email') }}" required autofocus>
                                    @error('email')
                                        <div class="invalid-feedback">{{ $message }}</div>
                                    @enderror
                                </div>
                            </div>

                            <button type="submit" class="btn btn-primary w-100">📩 Envoyer le lien</button>
                        </form>

                        <div class="text-center mt-3">
                            <a href="{{ url('/login-page') }}" class="back-to-login">⬅ Retour à la connexion</a>
                        </div>

                        <div class="credits">
                            Conçu par <a href="https://www.onfp.sn/" target="_blank">Lamine BADJI</a>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </main>

    <!-- JS Files -->
    <script src="{{ asset('assets/vendor/bootstrap/js/bootstrap.bundle.min.js') }}"></script>

</body>

</html>
