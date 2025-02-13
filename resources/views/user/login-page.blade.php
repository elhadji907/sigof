<!DOCTYPE html>
<html lang="fr">

<head>
    <meta charset="utf-8">
    <meta content="width=device-width, initial-scale=1.0" name="viewport">
    <meta name="csrf-token" content="{{ csrf_token() }}">
    <script type="text/javascript">
        function callbackThen(response) {
            // read Promise object
            response.json().then(function(data) {
                console.log(data);
                if (data.success && data.score > 0.5) {
                    console.log('recpatcha valid');
                } else {
                    document.getElementById('registerForm').addEventListener('submit', function(event) {
                        event.preventDefault();
                        alert('erreur recpatcha');
                    });
                }
            });
        }

        function callbackCatch(error) {
            console.error('Error:', error)
        }
    </script>

    {!! htmlScriptTagJsApi([
        'callback_then' => 'callbackThen',
        'callback_catch' => 'callbackCatch',
    ]) !!}
    <title>Page de connexion</title>
    <meta content="" name="description">
    <meta content="" name="keywords">

    <!-- Favicons -->
    <link href="{{ asset('assets/img/favicon-onfp.png') }}" rel="icon">
    <link href="{{ asset('assets/img/apple-touch-icon.png') }}" rel="apple-touch-icon">

    <!-- Google Fonts -->
    <link href="https://fonts.gstatic.com" rel="preconnect">
    <link
        href="https://fonts.googleapis.com/css?family=Open+Sans:300,300i,400,400i,600,600i,700,700i|Nunito:300,300i,400,400i,600,600i,700,700i|Poppins:300,300i,400,400i,500,500i,600,600i,700,700i"
        rel="stylesheet">

    <!-- Vendor CSS Files -->
    <link href="{{ asset('assets/vendor/bootstrap/css/bootstrap.min.css') }}" rel="stylesheet">
    <link href="{{ asset('assets/vendor/bootstrap-icons/bootstrap-icons.css') }}" rel="stylesheet">
    <link href="{{ asset('assets/vendor/boxicons/css/boxicons.min.css') }}" rel="stylesheet">
    <link href="{{ asset('assets/vendor/quill/quill.snow.css') }}" rel="stylesheet">
    <link href="{{ asset('assets/vendor/quill/quill.bubble.css') }}" rel="stylesheet">
    <link href="{{ asset('assets/vendor/remixicon/remixicon.css') }}" rel="stylesheet">
    <link href="{{ asset('assets/vendor/simple-datatables/style.css') }}" rel="stylesheet">

    <link href="{{ asset('assets/css/style.css') }}" rel="stylesheet">

</head>

<body>
    <main>
        <div class="container">

            <section
                class="section register min-vh-100 d-flex flex-column align-items-center justify-content-center py-4">
                <div class="container">
                    <div class="row justify-content-center">
                        <div class="col-lg-4 col-md-6 d-flex flex-column align-items-center justify-content-center">

                            <div class="d-flex justify-content-center py-4">
                                <a href="{{ route('accueil') }}" class="logo d-flex align-items-center w-auto"
                                    target="_blank">
                                    {{-- <img src="{{ asset('assets/img/logo_sigle.png') }}" alt=""> --}}
                                    <span class="d-none d-lg-block">ONFP-SIGOF</span>
                                </a>
                            </div><!-- End Logo -->

                            <div class="card mb-3">

                                <div class="card-body">

                                    <div class="pt-0 pb-2">
                                        <h5 class="card-title text-center pb-0 fs-4">Connection</h5>
                                        <p class="text-center small">Entrez vos identifiants pour vous connecter</p>
                                    </div>

                                    <form class="row g-3 needs-validation" novalidate method="POST"
                                        action="{{ route('login') }}">
                                        @csrf
                                        <label for="email" class="form-label">Email<span
                                                class="text-danger mx-1">*</span></label>
                                        <div class="input-group has-validation">
                                            <span class="input-group-text" id="inputGroupPrepend">@</span>
                                            <input type="email" name="email"
                                                class="form-control form-control-sm @error('email') is-invalid @enderror"
                                                id="email" required placeholder="Votre adresse e-mail"
                                                value="{{ old('email') }}" autofocus>
                                            <div class="invalid-feedback">
                                                @error('email')
                                                    {{ $message }}
                                                @enderror
                                            </div>
                                        </div>


                                        <div class="col-12">
                                            <label for="password" class="form-label">Mot de passe<span
                                                    class="text-danger mx-1">*</span></label>
                                            <div class="input-group has-validation">
                                                <span class="input-group-text" id="inputGroupPrepend"><i
                                                        class="bi bi-key"></i></span>
                                                <input type="password" name="password"
                                                    class="form-control form-control-sm  @error('password') is-invalid @enderror"
                                                    id="password" required placeholder="Votre mot de passe">
                                                <div class="invalid-feedback">
                                                    @error('password')
                                                        {{ $message }}
                                                    @enderror
                                                </div>
                                            </div>
                                        </div>

                                        <div class="col-12">
                                            <div class="form-check">
                                                <input class="form-check-input" type="checkbox" name="remember"
                                                    value="true" id="rememberMe">
                                                <label class="form-check-label" for="rememberMe">Souviens-toi de
                                                    moi</label>
                                            </div>
                                        </div>
                                        <div class="col-12">
                                            <button class="btn btn-primary btn-sm w-100" type="submit">Se
                                                connecter</button>
                                        </div>
                                        {{-- <div class="col-12">
                                            @if (Route::has('password.request'))
                                                <p class="small mb-0">Mot de passe oublié !<a
                                                        href="{{ route('password.request') }}"> Réinitialiser</a></p>
                                            @endif
                                        </div> --}}
                                        <div class="col-12">
                                            <p class="small mb-0">Retour à la page d'<a
                                                    href="{{ route('accueil') }}">accueil</a></p>
                                        </div>
                                    </form>

                                </div>
                            </div>

                            <div class="credits">
                                &copy; Copyright <strong><span><a href="https://www.onfp.sn/"
                                            target="_blank">ONFP</a></span></strong>
                            </div>

                        </div>
                    </div>
                </div>

            </section>

        </div>
    </main><!-- End #main -->

    {{-- <main id="main" class="main">
        <div class="container-fluid">
            <section
                class="section dashboard register min-vh-100 d-flex flex-column justify-content-center py-4">

                    <div class="col-12 col-md-12 col-lg-6 col-sm-12 col-xs-12 col-xxl-4 justify-content-center">
                        <div class="card">
                            <div class="card-body">
                                @if ($message = Session::get('status'))
                                    <div class="alert alert-success bg-success text-light border-0 alert-dismissible fade show"
                                        role="alert">
                                        <strong>{{ $message }}</strong>
                                        <button type="button" class="btn-close" data-bs-dismiss="alert"
                                            aria-label="Close"></button>
                                    </div>
                                @endif
                                <div class="d-flex justify-content-center">
                                    <a href="{{ url('/login-page') }}" class="logo d-flex w-auto">
                                        <h6 class="card-title">Connectez-vous !</h6>
                                    </a>
                                </div>
                                <form class="row g-3 needs-validation" novalidate method="POST"
                                    action="{{ route('login') }}">
                                    @csrf

                                    <div class="col-12">
                                        <label for="email" class="form-label">Email<span
                                                class="text-danger mx-1">*</span></label>
                                        <div class="input-group has-validation">
                                            <input type="email" name="email"
                                                class="form-control form-control-sm @error('email') is-invalid @enderror"
                                                id="email" required placeholder="Votre adresse e-mail"
                                                value="{{ old('email') }}" autofocus>
                                            <div class="invalid-feedback">
                                                @error('email')
                                                    {{ $message }}
                                                @enderror
                                            </div>
                                        </div>
                                    </div>

                                    <div class="col-12">
                                        <label for="password" class="form-label">Mot de passe<span
                                                class="text-danger mx-1">*</span></label>
                                        <input type="password" name="password"
                                            class="form-control form-control-sm  @error('password') is-invalid @enderror"
                                            id="password" required placeholder="Votre mot de passe">
                                        <div class="invalid-feedback">
                                            @error('password')
                                                {{ $message }}
                                            @enderror
                                        </div>
                                    </div>

                                    <div class="col-12">
                                        <div class="form-check">
                                            <input class="form-check-input" type="checkbox" name="remember"
                                                value="true" id="rememberMe">
                                            <label class="form-check-label" for="rememberMe">Souviens-toi de
                                                moi</label>
                                        </div>
                                    </div>
                                    <div class="col-12">
                                        <button class="btn btn-primary w-100" type="submit">Se connecter</button>
                                    </div>
                                    <div class="col-12">
                                        @if (Route::has('password.request'))
                                            <p class="small mb-0">Mot de passe oublié !<a
                                                    href="{{ route('password.request') }}"> Réinitialiser</a></p>
                                        @endif
                                    </div>
                                    <div class="col-12">
                                        <p class="small mb-0">Vous n'avez pas de compte ?<a
                                                href="{{ url('/register-page') }}"> Créer un compte</a></p>
                                    </div>
                                </form>

                            </div>
                        </div>
                    </div>
                <div class="copyright">
                    &copy; Copyright <strong><span><a href="https://www.onfp.sn/"
                                target="_blank">ONFP</a></span></strong>
                </div>
            </section>

            @include('sweetalert::alert')
        </div>
    </main> --}}
    <script src="{{ asset('assets/vendor/apexcharts/apexcharts.min.js') }}"></script>
    <script src="{{ asset('assets/vendor/bootstrap/js/bootstrap.bundle.min.js') }}"></script>
    <script src="{{ asset('assets/vendor/chart.js/chart.umd.js') }}"></script>
    <script src="{{ asset('assets/vendor/echarts/echarts.min.js') }}"></script>
    <script src="{{ asset('assets/vendor/quill/quill.min.js') }}"></script>
    <script src="{{ asset('assets/vendor/simple-datatables/simple-datatables.js') }}"></script>
    <script src="{{ asset('assets/vendor/tinymce/tinymce.min.js') }}"></script>
    <script src="{{ asset('assets/vendor/php-email-form/validate.js') }}"></script>

    <script src="{{ asset('assets/js/main.js') }}"></script>

</body>

</html>
